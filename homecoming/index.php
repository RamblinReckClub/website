<?php
$pageTitle = "Homecoming";

/*
 * Everything on this page (cards, calendar, weekend timeline) is driven off this
 * one array so the dates only ever have to be updated in a single place.
 * Order matters: the weekend timeline renders in array order.
 */
$hcYear  = 2026;
$hcMonth = 10;

$hcEvents = array(
    array(
        'key'   => 'mini-500',
        'name'  => 'Mini 500',
        'short' => 'Mini 500',
        'date'  => '2026-10-23',
        'time'  => '5:00 PM',
        'color' => '#B3A369',
        'link'  => '/homecoming/mini-500.php',
        'email' => 'rrcmini500@gmail.com',
        'image' => '/homecoming/images/M55.jpg',
        'alt'   => 'Mini 500 racers pushing tricycles around Peters Parking Deck',
        'where' => 'Around Peters Parking Deck &mdash; start at Fowler St. &amp; Bobby Dodd Way',
        'blurb' => 'An eight-lap tricycle race around Peters Parking Deck on the Friday afternoon
                    before the Homecoming game, and one of Georgia Tech&rsquo;s most unique traditions
                    since 1969. Teams of seven &mdash; four racers and three pit crew &mdash; take turns
                    on the trike while the pit rotates the front wheel after laps two, four and six.
                    Paint your tricycle: <strong>red trikes do not race</strong>.',
        'note'  => 'Teams check in at their assigned pit between 4:15 and 4:45 PM.'
    ),
    array(
        'key'   => 'cake-race',
        'name'  => 'Freshman Cake Race',
        'short' => 'Cake Race',
        'date'  => '2026-10-24',
        'time'  => '6:30 AM',
        'color' => '#00263A',
        'link'  => '/homecoming/cake-race.php',
        'email' => 'rrccakerace@gmail.com',
        'image' => '/homecoming/images/cake_race_start.jpg',
        'alt'   => 'First-year students at the start line of the Freshman Cake Race',
        'where' => 'Georgia Tech campus &mdash; bibs are picked up in advance at the Reck Garage',
        'blurb' => 'A half-mile race held before sunrise on the morning of the Homecoming game,
                    open to every <strong>first-year</strong> student. Run it, jog it or walk it &mdash;
                    every finisher gets a cupcake, and the top male and female finishers get a cake
                    and are congratulated by the Ramblin&rsquo; Royalty on the field at halftime.
                    The race dates back to 1911.',
        'note'  => 'Bring your BuzzCard to bib pickup &mdash; bibs are not handed out on race morning.'
    ),
    array(
        'key'   => 'wreck-parade',
        'name'  => 'Ramblin&rsquo; Wreck Parade',
        'short' => 'Wreck Parade',
        'date'  => '2026-10-24',
        'time'  => '8:30 AM',
        'color' => '#004E7A',
        'link'  => '/homecoming/wreck-parade.php',
        'email' => 'rrcwreckparade@gmail.com',
        'image' => '/homecoming/images/wp-001.jpg',
        'alt'   => 'A student-built contraption rolling down Fowler Street in the Wreck Parade',
        'where' => 'Begins at the McCamish parking lot, up Fowler Street, finishing across Ferst Drive',
        'blurb' => 'The last event before kickoff: classic cars, student-built fixed bodies and
                    human-powered contraptions rolling through campus. It started in 1929 as the
                    Old Ford Race from Atlanta to Athens, and became a parade in 1932 after the
                    administration decided the race was a little too fast for its own good.',
        'note'  => 'Three entry categories: classic car, fixed body and contraption.'
    )
);

// Group the events by date for the calendar grid.
$hcByDate = array();
foreach ($hcEvents as $e) {
    $hcByDate[$e['date']][] = $e;
}

$hcFirst      = mktime(0, 0, 0, $hcMonth, 1, $hcYear);
$hcDaysInMon  = (int) date('t', $hcFirst);
$hcStartDow   = (int) date('w', $hcFirst); // 0 = Sunday
$hcMonthLabel = date('F Y', $hcFirst);
?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>

<style>
    /* ---------- Animated Reck scene ---------- */
    .reck-stage {
        position: relative;
        height: 400px;
        overflow: hidden;
        border-radius: .3rem;
        background: #00263A;
    }
    .reck-stage svg { display: block; width: 100%; height: 100%; }
    .reck-stage-label {
        position: absolute;
        left: 1.25rem;
        top: 1rem;
        color: #fff;
        text-shadow: 0 1px 6px rgba(0, 38, 58, .8);
        pointer-events: none;
    }
    .reck-stage-label .rsl-kicker {
        display: block;
        font-size: .7rem;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #decc80;
    }
    .reck-stage-label .rsl-date {
        display: block;
        font-family: 'Roboto Slab', serif;
        font-size: 1.5rem;
        line-height: 1.2;
    }

    @keyframes rrc-scroll-skyline { from { transform: translateX(0); }    to { transform: translateX(-2300px); } }
    @keyframes rrc-scroll-dash    { from { transform: translateX(0); }    to { transform: translateX(-100px); } }
    @keyframes rrc-spin           { from { transform: rotate(0deg); }     to { transform: rotate(360deg); } }
    @keyframes rrc-bob            { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-2.5px); } }
    @keyframes rrc-puff {
        0%   { opacity: .38; transform: translate(0, 0) scale(.4); }
        100% { opacity: 0;   transform: translate(-80px, -34px) scale(2.4); }
    }
    @keyframes rrc-flag    { 0%, 100% { transform: skewY(0deg) scaleY(1); } 50% { transform: skewY(-8deg) scaleY(.92); } }
    @keyframes rrc-twinkle { 0%, 100% { opacity: .12; } 50% { opacity: .85; } }

    .rrc-skyline  { animation: rrc-scroll-skyline 60s linear infinite; }
    .hc-lm-label  { font-family: 'Roboto Slab', Georgia, serif; font-size: 9px;
                    letter-spacing: 1.6px; fill: #b3a369; opacity: .75; }
    .hc-lm-tag    { font-family: 'Roboto Slab', Georgia, serif; font-size: 7px;
                    letter-spacing: 1px; fill: #b3a369; opacity: .6; text-anchor: middle; }
    .rrc-dashes   { animation: rrc-scroll-dash .42s linear infinite; }
    .rrc-car      { animation: rrc-bob .55s ease-in-out infinite; transform-box: fill-box; transform-origin: center; }
    .rrc-wheel    { animation: rrc-spin .5s linear infinite;  transform-box: fill-box; transform-origin: center; }
    .rrc-puff     { animation: rrc-puff 1.5s ease-out infinite; transform-box: fill-box; transform-origin: center; }
    .rrc-puff-2   { animation-delay: .5s; }
    .rrc-puff-3   { animation-delay: 1s; }
    .rrc-flag     { animation: rrc-flag .7s ease-in-out infinite; transform-box: fill-box; transform-origin: right center; }
    .rrc-flag-2   { animation-delay: .18s; }
    .rrc-star     { animation: rrc-twinkle 3.4s ease-in-out infinite; }
    .rrc-star-2   { animation-delay: 1.1s; }
    .rrc-star-3   { animation-delay: 2.2s; }
    .rrc-star-4   { animation-delay: .6s; }
    .rrc-star-5   { animation-delay: 1.7s; }

    /* ---------- Event cards ---------- */
    .hc-card { border: 0; border-top: 4px solid var(--accent); box-shadow: 0 1px 4px rgba(0,0,0,.12); height: 100%; }
    .hc-card-img { height: 190px; width: 100%; object-fit: cover; }
    .hc-eyebrow { font-size: .72rem; letter-spacing: .14em; text-transform: uppercase; color: var(--accent); font-weight: 700; }
    .hc-when { font-family: 'Roboto Slab', serif; color: #00263A; }
    .hc-meta { font-size: .85rem; }
    .hc-meta i { color: var(--accent); width: 1.1rem; }

    /* ---------- Calendar ---------- */
    .hc-cal { border: 1px solid #e5e5e5; border-radius: .3rem; overflow: hidden; }
    .hc-cal-head {
        background: #00263A; color: #fff; text-align: center;
        font-family: 'Roboto Slab', serif; padding: .6rem; letter-spacing: .04em;
    }
    .hc-cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); }
    .hc-dow {
        text-align: center; font-size: .68rem; letter-spacing: .1em; text-transform: uppercase;
        color: #7d7d7d; padding: .45rem 0; background: #faf9f6; border-bottom: 1px solid #e5e5e5;
    }
    .hc-day {
        position: relative; min-height: 68px; padding: .25rem;
        border-right: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0;
        font-size: .8rem; color: #444;
    }
    .hc-day:nth-child(7n) { border-right: 0; }
    .hc-day.is-blank { background: #fcfcfc; }
    .hc-day.is-event { background: rgba(179,163,105,.09); }
    .hc-daynum { display: block; font-weight: 600; }
    .hc-day.is-event .hc-daynum { color: #00263A; }
    .hc-pill {
        display: block; margin-top: 2px; padding: 1px 4px; border-radius: 2px;
        font-size: .58rem; line-height: 1.35; color: #fff; white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis;
    }
    .hc-pill:hover { color: #fff; }
    .hc-dot { display: none; width: 9px; height: 9px; border-radius: 50%; margin: 3px auto 0; }

    @media (max-width: 575.98px) {
        .hc-day { min-height: 46px; font-size: .72rem; }
        .hc-pill { display: none; }
        .hc-dot  { display: block; }
        .reck-stage { height: 260px; }
        .reck-stage-label .rsl-date { font-size: 1.15rem; }
    }

    /* ---------- Weekend timeline ---------- */
    .hc-timeline { list-style: none; margin: 0; padding: 0; }
    .hc-tl-day {
        font-family: 'Roboto Slab', serif; font-size: .78rem; letter-spacing: .12em;
        text-transform: uppercase; color: #7d7d7d; margin: 1rem 0 .5rem;
    }
    .hc-tl-item { position: relative; padding: 0 0 1rem 1.6rem; border-left: 2px solid #ececec; margin-left: .35rem; }
    .hc-tl-item:last-child { border-left-color: transparent; padding-bottom: 0; }
    .hc-tl-item::before {
        content: ''; position: absolute; left: -7px; top: .3rem;
        width: 12px; height: 12px; border-radius: 50%;
        background: var(--accent); box-shadow: 0 0 0 3px #fff;
    }
    .hc-tl-time { font-family: 'Roboto Slab', serif; color: #00263A; font-size: 1.05rem; }
    .hc-tl-where { font-size: .82rem; color: #6c757d; }

    @media (prefers-reduced-motion: reduce) {
        .reck-stage * { animation: none !important; }
    }
</style>

<!-- ============================ Page title ============================ -->
<div class="container mb-3">
    <div class='blog-header'>
        <div class='col-12' style="text-align: center;">
            <h1>Georgia Tech Homecoming</h1>
        </div>
    </div>
</div>

<!-- ============================ Animated Reck ============================ -->
<div class="container mb-4">
    <div class="reck-stage">
                                                                                                                                                        <svg viewBox="0 0 1200 400" preserveAspectRatio="xMidYMid slice" role="img"
                     aria-label="Illustration of the Ramblin’ Reck driving past Bobby Dodd Stadium, Tech Tower, the Kessler Campanile, McCamish Pavilion and the Atlanta skyline at dawn">
                    <defs>
                        <linearGradient id="hc-sky" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#00263A"/>
                            <stop offset="42%" stop-color="#0d4763"/>
                            <stop offset="74%" stop-color="#b3a369"/>
                            <stop offset="100%" stop-color="#f4e8c8"/>
                        </linearGradient>
                        <linearGradient id="hc-gold" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#d9bd63"/>
                            <stop offset="38%" stop-color="#bb9b3e"/>
                            <stop offset="100%" stop-color="#7d692b"/>
                        </linearGradient>
                        <linearGradient id="hc-gold-hood" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#e3c86e"/>
                            <stop offset="55%" stop-color="#c2a244"/>
                            <stop offset="100%" stop-color="#8e7930"/>
                        </linearGradient>
                        <linearGradient id="hc-chrome" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#f4f7f9"/>
                            <stop offset="45%" stop-color="#c3cad0"/>
                            <stop offset="100%" stop-color="#8f979c"/>
                        </linearGradient>
                        <linearGradient id="hc-steel" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#cfd6da"/>
                            <stop offset="55%" stop-color="#9aa3aa"/>
                            <stop offset="100%" stop-color="#5f686f"/>
                        </linearGradient>
                        <linearGradient id="hc-bronze" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#f0d492"/>
                            <stop offset="40%" stop-color="#c9a33f"/>
                            <stop offset="100%" stop-color="#7d6118"/>
                        </linearGradient>
                        <linearGradient id="hc-road" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#3d444b"/>
                            <stop offset="100%" stop-color="#20252a"/>
                        </linearGradient>
                        <radialGradient id="hc-glow" cx="50%" cy="100%" r="62%">
                            <stop offset="0%"   stop-color="#ffe9a8" stop-opacity=".9"/>
                            <stop offset="100%" stop-color="#ffe9a8" stop-opacity="0"/>
                        </radialGradient>
                        <g id="hc-landmark-tile">
                            <!-- downtown / midtown Atlanta -->
                            <path d="M 40,300 L 40,278 Q 46,258 84,255 Q 122,258 128,278 L 128,300 Z" fill="#0a3448"/>
                            <path d="M 46,272 Q 84,250 122,272" fill="none" stroke="#062a3c" stroke-width="3"/>
                            <path d="M 74,256 L 84,248 L 94,256 Z" fill="#062a3c"/>
                            <path d="M 140,300 L 140,176 L 162,176 L 162,160 L 184,160 L 184,144 L 200,144 L 200,300 Z" fill="#062a3c"/>
                            <path d="M 210,300 L 210,126 Q 210,110 228,110 Q 246,110 246,126 L 246,300 Z" fill="#0a3448"/>
                            <rect x="224" y="92" width="7" height="20" fill="#0a3448"/>
                            <rect x="256" y="130" width="42" height="170" fill="#062a3c"/>
                            <path d="M 256,130 L 277,96 L 298,130 Z" fill="#0a3448"/>
                            <path d="M 255,130 L 258,112 L 261,130 Z" fill="#0a3448"/>
                            <path d="M 293,130 L 296,112 L 299,130 Z" fill="#0a3448"/>
                            <rect x="308" y="112" width="46" height="188" fill="#0a3448"/>
                            <path d="M 312,112 L 350,112 L 342,72 L 320,72 Z" fill="#062a3c"/>
                            <path d="M 320,72 L 342,72 L 336,48 L 326,48 Z" fill="none" stroke="#e2b93f" stroke-width="1.8" opacity=".85"/>
                            <line x1="331" y1="48" x2="331" y2="20" stroke="#e2b93f" stroke-width="1.8" opacity=".85"/>
                            <circle cx="331" cy="18" r="2.4" fill="#e2b93f" opacity=".9"/>
                            <rect x="364" y="150" width="40" height="150" fill="#062a3c"/>
                            <rect x="368" y="130" width="12" height="20" fill="#0a3448"/>
                            <rect x="388" y="130" width="12" height="20" fill="#0a3448"/>
                            <rect x="412" y="268" width="44" height="32" fill="#0a3448"/>
                            <path d="M 424,268 Q 434,244 444,268 Z" fill="#062a3c"/>
                            <line x1="434" y1="246" x2="434" y2="236" stroke="#e2b93f" stroke-width="1.4" opacity=".8"/>
                            <g fill="#e2b93f" opacity=".38">
                              <rect x="145" y="184" width="3" height="4"/>
                              <rect x="163" y="184" width="3" height="4"/>
                              <rect x="190" y="184" width="3" height="4"/>
                              <rect x="154" y="196" width="3" height="4"/>
                              <rect x="172" y="196" width="3" height="4"/>
                              <rect x="163" y="208" width="3" height="4"/>
                              <rect x="181" y="208" width="3" height="4"/>
                              <rect x="145" y="220" width="3" height="4"/>
                              <rect x="172" y="220" width="3" height="4"/>
                              <rect x="190" y="220" width="3" height="4"/>
                              <rect x="154" y="232" width="3" height="4"/>
                              <rect x="181" y="232" width="3" height="4"/>
                              <rect x="145" y="244" width="3" height="4"/>
                              <rect x="163" y="244" width="3" height="4"/>
                              <rect x="190" y="244" width="3" height="4"/>
                              <rect x="154" y="256" width="3" height="4"/>
                              <rect x="172" y="256" width="3" height="4"/>
                              <rect x="163" y="268" width="3" height="4"/>
                              <rect x="181" y="268" width="3" height="4"/>
                              <rect x="145" y="280" width="3" height="4"/>
                              <rect x="172" y="280" width="3" height="4"/>
                              <rect x="190" y="280" width="3" height="4"/>
                              <rect x="154" y="292" width="3" height="4"/>
                              <rect x="181" y="292" width="3" height="4"/>
                            </g>
                            <g fill="#e2b93f" opacity=".38">
                              <rect x="261" y="138" width="3" height="4"/>
                              <rect x="279" y="138" width="3" height="4"/>
                              <rect x="270" y="150" width="3" height="4"/>
                              <rect x="288" y="150" width="3" height="4"/>
                              <rect x="279" y="162" width="3" height="4"/>
                              <rect x="261" y="174" width="3" height="4"/>
                              <rect x="288" y="174" width="3" height="4"/>
                              <rect x="270" y="186" width="3" height="4"/>
                              <rect x="261" y="198" width="3" height="4"/>
                              <rect x="279" y="198" width="3" height="4"/>
                              <rect x="270" y="210" width="3" height="4"/>
                              <rect x="288" y="210" width="3" height="4"/>
                              <rect x="279" y="222" width="3" height="4"/>
                              <rect x="261" y="234" width="3" height="4"/>
                              <rect x="288" y="234" width="3" height="4"/>
                              <rect x="270" y="246" width="3" height="4"/>
                              <rect x="261" y="258" width="3" height="4"/>
                              <rect x="279" y="258" width="3" height="4"/>
                              <rect x="270" y="270" width="3" height="4"/>
                              <rect x="288" y="270" width="3" height="4"/>
                              <rect x="279" y="282" width="3" height="4"/>
                            </g>
                            <g fill="#e2b93f" opacity=".38">
                              <rect x="313" y="120" width="3" height="4"/>
                              <rect x="331" y="120" width="3" height="4"/>
                              <rect x="322" y="132" width="3" height="4"/>
                              <rect x="340" y="132" width="3" height="4"/>
                              <rect x="331" y="144" width="3" height="4"/>
                              <rect x="313" y="156" width="3" height="4"/>
                              <rect x="340" y="156" width="3" height="4"/>
                              <rect x="322" y="168" width="3" height="4"/>
                              <rect x="313" y="180" width="3" height="4"/>
                              <rect x="331" y="180" width="3" height="4"/>
                              <rect x="322" y="192" width="3" height="4"/>
                              <rect x="340" y="192" width="3" height="4"/>
                              <rect x="331" y="204" width="3" height="4"/>
                              <rect x="313" y="216" width="3" height="4"/>
                              <rect x="340" y="216" width="3" height="4"/>
                              <rect x="322" y="228" width="3" height="4"/>
                              <rect x="313" y="240" width="3" height="4"/>
                              <rect x="331" y="240" width="3" height="4"/>
                              <rect x="322" y="252" width="3" height="4"/>
                              <rect x="340" y="252" width="3" height="4"/>
                              <rect x="331" y="264" width="3" height="4"/>
                              <rect x="313" y="276" width="3" height="4"/>
                              <rect x="340" y="276" width="3" height="4"/>
                              <rect x="322" y="288" width="3" height="4"/>
                            </g>
                            <g fill="#e2b93f" opacity=".38">
                              <rect x="369" y="158" width="3" height="4"/>
                              <rect x="387" y="158" width="3" height="4"/>
                              <rect x="378" y="170" width="3" height="4"/>
                              <rect x="396" y="170" width="3" height="4"/>
                              <rect x="387" y="182" width="3" height="4"/>
                              <rect x="369" y="194" width="3" height="4"/>
                              <rect x="396" y="194" width="3" height="4"/>
                              <rect x="378" y="206" width="3" height="4"/>
                              <rect x="369" y="218" width="3" height="4"/>
                              <rect x="387" y="218" width="3" height="4"/>
                              <rect x="378" y="230" width="3" height="4"/>
                              <rect x="396" y="230" width="3" height="4"/>
                              <rect x="387" y="242" width="3" height="4"/>
                              <rect x="369" y="254" width="3" height="4"/>
                              <rect x="396" y="254" width="3" height="4"/>
                              <rect x="378" y="266" width="3" height="4"/>
                              <rect x="369" y="278" width="3" height="4"/>
                              <rect x="387" y="278" width="3" height="4"/>
                              <rect x="378" y="290" width="3" height="4"/>
                              <rect x="396" y="290" width="3" height="4"/>
                            </g>
                            <g><line x1="248" y1="300" x2="248" y2="304" stroke="#e2b93f" stroke-width="1" opacity=".5"/><text x="248" y="316" text-anchor="middle" class="hc-lm-label">ATLANTA SKYLINE</text></g>
                            <!-- Bobby Dodd Stadium -->
                            <rect x="490" y="258" width="382" height="42" fill="#7d3b2b"/>
                            <rect x="490" y="258" width="382" height="4" fill="#a49b88"/>
                            <g fill="#5c2a1e">
                              <path d="M 500,300 L 500,278 Q 511,266 522,278 L 522,300 Z"/>
                              <path d="M 534,300 L 534,278 Q 545,266 556,278 L 556,300 Z"/>
                              <path d="M 568,300 L 568,278 Q 579,266 590,278 L 590,300 Z"/>
                              <path d="M 602,300 L 602,278 Q 613,266 624,278 L 624,300 Z"/>
                              <path d="M 636,300 L 636,278 Q 647,266 658,278 L 658,300 Z"/>
                              <path d="M 670,300 L 670,278 Q 681,266 692,278 L 692,300 Z"/>
                              <path d="M 704,300 L 704,278 Q 715,266 726,278 L 726,300 Z"/>
                              <path d="M 738,300 L 738,278 Q 749,266 760,278 L 760,300 Z"/>
                              <path d="M 772,300 L 772,278 Q 783,266 794,278 L 794,300 Z"/>
                              <path d="M 806,300 L 806,278 Q 817,266 828,278 L 828,300 Z"/>
                              <path d="M 840,300 L 840,278 Q 851,266 862,278 L 862,300 Z"/>
                            </g>
                            <g fill="#f2d086" opacity=".22">
                              <path d="M 504,300 L 504,280 Q 511,271 518,280 L 518,300 Z"/>
                              <path d="M 538,300 L 538,280 Q 545,271 552,280 L 552,300 Z"/>
                              <path d="M 572,300 L 572,280 Q 579,271 586,280 L 586,300 Z"/>
                              <path d="M 606,300 L 606,280 Q 613,271 620,280 L 620,300 Z"/>
                              <path d="M 640,300 L 640,280 Q 647,271 654,280 L 654,300 Z"/>
                              <path d="M 674,300 L 674,280 Q 681,271 688,280 L 688,300 Z"/>
                              <path d="M 708,300 L 708,280 Q 715,271 722,280 L 722,300 Z"/>
                              <path d="M 742,300 L 742,280 Q 749,271 756,280 L 756,300 Z"/>
                              <path d="M 776,300 L 776,280 Q 783,271 790,280 L 790,300 Z"/>
                              <path d="M 810,300 L 810,280 Q 817,271 824,280 L 824,300 Z"/>
                              <path d="M 844,300 L 844,280 Q 851,271 858,280 L 858,300 Z"/>
                            </g>
                            <text x="681" y="270" text-anchor="middle" class="hc-lm-tag">GEORGIA TECH</text>
                            <path d="M 500,258 L 862,258 L 846,198 L 516,198 Z" fill="#8e8a80"/>
                            <g stroke="#66635c" stroke-width="1.4" opacity=".8">
                              <line x1="503" y1="248" x2="859" y2="248"/>
                              <line x1="505" y1="238" x2="857" y2="238"/>
                              <line x1="508" y1="228" x2="854" y2="228"/>
                              <line x1="511" y1="218" x2="851" y2="218"/>
                              <line x1="513" y1="208" x2="849" y2="208"/>
                            </g>
                            <path d="M 500,258 L 862,258 L 862,262 L 500,262 Z" fill="#66635c"/>
                            <rect x="524" y="176" width="316" height="24" fill="#5c2a1e"/>
                            <g fill="#f2d086" opacity=".5">
                              <rect x="532" y="182" width="8" height="11"/>
                              <rect x="545" y="182" width="8" height="11"/>
                              <rect x="558" y="182" width="8" height="11"/>
                              <rect x="571" y="182" width="8" height="11"/>
                              <rect x="584" y="182" width="8" height="11"/>
                              <rect x="597" y="182" width="8" height="11"/>
                              <rect x="610" y="182" width="8" height="11"/>
                              <rect x="623" y="182" width="8" height="11"/>
                              <rect x="636" y="182" width="8" height="11"/>
                              <rect x="649" y="182" width="8" height="11"/>
                              <rect x="662" y="182" width="8" height="11"/>
                              <rect x="675" y="182" width="8" height="11"/>
                              <rect x="688" y="182" width="8" height="11"/>
                              <rect x="701" y="182" width="8" height="11"/>
                              <rect x="714" y="182" width="8" height="11"/>
                              <rect x="727" y="182" width="8" height="11"/>
                              <rect x="740" y="182" width="8" height="11"/>
                              <rect x="753" y="182" width="8" height="11"/>
                              <rect x="766" y="182" width="8" height="11"/>
                              <rect x="779" y="182" width="8" height="11"/>
                              <rect x="792" y="182" width="8" height="11"/>
                              <rect x="805" y="182" width="8" height="11"/>
                              <rect x="818" y="182" width="8" height="11"/>
                              <rect x="831" y="182" width="8" height="11"/>
                            </g>
                            <path d="M 496,172 L 868,164 L 868,174 L 496,182 Z" fill="#a9b1b7"/>
                            <path d="M 496,172 L 868,164 L 868,167 L 496,175 Z" fill="#c6ced4"/>
                            <g stroke="#69727a" stroke-width=".7" opacity=".7">
                              <line x1="500" y1="171.9" x2="500" y2="181.9"/>
                              <line x1="520" y1="171.5" x2="520" y2="181.5"/>
                              <line x1="540" y1="171.1" x2="540" y2="181.1"/>
                              <line x1="560" y1="170.6" x2="560" y2="180.6"/>
                              <line x1="580" y1="170.2" x2="580" y2="180.2"/>
                              <line x1="600" y1="169.8" x2="600" y2="179.8"/>
                              <line x1="620" y1="169.3" x2="620" y2="179.3"/>
                              <line x1="640" y1="168.9" x2="640" y2="178.9"/>
                              <line x1="660" y1="168.5" x2="660" y2="178.5"/>
                              <line x1="680" y1="168.0" x2="680" y2="178.0"/>
                              <line x1="700" y1="167.6" x2="700" y2="177.6"/>
                              <line x1="720" y1="167.2" x2="720" y2="177.2"/>
                              <line x1="740" y1="166.8" x2="740" y2="176.8"/>
                              <line x1="760" y1="166.3" x2="760" y2="176.3"/>
                              <line x1="780" y1="165.9" x2="780" y2="175.9"/>
                              <line x1="800" y1="165.5" x2="800" y2="175.5"/>
                              <line x1="820" y1="165.0" x2="820" y2="175.0"/>
                              <line x1="840" y1="164.6" x2="840" y2="174.6"/>
                              <line x1="860" y1="164.2" x2="860" y2="174.2"/>
                            </g>
                            <g stroke="#69727a" stroke-width="2">
                              <line x1="540" y1="181.1" x2="540" y2="196"/>
                              <line x1="600" y1="179.8" x2="600" y2="196"/>
                              <line x1="660" y1="178.5" x2="660" y2="196"/>
                              <line x1="720" y1="177.2" x2="720" y2="196"/>
                              <line x1="780" y1="175.9" x2="780" y2="196"/>
                              <line x1="840" y1="174.6" x2="840" y2="196"/>
                            </g>
                            <line x1="508" y1="196" x2="508" y2="120" stroke="#69727a" stroke-width="3.4"/>
                            <rect x="491" y="106" width="34" height="16" rx="2" fill="#69727a"/>
                            <g fill="#f2d086" opacity=".9">
                              <circle cx="495" cy="111" r="2"/>
                              <circle cx="495" cy="117" r="2"/>
                              <circle cx="502" cy="111" r="2"/>
                              <circle cx="502" cy="117" r="2"/>
                              <circle cx="508" cy="111" r="2"/>
                              <circle cx="508" cy="117" r="2"/>
                              <circle cx="514" cy="111" r="2"/>
                              <circle cx="514" cy="117" r="2"/>
                              <circle cx="521" cy="111" r="2"/>
                              <circle cx="521" cy="117" r="2"/>
                            </g>
                            <line x1="856" y1="196" x2="856" y2="120" stroke="#69727a" stroke-width="3.4"/>
                            <rect x="839" y="106" width="34" height="16" rx="2" fill="#69727a"/>
                            <g fill="#f2d086" opacity=".9">
                              <circle cx="843" cy="111" r="2"/>
                              <circle cx="843" cy="117" r="2"/>
                              <circle cx="850" cy="111" r="2"/>
                              <circle cx="850" cy="117" r="2"/>
                              <circle cx="856" cy="111" r="2"/>
                              <circle cx="856" cy="117" r="2"/>
                              <circle cx="862" cy="111" r="2"/>
                              <circle cx="862" cy="117" r="2"/>
                              <circle cx="869" cy="111" r="2"/>
                              <circle cx="869" cy="117" r="2"/>
                            </g>
                            <rect x="784" y="126" width="74" height="40" rx="2" fill="#12222c"/>
                            <rect x="788" y="130" width="66" height="32" fill="#0b3247"/>
                            <text x="821" y="152" text-anchor="middle" font-family="'Roboto Slab', Georgia, serif" font-size="16" font-weight="700" fill="#e2b93f">GT</text>
                            <line x1="821" y1="166" x2="821" y2="176" stroke="#69727a" stroke-width="3"/>
                            <g><line x1="681" y1="300" x2="681" y2="304" stroke="#e2b93f" stroke-width="1" opacity=".5"/><text x="681" y="316" text-anchor="middle" class="hc-lm-label">BOBBY DODD STADIUM</text></g>
                            <!-- Tech Tower (Evans Administration Building) -->
                            <rect x="942" y="228" width="46" height="72" fill="#7d3b2b"/>
                            <path d="M 939,228 L 965,204 L 991,228 Z" fill="#5c2a1e"/>
                            <g fill="#d6cfbf" opacity=".85">
                              <rect x="949" y="240" width="7" height="14" rx="1"/>
                              <rect x="962" y="240" width="7" height="14" rx="1"/>
                              <rect x="975" y="240" width="7" height="14" rx="1"/>
                              <rect x="949" y="264" width="7" height="14" rx="1"/>
                              <rect x="962" y="264" width="7" height="14" rx="1"/>
                              <rect x="975" y="264" width="7" height="14" rx="1"/>
                            </g>
                            <g fill="#f2d086" opacity=".45">
                              <rect x="950" y="242" width="5" height="11"/>
                              <rect x="963" y="242" width="5" height="11"/>
                              <rect x="976" y="242" width="5" height="11"/>
                            </g>
                            <rect x="1078" y="228" width="46" height="72" fill="#7d3b2b"/>
                            <path d="M 1075,228 L 1101,204 L 1127,228 Z" fill="#5c2a1e"/>
                            <g fill="#d6cfbf" opacity=".85">
                              <rect x="1085" y="240" width="7" height="14" rx="1"/>
                              <rect x="1098" y="240" width="7" height="14" rx="1"/>
                              <rect x="1111" y="240" width="7" height="14" rx="1"/>
                              <rect x="1085" y="264" width="7" height="14" rx="1"/>
                              <rect x="1098" y="264" width="7" height="14" rx="1"/>
                              <rect x="1111" y="264" width="7" height="14" rx="1"/>
                            </g>
                            <g fill="#f2d086" opacity=".45">
                              <rect x="1086" y="242" width="5" height="11"/>
                              <rect x="1099" y="242" width="5" height="11"/>
                              <rect x="1112" y="242" width="5" height="11"/>
                            </g>
                            <rect x="988" y="214" width="88" height="86" fill="#7d3b2b"/>
                            <rect x="988" y="214" width="88" height="4" fill="#d6cfbf"/>
                            <rect x="988" y="248" width="88" height="3" fill="#d6cfbf" opacity=".8"/>
                            <g fill="#d6cfbf" opacity=".85">
                              <rect x="995" y="224" width="8" height="16" rx="1"/>
                              <rect x="995" y="256" width="8" height="16" rx="1"/>
                              <rect x="1011" y="224" width="8" height="16" rx="1"/>
                              <rect x="1011" y="256" width="8" height="16" rx="1"/>
                              <rect x="1027" y="224" width="8" height="16" rx="1"/>
                              <rect x="1027" y="256" width="8" height="16" rx="1"/>
                              <rect x="1043" y="224" width="8" height="16" rx="1"/>
                              <rect x="1043" y="256" width="8" height="16" rx="1"/>
                              <rect x="1059" y="224" width="8" height="16" rx="1"/>
                              <rect x="1059" y="256" width="8" height="16" rx="1"/>
                            </g>
                            <g fill="#f2d086" opacity=".4">
                              <rect x="996" y="226" width="6" height="13"/>
                              <rect x="1012" y="226" width="6" height="13"/>
                              <rect x="1028" y="226" width="6" height="13"/>
                              <rect x="1044" y="226" width="6" height="13"/>
                              <rect x="1060" y="226" width="6" height="13"/>
                            </g>
                            <path d="M 1020,300 L 1020,286 Q 1032,272 1044,286 L 1044,300 Z" fill="#d6cfbf"/>
                            <path d="M 1023,300 L 1023,287 Q 1032,276 1041,287 L 1041,300 Z" fill="#f2d086" opacity=".5"/>
                            <rect x="1006" y="128" width="52" height="88" fill="#94493a"/>
                            <rect x="1006" y="128" width="52" height="88" fill="none" stroke="#5c2a1e" stroke-width="1"/>
                            <rect x="1004" y="176" width="56" height="4" fill="#d6cfbf"/>
                            <rect x="1004" y="200" width="56" height="4" fill="#d6cfbf"/>
                            <path d="M 1020,174 L 1020,152 Q 1032,138 1044,152 L 1044,174 Z" fill="#d6cfbf"/>
                            <path d="M 1023,172 L 1023,153 Q 1032,142 1041,153 L 1041,172 Z" fill="#15384a"/>
                            <g stroke="#d6cfbf" stroke-width="1.1"><line x1="1032" y1="142" x2="1032" y2="172"/><line x1="1023" y1="160" x2="1041" y2="160"/></g>
                            <rect x="1020" y="184" width="24" height="14" fill="#d6cfbf"/>
                            <rect x="1023" y="186" width="18" height="10" fill="#15384a"/>
                            <rect x="998" y="120" width="68" height="9" fill="#d6cfbf"/>
                            <rect x="1000" y="115" width="64" height="5" fill="#a49b88"/>
                            <path d="M 1002,115 L 1062,115 L 1032,64 Z" fill="#5f686f"/>
                            <path d="M 1032,115 L 1062,115 L 1032,64 Z" fill="#7b848c" opacity=".55"/>
                            <path d="M 1028,66 L 1032,54 L 1036,66 Z" fill="#e2b93f"/>
                            <path d="M 998,116 L 1002,96 L 1006,116 Z" fill="#d6cfbf"/>
                            <path d="M 1058,116 L 1062,96 L 1066,116 Z" fill="#d6cfbf"/>
                            <path d="M 1011,116 L 1014,101 L 1017,116 Z" fill="#d6cfbf" opacity=".85"/>
                            <path d="M 1047,116 L 1050,101 L 1053,116 Z" fill="#d6cfbf" opacity=".85"/>
                            <g font-family="'Roboto Slab', Georgia, serif" font-size="12" font-weight="700" fill="#e2b93f" stroke="#4a3410" stroke-width="1.6" paint-order="stroke" text-anchor="middle">
                              <text x="1014" y="114">T</text>
                              <text x="1026" y="114">E</text>
                              <text x="1038" y="114">C</text>
                              <text x="1050" y="114">H</text>
                            </g>
                            <g><line x1="1032" y1="300" x2="1032" y2="304" stroke="#e2b93f" stroke-width="1" opacity=".5"/><text x="1032" y="316" text-anchor="middle" class="hc-lm-label">TECH TOWER</text></g>
                            <!-- Kessler Campanile -->
                            <rect x="1186" y="292" width="96" height="8" rx="1" fill="#66635c"/>
                            <rect x="1194" y="288" width="80" height="5" rx="1" fill="#8e8a80"/>
                            <ellipse cx="1234" cy="292" rx="46" ry="4" fill="#e2b93f" opacity=".16"/>
                            <g stroke="#a9b1b7" stroke-width="1.1" opacity=".55">
                              <line x1="1198" y1="290" x2="1198" y2="283"/>
                              <line x1="1207" y1="290" x2="1207" y2="280"/>
                              <line x1="1216" y1="290" x2="1216" y2="277"/>
                              <line x1="1225" y1="290" x2="1225" y2="283"/>
                              <line x1="1234" y1="290" x2="1234" y2="280"/>
                              <line x1="1243" y1="290" x2="1243" y2="277"/>
                              <line x1="1252" y1="290" x2="1252" y2="283"/>
                              <line x1="1261" y1="290" x2="1261" y2="280"/>
                              <line x1="1270" y1="290" x2="1270" y2="277"/>
                            </g>
                            <path d="M 1224,290 L 1231,112 L 1237,112 L 1244,290 Z" fill="url(#hc-steel)"/>
                            <g stroke="#69727a" stroke-width=".7" opacity=".75">
                              <line x1="1224.0" y1="290.0" x2="1244.0" y2="290.0"/>
                              <line x1="1224.2" y1="286.0" x2="1243.8" y2="286.0"/>
                              <line x1="1224.3" y1="281.9" x2="1243.7" y2="281.9"/>
                              <line x1="1224.5" y1="277.9" x2="1243.5" y2="277.9"/>
                              <line x1="1224.6" y1="273.8" x2="1243.4" y2="273.8"/>
                              <line x1="1224.8" y1="269.8" x2="1243.2" y2="269.8"/>
                              <line x1="1225.0" y1="265.7" x2="1243.0" y2="265.7"/>
                              <line x1="1225.1" y1="261.7" x2="1242.9" y2="261.7"/>
                              <line x1="1225.3" y1="257.6" x2="1242.7" y2="257.6"/>
                              <line x1="1225.4" y1="253.6" x2="1242.6" y2="253.6"/>
                              <line x1="1225.6" y1="249.5" x2="1242.4" y2="249.5"/>
                              <line x1="1225.8" y1="245.5" x2="1242.2" y2="245.5"/>
                              <line x1="1225.9" y1="241.5" x2="1242.1" y2="241.5"/>
                              <line x1="1226.1" y1="237.4" x2="1241.9" y2="237.4"/>
                              <line x1="1226.2" y1="233.4" x2="1241.8" y2="233.4"/>
                              <line x1="1226.4" y1="229.3" x2="1241.6" y2="229.3"/>
                              <line x1="1226.5" y1="225.3" x2="1241.5" y2="225.3"/>
                              <line x1="1226.7" y1="221.2" x2="1241.3" y2="221.2"/>
                              <line x1="1226.9" y1="217.2" x2="1241.1" y2="217.2"/>
                              <line x1="1227.0" y1="213.1" x2="1241.0" y2="213.1"/>
                              <line x1="1227.2" y1="209.1" x2="1240.8" y2="209.1"/>
                              <line x1="1227.3" y1="205.0" x2="1240.7" y2="205.0"/>
                              <line x1="1227.5" y1="201.0" x2="1240.5" y2="201.0"/>
                              <line x1="1227.7" y1="197.0" x2="1240.3" y2="197.0"/>
                              <line x1="1227.8" y1="192.9" x2="1240.2" y2="192.9"/>
                              <line x1="1228.0" y1="188.9" x2="1240.0" y2="188.9"/>
                              <line x1="1228.1" y1="184.8" x2="1239.9" y2="184.8"/>
                              <line x1="1228.3" y1="180.8" x2="1239.7" y2="180.8"/>
                              <line x1="1228.5" y1="176.7" x2="1239.5" y2="176.7"/>
                              <line x1="1228.6" y1="172.7" x2="1239.4" y2="172.7"/>
                              <line x1="1228.8" y1="168.6" x2="1239.2" y2="168.6"/>
                              <line x1="1228.9" y1="164.6" x2="1239.1" y2="164.6"/>
                              <line x1="1229.1" y1="160.5" x2="1238.9" y2="160.5"/>
                              <line x1="1229.2" y1="156.5" x2="1238.8" y2="156.5"/>
                              <line x1="1229.4" y1="152.5" x2="1238.6" y2="152.5"/>
                              <line x1="1229.6" y1="148.4" x2="1238.4" y2="148.4"/>
                              <line x1="1229.7" y1="144.4" x2="1238.3" y2="144.4"/>
                              <line x1="1229.9" y1="140.3" x2="1238.1" y2="140.3"/>
                              <line x1="1230.0" y1="136.3" x2="1238.0" y2="136.3"/>
                              <line x1="1230.2" y1="132.2" x2="1237.8" y2="132.2"/>
                              <line x1="1230.4" y1="128.2" x2="1237.6" y2="128.2"/>
                              <line x1="1230.5" y1="124.1" x2="1237.5" y2="124.1"/>
                              <line x1="1230.7" y1="120.1" x2="1237.3" y2="120.1"/>
                              <line x1="1230.8" y1="116.0" x2="1237.2" y2="116.0"/>
                            </g>
                            <path d="M 1230,116 L 1231,72 L 1234,114 Z" fill="#dfe6ea"/>
                            <path d="M 1234,114 L 1237,76 L 1238,116 Z" fill="#a9b1b7"/>
                            <g><line x1="1234" y1="300" x2="1234" y2="304" stroke="#e2b93f" stroke-width="1" opacity=".5"/><text x="1234" y="316" text-anchor="middle" class="hc-lm-label">KESSLER CAMPANILE</text></g>
                            <!-- McCamish Pavilion -->
                            <path d="M 1352,252 Q 1486,198 1620,252 Z" fill="#7f929f"/>
                            <g stroke="#647684" stroke-width=".9" opacity=".8">
                              <line x1="1374" y1="235.5" x2="1374" y2="252"/>
                              <line x1="1397" y1="221.9" x2="1397" y2="252"/>
                              <line x1="1419" y1="211.4" x2="1419" y2="252"/>
                              <line x1="1442" y1="203.9" x2="1442" y2="252"/>
                              <line x1="1464" y1="199.5" x2="1464" y2="252"/>
                              <line x1="1486" y1="198.0" x2="1486" y2="252"/>
                              <line x1="1509" y1="199.6" x2="1509" y2="252"/>
                              <line x1="1531" y1="204.1" x2="1531" y2="252"/>
                              <line x1="1554" y1="211.7" x2="1554" y2="252"/>
                              <line x1="1576" y1="222.4" x2="1576" y2="252"/>
                              <line x1="1598" y1="236.0" x2="1598" y2="252"/>
                            </g>
                            <path d="M 1352,252 Q 1486,198 1620,252" fill="none" stroke="#a9bcc8" stroke-width="2"/>
                            <rect x="1356" y="258" width="260" height="42" fill="#15384a"/>
                            <g fill="#f2d086" opacity=".55">
                              <rect x="1362" y="264" width="11" height="30"/>
                              <rect x="1378" y="264" width="11" height="30"/>
                              <rect x="1394" y="264" width="11" height="30"/>
                              <rect x="1410" y="264" width="11" height="30"/>
                              <rect x="1426" y="264" width="11" height="30"/>
                              <rect x="1442" y="264" width="11" height="30"/>
                              <rect x="1458" y="264" width="11" height="30"/>
                              <rect x="1474" y="264" width="11" height="30"/>
                              <rect x="1490" y="264" width="11" height="30"/>
                              <rect x="1506" y="264" width="11" height="30"/>
                              <rect x="1522" y="264" width="11" height="30"/>
                              <rect x="1538" y="264" width="11" height="30"/>
                              <rect x="1554" y="264" width="11" height="30"/>
                              <rect x="1570" y="264" width="11" height="30"/>
                              <rect x="1586" y="264" width="11" height="30"/>
                              <rect x="1602" y="264" width="11" height="30"/>
                            </g>
                            <g stroke="#0c2431" stroke-width="1.6">
                              <line x1="1360" y1="258" x2="1360" y2="300"/>
                              <line x1="1376" y1="258" x2="1376" y2="300"/>
                              <line x1="1392" y1="258" x2="1392" y2="300"/>
                              <line x1="1408" y1="258" x2="1408" y2="300"/>
                              <line x1="1424" y1="258" x2="1424" y2="300"/>
                              <line x1="1440" y1="258" x2="1440" y2="300"/>
                              <line x1="1456" y1="258" x2="1456" y2="300"/>
                              <line x1="1472" y1="258" x2="1472" y2="300"/>
                              <line x1="1488" y1="258" x2="1488" y2="300"/>
                              <line x1="1504" y1="258" x2="1504" y2="300"/>
                              <line x1="1520" y1="258" x2="1520" y2="300"/>
                              <line x1="1536" y1="258" x2="1536" y2="300"/>
                              <line x1="1552" y1="258" x2="1552" y2="300"/>
                              <line x1="1568" y1="258" x2="1568" y2="300"/>
                              <line x1="1584" y1="258" x2="1584" y2="300"/>
                              <line x1="1600" y1="258" x2="1600" y2="300"/>
                              <line x1="1616" y1="258" x2="1616" y2="300"/>
                            </g>
                            <path d="M 1338,266 Q 1486,206 1634,266" fill="none" stroke="url(#hc-bronze)" stroke-width="15" stroke-linecap="round"/>
                            <path d="M 1338,266 Q 1350,278 1364,272 Q 1372,268 1368,261" fill="none" stroke="url(#hc-bronze)" stroke-width="13" stroke-linecap="round"/>
                            <path d="M 1344,262 Q 1486,204 1628,262" fill="none" stroke="#f0d492" stroke-width="1.6" opacity=".7"/>
                            <rect x="1444" y="280" width="84" height="20" fill="#0c2431"/>
                            <g fill="#f2d086" opacity=".7">
                              <rect x="1450" y="284" width="13" height="16"/>
                              <rect x="1470" y="284" width="13" height="16"/>
                              <rect x="1490" y="284" width="13" height="16"/>
                              <rect x="1510" y="284" width="13" height="16"/>
                            </g>
                            <rect x="1570" y="266" width="42" height="24" rx="2" fill="#0c2431"/>
                            <text x="1591" y="284" text-anchor="middle" font-family="'Roboto Slab', Georgia, serif" font-size="15" font-weight="700" fill="#e2b93f">GT</text>
                            <text x="1400" y="276" text-anchor="middle" class="hc-lm-tag">McCAMISH PAVILION</text>
                            <g><line x1="1486" y1="300" x2="1486" y2="304" stroke="#e2b93f" stroke-width="1" opacity=".5"/><text x="1486" y="316" text-anchor="middle" class="hc-lm-label">McCAMISH PAVILION</text></g>
                            <!-- Peters Parking Deck: three levels -->
                            <rect x="1694" y="238" width="24" height="62" fill="#66635c"/>
                            <g fill="#f2d086" opacity=".4">
                              <rect x="1700" y="246" width="12" height="9"/>
                              <rect x="1700" y="266" width="12" height="9"/>
                              <rect x="1700" y="286" width="12" height="9"/>
                            </g>
                            <rect x="1718" y="250" width="152" height="6" fill="#8e8a80"/>
                            <rect x="1718" y="256" width="152" height="2" fill="#66635c"/>
                            <rect x="1718" y="270" width="152" height="6" fill="#8e8a80"/>
                            <rect x="1718" y="276" width="152" height="2" fill="#66635c"/>
                            <rect x="1718" y="290" width="152" height="6" fill="#8e8a80"/>
                            <rect x="1718" y="296" width="152" height="2" fill="#66635c"/>
                            <rect x="1718" y="238" width="152" height="12" fill="#8e8a80"/>
                            <g stroke="#66635c" stroke-width="3.4">
                              <line x1="1730" y1="250" x2="1730" y2="292"/>
                              <line x1="1758" y1="250" x2="1758" y2="292"/>
                              <line x1="1786" y1="250" x2="1786" y2="292"/>
                              <line x1="1814" y1="250" x2="1814" y2="292"/>
                              <line x1="1842" y1="250" x2="1842" y2="292"/>
                              <line x1="1870" y1="250" x2="1870" y2="292"/>
                            </g>
                            <g fill="#e2b93f" opacity=".38">
                              <rect x="1736" y="260" width="12" height="5" rx="1.5"/>
                              <rect x="1772" y="260" width="12" height="5" rx="1.5"/>
                              <rect x="1808" y="260" width="12" height="5" rx="1.5"/>
                              <rect x="1844" y="260" width="12" height="5" rx="1.5"/>
                              <rect x="1736" y="280" width="12" height="5" rx="1.5"/>
                              <rect x="1772" y="280" width="12" height="5" rx="1.5"/>
                              <rect x="1808" y="280" width="12" height="5" rx="1.5"/>
                              <rect x="1844" y="280" width="12" height="5" rx="1.5"/>
                            </g>
                            <rect x="1718" y="296" width="152" height="4" fill="#66635c"/>
                            <g><line x1="1794" y1="300" x2="1794" y2="304" stroke="#e2b93f" stroke-width="1" opacity=".5"/><text x="1794" y="316" text-anchor="middle" class="hc-lm-label">PETERS PARKING DECK</text></g>
                            <!-- campus trees -->
                            <path d="M 443,300 Q 462,256 481,300 Z" fill="#0b3a35"/>
                            <rect x="460" y="293" width="3" height="7" fill="#07281f"/>
                            <path d="M 892,300 Q 908,264 924,300 Z" fill="#0b3a35"/>
                            <rect x="906" y="294" width="3" height="6" fill="#07281f"/>
                            <path d="M 1142,300 Q 1160,258 1178,300 Z" fill="#0b3a35"/>
                            <rect x="1158" y="293" width="3" height="7" fill="#07281f"/>
                            <path d="M 1283,300 Q 1300,262 1317,300 Z" fill="#0b3a35"/>
                            <rect x="1298" y="294" width="3" height="6" fill="#07281f"/>
                            <path d="M 1642,300 Q 1660,260 1678,300 Z" fill="#0b3a35"/>
                            <rect x="1658" y="294" width="3" height="6" fill="#07281f"/>
                            <path d="M 1909,300 Q 1930,252 1951,300 Z" fill="#0b3a35"/>
                            <rect x="1928" y="292" width="3" height="8" fill="#07281f"/>
                            <path d="M 1963,300 Q 1990,238 2017,300 Z" fill="#0b3a35"/>
                            <rect x="1988" y="290" width="3" height="10" fill="#07281f"/>
                            <path d="M 2107,300 Q 2130,248 2153,300 Z" fill="#0b3a35"/>
                            <rect x="2128" y="292" width="3" height="8" fill="#07281f"/>
                            <path d="M 2192,300 Q 2210,260 2228,300 Z" fill="#0b3a35"/>
                            <rect x="2208" y="294" width="3" height="6" fill="#07281f"/>
                            <path d="M 2245,300 Q 2270,244 2295,300 Z" fill="#0b3a35"/>
                            <rect x="2268" y="291" width="3" height="9" fill="#07281f"/>
                            <rect x="2040" y="246" width="56" height="54" fill="#5c2a1e"/>
                            <path d="M 2036,246 L 2068,224 L 2100,246 Z" fill="#5f686f"/>
                            <g fill="#f2d086" opacity=".35">
                              <rect x="2050" y="256" width="8" height="11"/>
                              <rect x="2065" y="256" width="8" height="11"/>
                              <rect x="2080" y="256" width="8" height="11"/>
                              <rect x="2050" y="276" width="8" height="11"/>
                              <rect x="2065" y="276" width="8" height="11"/>
                              <rect x="2080" y="276" width="8" height="11"/>
                            </g>
                        </g>
                    </defs>

                    <rect x="0" y="0" width="1200" height="300" fill="url(#hc-sky)"/>
                    <ellipse cx="600" cy="300" rx="560" ry="170" fill="url(#hc-glow)"/>
                    <g fill="#ffffff">
                        <circle class="rrc-star" cx="130" cy="44" r="1.8"/>
                        <circle class="rrc-star rrc-star-2" cx="340" cy="76" r="1.4"/>
                        <circle class="rrc-star rrc-star-3" cx="560" cy="34" r="2.0"/>
                        <circle class="rrc-star rrc-star-4" cx="820" cy="60" r="1.5"/>
                        <circle class="rrc-star rrc-star-5" cx="1040" cy="42" r="1.7"/>
                        <circle class="rrc-star rrc-star-2" cx="960" cy="96" r="1.2"/>
                        <circle class="rrc-star rrc-star-3" cx="240" cy="108" r="1.2"/>
                        <circle class="rrc-star rrc-star-4" cx="680" cy="118" r="1.1"/>
                        <circle class="rrc-star rrc-star-5" cx="430" cy="22" r="1.4"/>
                    </g>

                    <rect x="0" y="296" width="1200" height="26" fill="#04303f"/>
                    <g class="rrc-skyline">
                        <use href="#hc-landmark-tile" x="0"/>
                        <use href="#hc-landmark-tile" x="2300"/>
                    </g>

                    <rect x="0" y="318" width="1200" height="82" fill="url(#hc-road)"/>
                    <rect x="0" y="318" width="1200" height="3" fill="#606a72"/>
                    <g class="rrc-dashes">
                        <line x1="-100" y1="386" x2="1300" y2="386" stroke="#b3a369" stroke-width="5" stroke-dasharray="58 42"/>
                    </g>

                    <!-- ============ The Reck ============ -->
                    <g transform="translate(600, 370) scale(1.16) translate(-163, -150)">
                        <g class="rrc-car">
                            <ellipse cx="165" cy="150" rx="158" ry="6.5" fill="#000" opacity=".32"/>
                            <!-- exhaust -->
                            <rect x="22" y="110" width="24" height="4" rx="2" fill="#8f979c"/>
                            <g fill="#c7d2d8">
                              <circle class="rrc-puff"            cx="20" cy="112" r="6"/>
                              <circle class="rrc-puff rrc-puff-2" cx="20" cy="112" r="4.5"/>
                              <circle class="rrc-puff rrc-puff-3" cx="20" cy="112" r="5.5"/>
                            </g>
                            <!-- rear-mounted spare, seen edge-on: flush to the tail, facing rearwards -->
                            <path d="M 38,74 L 28,76 M 38,104 L 28,102" stroke="#b9c0c6" stroke-width="3.2" stroke-linecap="round"/>
                            <rect x="17" y="64" width="15" height="52" rx="7.5" fill="#171717"/>
                            <rect x="17" y="64" width="5" height="52" rx="2.5" fill="#2e2e2e"/>
                            <g stroke="#3d3d3d" stroke-width=".9">
                              <line x1="18.5" y1="71" x2="30.5" y2="71"/>
                              <line x1="18.5" y1="78" x2="30.5" y2="78"/>
                              <line x1="18.5" y1="85" x2="30.5" y2="85"/>
                              <line x1="18.5" y1="92" x2="30.5" y2="92"/>
                              <line x1="18.5" y1="99" x2="30.5" y2="99"/>
                              <line x1="18.5" y1="106" x2="30.5" y2="106"/>
                            </g>
                            <rect x="28.5" y="69" width="4" height="42" rx="2" fill="#e9e5d8"/>
                            <rect x="28.5" y="69" width="1.4" height="42" rx=".7" fill="#c9c3b2"/>
                            <!-- rear bumper and plate -->
                            <rect x="-4" y="110" width="34" height="3.4" rx="1.7" fill="url(#hc-chrome)"/>
                            <rect x="-4" y="118" width="34" height="3.4" rx="1.7" fill="url(#hc-chrome)"/>
                            <rect x="6" y="110" width="3.2" height="11.4" fill="#c3cad0"/>
                            <rect x="12" y="110" width="15" height="8" rx="1" fill="#e8edf0" stroke="#a9b1b8" stroke-width=".6"/>
                            <!-- flag poles and pennants -->
                            <line x1="252" y1="86" x2="252" y2="-12" stroke="#c9ced2" stroke-width="2.4"/>
                            <circle cx="252" cy="-13" r="2.3" fill="#dfe4e8"/>
                            <line x1="304" y1="88" x2="304" y2="2" stroke="#c9ced2" stroke-width="2.4"/>
                            <circle cx="304" cy="1" r="2.3" fill="#dfe4e8"/>
                            <g class="rrc-flag">
                              <path d="M 252,-12 L 185,0.6 L 185,1.4 L 252,14 Z" fill="#d9781d"/>
                              <path d="M 252,-12 L 185,0.6 L 206,-0.6 L 252,-8.5 Z" fill="#e89a45"/>
                              <path d="M 252,14 L 185,1.4 L 206,2.6 L 252,10.5 Z" fill="#b45f10" opacity=".8"/>
                              <text x="248" y="2.6" text-anchor="end" font-family="'Roboto Slab', Georgia, serif" font-size="4.1" font-weight="700" letter-spacing=".12" fill="#fff">GIVE ’EM HELL TECH</text>
                            </g>
                            <g class="rrc-flag rrc-flag-2">
                              <path d="M 304,2 L 241,12.6 L 241,13.4 L 304,26 Z" fill="#d9781d"/>
                              <path d="M 304,2 L 241,12.6 L 261,11.4 L 304,5 Z" fill="#e89a45"/>
                              <path d="M 304,26 L 241,13.4 L 261,14.6 L 304,23 Z" fill="#b45f10" opacity=".8"/>
                              <text x="300" y="15.6" text-anchor="end" font-family="'Roboto Slab', Georgia, serif" font-size="3.6" font-weight="700" letter-spacing=".08" fill="#fff">TO HELL WITH GEORGIA</text>
                            </g>
                            <!-- gold body shell -->
                            <path d="M 34,84 L 106,66 L 108,42 Q 109,30 120,28 L 184,24 Q 195,24 197,32 L 202,66 L 288,62 Q 297,62 298,71 L 300,116 L 44,116 Q 34,116 34,106 Z" fill="url(#hc-gold)"/>
                            <path d="M 34,84 L 106,66" fill="none" stroke="#8d7c46" stroke-width="1.2"/>
                            <!-- open rumble-seat lid, stood up at the back of the well as the seat back -->
                            <path d="M 42,82 L 36,40 L 50,38 L 56,76 Z" fill="url(#hc-gold)"/>
                            <path d="M 50,38 L 56,76 L 50,77 L 44,39 Z" fill="#efe9d8"/>
                            <g stroke="#d6cfba" stroke-width=".7" opacity=".8">
                              <line x1="46.0" y1="52" x2="52.0" y2="51"/>
                              <line x1="48.0" y1="64" x2="54.0" y2="63"/>
                            </g>
                            <path d="M 36,40 L 50,38" fill="none" stroke="#6b5c2a" stroke-width="1.4"/>
                            <!-- rider seated in the well, in front of the raised lid -->
                            <path d="M 70,65 L 66,51" stroke="#12242e" stroke-width="2.8" stroke-linecap="round"/>
                            <circle cx="65" cy="49" r="2.1" fill="#12242e"/>
                            <path d="M 68,76 L 69,63 Q 71,57 75,57 Q 79,58 80,64 L 82,73 Z" fill="#12242e"/>
                            <ellipse cx="75" cy="50" rx="4.6" ry="5.2" fill="#12242e"/>
                            <!-- white landau top over roof and rear quarter -->
                            <path d="M 194,32 L 184,25 L 122,27 Q 110,29 108,42 L 106,68 L 106,72 L 132,72 L 132,37 L 190,32 Z" fill="#f2efe6"/>
                            <path d="M 194,32 L 184,25 L 122,27 Q 110,29 108,42 L 106,70" fill="none" stroke="#dcd6c6" stroke-width=".9"/>
                            <path d="M 186,29 L 124,31 Q 116,33 114,44 L 112,70" fill="none" stroke="#d7d0be" stroke-width=".8" stroke-dasharray="3 2.5"/>
                            <!-- door glass, driver, steering wheel -->
                            <path d="M 134,37 L 185,31 L 189,61 L 134,61 Z" fill="#16323f"/>
                            <path d="M 134,37 L 185,31 L 189,61 L 134,61 Z" fill="none" stroke="#c8ad60" stroke-width="2"/>
                            <path d="M 139,39 L 168,36 L 152,59 L 140,59 Z" fill="#fff" opacity=".10"/>
                            <circle cx="164" cy="44" r="6.5" fill="#12242e"/>
                            <path d="M 152,61 Q 164,48 177,61 Z" fill="#12242e"/>
                            <ellipse cx="180" cy="52" rx="2.6" ry="6.5" fill="none" stroke="#0d2029" stroke-width="1.5"/>
                            <!-- windshield post, visor, mirror -->
                            <path d="M 188,27 L 202,29 L 202,33 L 190,32 Z" fill="#e6e1d4"/>
                            <line x1="194" y1="32" x2="199" y2="66" stroke="#cdd3d8" stroke-width="2.4"/>
                            <line x1="189" y1="35" x2="186" y2="41" stroke="#cdd3d8" stroke-width="1.6"/>
                            <ellipse cx="184" cy="42" rx="4" ry="3" fill="#dfe4e8" stroke="#a9b1b8" stroke-width=".7"/>
                            <!-- beltline moulding -->
                            <path d="M 106,66 L 300,62" fill="none" stroke="#8d7c46" stroke-width="1.4"/>
                            <path d="M 106,68 L 300,64" fill="none" stroke="#e0d4a4" stroke-width=".8" opacity=".5"/>
                            <!-- door shut lines, handle and GT -->
                            <path d="M 128,68 L 128,113" stroke="#8d7c46" stroke-width="1.4"/>
                            <path d="M 196,64 L 197,113" stroke="#8d7c46" stroke-width="1.4"/>
                            <path d="M 177,74 q 9,-2 12,1" fill="none" stroke="#dfe4e8" stroke-width="2.8" stroke-linecap="round"/>
                            <text x="160" y="100" text-anchor="middle" font-family="'Roboto Slab', Georgia, serif" font-size="30" font-weight="700" fill="#fff" stroke="#16323f" stroke-width="2.4" paint-order="stroke">GT</text>
                            <circle cx="39" cy="92" r="3" fill="#c0392b" stroke="#dfe4e8" stroke-width="1"/>
                            <!-- cowl: gas cap, lamp, horn -->
                            <circle cx="205" cy="62" r="2.4" fill="#dfe4e8"/>
                            <circle cx="211" cy="56" r="4.2" fill="#e8edf0" stroke="#a9b1b8" stroke-width=".8"/>
                            <circle cx="211" cy="56" r="1.8" fill="#fff6d6"/>
                            <path d="M 205,72 L 215,69 L 215,77 L 205,75 Z" fill="#cdd3d8"/>
                            <circle cx="199" cy="52" r="4.6" fill="url(#hc-chrome)" stroke="#9aa3aa" stroke-width=".7"/>
                            <!-- hood with louvres -->
                            <path d="M 202,66 L 288,62 Q 297,62 298,71 L 299,88 L 202,90 Z" fill="url(#hc-gold-hood)"/>
                            <path d="M 202,68 L 296,64" fill="none" stroke="#e6d9a8" stroke-width="1" opacity=".65"/>
                            <path d="M 202,66 L 202,116" stroke="#8d7c46" stroke-width="1.2"/>
                            <path d="M 208,78 q 7,-1 10,1" fill="none" stroke="#dfe4e8" stroke-width="1.8" stroke-linecap="round"/>
                            <g stroke="#8d7c46" stroke-width="1.1" opacity=".85">
                              <line x1="217" y1="74.0" x2="217" y2="102.0"/>
                              <line x1="220" y1="73.8" x2="220" y2="101.8"/>
                              <line x1="224" y1="73.7" x2="224" y2="101.7"/>
                              <line x1="227" y1="73.5" x2="227" y2="101.5"/>
                              <line x1="231" y1="73.4" x2="231" y2="101.4"/>
                              <line x1="234" y1="73.2" x2="234" y2="101.2"/>
                              <line x1="237" y1="73.1" x2="237" y2="101.1"/>
                              <line x1="241" y1="72.9" x2="241" y2="100.9"/>
                              <line x1="244" y1="72.8" x2="244" y2="100.8"/>
                              <line x1="248" y1="72.6" x2="248" y2="100.6"/>
                              <line x1="251" y1="72.5" x2="251" y2="100.5"/>
                              <line x1="254" y1="72.3" x2="254" y2="100.3"/>
                              <line x1="258" y1="72.2" x2="258" y2="100.2"/>
                              <line x1="261" y1="72.0" x2="261" y2="100.0"/>
                              <line x1="265" y1="71.9" x2="265" y2="99.9"/>
                              <line x1="268" y1="71.7" x2="268" y2="99.7"/>
                              <line x1="271" y1="71.6" x2="271" y2="99.6"/>
                              <line x1="275" y1="71.4" x2="275" y2="99.4"/>
                              <line x1="278" y1="71.2" x2="278" y2="99.2"/>
                              <line x1="282" y1="71.1" x2="282" y2="99.1"/>
                              <line x1="285" y1="70.9" x2="285" y2="98.9"/>
                            </g>
                            <!-- radiator shell, cap, grille -->
                            <path d="M 288,54 L 306,59 L 307,113 L 290,113 Z" fill="url(#hc-chrome)"/>
                            <path d="M 292,62 L 303,66 L 304,107 L 293,107 Z" fill="#4a4437"/>
                            <g stroke="#8c8467" stroke-width=".8">
                              <line x1="294.5" y1="64.2" x2="295.1" y2="106"/>
                              <line x1="297" y1="65.0" x2="297.6" y2="106"/>
                              <line x1="299.5" y1="65.9" x2="300.1" y2="106"/>
                              <line x1="302" y1="66.8" x2="302.6" y2="106"/>
                            </g>
                            <path d="M 293,54 L 302,57 L 301,51 L 295,49 Z" fill="#e8edf0"/>
                            <circle cx="297" cy="47" r="2.6" fill="#dfe4e8"/>
                            <!-- headlamp bar and lamps -->
                            <line x1="256" y1="52" x2="310" y2="54" stroke="#b9c0c6" stroke-width="2.6"/>
                            <circle cx="272" cy="46" r="9.5" fill="#c8cfd4" stroke="#9aa3aa" stroke-width="1.2"/>
                            <line x1="281" y1="53" x2="281" y2="60" stroke="#b9c0c6" stroke-width="2"/>
                            <circle cx="281" cy="50" r="11" fill="url(#hc-chrome)" stroke="#9aa3aa" stroke-width="1.2"/>
                            <circle cx="281" cy="50" r="7" fill="#fff8dd"/>
                            <circle cx="278" cy="47" r="2.6" fill="#fff" opacity=".85"/>
                            <!-- running board -->
                            <rect x="122" y="115" width="94" height="10" rx="2.5" fill="#f2efe6"/>
                            <rect x="126" y="117" width="86" height="6" rx="1.5" fill="#33383c"/>
                            <g stroke="#4e555a" stroke-width=".9">
                              <line x1="132" y1="118" x2="132" y2="122"/>
                              <line x1="138" y1="118" x2="138" y2="122"/>
                              <line x1="144" y1="118" x2="144" y2="122"/>
                              <line x1="150" y1="118" x2="150" y2="122"/>
                              <line x1="156" y1="118" x2="156" y2="122"/>
                              <line x1="162" y1="118" x2="162" y2="122"/>
                              <line x1="168" y1="118" x2="168" y2="122"/>
                              <line x1="174" y1="118" x2="174" y2="122"/>
                              <line x1="180" y1="118" x2="180" y2="122"/>
                              <line x1="186" y1="118" x2="186" y2="122"/>
                              <line x1="192" y1="118" x2="192" y2="122"/>
                              <line x1="198" y1="118" x2="198" y2="122"/>
                              <line x1="204" y1="118" x2="204" y2="122"/>
                            </g>
                            <path d="M 118,112 L 124,112 L 124,120 L 118,120 Z" fill="#e6e1d4"/>
                            <path d="M 214,112 L 220,112 L 220,120 L 214,120 Z" fill="#e6e1d4"/>
                            <!-- fenders -->
                            <path d="M 52,120 C 52,100 64,90 84,90 C 106,90 118,100 118,120 L 118,124" fill="none" stroke="#f2efe6" stroke-width="9" stroke-linecap="round"/>
                            <path d="M 56,120 C 56,103 66,95 84,95 C 103,95 114,103 114,120" fill="none" stroke="#d9d3c3" stroke-width=".9"/>
                            <path d="M 214,120 C 214,99 235,89 265,89 C 293,89 308,98 313,110 C 316,117 317,122 317,126" fill="none" stroke="#f2efe6" stroke-width="10" stroke-linecap="round"/>
                            <path d="M 219,120 C 219,103 237,94 265,94 C 289,94 303,102 308,112" fill="none" stroke="#d9d3c3" stroke-width=".9"/>
                            <rect x="44" y="102" width="14" height="3.4" rx="1.5" fill="#dfe4e8"/>
                            <!-- front bumper -->
                            <rect x="304" y="100" width="21" height="3.4" rx="1.7" fill="url(#hc-chrome)"/>
                            <rect x="304" y="107" width="21" height="3.4" rx="1.7" fill="url(#hc-chrome)"/>
                            <rect x="311" y="100" width="3.2" height="10.4" fill="#c3cad0"/>
                            <rect x="306" y="112" width="14" height="6" rx="1" fill="#e8edf0" stroke="#a9b1b8" stroke-width=".6"/>
                            <!-- road wheels -->
                            <circle cx="84" cy="124" r="26" fill="#141414"/>
                            <circle cx="84" cy="124" r="24.2" fill="none" stroke="#2c2c2c" stroke-width="1"/>
                            <circle cx="84" cy="124" r="21.1" fill="#f1ede2"/>
                            <circle cx="84" cy="124" r="21.1" fill="none" stroke="#d5cfbe" stroke-width=".8"/>
                            <g class="rrc-wheel">
                              <circle cx="84" cy="124" r="15.6" fill="#7d6c37"/>
                              <g stroke="#d3ba6b" stroke-width="1" stroke-linecap="round">
                                <line x1="89.2" y1="124.0" x2="97.5" y2="131.8"/>
                                <line x1="89.2" y1="124.0" x2="97.5" y2="116.2"/>
                                <line x1="88.5" y1="126.6" x2="91.8" y2="137.5"/>
                                <line x1="88.5" y1="126.6" x2="99.6" y2="124.1"/>
                                <line x1="86.6" y1="128.5" x2="84.1" y2="139.6"/>
                                <line x1="86.6" y1="128.5" x2="97.5" y2="131.8"/>
                                <line x1="84.0" y1="129.2" x2="76.2" y2="137.5"/>
                                <line x1="84.0" y1="129.2" x2="91.8" y2="137.5"/>
                                <line x1="81.4" y1="128.5" x2="70.5" y2="131.8"/>
                                <line x1="81.4" y1="128.5" x2="83.9" y2="139.6"/>
                                <line x1="79.5" y1="126.6" x2="68.4" y2="124.1"/>
                                <line x1="79.5" y1="126.6" x2="76.2" y2="137.5"/>
                                <line x1="78.8" y1="124.0" x2="70.5" y2="116.2"/>
                                <line x1="78.8" y1="124.0" x2="70.5" y2="131.8"/>
                                <line x1="79.5" y1="121.4" x2="76.2" y2="110.5"/>
                                <line x1="79.5" y1="121.4" x2="68.4" y2="123.9"/>
                                <line x1="81.4" y1="119.5" x2="83.9" y2="108.4"/>
                                <line x1="81.4" y1="119.5" x2="70.5" y2="116.2"/>
                                <line x1="84.0" y1="118.8" x2="91.8" y2="110.5"/>
                                <line x1="84.0" y1="118.8" x2="76.2" y2="110.5"/>
                                <line x1="86.6" y1="119.5" x2="97.5" y2="116.2"/>
                                <line x1="86.6" y1="119.5" x2="84.1" y2="108.4"/>
                                <line x1="88.5" y1="121.4" x2="99.6" y2="123.9"/>
                                <line x1="88.5" y1="121.4" x2="91.8" y2="110.5"/>
                              </g>
                              <circle cx="84" cy="124" r="15.6" fill="none" stroke="#c8ad60" stroke-width="2"/>
                              <circle cx="84" cy="124" r="5.2" fill="#dfe4e8" stroke="#a9b1b8" stroke-width=".8"/>
                              <circle cx="84" cy="124" r="2.2" fill="#b3a369"/>
                            </g>
                            <circle cx="265" cy="124" r="26" fill="#141414"/>
                            <circle cx="265" cy="124" r="24.2" fill="none" stroke="#2c2c2c" stroke-width="1"/>
                            <circle cx="265" cy="124" r="21.1" fill="#f1ede2"/>
                            <circle cx="265" cy="124" r="21.1" fill="none" stroke="#d5cfbe" stroke-width=".8"/>
                            <g class="rrc-wheel">
                              <circle cx="265" cy="124" r="15.6" fill="#7d6c37"/>
                              <g stroke="#d3ba6b" stroke-width="1" stroke-linecap="round">
                                <line x1="270.2" y1="124.0" x2="278.5" y2="131.8"/>
                                <line x1="270.2" y1="124.0" x2="278.5" y2="116.2"/>
                                <line x1="269.5" y1="126.6" x2="272.8" y2="137.5"/>
                                <line x1="269.5" y1="126.6" x2="280.6" y2="124.1"/>
                                <line x1="267.6" y1="128.5" x2="265.1" y2="139.6"/>
                                <line x1="267.6" y1="128.5" x2="278.5" y2="131.8"/>
                                <line x1="265.0" y1="129.2" x2="257.2" y2="137.5"/>
                                <line x1="265.0" y1="129.2" x2="272.8" y2="137.5"/>
                                <line x1="262.4" y1="128.5" x2="251.5" y2="131.8"/>
                                <line x1="262.4" y1="128.5" x2="264.9" y2="139.6"/>
                                <line x1="260.5" y1="126.6" x2="249.4" y2="124.1"/>
                                <line x1="260.5" y1="126.6" x2="257.2" y2="137.5"/>
                                <line x1="259.8" y1="124.0" x2="251.5" y2="116.2"/>
                                <line x1="259.8" y1="124.0" x2="251.5" y2="131.8"/>
                                <line x1="260.5" y1="121.4" x2="257.2" y2="110.5"/>
                                <line x1="260.5" y1="121.4" x2="249.4" y2="123.9"/>
                                <line x1="262.4" y1="119.5" x2="264.9" y2="108.4"/>
                                <line x1="262.4" y1="119.5" x2="251.5" y2="116.2"/>
                                <line x1="265.0" y1="118.8" x2="272.8" y2="110.5"/>
                                <line x1="265.0" y1="118.8" x2="257.2" y2="110.5"/>
                                <line x1="267.6" y1="119.5" x2="278.5" y2="116.2"/>
                                <line x1="267.6" y1="119.5" x2="265.1" y2="108.4"/>
                                <line x1="269.5" y1="121.4" x2="280.6" y2="123.9"/>
                                <line x1="269.5" y1="121.4" x2="272.8" y2="110.5"/>
                              </g>
                              <circle cx="265" cy="124" r="15.6" fill="none" stroke="#c8ad60" stroke-width="2"/>
                              <circle cx="265" cy="124" r="5.2" fill="#dfe4e8" stroke="#a9b1b8" stroke-width=".8"/>
                              <circle cx="265" cy="124" r="2.2" fill="#b3a369"/>
                            </g>
                        </g>
                    </g>
                </svg>

        <div class="reck-stage-label">
            <span class="rsl-kicker">Homecoming Weekend</span>
            <span class="rsl-date">October 23 &ndash; 24, 2026</span>
        </div>
    </div>
</div>

<!-- ============================ Intro ============================ -->
<div class="container mb-4">
    <div class="row">
        <div class="col-md-10 offset-md-1 text-center">
            <p class="lead mb-2">Three traditions. One weekend. Ninety-plus years of Georgia Tech spirit.</p>
            <p>Every fall the Ramblin&rsquo; Reck Club puts on the three events that make Georgia Tech&rsquo;s
                Homecoming its own: the <a href="/homecoming/mini-500.php">Mini 500</a> tricycle race on Friday
                evening, the <a href="/homecoming/cake-race.php">Freshman Cake Race</a> before sunrise on
                Saturday, and the <a href="/homecoming/wreck-parade.php">Ramblin&rsquo; Wreck Parade</a> up
                Fowler Street just before kickoff. Here&rsquo;s what each one is, and when and where to be.</p>
        </div>
    </div>
    <hr class="mb-4">
</div>

<!-- ============================ The three events ============================ -->
<div class="container mb-4">
    <div class="row">
        <?php foreach ($hcEvents as $e): ?>
            <?php $ts = strtotime($e['date']); ?>
            <div class="col-lg-4 col-md-12 mb-4">
                <div class="card hc-card" style="--accent: <?php echo $e['color']; ?>">
                    <img class="hc-card-img" src="<?php echo $e['image']; ?>"
                         alt="<?php echo $e['alt']; ?>" loading="lazy">
                    <div class="card-body d-flex flex-column">
                        <span class="hc-eyebrow mb-1"><?php echo date('l, F j', $ts); ?></span>
                        <h4 class="mb-1"><?php echo $e['name']; ?></h4>
                        <p class="hc-when mb-3"><?php echo $e['time']; ?></p>
                        <p class="card-text mb-3"><?php echo $e['blurb']; ?></p>
                        <div class="hc-meta mb-2">
                            <p class="mb-1"><i class="fas fa-map-marker-alt"></i> <?php echo $e['where']; ?></p>
                            <p class="mb-0 text-muted"><i class="fas fa-info-circle"></i> <?php echo $e['note']; ?></p>
                        </div>
                        <a class="btn btn-md btn-primary mt-auto align-self-start"
                           href="<?php echo $e['link']; ?>">Rules, sign-ups &amp; details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ============================ Calendar ============================ -->
<div class="container mb-4">
    <div class='blog-header mb-4'>
        <div class='col-12' style="text-align: center;">
            <h1>The Weekend at a Glance</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 col-md-12 mb-4">
            <div class="hc-cal">
                <div class="hc-cal-head"><?php echo $hcMonthLabel; ?></div>
                <div class="hc-cal-grid">
                    <?php foreach (array('Sun','Mon','Tue','Wed','Thu','Fri','Sat') as $dow): ?>
                        <div class="hc-dow"><?php echo $dow; ?></div>
                    <?php endforeach; ?>

                    <?php for ($i = 0; $i < $hcStartDow; $i++): ?>
                        <div class="hc-day is-blank"></div>
                    <?php endfor; ?>

                    <?php for ($day = 1; $day <= $hcDaysInMon; $day++): ?>
                        <?php
                        $iso    = sprintf('%04d-%02d-%02d', $hcYear, $hcMonth, $day);
                        $onThis = isset($hcByDate[$iso]) ? $hcByDate[$iso] : array();
                        ?>
                        <div class="hc-day<?php echo $onThis ? ' is-event' : ''; ?>">
                            <span class="hc-daynum"><?php echo $day; ?></span>
                            <?php foreach ($onThis as $e): ?>
                                <a class="hc-pill" href="<?php echo $e['link']; ?>"
                                   style="background: <?php echo $e['color']; ?>"
                                   title="<?php echo strip_tags($e['name']) . ' &ndash; ' . $e['time']; ?>">
                                    <?php echo $e['short']; ?>
                                </a>
                                <a class="hc-dot" href="<?php echo $e['link']; ?>"
                                   style="background: <?php echo $e['color']; ?>"
                                   title="<?php echo strip_tags($e['name']) . ' &ndash; ' . $e['time']; ?>"></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endfor; ?>

                    <?php
                    // Pad the final week so the grid stays rectangular.
                    $filled = $hcStartDow + $hcDaysInMon;
                    $trail  = (7 - ($filled % 7)) % 7;
                    for ($i = 0; $i < $trail; $i++):
                        ?>
                        <div class="hc-day is-blank"></div>
                    <?php endfor; ?>
                </div>
            </div>
            <p class="text-muted mt-2" style="font-size: .82rem;">
                <i class="fas fa-hand-pointer"></i> Tap a highlighted day to jump to that event&rsquo;s page.
            </p>
        </div>

        <div class="col-lg-5 col-md-12 mb-4">
            <ul class="hc-timeline">
                <?php
                $lastDate = null;
                foreach ($hcEvents as $e):
                    $ts = strtotime($e['date']);
                    if ($e['date'] !== $lastDate):
                        $lastDate = $e['date'];
                        ?>
                        <li class="hc-tl-day"><?php echo date('l, F j', $ts); ?></li>
                    <?php endif; ?>
                    <li class="hc-tl-item" style="--accent: <?php echo $e['color']; ?>">
                        <div class="hc-tl-time"><?php echo $e['time']; ?></div>
                        <div><a href="<?php echo $e['link']; ?>"><strong><?php echo $e['name']; ?></strong></a></div>
                        <div class="hc-tl-where"><?php echo $e['where']; ?></div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p class="text-muted mt-4" style="font-size: .82rem;">
                Sign-ups, rule books and bib or tricycle pickup times live on each event&rsquo;s page &mdash;
                check them for the latest.
            </p>
        </div>
    </div>
    <hr class="mb-3">
</div>

<!-- ============================ Contact ============================ -->
<div class="container mb-3">
    <div class="row">
        <div class="col-md-3 col-sm-6 text-center mb-3">
            <p class="mb-0"><a href="mailto:rrchomecoming@gmail.com"><b>Sophia Uma&ntilde;a</b></a></p>
            <p class="mb-0"><i>Reck Club Homecoming Chair</i></p>
            <p class="mb-0">rrchomecoming@gmail.com</p>
        </div>
        <?php foreach ($hcEvents as $e): ?>
            <div class="col-md-3 col-sm-6 text-center mb-3">
                <p class="mb-0"><a href="mailto:<?php echo $e['email']; ?>"><b><?php echo $e['name']; ?></b></a></p>
                <p class="mb-0"><i>Questions about this event</i></p>
                <p class="mb-0"><?php echo $e['email']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="text-muted"><i>Have any questions? Reach out to us at
                <a href="mailto:rrchomecoming@gmail.com">rrchomecoming@gmail.com</a>.</i></p>
        </div>
    </div>
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>
