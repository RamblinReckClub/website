<?php
	// The "your Wrapped is ready" banner on the points page, shown while a Wrapped that
	// was released to everyone or sent to this member is still up. Expects $db and $memberID.
	require_once dirname(__FILE__).'/../lib/wrapped.php';

	$wrappedUp   = wrapped_visible($db, $memberID);
	$wrappedYear = (count($wrappedUp) > 0) ? array_key_first($wrappedUp) : null;
?>
<?php if ($wrappedYear !== null): ?>
	<?php $wrappedDays = max(1, (int)ceil((strtotime($wrappedUp[$wrappedYear]) - time()) / 86400)); ?>
	<a href="/wrapped.php?year=<?php echo (int)$wrappedYear; ?>" class="d-block mb-3" style="background: #00263A; color: #fff; border-radius: 12px; padding: 1.25rem 1.5rem; text-decoration: none;">
		<span style="display: block; font-size: .78rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #decc80;">Reck Club Wrapped &middot; <?php echo (int)$wrappedYear; ?></span>
		<span style="display: block; font-family: 'Roboto Slab', Georgia, serif; font-weight: 700; font-size: 1.5rem; line-height: 1.25; margin: .25rem 0;"><?php echo htmlspecialchars($_SESSION['firstName']); ?>, your <?php echo (int)$wrappedYear; ?> is ready.</span>
		<span style="display: block; font-size: .9rem;">See your year &rarr; <span style="color: #decc80;">here for <?php echo $wrappedDays; ?> more day<?php echo ($wrappedDays == 1) ? '' : 's'; ?></span></span>
	</a>
<?php endif; ?>
