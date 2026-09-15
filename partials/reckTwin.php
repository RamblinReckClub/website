<?php
	// Your Reck Twin card. Who is paired with whom is worked out in lib/reckTwins.php.
	// Expects $db and $memberID.
	require_once dirname(__FILE__).'/../lib/reckTwins.php';

	$twinCard   = reck_twin_for($db, $memberID);
	$twin       = $twinCard['twin'];
	$twinEvents = $twinCard['events'];
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

		<p class="rrc-twin-count">There for <b><?php echo (int)$twinCard['together']; ?></b> of your <?php echo count($twinEvents); ?> events</p>

		<div class="rrc-twin-strip" role="img" aria-label="<?php echo (int)$twinCard['together']; ?> of your <?php echo count($twinEvents); ?> events shared">
			<?php foreach ($twinEvents as $twinEvent): ?>
				<i class="<?php echo $twinEvent['together'] ? 'on' : ''; ?>" title="<?php echo htmlspecialchars($twinEvent['eventName'].' ('.$twinEvent['dateMonth'].'/'.$twinEvent['dateDay'].') - '.($twinEvent['together'] ? 'together' : 'just you')); ?>"></i>
			<?php endforeach; ?>
		</div>

		<div class="rrc-twin-foot">
			<span><?php echo htmlspecialchars($twinCard['semester']['label']); ?></span>
			<span class="rrc-twin-key"><i class="on"></i>together<i></i>just you</span>
		</div>
	<?php elseif (count($twinEvents) > 0): ?>
		<p class="mb-0 text-muted">No twin yet &mdash; everyone you overlap with is already paired up. Keep checking off events; twins update as they come in.</p>
	<?php else: ?>
		<p class="mb-0 text-muted">Check off a few events and your twin will show up here.</p>
	<?php endif; ?>
</div>
