<?php
	require "logged_in_check.php";
	require "set_session_vars_short.php";
	require "database_connect.php";
	require_once "lib/wrapped.php";
	$pageTitle = "Wrapped";

	// Admins always; everyone else only while a year released to the club, or sent to
	// them, is still up.
	wrapped_guard($db, $isAdmin, $memberID);

	// An admin can look at any year and any member. A member gets the years that are up
	// for them, and only ever their own page.
	$released = wrapped_released($db);
	$years    = ($isAdmin == 1) ? wrapped_years($db) : array_keys(wrapped_visible($db, $memberID));
	$year     = (isset($_GET['year']) && in_array((int)$_GET['year'], $years, true)) ? (int)$_GET['year'] : null;
	if ($year === null) {
		$year = in_array((int)date('Y'), $years, true) ? (int)date('Y') : (count($years) > 0 ? $years[0] : (int)date('Y'));
	}

	$who = ($isAdmin == 1 && isset($_GET['id'])) ? (int)$_GET['id'] : (int)$memberID;
	$w   = wrapped_for($db, $who, $year);
	if (!$w) {
		$who = (int)$memberID;
		$w   = wrapped_for($db, $who, $year);
	}

	$memberList = array();
	if ($isAdmin == 1) {
		$memberList = $db->query("SELECT memberID, firstName, lastName
		                          FROM Member WHERE status IN ('member', 'probate', 'social')
		                          ORDER BY lastName, firstName")->fetchAll(PDO::FETCH_ASSOC);
		if (!isset($_SESSION['wrappedToken'])) { $_SESSION['wrappedToken'] = bin2hex(random_bytes(16)); }
		$sendStatus = wrapped_send_status($db, $who, $year);
	}
	$errs = array(
		'1'     => 'That did not go through. Reload the page and try again.',
		'table' => 'The Wrapped tables have not been created yet - see docs/WRAPPED.md.',
	);
	$err = ($isAdmin == 1 && isset($_GET['err']) && isset($errs[$_GET['err']])) ? $errs[$_GET['err']] : '';

	function w_ord($n) {
		if ($n % 100 >= 11 && $n % 100 <= 13) { return $n.'th'; }
		return $n.match ($n % 10) { 1 => 'st', 2 => 'nd', 3 => 'rd', default => 'th' };
	}
	function w_n($n, $one, $many = null) {
		return number_format($n).' '.(($n == 1) ? $one : (($many === null) ? $one.'s' : $many));
	}
	function w_e($s) { return htmlspecialchars((string)$s); }
	function w_initials($person) {
		return w_e(strtoupper(substr($person['firstName'], 0, 1).substr($person['lastName'], 0, 1)));
	}
?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php"; ?>
<body>
<?php require "partials/header.php"; ?>

<style>
	.w-admin { border: 1px solid #dee2e6; border-radius: 8px; padding: .75rem 1rem; margin-bottom: 1rem; display: flex; flex-wrap: wrap; gap: 8px 12px; align-items: center; }
	.w-admin form { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin: 0; }
	.w-admin select { width: auto; }
	.w-admin .w-state { font-size: .82rem; color: #6c757d; margin-left: auto; }
	.w-admin .w-state b { color: #212529; }
	.w-admin .w-left { margin-left: 0; margin-right: auto; }
	.w-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; margin-bottom: 2rem; }
	.w-card { border-radius: 12px; padding: 1.5rem 1.6rem; min-height: 300px; display: flex; flex-direction: column; }
	.w-wide { grid-column: 1 / -1; min-height: 0; padding: 2.2rem 1.6rem; }
	.w-navy { background: #00263A; color: #fff; }
	.w-gold { background: #B3A369; color: #00263A; }
	.w-cream { background: #f5f1e3; color: #00263A; }
	.w-kicker { font-size: .78rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; margin-bottom: .5rem; opacity: .75; }
	.w-navy .w-kicker { color: #decc80; opacity: 1; }
	.w-big { font-family: 'Roboto Slab', Georgia, serif; font-weight: 700; font-size: 3.6rem; line-height: 1; margin: 0 0 .6rem; }
	.w-head { font-family: 'Roboto Slab', Georgia, serif; font-weight: 700; font-size: 1.45rem; line-height: 1.25; margin: 0 0 .7rem; }
	.w-wide .w-head { font-size: 2.2rem; margin-bottom: .5rem; }
	.w-card p { margin: 0 0 .8rem; font-size: .95rem; line-height: 1.5; }
	.w-card p:last-child { margin-bottom: 0; }
	.w-wide p { font-size: 1.05rem; max-width: 46rem; }
	.w-foot { margin-top: auto; padding-top: 1rem; font-size: .88rem; font-weight: 700; }
	.w-navy .w-foot { color: #decc80; }
	.w-list { list-style: none; padding: 0; margin: 0; }
	.w-list li { display: flex; align-items: center; gap: 10px; padding: .3rem 0; font-size: .95rem; border-bottom: 1px solid rgba(0, 38, 58, .12); }
	.w-list li:last-child { border-bottom: 0; }
	.w-list span { flex: 1; min-width: 0; }
	.w-list b { flex: none; }
	.w-avatar { flex: none; width: 30px; height: 30px; border-radius: 50%; background: #B3A369; color: #fff; font-size: .72rem; font-weight: 700; line-height: 30px; text-align: center; font-style: normal; }
	.w-bars { display: grid; grid-template-columns: 5.5rem minmax(0, 1fr) 2rem; gap: .5rem .6rem; align-items: center; font-size: .9rem; }
	.w-bars i { display: block; height: 10px; border-radius: 5px; background: #decc80; }
	.w-bars b { text-align: right; }
	.w-months { display: flex; align-items: flex-end; gap: 5px; height: 84px; }
	.w-months i { flex: 1; background: rgba(0, 38, 58, .3); border-radius: 3px 3px 0 0; min-height: 2px; }
	.w-months i.peak { background: #00263A; }
	.w-monthkey { display: flex; gap: 5px; font-size: .7rem; text-align: center; margin: 4px 0 .8rem; }
	.w-monthkey span { flex: 1; }
	.w-sign { font-family: 'Roboto Slab', Georgia, serif; color: #decc80; margin-top: 1rem; }
	@media (max-width: 767px) {
		.w-grid { grid-template-columns: minmax(0, 1fr); }
		.w-card { min-height: 0; }
		.w-big { font-size: 2.8rem; }
		.w-wide .w-head { font-size: 1.7rem; }
		.w-admin .w-state { margin-left: 0; }
	}
</style>

<div class="container">
	<?php if ($isAdmin == 1): ?>
		<?php if ($err !== ''): ?>
			<div class="alert alert-danger"><?php echo w_e($err); ?></div>
		<?php endif; ?>
		<div class="w-admin">
			<form method="get" action="wrapped.php">
				<select class="custom-select custom-select-sm" name="id" onchange="this.form.submit()" aria-label="Member">
					<?php $listed = false; foreach ($memberList as $m): $listed = $listed || ((int)$m['memberID'] === $who); ?>
						<option value="<?php echo (int)$m['memberID']; ?>"<?php echo ((int)$m['memberID'] === $who) ? ' selected' : ''; ?>><?php echo w_e($m['lastName'].', '.$m['firstName']); ?></option>
					<?php endforeach; ?>
					<?php if (!$listed): ?>
						<option value="<?php echo $who; ?>" selected><?php echo w_e($w['member']['lastName'].', '.$w['member']['firstName']); ?></option>
					<?php endif; ?>
				</select>
				<select class="custom-select custom-select-sm" name="year" onchange="this.form.submit()" aria-label="Year">
					<?php foreach ($years as $y): ?>
						<option value="<?php echo $y; ?>"<?php echo ($y === $year) ? ' selected' : ''; ?>><?php echo $y; ?></option>
					<?php endforeach; ?>
				</select>
			</form>
			<?php $rel = isset($released[$year]) ? $released[$year] : null; ?>
			<?php if ($rel && $rel['active']): ?>
				<span class="w-state"><b><?php echo $year; ?> is out to everyone.</b> On every points page until <?php echo date('M j, g:i a', strtotime($rel['expiresAt'])); ?>.</span>
			<?php elseif ($rel): ?>
				<span class="w-state"><b>Released <?php echo date('M j', strtotime($rel['releasedAt'])); ?>.</b> Those <?php echo (int)WRAPPED_SHOW_DAYS; ?> days have run out.</span>
			<?php else: ?>
				<span class="w-state"><b>Only admins can see <?php echo $year; ?>.</b> Releasing puts it on every points page for <?php echo (int)WRAPPED_SHOW_DAYS; ?> days.</span>
			<?php endif; ?>
			<form method="post" action="updateWrapped.php" onsubmit="return confirm('Release <?php echo $year; ?> Wrapped to every member? It goes on everyone\'s points page straight away and stays for <?php echo (int)WRAPPED_SHOW_DAYS; ?> days.');">
				<input type="hidden" name="year" value="<?php echo $year; ?>">
				<input type="hidden" name="id" value="<?php echo $who; ?>">
				<input type="hidden" name="action" value="release">
				<input type="hidden" name="token" value="<?php echo w_e($_SESSION['wrappedToken']); ?>">
				<button type="submit" class="btn btn-sm btn-primary"><?php echo $rel ? 'Release again' : 'Release '.$year.' to everyone'; ?></button>
			</form>
			<?php if ($rel && $rel['active']): ?>
			<form method="post" action="updateWrapped.php" onsubmit="return confirm('Take <?php echo $year; ?> Wrapped down for everyone?');">
				<input type="hidden" name="year" value="<?php echo $year; ?>">
				<input type="hidden" name="id" value="<?php echo $who; ?>">
				<input type="hidden" name="action" value="unrelease">
				<input type="hidden" name="token" value="<?php echo w_e($_SESSION['wrappedToken']); ?>">
				<button type="submit" class="btn btn-sm btn-outline-secondary">Take it back</button>
			</form>
			<?php endif; ?>
		</div>
		<?php if ($w['events'] > 0): $toName = w_e($w['member']['firstName']); ?>
		<div class="w-admin">
			<?php if ($sendStatus && $sendStatus['active']): ?>
				<span class="w-state w-left"><b>Sent to <?php echo $toName; ?> on <?php echo date('M j', strtotime($sendStatus['sentAt'])); ?>.</b> On their points page until <?php echo date('M j, g:i a', strtotime($sendStatus['expiresAt'])); ?>.</span>
			<?php elseif ($sendStatus): ?>
				<span class="w-state w-left"><b>Sent to <?php echo $toName; ?> on <?php echo date('M j', strtotime($sendStatus['sentAt'])); ?>.</b> Those <?php echo (int)WRAPPED_SHOW_DAYS; ?> days have run out.</span>
			<?php else: ?>
				<span class="w-state w-left"><b>Just for <?php echo $toName; ?>.</b> Sending puts this on their points page for <?php echo (int)WRAPPED_SHOW_DAYS; ?> days.</span>
			<?php endif; ?>
			<form method="post" action="updateWrapped.php" onsubmit="return confirm('Send this <?php echo $year; ?> Wrapped to the member you are viewing? It stays on their points page for <?php echo (int)WRAPPED_SHOW_DAYS; ?> days.');">
				<input type="hidden" name="year" value="<?php echo $year; ?>">
				<input type="hidden" name="id" value="<?php echo $who; ?>">
				<input type="hidden" name="action" value="send">
				<input type="hidden" name="token" value="<?php echo w_e($_SESSION['wrappedToken']); ?>">
				<button type="submit" class="btn btn-sm btn-primary"><?php echo $sendStatus ? 'Send again' : 'Send to '.$toName; ?></button>
			</form>
			<?php if ($sendStatus && $sendStatus['active']): ?>
			<form method="post" action="updateWrapped.php" onsubmit="return confirm('Take this Wrapped back from the member you are viewing?');">
				<input type="hidden" name="year" value="<?php echo $year; ?>">
				<input type="hidden" name="id" value="<?php echo $who; ?>">
				<input type="hidden" name="action" value="unsend">
				<input type="hidden" name="token" value="<?php echo w_e($_SESSION['wrappedToken']); ?>">
				<button type="submit" class="btn btn-sm btn-outline-secondary">Take it back</button>
			</form>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	<?php elseif (count($years) > 1): ?>
		<form class="mb-3" method="get" action="wrapped.php">
			<select class="custom-select custom-select-sm" style="width: auto;" name="year" onchange="this.form.submit()" aria-label="Year">
				<?php foreach ($years as $y): ?>
					<option value="<?php echo $y; ?>"<?php echo ($y === $year) ? ' selected' : ''; ?>><?php echo $y; ?></option>
				<?php endforeach; ?>
			</select>
		</form>
	<?php endif; ?>

	<?php if ($w['events'] == 0): ?>
		<div class="w-grid">
			<div class="w-card w-wide w-navy">
				<div class="w-kicker">Reck Club Wrapped &middot; <?php echo $year; ?></div>
				<h1 class="w-head">Nothing to wrap yet, <?php echo w_e($w['member']['firstName']); ?></h1>
				<p>No events checked off in <?php echo $year; ?>. Tick a few off and this page fills itself in.</p>
			</div>
		</div>
	<?php else: ?>
		<?php
			$name     = w_e($w['member']['firstName']);
			$first    = $w['first'];
			$types    = $w['types'];
			$typeMax  = max($types);
			$monthMax = max($w['months']);
			$bigDay   = $w['bigDay'];
			$bigCount = count($bigDay['names']);
			$cuts     = $w['deepCuts'];
			$pals     = $w['companions'];
			$ahead    = $w['events'] - $w['clubAverage'];
		?>
		<div class="w-grid">
			<div class="w-card w-wide w-navy">
				<div class="w-kicker">Reck Club Wrapped &middot; <?php echo $year; ?></div>
				<h1 class="w-head"><?php echo $name; ?>, what a <?php echo $w['firstYear'] ? 'first year' : 'year'; ?>.</h1>
				<?php if ($w['firstYear'] && $w['events'] >= 10): ?>
					<p>You walked into <?php echo w_e($first['eventName']); ?> on <?php echo date('F j', strtotime($first['eventDate'])); ?> as the new one. <?php echo w_n($w['events'], 'event'); ?> later, it is hard to picture the club without you.</p>
				<?php elseif ($w['events'] >= 10): ?>
					<p>It started with <?php echo w_e($first['eventName']); ?> on <?php echo date('F j', strtotime($first['eventDate'])); ?>, and you did not slow down. Here is your <?php echo $year; ?>, the way the club saw it.</p>
				<?php else: ?>
					<p>It started with <?php echo w_e($first['eventName']); ?> on <?php echo date('F j', strtotime($first['eventDate'])); ?>. Here is your <?php echo $year; ?>, the way the club saw it.</p>
				<?php endif; ?>
			</div>

			<div class="w-card w-gold">
				<div class="w-kicker">You showed up</div>
				<div class="w-big"><?php echo w_n($w['events'], 'time'); ?></div>
				<p>
					<?php if ($w['perWeek'] >= 2): ?>
						That is about <?php echo (int)$w['perWeek']; ?> events a week, every week, since <?php echo date('F', strtotime($first['eventDate'])); ?>.
					<?php else: ?>
						<?php echo w_n($w['events'], 'event'); ?>, and <?php echo w_n($w['points'], 'point'); ?> to show for it.
					<?php endif; ?>
					<?php if ($ahead > 0): ?>
						The average member made it to <?php echo (int)$w['clubAverage']; ?>. You cleared that by <?php echo (int)$ahead; ?>.
					<?php else: ?>
						Somebody noticed you at every single one.
					<?php endif; ?>
				</p>
				<div class="w-foot"><?php echo w_n($w['points'], 'point'); ?> &middot; <?php echo w_ord($w['rank']); ?> of <?php echo $w['clubSize']; ?> in the club<?php echo ($w['topPercent'] <= 50) ? ' &middot; top '.$w['topPercent'].'%' : ''; ?></div>
			</div>

			<div class="w-card w-cream">
				<div class="w-kicker">Your people</div>
				<?php if (count($pals) > 0): ?>
					<h2 class="w-head">
						<?php if (count($pals) > 1 && $pals[1]['together'] === $pals[0]['together']): ?>
							<?php echo w_e($pals[0]['firstName']); ?> and <?php echo w_e($pals[1]['firstName']); ?> were each there for <?php echo (int)$pals[0]['together']; ?> of your <?php echo (int)$w['events']; ?>
						<?php else: ?>
							<?php echo w_e($pals[0]['firstName']); ?> was there for <?php echo (int)$pals[0]['together']; ?> of your <?php echo (int)$w['events']; ?>
						<?php endif; ?>
					</h2>
					<p>Wherever you turned up this year, these faces were usually already there.</p>
					<ul class="w-list">
						<?php foreach ($pals as $pal): ?>
							<li><i class="w-avatar"><?php echo w_initials($pal); ?></i><span><?php echo w_e($pal['firstName'].' '.$pal['lastName']); ?></span><b><?php echo (int)$pal['together']; ?></b></li>
						<?php endforeach; ?>
					</ul>
				<?php else: ?>
					<h2 class="w-head">A solo run so far</h2>
					<p>Nobody else has checked off the same events yet. Bring a friend next time.</p>
				<?php endif; ?>
			</div>

			<div class="w-card w-navy">
				<div class="w-kicker">Your type</div>
				<h2 class="w-head"><?php echo w_e($w['persona']); ?></h2>
				<p><?php echo w_e($w['personaLine']); ?></p>
				<div class="w-bars">
					<?php foreach ($types as $type => $n): ?>
						<span><?php echo ucfirst($type); ?></span>
						<span><i style="width: <?php echo ($typeMax > 0) ? max(2, round($n / $typeMax * 100)) : 2; ?>%"></i></span>
						<b><?php echo (int)$n; ?></b>
					<?php endforeach; ?>
				</div>
				<?php if ($w['points'] > 0): ?>
					<div class="w-foot"><?php echo ucfirst($w['pointsType']); ?> events are where your points came from: <?php echo number_format($w['pointsTypeTotal']); ?> of your <?php echo number_format($w['points']); ?></div>
				<?php endif; ?>
			</div>

			<div class="w-card w-cream">
				<div class="w-kicker">The ones nobody else went to</div>
				<h2 class="w-head">
					<?php if ($cuts[0]['headcount'] == 1): ?>
						Nobody else made it to <?php echo w_e($cuts[0]['eventName']); ?>. You did.
					<?php else: ?>
						Only <?php echo (int)$cuts[0]['headcount']; ?> people made it to <?php echo w_e($cuts[0]['eventName']); ?>. You were one of them.
					<?php endif; ?>
				</h2>
				<p>Anyone can turn up to the big ones. These are the ones that say something about you.</p>
				<ul class="w-list">
					<?php foreach ($cuts as $cut): ?>
						<li><span><?php echo w_e($cut['eventName']); ?> &middot; <?php echo date('M j', strtotime($cut['eventDate'])); ?></span><b><?php echo ($cut['headcount'] == 1) ? 'just you' : (int)$cut['headcount'].' there'; ?></b></li>
					<?php endforeach; ?>
				</ul>
				<?php if ($w['sport'] && $w['sport']['games'] >= 3): ?>
					<div class="w-foot"><?php echo w_n($w['sport']['games'], $w['sport']['name'].' event'); ?> this year. They should save you a seat.</div>
				<?php endif; ?>
			</div>

			<div class="w-card w-gold">
				<div class="w-kicker">Your rhythm</div>
				<h2 class="w-head">
					<?php if ($w['streak'] >= 4): ?>
						<?php echo (int)$w['streak']; ?> weeks in a row. Not one missed.
					<?php elseif ($w['streak'] >= 2): ?>
						<?php echo (int)$w['streak']; ?> weeks in a row at your best
					<?php else: ?>
						You picked your moments
					<?php endif; ?>
				</h2>
				<div class="w-months" role="img" aria-label="Events per month">
					<?php foreach ($w['months'] as $month => $n): ?>
						<i class="<?php echo ($month === $w['peakMonth']) ? 'peak' : ''; ?>" style="height: <?php echo ($monthMax > 0) ? round($n / $monthMax * 100) : 0; ?>%" title="<?php echo date('F', mktime(0, 0, 0, $month, 1)).': '.(int)$n; ?>"></i>
					<?php endforeach; ?>
				</div>
				<div class="w-monthkey">
					<?php foreach (array('J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D') as $letter): ?><span><?php echo $letter; ?></span><?php endforeach; ?>
				</div>
				<p><?php echo date('F', mktime(0, 0, 0, $w['peakMonth'], 1)); ?> was your month, with <?php echo w_n($monthMax, 'event'); ?>. And <?php echo w_e($w['weekday']['name']); ?>s? You showed up <?php echo w_n($w['weekday']['events'], 'time'); ?>.</p>
			</div>

			<div class="w-card w-navy">
				<div class="w-kicker">Your biggest day</div>
				<?php if ($bigCount >= 2): ?>
					<h2 class="w-head"><?php echo date('F j', strtotime($bigDay['date'])); ?>: <?php echo w_n($bigCount, 'event'); ?> before bedtime</h2>
					<p><?php echo w_e(implode(' · ', $bigDay['names'])); ?></p>
					<p><?php echo ($bigCount >= 4) ? 'We hope you slept in on the '.date('jS', strtotime($bigDay['date'].' +1 day')).'.' : 'Not a bad day\'s work.'; ?></p>
				<?php else: ?>
					<h2 class="w-head">One at a time</h2>
					<p>You never doubled up on a single day, which is a perfectly sane way to live.</p>
				<?php endif; ?>
				<?php if ($w['family']): ?>
					<div class="w-foot"><?php echo (int)$w['family']['share']; ?>% of the points for <?php echo w_e($w['family']['name']); ?> came from you &middot; <?php echo w_ord($w['family']['rank']); ?> of <?php echo (int)$w['family']['size']; ?> in the family</div>
				<?php endif; ?>
			</div>

			<div class="w-card w-wide w-navy">
				<div class="w-kicker">That is a wrap</div>
				<h2 class="w-head">Thanks for a great <?php echo $year; ?>, <?php echo $name; ?>.</h2>
				<p><?php echo w_e($w['thanks']); ?> See you at the next one.</p>
				<div class="w-sign">&mdash; Ramblin&rsquo; Reck Club</div>
			</div>
		</div>
	<?php endif; ?>
</div>

<?php require "partials/footer.php"; ?>
<?php require "partials/scripts.php"; ?>

</body>

</html>
