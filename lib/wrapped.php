<?php
// Reck Club Wrapped. One member's calendar year, worked out from attendance alone.
//
// Everything comes from AttendsEvent joined to Event, so rows whose event is gone
// (see allTimeEvents.php) drop out. Only events held through today count, and the
// year runs Jan 1 - Dec 31 rather than by semester.
//
// The numbers are never stored. The same attendance always gives the same page.
// What is stored is who may see it. Until an admin acts, only admins can. Releasing
// a year (WrappedRelease) shows every member their own; sending it to one member
// (WrappedSend) shows just them. Either way it sits on their points page for
// WRAPPED_SHOW_DAYS days and then comes down again.
// See docs/WRAPPED.md.

define('WRAPPED_COMPANIONS', 5);  // how many companions the card lists
define('WRAPPED_DEEP_CUTS', 3);   // how many of the member's smallest events it lists
define('WRAPPED_SHOW_DAYS', 5);   // how long a released or sent Wrapped stays up for members

// Every year an admin has released, newest first: year => array(releasedAt, expiresAt,
// active, firstName, lastName). A release stays up for WRAPPED_SHOW_DAYS days. Empty
// if the table has not been created yet, so the nav never breaks a page.
function wrapped_released($db) {
	static $released = null;
	if ($released !== null) { return $released; }
	$released = array();
	try {
		$q = $db->query("
			SELECT r.year, r.releasedAt, m.firstName, m.lastName,
			       r.releasedAt + INTERVAL ".(int)WRAPPED_SHOW_DAYS." DAY AS expiresAt,
			       (r.releasedAt + INTERVAL ".(int)WRAPPED_SHOW_DAYS." DAY > NOW()) AS active
			FROM WrappedRelease r
			LEFT JOIN Member m ON m.memberID = r.releasedBy
			ORDER BY r.year DESC");
		while ($row = $q->fetch(PDO::FETCH_ASSOC)) { $released[(int)$row['year']] = $row; }
	} catch (PDOException $e) {}
	return $released;
}

// One member's years that an admin has sent to them and that are still inside the
// WRAPPED_SHOW_DAYS window, newest first: year => array(year, sentAt, expiresAt).
function wrapped_sent($db, $memberID) {
	static $cache = array();
	$memberID = (int)$memberID;
	if (isset($cache[$memberID])) { return $cache[$memberID]; }
	$sent = array();
	try {
		$q = $db->prepare("
			SELECT year, sentAt, sentAt + INTERVAL ".(int)WRAPPED_SHOW_DAYS." DAY AS expiresAt
			FROM WrappedSend
			WHERE memberID = :m AND sentAt + INTERVAL ".(int)WRAPPED_SHOW_DAYS." DAY > NOW()
			ORDER BY year DESC");
		$q->execute(array('m' => $memberID));
		while ($row = $q->fetch(PDO::FETCH_ASSOC)) { $sent[(int)$row['year']] = $row; }
	} catch (PDOException $e) {}
	return $cache[$memberID] = $sent;
}

// What a member may open right now, newest first: year => when it comes down. That is
// every release still inside its window, plus anything sent to them that is too.
function wrapped_visible($db, $memberID) {
	$until = array();
	foreach (wrapped_released($db) as $year => $row) {
		if ($row['active']) { $until[$year] = $row['expiresAt']; }
	}
	foreach (wrapped_sent($db, $memberID) as $year => $row) {
		if (!isset($until[$year]) || $row['expiresAt'] > $until[$year]) { $until[$year] = $row['expiresAt']; }
	}
	krsort($until);
	return $until;
}

// Admins always get in. Everyone else only for a year they are allowed to open.
function wrapped_guard($db, $isAdmin, $memberID, $to = 'points.php') {
	if ($isAdmin == 1 || count(wrapped_visible($db, $memberID)) > 0) { return; }
	header('Location: '.$to);
	exit;
}

// Show a year to every member, or take it back. Releasing again restarts the clock.
function wrapped_release($db, $year, $byMemberID) {
	$q = $db->prepare("REPLACE INTO WrappedRelease (year, releasedAt, releasedBy) VALUES (:y, NOW(), :m)");
	$q->execute(array('y' => (int)$year, 'm' => (int)$byMemberID));
}
function wrapped_unrelease($db, $year) {
	$q = $db->prepare("DELETE FROM WrappedRelease WHERE year = :y");
	$q->execute(array('y' => (int)$year));
}

// Send one member their year, or take it back. Sending again restarts the clock.
function wrapped_send($db, $memberID, $year, $byMemberID) {
	$q = $db->prepare("REPLACE INTO WrappedSend (memberID, year, sentAt, sentBy) VALUES (:m, :y, NOW(), :b)");
	$q->execute(array('m' => (int)$memberID, 'y' => (int)$year, 'b' => (int)$byMemberID));
}
function wrapped_unsend($db, $memberID, $year) {
	$q = $db->prepare("DELETE FROM WrappedSend WHERE memberID = :m AND year = :y");
	$q->execute(array('m' => (int)$memberID, 'y' => (int)$year));
}

// For the admin bar: when a member was last sent a year, whether or not it has run out.
function wrapped_send_status($db, $memberID, $year) {
	try {
		$q = $db->prepare("
			SELECT sentAt, sentAt + INTERVAL ".(int)WRAPPED_SHOW_DAYS." DAY AS expiresAt,
			       (sentAt + INTERVAL ".(int)WRAPPED_SHOW_DAYS." DAY > NOW()) AS active
			FROM WrappedSend WHERE memberID = :m AND year = :y");
		$q->execute(array('m' => (int)$memberID, 'y' => (int)$year));
		$row = $q->fetch(PDO::FETCH_ASSOC);
		return $row ? $row : null;
	} catch (PDOException $e) { return null; }
}

// Years that have events held, newest first, for the year picker.
function wrapped_years($db) {
	$q = $db->query("
		SELECT DISTINCT dateYear
		FROM Event
		WHERE STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear),'%m/%d/%Y') <= CURDATE()
		ORDER BY dateYear DESC");
	return array_map('intval', $q->fetchAll(PDO::FETCH_COLUMN));
}

// Sports a member can be "a regular" at. Matched on name within sports and mandatory
// events, skipping intramurals - see the keyword AND type note in CLAUDE.md.
function wrapped_sports() {
	return array('football', 'basketball', 'volleyball', 'baseball', 'softball', 'hockey',
	             'soccer', 'tennis', 'lacrosse', 'swim', 'golf', 'track');
}

// The headline and line for the mix card, by the type the member went to most.
function wrapped_persona($type, $n) {
	return match ($type) {
		'social'    => array('Social butterfly', 'If there was a hangout, you were probably already there. '.$n.' socials this year.'),
		'sports'    => array('Sideline regular', 'Rain, cold, extra innings - you were in the stands. '.$n.' games this year.'),
		'work'      => array('First to volunteer', 'When something needed doing, your hand went up. '.$n.' work events this year.'),
		'mandatory' => array('Never misses a meeting', 'Nobody ever had to ask where you were. '.$n.' mandatory events this year.'),
		default     => array('A bit of everything', 'You did not pick a lane, and the club is better for it.'),
	};
}

// The sign-off, by where the member finished in the club.
function wrapped_thanks($topPercent) {
	if ($topPercent <= 10) { return 'You were one of the most present people in the whole club this year.'; }
	if ($topPercent <= 50) { return 'The Reck runs on people who show up the way you did.'; }
	return 'Every event you made it to was better with you there.';
}

// Everything the page shows for one member and year, or 'events' => 0 if they have none.
function wrapped_for($db, $memberID, $year) {
	$memberID = (int)$memberID;
	$year = (int)$year;

	$q = $db->prepare("
		SELECT m.memberID, m.firstName, m.lastName, m.status, m.joinYear, m.memFamilyID, f.familyName
		FROM Member m
		LEFT JOIN Family f ON f.familyID = m.memFamilyID
		WHERE m.memberID = :m");
	$q->execute(array('m' => $memberID));
	$member = $q->fetch(PDO::FETCH_ASSOC);
	if (!$member) { return null; }

	$out = array('member' => $member, 'year' => $year, 'events' => 0);

	$q = $db->prepare("
		SELECT eventID, eventName, type, pointValue,
		       STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear),'%m/%d/%Y') AS eventDate
		FROM Event
		WHERE dateYear = :y
		  AND STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear),'%m/%d/%Y') <= CURDATE()
		ORDER BY eventDate, eventID");
	$q->execute(array('y' => $year));
	$events = array();
	while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
		$row['pointValue'] = (int)$row['pointValue'];
		$events[(int)$row['eventID']] = $row;
	}

	$q = $db->prepare("
		SELECT DISTINCT a.memberID, a.eventID
		FROM AttendsEvent a
		JOIN Event e ON e.eventID = a.eventID
		WHERE a.memberID IS NOT NULL
		  AND e.dateYear = :y
		  AND STR_TO_DATE(CONCAT(e.dateMonth,'/',e.dateDay,'/',e.dateYear),'%m/%d/%Y') <= CURDATE()");
	$q->execute(array('y' => $year));
	$attendees = array();  // eventID => memberIDs
	$counts = array();     // memberID => events
	$points = array();     // memberID => points
	while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
		$m = (int)$row['memberID'];
		$e = (int)$row['eventID'];
		$attendees[$e][] = $m;
		$counts[$m] = isset($counts[$m]) ? $counts[$m] + 1 : 1;
		$points[$m] = (isset($points[$m]) ? $points[$m] : 0) + $events[$e]['pointValue'];
	}
	if (!isset($counts[$memberID])) { return $out; }

	// The member's own events, in date order.
	$mine = array();
	foreach ($events as $e => $event) {
		if (isset($attendees[$e]) && in_array($memberID, $attendees[$e], true)) {
			$event['headcount'] = count($attendees[$e]);
			$mine[$e] = $event;
		}
	}

	$out['events'] = $counts[$memberID];
	$out['points'] = $points[$memberID];
	$out['first']  = reset($mine);
	$out['last']   = end($mine);
	$span = (strtotime($out['last']['eventDate']) - strtotime($out['first']['eventDate'])) / 86400;
	$out['perWeek'] = ($span >= 28) ? (int)round($counts[$memberID] / ($span / 7)) : 0;
	$out['firstYear'] = ((int)$member['joinYear'] === $year);

	// Where they stand among everyone with attendance this year.
	$rank = 1;
	foreach ($counts as $n) {
		if ($n > $counts[$memberID]) { $rank++; }
	}
	$out['rank'] = $rank;
	$out['clubSize'] = count($counts);
	$out['clubAverage'] = (int)round(array_sum($counts) / count($counts));
	$out['topPercent'] = max(1, (int)ceil($rank / count($counts) * 100));
	$out['thanks'] = wrapped_thanks($out['topPercent']);

	// The mix across the four event types.
	$types = array('mandatory' => 0, 'sports' => 0, 'social' => 0, 'work' => 0);
	$typePoints = $types;
	foreach ($mine as $event) {
		$types[$event['type']]++;
		$typePoints[$event['type']] += $event['pointValue'];
	}
	arsort($types);
	arsort($typePoints);
	$out['types'] = $types;
	list($out['persona'], $out['personaLine']) = wrapped_persona(key($types), current($types));
	$out['pointsType'] = key($typePoints);
	$out['pointsTypeTotal'] = current($typePoints);

	// Who else was there.
	$together = array();
	foreach ($mine as $e => $event) {
		foreach ($attendees[$e] as $m) {
			if ($m !== $memberID) { $together[$m] = isset($together[$m]) ? $together[$m] + 1 : 1; }
		}
	}
	arsort($together);
	$out['companions'] = array();
	$top = array_slice($together, 0, WRAPPED_COMPANIONS, true);
	if (count($top) > 0) {
		$marks = implode(',', array_fill(0, count($top), '?'));
		$q = $db->prepare("SELECT memberID, firstName, lastName FROM Member WHERE memberID IN ($marks)");
		$q->execute(array_keys($top));
		$names = array();
		while ($row = $q->fetch(PDO::FETCH_ASSOC)) { $names[(int)$row['memberID']] = $row; }
		foreach ($top as $m => $n) {
			if (!isset($names[$m])) { continue; }
			$out['companions'][] = array(
				'firstName' => $names[$m]['firstName'],
				'lastName'  => $names[$m]['lastName'],
				'together'  => $n,
			);
		}
	}

	// Deep cuts: the smallest events they made it to.
	$small = $mine;
	uasort($small, function ($x, $y) {
		if ($x['headcount'] != $y['headcount']) { return $x['headcount'] - $y['headcount']; }
		return strcmp($x['eventDate'], $y['eventDate']);
	});
	$out['deepCuts'] = array_slice(array_values($small), 0, WRAPPED_DEEP_CUTS);

	// The sport they turned up to most.
	$sports = array();
	foreach ($mine as $event) {
		if ($event['type'] !== 'sports' && $event['type'] !== 'mandatory') { continue; }
		if (preg_match('/\bIM\b/i', $event['eventName'])) { continue; }
		foreach (wrapped_sports() as $sport) {
			if (stripos($event['eventName'], $sport) !== false) {
				$sports[$sport] = isset($sports[$sport]) ? $sports[$sport] + 1 : 1;
				break;
			}
		}
	}
	arsort($sports);
	$out['sport'] = (count($sports) > 0) ? array('name' => key($sports), 'games' => current($sports)) : null;

	// Rhythm: events a month, the weekday they favour, their fullest day, and the
	// longest run of Monday-to-Sunday weeks with at least one event.
	$months = array_fill(1, 12, 0);
	$weekdays = array();
	$days = array();
	$weeks = array();
	foreach ($mine as $event) {
		$time = strtotime($event['eventDate']);
		$months[(int)date('n', $time)]++;
		$weekday = date('l', $time);
		$weekdays[$weekday] = isset($weekdays[$weekday]) ? $weekdays[$weekday] + 1 : 1;
		$days[$event['eventDate']][] = $event['eventName'];
		$weeks[date('Y-m-d', strtotime('monday this week', $time))] = true;
	}
	$out['months'] = $months;
	$out['peakMonth'] = array_search(max($months), $months);
	arsort($weekdays);
	$out['weekday'] = array('name' => key($weekdays), 'events' => current($weekdays));

	$bigDay = null;
	foreach ($days as $date => $names) {
		if ($bigDay === null || count($names) > count($days[$bigDay])) { $bigDay = $date; }
	}
	$out['bigDay'] = array('date' => $bigDay, 'names' => $days[$bigDay]);

	$streak = 0;
	$run = 0;
	$last = null;
	foreach (array_keys($weeks) as $monday) {
		$run = ($last !== null && strtotime($last.' +7 days') === strtotime($monday)) ? $run + 1 : 1;
		$streak = max($streak, $run);
		$last = $monday;
	}
	$out['streak'] = $streak;

	// Their place in their family, counting the members familyPoints counts.
	$out['family'] = null;
	if ($member['memFamilyID'] !== null) {
		$q = $db->prepare("SELECT memberID FROM Member WHERE memFamilyID = :f AND (status != 'alumni' OR memberID = :m)");
		$q->execute(array('f' => $member['memFamilyID'], 'm' => $memberID));
		$familyRank = 1;
		$familyPoints = 0;
		$familySize = 0;
		foreach ($q->fetchAll(PDO::FETCH_COLUMN) as $m) {
			$p = isset($points[(int)$m]) ? $points[(int)$m] : 0;
			$familySize++;
			$familyPoints += $p;
			if ($p > $points[$memberID]) { $familyRank++; }
		}
		$out['family'] = array(
			'name'  => $member['familyName'],
			'rank'  => $familyRank,
			'size'  => $familySize,
			'share' => ($familyPoints > 0) ? (int)round($points[$memberID] / $familyPoints * 100) : 0,
		);
	}

	return $out;
}
