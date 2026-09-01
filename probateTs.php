<?php
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
	require "lib/tplan.php";
	$pageTitle = "Probate Ts";

	// Probate Guides and Admins only.
	if ($isProbateGuide != 1 && $isAdmin != 1) {
		header('Location: points.php');
		exit;
	}

	$plan     = tplan_load('fall-2026');
	$daysLeft = (int)floor((strtotime($plan['deadline']) - time()) / 86400);

	// How far through the semester are we? A probate is only "at risk" if they are
	// well behind the pace the calendar sets, not simply because it is still early.
	$span    = strtotime($plan['deadline']) - strtotime($plan['start']);
	$elapsed = $span > 0 ? max(0, min(1, (time() - strtotime($plan['start'])) / $span)) : 1;
	$expected = (int)round($elapsed * 100);

	$probates = $db->query("SELECT memberID, firstName, lastName
	                        FROM Member WHERE status = 'probate'
	                        ORDER BY lastName, firstName")->fetchAll(PDO::FETCH_ASSOC);

	$rows = array();
	foreach ($probates as $pr) {
		$events    = tplan_events($db, $pr['memberID']);
		$checks    = tplan_checks($db, $pr['memberID'], $plan['key']);
		$overrides = tplan_overrides($db, $pr['memberID'], $plan['key']);

		$mand = array(); $mandDone = 0;
		foreach ($plan['mandatory'] as $t) {
			$r = tplan_t($t, $events, $checks, $overrides);
			$mand[] = $r; if ($r['done']) { $mandDone++; }
		}
		$elecDone = 0;
		foreach ($plan['elective']['ts'] as $t) {
			$r = tplan_t($t, $events, $checks, $overrides);
			if ($r['done']) { $elecDone++; }
		}
		$mkUsed = 0;
		foreach ($plan['makeup']['ts'] as $m) {
			$r = tplan_part($m, $events, $checks, $overrides);
			if ($r['done']) { $mkUsed++; }
		}

		// What is still outstanding, in plain words, for the "needs" column.
		$needs = array();
		foreach ($mand as $t) {
			if ($t['done']) { continue; }
			foreach ($t['parts'] as $p) {
				if (!$p['done'] && count($needs) < 2) {
					$needs[] = $p['def']['label'].' ('.$p['have'].'/'.$p['need'].')';
				}
			}
		}

		$need     = 4 + $plan['elective']['need'];
		$pct      = (int)round((($mandDone + min($elecDone, $plan['elective']['need'])) / $need) * 100);
		$atRisk   = ($pct < $expected - 25) || ($mkUsed >= $plan['makeup']['max']);

		$rows[] = array(
			'id'=>$pr['memberID'], 'name'=>$pr['firstName'].' '.$pr['lastName'],
			'mand'=>$mandDone, 'mandT'=>$mand, 'elec'=>$elecDone, 'mk'=>$mkUsed,
			'pct'=>$pct, 'risk'=>$atRisk, 'needs'=>$needs, 'events'=>count($events),
		);
	}

	usort($rows, function($a, $b) { return $a['pct'] === $b['pct'] ? strcmp($a['name'], $b['name']) : $a['pct'] - $b['pct']; });

	$riskCount = 0; $doneCount = 0;
	foreach ($rows as $r) { if ($r['risk']) { $riskCount++; } if ($r['pct'] >= 100) { $doneCount++; } }
?>
<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<link rel="stylesheet" href="/css/tplan.css?v=<?php echo filemtime(dirname(__FILE__).'/css/tplan.css'); ?>">
<body>
<?php require "partials/header.php"; ?>

<div class="container t-wrap mb-5">

	<div class="t-board">
		<div class="t-board-top">
			<h1 class="t-cond">Probate Ts</h1>
			<span class="t-tag t-up"><?= htmlspecialchars($plan['name']) ?></span>
		</div>
		<div class="t-stats">
			<div class="t-stat">
				<div class="n t-cond"><?= count($rows) ?></div>
				<div class="l t-up">Probates</div>
			</div>
			<div class="t-stat">
				<div class="n t-cond" style="color:var(--t-ok)"><?= $doneCount ?></div>
				<div class="l t-up">Finished</div>
			</div>
			<div class="t-stat">
				<div class="n t-cond" style="color:<?= $riskCount ? 'var(--t-hot)' : 'inherit' ?>"><?= $riskCount ?></div>
				<div class="l t-up">At risk</div>
				<div class="t-meta" style="margin-top:.55rem">Behind pace (<?= $expected ?>% expected)</div>
			</div>
			<div class="t-stat">
				<div class="n t-cond" style="color:var(--t-gold-deep)"><?= max(0, $daysLeft) ?></div>
				<div class="l t-up">Days remaining</div>
				<div class="t-meta" style="margin-top:.55rem">Due Mon Nov 16, 12:00 PM</div>
			</div>
		</div>
	</div>

	<div class="t-sec">
		<h2 class="t-up">Roster</h2>
		<span class="t-up">Lowest progress first</span>
	</div>

	<div class="t-card">
		<div style="overflow-x:auto">
		<table class="t-roster">
			<thead>
				<tr>
					<th>Probate</th>
					<th>Mandatory</th>
					<th>Elective</th>
					<th>Make-ups</th>
					<th>Events</th>
					<th style="text-align:right">Overall</th>
					<th>Still needs</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($rows as $r): ?>
				<tr>
					<td class="nm"><a href="/myTs.php?memberId=<?= (int)$r['id'] ?>"><?= htmlspecialchars($r['name']) ?></a></td>
					<td>
						<div class="t-seg" style="width:74px">
						<?php foreach ($r['mandT'] as $t): ?><i class="<?= $t['done'] ? 'ok' : ($t['complete'] ? 'on' : '') ?>"></i><?php endforeach; ?>
						</div>
					</td>
					<td>
						<div class="t-seg" style="width:54px">
						<?php for ($i = 0; $i < $plan['elective']['need']; $i++): ?><i class="<?= $i < $r['elec'] ? 'ok' : '' ?>"></i><?php endfor; ?>
						</div>
					</td>
					<td><span style="color:<?= $r['mk'] >= $plan['makeup']['max'] ? 'var(--t-hot)' : 'var(--t-ink-3)' ?>"><?= $r['mk'] ?>/<?= $plan['makeup']['max'] ?></span></td>
					<td style="color:var(--t-ink-3)"><?= $r['events'] ?></td>
					<td class="t-pct" style="text-align:right;color:<?= $r['pct'] >= 100 ? 'var(--t-ok)' : ($r['risk'] ? 'var(--t-hot)' : 'inherit') ?>"><?= $r['pct'] ?>%</td>
					<td>
						<?php if ($r['pct'] >= 100): ?><span class="t-chip t-c-ok t-up">Done</span>
						<?php elseif ($r['mk'] >= $plan['makeup']['max']): ?><span class="t-chip t-c-hot t-up">Make-ups spent</span>
						<?php elseif ($r['needs']): ?><span class="t-meta" style="margin:0"><?php
							$nb=array(); foreach($r['needs'] as $n){ $nb[]=htmlspecialchars($n); } echo implode(' &middot; ',$nb); ?></span>
						<?php else: ?><span class="t-chip t-c-go t-up">In progress</span><?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			<?php if (!$rows): ?>
				<tr><td colspan="7" style="color:var(--t-ink-3)">No probates on the roster.</td></tr>
			<?php endif; ?>
			</tbody>
		</table>
		</div>
	</div>

	<p class="t-meta mt-3">Click any name to open that probate&rsquo;s dashboard. Guides can view, but only the probate can tick their own self-checked items.</p>

</div>

<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>
</body>
</html>
