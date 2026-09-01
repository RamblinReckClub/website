<?php
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
	require "lib/tplan.php";
	$pageTitle = "The T Plan";

	// Probates, Probate Guides and Admins only.
	tplan_guard($status, $isProbateGuide, $isAdmin);

	$plan     = tplan_load('fall-2026');
	$daysLeft = (int)floor((strtotime($plan['deadline']) - time()) / 86400);

	function tg_part($p) {
		$need = isset($p['need']) ? $p['need'] : 1;
		$src  = ($p['mode'] === 'auto')
			? '<i class="t-src auto t-up">auto</i>'
			: '<i class="t-src t-up">self</i>';
		$cap  = isset($p['cap']) ? ' max' : '';
		echo '<div class="t-guide-p"><h4>'.htmlspecialchars($p['label']).$src
		   . '<span class="t-need">'.$need.$cap.'</span></h4>';
		if (!empty($p['desc'])) { echo '<p>'.htmlspecialchars($p['desc']).'</p>'; }
		if (!empty($p['buckets'])) {
			$b = array();
			foreach ($p['buckets'] as $label => $k) { $b[] = htmlspecialchars($label); }
			echo '<p style="margin-top:.3rem"><strong>Counts:</strong> '.implode(' &middot; ', $b).'</p>';
		}
		echo '</div>';
	}
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
			<h1 class="t-cond">The T Plan</h1>
			<span>
				<span class="t-tag t-up"><?= htmlspecialchars($plan['name']) ?></span>
				<span class="t-tag t-up"><?= max(0, $daysLeft) ?> days left</span>
			</span>
		</div>
		<div style="padding:1rem 1.15rem;background:var(--t-diploma)">
			<p style="margin:0;font-size:.88rem;color:var(--t-ink-2);max-width:72ch"><?= htmlspecialchars($plan['intro']) ?></p>
			<p style="margin:.5rem 0 0;font-size:.78rem;color:var(--t-gold-deep);font-weight:600">
				Everything due Monday, November 16 at 12:00 PM.
				<?php if ($status === 'probate'): ?><a href="/myTs.php" style="margin-left:.5rem">See where you stand &rarr;</a><?php endif; ?>
			</p>
			<?php if (!empty($plan['form_url'])): ?>
			<div class="t-submit" style="margin-top:.9rem">
				<div>
					<b>Every completed T has to be submitted</b>
					<span>Finishing a T on your dashboard is not the same as submitting it. Fill in the form each time you complete one.</span>
				</div>
				<a class="t-submit-btn" href="<?= htmlspecialchars($plan['form_url']) ?>" target="_blank" rel="noopener noreferrer">
					Open the T Plan form <span aria-hidden="true">&#8599;</span>
				</a>
			</div>
			<?php endif; ?>
		</div>
		<div class="t-flag" style="background:var(--t-gold-wash);border-top:1px solid var(--t-line)">
			<i class="rail" style="background:var(--t-tech)"></i>
			<div>
				<b class="t-up" style="color:var(--t-gold-deep)">How each part is tracked</b>
				<p style="margin:0;font-size:.78rem;color:var(--t-ink-2)">
					<i class="t-src auto t-up">auto</i> counts itself from events you check off on the points page.
					<i class="t-src t-up">self</i> is yours to tick on your own dashboard - the site cannot see it.
				</p>
			</div>
		</div>
	</div>

	<div class="t-sec"><h2 class="t-up">General requirements</h2><i class="rule"></i><span class="t-up">Always on</span></div>
	<div class="t-guide-t">
		<?php foreach ($plan['general'] as $p) { tg_part($p); } ?>
	</div>

	<div class="t-sec"><h2 class="t-up">Mandatory Ts</h2><i class="rule"></i><span class="t-up">All four</span></div>
	<?php foreach ($plan['mandatory'] as $i => $t): ?>
	<div class="t-guide-t">
		<div class="t-guide-h" style="border-left:4px solid var(--t-<?= htmlspecialchars(isset($t['accent'])?$t['accent']:'navy') ?>)">
			<h3 class="t-cond"><?= ($i+1) ?>. <?= htmlspecialchars($t['name']) ?>
				<?php if (isset($t['choose'])): ?><span class="t-need">any <?= (int)$t['choose'] ?></span><?php endif; ?></h3>
			<p><?= htmlspecialchars($t['blurb']) ?></p>
		</div>
		<?php foreach ($t['parts'] as $p) { tg_part($p); } ?>
	</div>
	<?php endforeach; ?>

	<div class="t-sec"><h2 class="t-up">Elective Focus Ts</h2><i class="rule"></i><span class="t-up">Any <?= $plan['elective']['need'] ?> of <?= count($plan['elective']['ts']) ?></span></div>
	<?php foreach ($plan['elective']['ts'] as $t): ?>
	<div class="t-guide-t">
		<div class="t-guide-h" style="border-left:4px solid var(--t-<?= htmlspecialchars(isset($t['accent'])?$t['accent']:'buzz') ?>)">
			<h3 class="t-cond"><?= htmlspecialchars($t['name']) ?></h3>
			<p><?= htmlspecialchars($t['blurb']) ?></p>
		</div>
		<?php foreach ($t['parts'] as $p) { tg_part($p); } ?>
	</div>
	<?php endforeach; ?>

	<div class="t-sec"><h2 class="t-up">Make-up Ts</h2><i class="rule"></i><span class="t-up">Up to <?= $plan['makeup']['max'] ?></span></div>
	<div class="t-guide-t">
		<div class="t-guide-h" style="border-left:4px solid var(--t-gold)">
			<h3 class="t-cond">What a make-up T can replace</h3>
			<p>Tell Katie and Harrison in advance so they can approve your plan. A make-up covers part of a T, never a whole one.</p>
		</div>
		<div class="t-guide-p">
			<?php foreach ($plan['makeup_covers'] as $where => $what): ?>
				<p style="margin-bottom:.15rem"><strong><?= htmlspecialchars($where) ?>:</strong> <?= htmlspecialchars($what) ?></p>
			<?php endforeach; ?>
		</div>
	</div>
	<?php foreach ($plan['makeup']['ts'] as $m):
		$m['label'] = $m['name'];
	?>
	<div class="t-guide-t">
		<?php tg_part($m); ?>
	</div>
	<?php endforeach; ?>

	<div class="t-sec"><h2 class="t-up">Ground rules</h2><i class="rule"></i></div>
	<div class="t-guide-t">
		<div class="t-guide-p"><h4>No double-counting</h4>
			<p>One event satisfies one component of the plan, unless the Probate Guides say otherwise. Your dashboard warns you when something has landed in two places rather than blocking it, so you and the guides can sort it out.</p></div>
		<div class="t-guide-p"><h4>Overflow can move</h4>
			<p>If you go past what a component needs - a fifth non-mandatory Homecoming event, say - the extras can count elsewhere in the plan, usually as work events.</p></div>
		<div class="t-guide-p"><h4>Road games are not double here</h4>
			<p>The Social Focus T awards two for a trip because of the hours spent with the club. The Athletics Focus T only cares about the game itself, so road games count once.</p></div>
		<div class="t-guide-p"><h4>Organising a PMS</h4>
			<p>Planning a PMS counts as two social events, but it is not a component of the plan by itself. Talk to the MALs and the guides if you think your plans are big enough to count under the Important Impact T.</p></div>
	</div>

</div>

<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>
</body>
</html>
