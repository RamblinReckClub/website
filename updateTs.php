<?php
	// Add or remove one self-checked T Plan entry.
	// A probate may only ever touch their own entries - guides and admins can look, not tick.
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
	require "lib/tplan.php";

	$planKey = 'fall-2026';
	$plan    = tplan_load($planKey);
	$back    = 'myTs.php';

	// Only requirements the plan marks 'self' can be written. Anything else is refused,
	// so nobody can POST their way into an auto-counted requirement.
	$selfKeys = array();
	foreach ($plan['general'] as $p) { if ($p['mode']==='self') { $selfKeys[$p['key']] = true; } }
	foreach ($plan['mandatory'] as $t) { foreach ($t['parts'] as $p) { if ($p['mode']==='self') { $selfKeys[$p['key']] = true; } } }
	foreach ($plan['elective']['ts'] as $t) { foreach ($t['parts'] as $p) { if ($p['mode']==='self') { $selfKeys[$p['key']] = true; } } }
	foreach ($plan['makeup']['ts'] as $m) { if ($m['mode']==='self') { $selfKeys[$m['key']] = true; } }

	$action = isset($_POST['action']) ? $_POST['action'] : '';
	$reqKey = isset($_POST['reqKey']) ? $_POST['reqKey'] : '';

	if ($action === 'add') {
		if (!isset($selfKeys[$reqKey])) { header('Location: '.$back.'?err=badreq'); exit; }

		$note = trim(isset($_POST['note']) ? $_POST['note'] : '');
		if (strlen($note) > 255) { $note = substr($note, 0, 255); }
		$with = (isset($_POST['withMemberID']) && $_POST['withMemberID'] !== '') ? (int)$_POST['withMemberID'] : null;

		// Friendship T: one hangout per member, and at most three with your own RP.
		if ($reqKey === 'hangouts') {
			if (!$with) { header('Location: '.$back.'?err=whomissing'); exit; }
			$dup = $db->prepare("SELECT COUNT(*) c FROM ProbateTEntry
			                     WHERE memberID=:m AND planKey=:p AND reqKey='hangouts' AND withMemberID=:w");
			$dup->execute(array('m'=>$memberID, 'p'=>$planKey, 'w'=>$with));
			$row  = $dup->fetch(PDO::FETCH_ASSOC);
			$isRP = ($reckerPair !== '' && $reckerPair !== null && (int)$reckerPair === $with);
			if ($row['c'] > 0 && !$isRP) { header('Location: '.$back.'?err=dupmember'); exit; }
			if ($isRP && $row['c'] >= 3)  { header('Location: '.$back.'?err=rpcap');     exit; }
		}

		$ins = $db->prepare("INSERT INTO ProbateTEntry (memberID, planKey, reqKey, note, withMemberID)
		                     VALUES (:m, :p, :r, :n, :w)");
		$ins->execute(array('m'=>$memberID, 'p'=>$planKey, 'r'=>$reqKey,
		                    'n'=>($note === '' ? null : $note), 'w'=>$with));

	} elseif ($action === 'remove') {
		// Scoped to memberID so one probate can never delete another's entry.
		$entryID = (int)(isset($_POST['entryID']) ? $_POST['entryID'] : 0);
		$del = $db->prepare("DELETE FROM ProbateTEntry WHERE entryID = :e AND memberID = :m");
		$del->execute(array('e'=>$entryID, 'm'=>$memberID));
	}

	header('Location: '.$back.'#'.preg_replace('/[^a-z0-9\-]/i', '', $reqKey));
	exit;
