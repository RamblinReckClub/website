<?php
// T Plan evaluator. Loads a plan config, pulls a probate's attended events for the
// current points window, and works out where they stand.
// See docs/T-PLAN.md.

// Who may see anything to do with Ts. Probates see their own; Probate Guides and
// Admins see everyone. General members and socials get nothing at all.
function tplan_guard($status, $isProbateGuide, $isAdmin, $to = 'points.php') {
	if ($status === 'probate' || $isProbateGuide == 1 || $isAdmin == 1) { return; }
	header('Location: '.$to);
	exit;
}

function tplan_load($key) {
	return require dirname(__FILE__).'/../tplans/'.basename($key).'.php';
}

// Every event this member checked off inside the current semester window.
function tplan_events($db, $memberID) {
	$q = $db->prepare("
		SELECT e.eventID, e.eventName, e.type, e.dateMonth, e.dateDay, e.dateYear
		FROM AttendsEvent a
		JOIN Event e ON e.eventID = a.eventID
		WHERE a.memberID = :m
		  AND (
		        (MONTH(CURDATE()) BETWEEN 1 AND 7  AND e.dateYear = YEAR(CURDATE()) AND e.dateMonth BETWEEN 1 AND 7)
		     OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND e.dateYear = YEAR(CURDATE()) AND e.dateMonth BETWEEN 8 AND 12)
		      )
		  AND STR_TO_DATE(CONCAT(e.dateMonth,'/',e.dateDay,'/',e.dateYear),'%m/%d/%Y') <= CURDATE()
		ORDER BY e.dateMonth, e.dateDay");
	$q->execute(array('m'=>$memberID));
	return $q->fetchAll(PDO::FETCH_ASSOC);
}

// Does one event satisfy a match spec?
function tplan_match($event, $spec) {
	if (empty($spec)) { return false; }
	$name = strtolower($event['eventName']);
	if (!empty($spec['type']) && !in_array($event['type'], (array)$spec['type'])) { return false; }
	if (!empty($spec['not'])) {
		foreach ((array)$spec['not'] as $bad) { if (strpos($name, $bad) !== false) { return false; } }
	}
	if (!empty($spec['all'])) {
		foreach ((array)$spec['all'] as $need) { if (strpos($name, $need) === false) { return false; } }
	}
	if (!empty($spec['any'])) {
		foreach ((array)$spec['any'] as $ok) { if (strpos($name, $ok) !== false) { return true; } }
		return false;
	}
	return true; // type-only spec
}

// Resolve one requirement into {have, need, done, events, buckets}.
function tplan_part($part, $events, $checks, $overrides) {
	$key  = $part['key'];
	$need = isset($part['need']) ? $part['need'] : 1;
	$out  = array('need'=>$need, 'have'=>0, 'events'=>array(), 'buckets'=>array(), 'short'=>array(), 'entries'=>array());

	if ($part['mode'] === 'self') {
		$out['entries'] = isset($checks[$key]) ? $checks[$key] : array();
		$out['have']    = count($out['entries']);
	} else {
		foreach ($events as $e) {
			$eid = $e['eventID'];
			$forced = isset($overrides[$key][$eid]) ? $overrides[$key][$eid] : null;
			if ($forced === 'exclude') { continue; }
			if ($forced === 'include' || tplan_match($e, isset($part['match']) ? $part['match'] : array())) {
				$out['events'][] = $e;
			}
		}
		// "do each of these at least once" sub-buckets
		if (!empty($part['buckets'])) {
			foreach ($part['buckets'] as $label => $keys) { $out['buckets'][$label] = 0; }
			$kept = array();
			foreach ($out['events'] as $e) {
				$name = strtolower($e['eventName']);
				foreach ($part['buckets'] as $label => $keys) {
					foreach ((array)$keys as $k) {
						if (strpos($name, $k) !== false) { $out['buckets'][$label]++; $kept[] = $e; break 2; }
					}
				}
			}
			$out['events'] = $kept;
			$min = isset($part['each_at_least']) ? $part['each_at_least'] : 0;
			foreach ($out['buckets'] as $label => $n) { if ($n < $min) { $out['short'][] = $label; } }
		}
		$out['have'] = count($out['events']);
	}
	// A capped part is a ceiling, not a floor - it never blocks the T.
	if (isset($part['cap'])) {
		$out['capped'] = min($out['have'], $part['cap']);
		$out['done']   = true;
		$out['over']   = ($out['have'] > $part['cap']);
	} else {
		$out['capped'] = $out['have'];
		$out['done']   = ($out['have'] >= $need) && empty($out['short']);
	}
	return $out;
}

// Roll a T up from its parts. 'choose' means N of the parts, not all.
function tplan_t($t, $events, $checks, $overrides) {
	$parts = array(); $byKey = array();
	foreach ($t['parts'] as $p) {
		if (!empty($p['sum'])) { continue; }   // resolved below, once siblings are known
		$r = tplan_part($p, $events, $checks, $overrides);
		$r['def'] = $p;
		$parts[$p['key']] = $r; $byKey[$p['key']] = $r;
	}
	// A summing part totals the capped contributions of the parts it names.
	foreach ($t['parts'] as $p) {
		if (empty($p['sum'])) { continue; }
		$have = 0; $ev = array();
		foreach ($p['sum'] as $k) {
			if (isset($byKey[$k])) {
				$have += $byKey[$k]['capped'];
				$ev = array_merge($ev, $byKey[$k]['events']);
			}
		}
		$need = isset($p['need']) ? $p['need'] : 1;
		$parts[$p['key']] = array(
			'def'=>$p, 'need'=>$need, 'have'=>$have, 'capped'=>$have,
			'events'=>$ev, 'buckets'=>array(), 'short'=>array(), 'entries'=>array(),
			'done'=>($have >= $need),
		);
	}
	// put them back in the order the plan declares
	$ordered = array(); foreach ($t['parts'] as $p) { if (isset($parts[$p['key']])) { $ordered[] = $parts[$p['key']]; } }
	$parts = $ordered;
	$complete = 0;
	foreach ($parts as $r) { if ($r['done']) { $complete++; } }
	$needParts = isset($t['choose']) ? $t['choose'] : count($parts);
	return array(
		'def'=>$t, 'parts'=>$parts,
		'complete'=>$complete, 'needParts'=>$needParts,
		'done'=>($complete >= $needParts),
	);
}

// Any event counted by more than one requirement, which the FAQ disallows.
function tplan_conflicts($groups) {
	$seen = array(); $conf = array();
	foreach ($groups as $g) {
		foreach ($g['parts'] as $p) {
			// a summing part re-lists its siblings' events, so it is not a real conflict
			if (empty($p['events']) || !empty($p['def']['sum'])) { continue; }
			foreach ($p['events'] as $e) {
				$seen[$e['eventID']]['name'] = $e['eventName'];
				$seen[$e['eventID']]['in'][] = $g['def']['name'].' / '.$p['def']['label'];
			}
		}
	}
	foreach ($seen as $eid => $s) {
		if (count($s['in']) > 1) { $conf[$eid] = $s; }
	}
	return $conf;
}

// Self-checked entries, grouped by requirement. One row per completion.
function tplan_checks($db, $memberID, $planKey) {
	$q = $db->prepare("SELECT e.entryID, e.reqKey, e.note, e.withMemberID,
	                          CONCAT(m.firstName,' ',m.lastName) AS withName
	                   FROM ProbateTEntry e
	                   LEFT JOIN Member m ON m.memberID = e.withMemberID
	                   WHERE e.memberID=:m AND e.planKey=:p
	                   ORDER BY e.entryID");
	$q->execute(array('m'=>$memberID,'p'=>$planKey));
	$out = array();
	foreach ($q->fetchAll(PDO::FETCH_ASSOC) as $r) { $out[$r['reqKey']][] = $r; }
	return $out;
}

function tplan_overrides($db, $memberID, $planKey) {
	$q = $db->prepare("SELECT reqKey, eventID, action FROM ProbateTOverride WHERE memberID=:m AND planKey=:p");
	$q->execute(array('m'=>$memberID,'p'=>$planKey));
	$out = array();
	foreach ($q->fetchAll(PDO::FETCH_ASSOC) as $r) { $out[$r['reqKey']][$r['eventID']] = $r['action']; }
	return $out;
}
