<?php
// Reck Twins. Every active member (member, probate, social) has at most one twin,
// and twins are mutual: if Alex's twin is Blair, Blair's twin is Alex.
//
// Choosing pairs
//   score = events together / (Alex's events + Blair's events - events together)
//           x sqrt(smaller event count / larger event count)
//   The first part stops the people who go to everything from outscoring everyone
//   else; the second pairs heavy attendees with heavy attendees. The strongest pair
//   in the club is locked in first, then the strongest pair among whoever is left,
//   and so on, so twins are always mutual and nobody is claimed twice.
//
// Over time
//   Twins update live: every page load replays the semester through today, one
//   Monday-to-Sunday week at a time, with the current week as the last round. Each
//   round gives the previous week's pairs RECK_TWIN_STAY_BONUS, so a pair only
//   splits when one of them has built a clearly stronger overlap with someone else,
//   not every time someone checks off an event. On Fall 2025 data about half the
//   club changed twins every week without it, and about 10 people a week with it.
//   A much larger bonus locks in weak pairs from the first few weeks.
//
// Nothing is stored. The same attendance always gives the same twins, so a new
// check-off, a late check-off or a status change shows up on the next page load.

define('RECK_TWIN_MIN_SHARED', 3);     // a pair needs at least this many events together
define('RECK_TWIN_MIN_EVENTS', 10);    // events a semester needs before twins are picked from it
define('RECK_TWIN_STAY_BONUS', 1.25);  // last week's pair scores 25% higher

// The date twins are worked out as of: today, as Y-m-d.
function reck_twin_as_of($today = null) {
	return date('Y-m-d', ($today === null) ? time() : strtotime($today));
}

// The most recent semester with enough events held by $asOf, so the first week of a
// new semester still shows last semester's twins. Spring is Jan-Jul, Fall is Aug-Dec.
function reck_twin_semester($db, $asOf) {
	$q = $db->prepare("
		SELECT dateYear AS y, IF(dateMonth <= 7, 1, 8) AS m1, COUNT(*) AS held
		FROM Event
		WHERE isFamilyEvent = 0
		  AND STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear),'%m/%d/%Y') <= :asOf
		GROUP BY y, m1
		HAVING held >= ".(int)RECK_TWIN_MIN_EVENTS."
		ORDER BY y DESC, m1 DESC
		LIMIT 1");
	$q->execute(array('asOf' => $asOf));
	$row = $q->fetch(PDO::FETCH_ASSOC);
	if (!$row) { return null; }

	$from = (int)$row['m1'];
	return array(
		'year'  => (int)$row['y'],
		'from'  => $from,
		'to'    => ($from == 1) ? 7 : 12,
		'label' => (($from == 1) ? 'Spring ' : 'Fall ').(int)$row['y'],
	);
}

// One round of pairing. $previous is last week's result, whose pairs get the bonus.
function reck_twin_match($events, $shared, $previous) {
	$edges = array();
	foreach ($shared as $key => $together) {
		if ($together < RECK_TWIN_MIN_SHARED) { continue; }
		list($a, $b) = explode(':', $key);
		$a = (int)$a;
		$b = (int)$b;
		$score = $together / ($events[$a] + $events[$b] - $together)
		       * sqrt(min($events[$a], $events[$b]) / max($events[$a], $events[$b]));
		if (isset($previous[$a]) && $previous[$a]['twinID'] === $b) {
			$score *= RECK_TWIN_STAY_BONUS;
		}
		$edges[] = array($score, $together, $a, $b);
	}

	// Strongest first; ties go to more events together, then the lower member ids,
	// so every page load agrees on the order.
	usort($edges, function ($x, $y) {
		if ($x[0] != $y[0]) { return ($x[0] < $y[0]) ? 1 : -1; }
		if ($x[1] != $y[1]) { return $y[1] - $x[1]; }
		if ($x[2] != $y[2]) { return $x[2] - $y[2]; }
		return $x[3] - $y[3];
	});

	$twins = array();
	foreach ($edges as $edge) {
		$a = $edge[2];
		$b = $edge[3];
		if (isset($twins[$a]) || isset($twins[$b])) { continue; }
		$twins[$a] = array('twinID' => $b, 'shared' => $edge[1]);
		$twins[$b] = array('twinID' => $a, 'shared' => $edge[1]);
	}
	return $twins;
}

// Every twin pair as of $asOf (default: last Sunday), keyed by memberID both ways.
function reck_twin_pairs($db, $asOf = null) {
	static $cache = array();
	if ($asOf === null) { $asOf = reck_twin_as_of(); }
	if (isset($cache[$asOf])) { return $cache[$asOf]; }

	$result = array('asOf' => $asOf, 'semester' => null, 'twins' => array());
	$sem = reck_twin_semester($db, $asOf);
	if (!$sem) { return $cache[$asOf] = $result; }
	$result['semester'] = $sem;

	$q = $db->prepare("
		SELECT DISTINCT a.memberID, a.eventID,
		       STR_TO_DATE(CONCAT(e.dateMonth,'/',e.dateDay,'/',e.dateYear),'%m/%d/%Y') AS eventDate
		FROM AttendsEvent a
		JOIN Event e ON e.eventID = a.eventID
		JOIN Member m ON m.memberID = a.memberID
		WHERE m.status IN ('member', 'probate', 'social')
		  AND e.isFamilyEvent = 0
		  AND e.dateYear = :y AND e.dateMonth BETWEEN :m1 AND :m2
		  AND STR_TO_DATE(CONCAT(e.dateMonth,'/',e.dateDay,'/',e.dateYear),'%m/%d/%Y') <= :asOf
		ORDER BY eventDate, a.eventID, a.memberID");
	$q->execute(array('y' => $sem['year'], 'm1' => $sem['from'], 'm2' => $sem['to'], 'asOf' => $asOf));

	// Monday-to-Sunday weeks, in date order, each event holding its attendees.
	$weeks = array();
	while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
		$week = date('o-W', strtotime($row['eventDate']));
		$weeks[$week][(int)$row['eventID']][] = (int)$row['memberID'];
	}

	$events = array();  // memberID => events so far
	$shared = array();  // "lowID:highID" => events together so far
	$held = 0;
	$twins = array();
	foreach ($weeks as $weekEvents) {
		foreach ($weekEvents as $attendees) {
			$held++;
			sort($attendees);
			$n = count($attendees);
			for ($i = 0; $i < $n; $i++) {
				$a = $attendees[$i];
				$events[$a] = isset($events[$a]) ? $events[$a] + 1 : 1;
				for ($j = $i + 1; $j < $n; $j++) {
					$key = $a.':'.$attendees[$j];
					$shared[$key] = isset($shared[$key]) ? $shared[$key] + 1 : 1;
				}
			}
		}
		if ($held >= RECK_TWIN_MIN_EVENTS) {
			$twins = reck_twin_match($events, $shared, $twins);
		}
	}

	$result['twins'] = $twins;
	return $cache[$asOf] = $result;
}

// What the Your Reck Twin card shows for one member: their twin (or null), and every
// event they went to this semester through today, marked where the twin was there too.
function reck_twin_for($db, $memberID, $asOf = null) {
	$pairs = reck_twin_pairs($db, $asOf);
	$out = array('semester' => $pairs['semester'], 'twin' => null, 'events' => array(), 'together' => 0);
	$sem = $pairs['semester'];
	if (!$sem) { return $out; }

	$twinID = isset($pairs['twins'][$memberID]) ? $pairs['twins'][$memberID]['twinID'] : 0;

	$q = $db->prepare("
		SELECT e.eventID, e.eventName, e.dateMonth, e.dateDay,
		       EXISTS (SELECT 1 FROM AttendsEvent t WHERE t.eventID = e.eventID AND t.memberID = :twin) AS together
		FROM Event e
		WHERE e.isFamilyEvent = 0
		  AND e.dateYear = :y AND e.dateMonth BETWEEN :m1 AND :m2
		  AND STR_TO_DATE(CONCAT(e.dateMonth,'/',e.dateDay,'/',e.dateYear),'%m/%d/%Y') <= CURDATE()
		  AND e.eventID IN (SELECT a.eventID FROM AttendsEvent a WHERE a.memberID = :me)
		ORDER BY e.dateMonth, e.dateDay, e.eventName");
	$q->execute(array('twin' => $twinID, 'y' => $sem['year'], 'm1' => $sem['from'], 'm2' => $sem['to'], 'me' => $memberID));
	$out['events'] = $q->fetchAll(PDO::FETCH_ASSOC);

	foreach ($out['events'] as $event) {
		if ($event['together']) { $out['together']++; }
	}

	if ($twinID) {
		$q = $db->prepare("
			SELECT m.memberID, m.firstName, m.lastName, m.status, f.familyName
			FROM Member m
			LEFT JOIN Family f ON f.familyID = m.memFamilyID
			WHERE m.memberID = :twin");
		$q->execute(array('twin' => $twinID));
		$out['twin'] = $q->fetch(PDO::FETCH_ASSOC);
	}
	return $out;
}
