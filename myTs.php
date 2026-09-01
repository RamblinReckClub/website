<?php
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
	require "lib/tplan.php";
	$pageTitle = "My Ts";

	// Probates, Probate Guides and Admins only. A general member gets nothing.
	tplan_guard($status, $isProbateGuide, $isAdmin);

	// Guides and Admins may look at anyone. A probate only ever sees themselves.
	$canViewOthers = ($isProbateGuide == 1 || $isAdmin == 1);
	$viewID = isset($_GET['memberId']) ? (int)$_GET['memberId'] : $memberID;
	if ($viewID != $memberID && !$canViewOthers) { $viewID = $memberID; }
	$canEdit = ($viewID == $memberID);   // only the probate ticks their own boxes

	$who = $db->prepare("SELECT firstName, lastName, status, reckerPair FROM Member WHERE memberID = :m");
	$who->execute(array('m'=>$viewID));
	$probate = $who->fetch(PDO::FETCH_ASSOC);
	if (!$probate) { header('Location: points.php'); exit; }

	$rpName = '';
	if (!empty($probate['reckerPair'])) {
		$rp = $db->prepare("SELECT firstName, lastName FROM Member WHERE memberID = :m");
		$rp->execute(array('m'=>$probate['reckerPair']));
		$r = $rp->fetch(PDO::FETCH_ASSOC);
		if ($r) { $rpName = $r['firstName'].' '.$r['lastName']; }
	}

	$plan      = tplan_load('fall-2026');
	$events    = tplan_events($db, $viewID);
	$checks    = tplan_checks($db, $viewID, $plan['key']);
	$overrides = tplan_overrides($db, $viewID, $plan['key']);

	$general = array();
	foreach ($plan['general'] as $p) { $r = tplan_part($p,$events,$checks,$overrides); $r['def']=$p; $general[]=$r; }

	$mandatory = array();
	foreach ($plan['mandatory'] as $t) { $mandatory[] = tplan_t($t,$events,$checks,$overrides); }
	$mandDone = 0; foreach ($mandatory as $t) { if ($t['done']) { $mandDone++; } }

	$elective = array();
	foreach ($plan['elective']['ts'] as $t) { $elective[] = tplan_t($t,$events,$checks,$overrides); }
	$elecDone = 0; foreach ($elective as $t) { if ($t['done']) { $elecDone++; } }

	$makeups = array(); $mkUsed = 0;
	foreach ($plan['makeup']['ts'] as $m) {
		$r = tplan_part($m,$events,$checks,$overrides); $r['def']=$m; $makeups[]=$r;
		if ($r['done']) { $mkUsed++; }
	}

	$memberList = $db->query("SELECT memberID, firstName, lastName FROM Member
	                          WHERE status IN ('member','probate') ORDER BY firstName, lastName")->fetchAll(PDO::FETCH_ASSOC);

	$conflicts = tplan_conflicts(array_merge($mandatory, $elective));
	$daysLeft  = (int)floor((strtotime($plan['deadline']) - time()) / 86400);

	$errs = array(
		'dupmember'  => 'You already logged a hangout with that member. Each member can only count once.',
		'rpcap'      => 'That is your RP, and only three hangouts with your own RP can count.',
		'whomissing' => 'Pick who the hangout was with.',
		'badreq'     => 'That is not a self-checked requirement.',
	);
	$err = (isset($_GET['err']) && isset($errs[$_GET['err']])) ? $errs[$_GET['err']] : '';

	function t_seg($have, $need, $ok = false) {
		$out = '<div class="t-seg">';
		for ($i = 0; $i < $need; $i++) {
			$out .= '<i class="'.($i < $have ? ($ok ? 'ok' : 'on') : '').'"></i>';
		}
		return $out.'</div>';
	}
	function t_pct($have, $need) { return ($need > 0) ? min(100, round(($have / $need) * 100)) : 0; }

	// Add / remove controls for a self-checked requirement.
	function t_self($p, $memberList, $canEdit) {
		if ($p['def']['mode'] !== 'self' || !$canEdit) { return ''; }
		$key  = htmlspecialchars($p['def']['key']);
		$isHo = ($p['def']['key'] === 'hangouts');
		$h = '<div class="t-ents" id="'.$key.'">';
		foreach ($p['entries'] as $e) {
			$label = $e['withName'] ? $e['withName'] : $e['note'];
			if ($e['withName'] && $e['note']) { $label = $e['withName'].' &mdash; '.htmlspecialchars($e['note']); }
			else { $label = htmlspecialchars($label ? $label : 'Logged'); }
			if ($e['withName']) { $label = '<b>'.htmlspecialchars($e['withName']).'</b>'.($e['note'] ? ' &mdash; '.htmlspecialchars($e['note']) : ''); }
			else { $label = '<b>'.htmlspecialchars($e['note'] ? $e['note'] : 'Logged').'</b>'; }
			$h .= '<form action="updateTs.php" method="POST" class="t-ent">'
			   .  $label
			   .  '<input type="hidden" name="action" value="remove">'
			   .  '<input type="hidden" name="reqKey" value="'.$key.'">'
			   .  '<input type="hidden" name="entryID" value="'.(int)$e['entryID'].'">'
			   .  '<button type="submit" title="Remove" aria-label="Remove entry">&times;</button></form>';
		}
		if ($p['have'] < $p['need']) {
			$h .= '<form action="updateTs.php" method="POST" class="t-add">'
			   .  '<input type="hidden" name="action" value="add">'
			   .  '<input type="hidden" name="reqKey" value="'.$key.'">';
			if ($isHo) {
				$h .= '<select name="withMemberID" class="form-control form-control-sm" required><option value="">Who with&hellip;</option>';
				foreach ($memberList as $m) {
					$h .= '<option value="'.(int)$m['memberID'].'">'.htmlspecialchars($m['firstName'].' '.$m['lastName']).'</option>';
				}
				$h .= '</select>';
			}
			$h .= '<input type="text" name="note" class="form-control form-control-sm" maxlength="255" placeholder="'
			   .  ($isHo ? 'What you did' : 'Add a note').'">'
			   .  '<button type="submit" class="btn btn-sm btn-outline-primary">Add</button></form>';
		}
		return $h.'</div>';
	}

	// One requirement row.
	function t_row($p, $memberList, $canEdit) {
		$pct = t_pct($p['have'], $p['need']);
		$src = ($p['def']['mode'] === 'auto') ? '<i class="t-src auto t-up">auto</i>' : '<i class="t-src t-up">self</i>';
		echo '<div class="t-p"><div><span class="t-lab">'.htmlspecialchars($p['def']['label']).$src.'</span>';
		if (!empty($p['short'])) {
			echo '<span class="t-warn">Still need at least one: '.htmlspecialchars(implode(', ', $p['short'])).'</span>';
		}
		if (!empty($p['def']['desc'])) { echo '<span class="t-desc">'.htmlspecialchars($p['def']['desc']).'</span>'; }
		if (!empty($p['def']['hint'])) { echo '<span class="t-meta">'.htmlspecialchars($p['def']['hint']).'</span>'; }
		if (!empty($p['over'])) {
			echo '<span class="t-warn">'.($p['have'] - $p['def']['cap']).' past the cap of '.(int)$p['def']['cap'].' &mdash; extras do not add to your total.</span>';
		}
		if (!empty($p['buckets'])) {
			$bits = array();
			foreach ($p['buckets'] as $b => $n) { $bits[] = htmlspecialchars($b).' '.(int)$n; }
			echo '<span class="t-meta">'.implode(' &middot; ', $bits).'</span>';
		} elseif (!empty($p['events'])) {
			$ns = array();
			foreach (array_slice($p['events'], 0, 3) as $e) {
				$ns[] = '<i class="t-ev t-ev-'.htmlspecialchars($e['type']).'"></i>'.htmlspecialchars($e['eventName']);
			}
			echo '<span class="t-meta">'.implode(', ', $ns).(count($p['events']) > 3 ? ' +'.(count($p['events']) - 3).' more' : '').'</span>';
		}
		echo t_self($p, $memberList, $canEdit);
		$barCls = isset($p['def']['cap']) ? 'cap' : ($p['done'] ? 'full' : '');
		$capNote = isset($p['def']['cap']) ? '<small>max</small>' : '';
		echo '</div><div class="t-bar"><i class="'.$barCls.'" style="width:'.$pct.'%"></i></div>'
		   . '<div class="t-pv'.($p['done'] && !isset($p['def']['cap']) ? ' done' : '').'">'.$p['have'].'/'.$p['need'].$capNote.'</div></div>';
	}
?>
<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<link rel="stylesheet" href="/css/tplan.css?v=<?php echo filemtime(dirname(__FILE__).'/css/tplan.css'); ?>">
<body>
<?php require "partials/header.php"; ?>

<div class="container t-wrap mb-5">

	<?php if ($viewID != $memberID): ?>
	<div class="mb-2"><a href="/probateTs.php" style="font-size:.85rem;">&larr; All probates</a></div>
	<?php endif; ?>

	<div class="t-board">
		<div class="t-board-top">
			<h1 class="t-cond"><?= htmlspecialchars($probate['firstName'].' '.$probate['lastName']) ?></h1>
			<span>
				<span class="t-tag t-up"><?= htmlspecialchars($probate['status']) ?></span>
				<?php if ($rpName): ?><span class="t-tag t-up">RP &middot; <?= htmlspecialchars($rpName) ?></span><?php endif; ?>
				<span class="t-tag t-up"><?= htmlspecialchars($plan['name']) ?></span>
			</span>
		</div>

		<div class="t-stats">
			<div class="t-stat">
				<div class="n t-cond"><?= $mandDone ?><small>/4</small></div>
				<div class="l t-up">Mandatory Ts</div>
				<?= t_seg($mandDone, 4, true) ?>
			</div>
			<div class="t-stat">
				<div class="n t-cond"><?= $elecDone ?><small>/<?= $plan['elective']['need'] ?></small></div>
				<div class="l t-up">Elective Ts</div>
				<?= t_seg($elecDone, $plan['elective']['need'], true) ?>
			</div>
			<div class="t-stat">
				<div class="n t-cond"><?= $mkUsed ?><small>/<?= $plan['makeup']['max'] ?></small></div>
				<div class="l t-up">Make-ups used</div>
				<?= t_seg($mkUsed, $plan['makeup']['max']) ?>
			</div>
			<div class="t-stat">
				<div class="n t-cond" style="color:var(--t-gold-deep)"><?= max(0, $daysLeft) ?></div>
				<div class="l t-up">Days remaining</div>
				<div class="t-meta" style="margin-top:.55rem">Due Mon Nov 16, 12:00 PM</div>
			</div>
		</div>

		<?php if ($conflicts): ?>
		<div class="t-flag">
			<i class="rail"></i>
			<div>
				<b class="t-up"><?= count($conflicts) ?> event<?= count($conflicts)==1?'':'s' ?> counted in more than one place</b>
				<ul>
				<?php foreach (array_slice($conflicts, 0, 3, true) as $c): ?>
					<li><?= htmlspecialchars($c['name']) ?> &mdash; <?= htmlspecialchars(implode('; ', array_slice($c['in'], 0, 2))) ?></li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<?php endif; ?>
	</div>

	<?php if ($err): ?><div class="alert alert-danger" style="font-size:.85rem;"><?= htmlspecialchars($err) ?></div><?php endif; ?>

	<div class="t-sec"><h2 class="t-up">General requirements</h2></div>
	<div class="t-card"><div class="t-parts">
		<?php foreach ($general as $g) { t_row($g, $memberList, $canEdit); } ?>
	</div></div>

	<div class="t-sec"><h2 class="t-up">Mandatory</h2><span class="t-up">All four required</span></div>
	<?php foreach ($mandatory as $t): ?>
	<div class="t-card a-<?= htmlspecialchars(isset($t['def']['accent'])?$t['def']['accent']:'navy') ?><?= $t['done'] ? ' done' : '' ?>">
		<div class="t-crest"></div>
		<div class="t-head">
			<h3 class="t-cond"><?= htmlspecialchars($t['def']['name']) ?>
				<span class="blurb"><?= htmlspecialchars($t['def']['blurb']) ?></span></h3>
			<?php
				$blockers = 0;
				foreach ($t['parts'] as $p) { if (!$p['done'] && ($p['have'] > 0 || !empty($p['short']))) { $blockers++; } }
				if ($t['done']) { echo '<span class="t-chip t-c-ok t-up">Complete</span>'; }
				elseif ($blockers) { echo '<span class="t-chip t-c-hot t-up">'.$blockers.' to finish</span>'; }
				elseif ($t['complete']) { echo '<span class="t-chip t-c-go t-up">In progress</span>'; }
				else { echo '<span class="t-chip t-c-no t-up">Not started</span>'; }
			?>
			<span class="t-score t-cond"><?= $t['complete'] ?><small>/<?= $t['needParts'] ?></small></span>
		</div>
		<div class="t-parts">
			<?php foreach ($t['parts'] as $p) { t_row($p, $memberList, $canEdit); } ?>
		</div>
	</div>
	<?php endforeach; ?>

	<div class="t-sec"><h2 class="t-up">Elective focus</h2><span class="t-up">Any <?= $plan['elective']['need'] ?></span></div>
	<?php foreach ($elective as $t): ?>
	<div class="t-card a-<?= htmlspecialchars(isset($t['def']['accent'])?$t['def']['accent']:'buzz') ?><?= $t['done'] ? ' done' : '' ?>">
		<div class="t-crest"></div>
		<div class="t-head">
			<h3 class="t-cond"><?= htmlspecialchars($t['def']['name']) ?>
				<span class="blurb"><?= htmlspecialchars($t['def']['blurb']) ?></span></h3>
			<?php if ($t['done']): ?><span class="t-chip t-c-ok t-up">Complete</span>
			<?php else: $left = 0; foreach ($t['parts'] as $p) { $left += max(0, $p['need'] - $p['have']); } ?>
				<span class="t-chip t-c-go t-up"><?= $left ?> to go</span><?php endif; ?>
			<?php $hp = $t['parts'][0]; foreach ($t['parts'] as $cand) { if (!empty($cand['def']['sum'])) { $hp = $cand; break; } } ?>
			<span class="t-score t-cond"><?= $hp['have'] ?><small>/<?= $hp['need'] ?></small></span>
		</div>
		<?php if (!$t['done']): ?>
		<div class="t-parts">
			<?php foreach ($t['parts'] as $p) { t_row($p, $memberList, $canEdit); } ?>
		</div>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>

	<div class="t-sec"><h2 class="t-up">Make-up Ts</h2><span class="t-up">Up to <?= $plan['makeup']['max'] ?></span></div>
	<div class="t-card"><div class="t-parts">
		<?php foreach ($makeups as $m) {
			$m['def']['label'] = $m['def']['name'];
			$m['def']['hint']  = $m['def']['blurb'];
			t_row($m, $memberList, $canEdit);
		} ?>
	</div></div>

</div>

<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>
</body>
</html>
