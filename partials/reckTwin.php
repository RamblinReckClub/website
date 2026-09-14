<?php
	// Your Reck Twin: the active member whose events overlap most with yours.
	// Scored as shared / (yours + theirs - shared). A raw shared count crowns
	// whoever goes to everything - on Fall 2025 it picked the same 4 people for all 52.
	// Expects $db and $memberID.

	$twinDate = "STR_TO_DATE(CONCAT(e.dateMonth,'/',e.dateDay,'/',e.dateYear),'%m/%d/%Y')";

	// Score it on the current semester, or the latest one you went to anything in,
	// so nobody's card sits empty for the first week of a semester.
	$twinSemQuery = $db->prepare("SELECT e.dateYear AS y, IF(e.dateMonth <= 7, 1, 8) AS m1
	                              FROM AttendsEvent a JOIN Event e ON e.eventID = a.eventID
	                              WHERE a.memberID = :me AND e.isFamilyEvent = 0 AND $twinDate <= CURDATE()
	                              ORDER BY e.dateYear DESC, m1 DESC
	                              LIMIT 1");
	$twinSemQuery->execute(array('me' => $memberID));
	$twinSem = $twinSemQuery->fetch(PDO::FETCH_ASSOC);

	$twin = null;
	$twinEvents = array();
	$twinLabel = '';

	if ($twinSem) {
		$twinY  = (int)$twinSem['y'];
		$twinM1 = (int)$twinSem['m1'];
		$twinM2 = ($twinM1 == 1) ? 7 : 12;
		$twinWindow = "e.isFamilyEvent = 0 AND e.dateYear = $twinY AND e.dateMonth BETWEEN $twinM1 AND $twinM2 AND $twinDate <= CURDATE()";

		$isCurrent = ($twinY == (int)date('Y') && $twinM1 == ((int)date('n') <= 7 ? 1 : 8));
		$twinLabel = $isCurrent ? 'This semester' : (($twinM1 == 1 ? 'Spring ' : 'Fall ').$twinY);

		$twinQuery = $db->prepare("
			WITH mine AS (
				SELECT DISTINCT a.eventID
				FROM AttendsEvent a JOIN Event e ON e.eventID = a.eventID
				WHERE a.memberID = :me1 AND $twinWindow
			),
			theirs AS (
				SELECT DISTINCT a.memberID, a.eventID
				FROM AttendsEvent a
				JOIN Event e ON e.eventID = a.eventID
				JOIN Member o ON o.memberID = a.memberID
				WHERE a.memberID <> :me2 AND o.status IN ('member', 'probate', 'social') AND $twinWindow
			),
			theirCount AS (SELECT memberID, COUNT(*) AS n FROM theirs GROUP BY memberID),
			shared AS (SELECT t.memberID, COUNT(*) AS s FROM theirs t JOIN mine m ON m.eventID = t.eventID GROUP BY t.memberID)
			SELECT sh.memberID, sh.s AS shared, (SELECT COUNT(*) FROM mine) AS mineCount,
			       o.firstName, o.lastName, o.status, f.familyName, o.memFamilyID
			FROM shared sh
			JOIN theirCount c ON c.memberID = sh.memberID
			JOIN Member o ON o.memberID = sh.memberID
			LEFT JOIN Family f ON f.familyID = o.memFamilyID
			ORDER BY sh.s / ((SELECT COUNT(*) FROM mine) + c.n - sh.s) DESC, sh.s DESC, o.lastName
			LIMIT 1");
		$twinQuery->execute(array('me1' => $memberID, 'me2' => $memberID));
		$twin = $twinQuery->fetch(PDO::FETCH_ASSOC);

		if ($twin) {
			$twinEventsQuery = $db->prepare("
				SELECT e.eventID, e.eventName, e.dateMonth, e.dateDay,
				       EXISTS (SELECT 1 FROM AttendsEvent t WHERE t.eventID = e.eventID AND t.memberID = :twin) AS together
				FROM Event e
				WHERE $twinWindow
				  AND e.eventID IN (SELECT a.eventID FROM AttendsEvent a WHERE a.memberID = :me)
				ORDER BY e.dateMonth, e.dateDay, e.eventName");
			$twinEventsQuery->execute(array('twin' => $twin['memberID'], 'me' => $memberID));
			$twinEvents = $twinEventsQuery->fetchAll(PDO::FETCH_ASSOC);
		}
	}
?>

<style>
	.rrc-twin { border: 1px solid #dee2e6; border-radius: 8px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; }
	.rrc-twin-who { display: flex; align-items: center; gap: 12px; }
	.rrc-twin-avatar { width: 46px; height: 46px; border-radius: 50%; background: #b3a369; color: #fff; font-weight: 700; font-size: 1rem; line-height: 46px; text-align: center; flex: none; box-shadow: 0 0 0 3px #f1efe8; }
	.rrc-twin-name { font-family: 'Roboto Slab', Georgia, serif; font-size: 1.25rem; line-height: 1.2; }
	.rrc-twin-sub { font-size: .8rem; color: #6c757d; }
	.rrc-twin-count { margin: .8rem 0 .5rem; font-size: .9rem; color: #495057; }
	.rrc-twin-count b { color: #212529; font-size: 1.05rem; }
	.rrc-twin-strip { display: flex; flex-wrap: wrap; gap: 4px; }
	.rrc-twin-strip i { width: 14px; height: 14px; border-radius: 3px; border: 1.5px solid #dee2e6; }
	.rrc-twin-strip i.on { background: #b3a369; border-color: #b3a369; }
	.rrc-twin-foot { border-top: 1px solid #dee2e6; margin-top: .75rem; padding-top: .5rem; display: flex; justify-content: space-between; gap: 10px; font-size: .75rem; color: #6c757d; }
	.rrc-twin-key i { display: inline-block; width: 10px; height: 10px; border-radius: 2px; border: 1.5px solid #dee2e6; vertical-align: -1px; margin: 0 4px 0 10px; }
	.rrc-twin-key i.on { background: #b3a369; border-color: #b3a369; }
</style>

<div class="rrc-twin">
	<?php if ($twin && count($twinEvents) > 0): ?>
		<div class="rrc-twin-who">
			<span class="rrc-twin-avatar"><?php echo htmlspecialchars(strtoupper(substr($twin['firstName'], 0, 1).substr($twin['lastName'], 0, 1))); ?></span>
			<div>
				<div class="rrc-twin-name"><?php echo htmlspecialchars($twin['firstName'].' '.$twin['lastName']); ?></div>
				<div class="rrc-twin-sub">
					<?php echo htmlspecialchars((strlen((string)$twin['familyName']) > 0) ? $twin['familyName'] : 'No family'); ?>
					&middot; <?php echo htmlspecialchars($twin['status']); ?>
				</div>
			</div>
		</div>

		<p class="rrc-twin-count">There for <b><?php echo (int)$twin['shared']; ?></b> of your <?php echo count($twinEvents); ?> events</p>

		<div class="rrc-twin-strip" role="img" aria-label="<?php echo (int)$twin['shared']; ?> of your <?php echo count($twinEvents); ?> events shared">
			<?php foreach ($twinEvents as $twinEvent): ?>
				<i class="<?php echo $twinEvent['together'] ? 'on' : ''; ?>" title="<?php echo htmlspecialchars($twinEvent['eventName'].' ('.$twinEvent['dateMonth'].'/'.$twinEvent['dateDay'].') - '.($twinEvent['together'] ? 'together' : 'just you')); ?>"></i>
			<?php endforeach; ?>
		</div>

		<div class="rrc-twin-foot">
			<span><?php echo htmlspecialchars($twinLabel); ?></span>
			<span class="rrc-twin-key"><i class="on"></i>together<i></i>just you</span>
		</div>
	<?php else: ?>
		<p class="mb-0 text-muted">Check off a few events and your twin will show up here.</p>
	<?php endif; ?>
</div>
