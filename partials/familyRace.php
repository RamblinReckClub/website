<?php
	// Family points race. One lane per family, one Reck per lane, parked at that
	// family's share of the leader's total. Expects $db; uses $memFamilyID from
	// set_session_vars_full.php to mark the viewer's own family when it is set.

	$raceQuery = $db->query("SELECT familyID, familyName, familyPoints FROM Family ORDER BY familyPoints DESC, familyName");
	$raceFamilies = $raceQuery->fetchAll(PDO::FETCH_ASSOC);

	$raceMax = 0;
	foreach ($raceFamilies as $raceRow) {
		if ((int)$raceRow['familyPoints'] > $raceMax) {
			$raceMax = (int)$raceRow['familyPoints'];
		}
	}

	// Events held so far this semester, same window the points queries use.
	$raceCountQuery = $db->query("SELECT COUNT(*) as CNT
	                              FROM Event
	                              WHERE (
	                                      (MONTH(CURDATE()) BETWEEN 1 AND 7  AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 1 AND 7)
	                                   OR (MONTH(CURDATE()) BETWEEN 8 AND 12 AND dateYear = YEAR(CURDATE()) AND dateMonth BETWEEN 8 AND 12)
	                                    )
	                                AND STR_TO_DATE(CONCAT(dateMonth,'/',dateDay,'/',dateYear),'%m/%d/%Y') <= CURDATE()");
	$raceCountRow = $raceCountQuery->fetch(PDO::FETCH_ASSOC);
	$raceEventCount = (int)$raceCountRow['CNT'];

	$raceMyFamily = isset($memFamilyID) ? $memFamilyID : null;

	// Optional, set by the including page before the require:
	//   $raceCompact    - narrower columns, for a half-width slot like points.php
	//   $raceShowHeader - false when the page already has its own heading above
	$raceCompact = isset($raceCompact) ? $raceCompact : false;
	$raceShowHeader = isset($raceShowHeader) ? $raceShowHeader : true;

	// The stylesheet and the car symbol only need to be emitted once per page.
	$raceAssetsDone = defined('RRC_RACE_ASSETS');
	if (!$raceAssetsDone) { define('RRC_RACE_ASSETS', 1); }
?>

<?php if (!$raceAssetsDone): ?>
<style>
	.rrc-race { border: 1px solid #dee2e6; border-radius: 8px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; }
	.rrc-race-head { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: .75rem; }
	.rrc-race-title { font-size: 1.1rem; margin: 0; }
	.rrc-race-sub { font-size: .8rem; color: #6c757d; }
	.rrc-race-row { display: grid; grid-template-columns: 18px minmax(0, 150px) 1fr 60px; align-items: center; gap: 10px; padding: 4px 0; }
	.rrc-race-rank { font-size: .75rem; color: #6c757d; text-align: right; }
	.rrc-race-name { font-size: .875rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
	.rrc-race-name a { color: inherit; }
	.rrc-race-lane { position: relative; height: 24px; border-right: 2px dashed #dee2e6; }
	.rrc-race-track { position: absolute; left: 0; right: 38px; top: 0; bottom: 0; }
	.rrc-race-track:before { content: ""; position: absolute; left: 0; right: -38px; top: 9px; height: 6px; background: #f1efe8; border-radius: 3px; }
	.rrc-race-trail { position: absolute; left: 0; top: 9px; height: 6px; background: #b3a369; opacity: .5; border-radius: 3px 0 0 3px; }
	.rrc-race-car { position: absolute; top: 1px; width: 38px; height: 21px; display: block; }
	.rrc-race-pts { font-size: .875rem; text-align: right; font-variant-numeric: tabular-nums; }
	.rrc-race-you { display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #b3a369; margin-right: 5px; vertical-align: middle; }
	.rrc-race-foot { border-top: 1px solid #dee2e6; margin-top: .75rem; padding-top: .5rem; display: flex; justify-content: space-between; font-size: .75rem; color: #6c757d; }
	.rrc-race-sm { padding: .75rem 1rem; }
	.rrc-race-sm .rrc-race-row { grid-template-columns: 16px minmax(0, 128px) 1fr 52px; gap: 8px; }
	.rrc-race-sm .rrc-race-name, .rrc-race-sm .rrc-race-pts { font-size: .8rem; }
	@media (max-width: 480px) {
		.rrc-race-row { grid-template-columns: 16px minmax(0, 80px) 1fr 56px; gap: 8px; }
		.rrc-race-car { display: none; }
		.rrc-race-track { right: 0; }
		.rrc-race-track:before { right: 0; top: 7px; height: 10px; border-radius: 5px; }
		.rrc-race-trail { top: 7px; height: 10px; opacity: 1; border-radius: 5px; }
	}
</style>

<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
	<symbol id="rrc-reck" viewBox="0 0 48 26">
		<g stroke="#6b5f38" stroke-width=".8" stroke-linejoin="round" stroke-linecap="round">
			<circle cx="13" cy="18.5" r="5" fill="#2b2b29"/>
			<circle cx="37" cy="18.5" r="5" fill="#2b2b29"/>
			<path d="M6,17 L6,13 C6,11.5 7,10.6 9.5,10.1 L18,9.5 L19.5,4.5 L30,4.5 L31.5,9.5 L41,10.6 L45,12 L45,17 Z" fill="#b3a369"/>
			<path d="M21,6.2 L29,6.2 L29.9,9.2 L20.2,9.2 Z" fill="#e8e4d3"/>
			<rect x="11" y="16.3" width="27" height="2" rx=".8" fill="#fbfaf6"/>
			<path d="M6.5,17 Q6.5,11.5 13,11.5 Q19.5,11.5 19.5,17 L17.6,17 Q17.6,13.6 13,13.6 Q8.4,13.6 8.4,17 Z" fill="#fbfaf6"/>
			<path d="M30.5,17 Q30.5,11 37,11 Q43.5,11 43.5,17 L41.6,17 Q41.6,13.1 37,13.1 Q32.4,13.1 32.4,17 Z" fill="#fbfaf6"/>
			<circle cx="43.2" cy="11.2" r="1.5" fill="#ffe08a"/>
			<circle cx="13" cy="18.5" r="2.9" fill="#fbfaf6"/><circle cx="13" cy="18.5" r="1.2" fill="#b3a369"/>
			<circle cx="37" cy="18.5" r="2.9" fill="#fbfaf6"/><circle cx="37" cy="18.5" r="1.2" fill="#b3a369"/>
			<path d="M39.5,10 L39.5,1.6" stroke-width="1"/>
			<path d="M39.5,1.6 L45.5,3.6 L39.5,5.6 Z" fill="#b3a369"/>
		</g>
	</symbol>
</svg>
<?php endif; ?>

<div class="rrc-race<?php echo $raceCompact ? ' rrc-race-sm' : ''; ?>">
	<?php if ($raceShowHeader): ?>
	<div class="rrc-race-head">
		<h4 class="rrc-race-title">Family Points Race</h4>
		<span class="rrc-race-sub"><?php echo $raceEventCount; ?> event<?php echo ($raceEventCount == 1) ? '' : 's'; ?> so far this semester</span>
	</div>
	<?php endif; ?>

	<?php
		$raceRank = 1;
		foreach ($raceFamilies as $raceRow):
			$racePoints = (int)$raceRow['familyPoints'];
			$racePct = ($raceMax > 0) ? ($racePoints / $raceMax) * 100 : 0;
			$raceName = (strlen($raceRow['familyName']) > 0) ? $raceRow['familyName'] : 'Family '.$raceRow['familyID'];
			$raceIsMine = ($raceMyFamily !== null && $raceMyFamily == $raceRow['familyID']);
	?>
		<div class="rrc-race-row" title="<?php echo htmlspecialchars($raceName); ?> &mdash; <?php echo number_format($racePoints); ?> points">
			<span class="rrc-race-rank"><?php echo $raceRank; ?></span>
			<span class="rrc-race-name">
				<?php if ($raceIsMine): ?><span class="rrc-race-you"></span><?php endif; ?>
				<a href="#family-<?php echo $raceRow['familyID']; ?>"><?php echo htmlspecialchars($raceName); ?></a>
			</span>
			<span class="rrc-race-lane">
				<span class="rrc-race-track">
					<span class="rrc-race-trail" style="width: <?php echo round($racePct, 2); ?>%;"></span>
					<svg class="rrc-race-car" style="left: <?php echo round($racePct, 2); ?>%;" viewBox="0 0 48 26" aria-hidden="true" focusable="false"><use href="#rrc-reck"/></svg>
				</span>
			</span>
			<span class="rrc-race-pts"><?php echo number_format($racePoints); ?></span>
		</div>
	<?php
			$raceRank++;
		endforeach;
	?>

	<div class="rrc-race-foot">
		<span><?php echo count($raceFamilies); ?> families<?php if (!$raceShowHeader): ?> &middot; <?php echo $raceEventCount; ?> event<?php echo ($raceEventCount == 1) ? '' : 's'; ?><?php endif; ?></span>
		<?php if ($raceMyFamily !== null): ?><span>your family is marked with a dot</span><?php endif; ?>
	</div>
</div>

<?php unset($raceCompact, $raceShowHeader); ?>
