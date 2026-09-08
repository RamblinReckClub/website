<?php $pageTitle = "Mini 500"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<!--<link href="https://fonts.googleapis.com/css?family=Saira+Semi+Condensed:400,600&display=swap" rel="stylesheet">-->

<body>
    <?php require "../partials/public-header.php" ?>

    <?php
    // Renders one "image left, copy right" block per item. Both sections below use
    // this so their spacing stays identical.
    function mini500_info_rows(array $items): void
    {
        foreach ($items as $item) {
            $hasList = !empty($item["list"]);
            echo "<div class='row mb-4'>";
            echo "<div class='col-12 col-md-5 mb-3 mb-md-0'>";
            echo "<img class='img-fluid' src=\"" . $item["image"] . "\"/>";
            echo "</div>";
            echo "<div class='col-12 col-md-7'>";
            echo "<h4>" . $item["title"] . "</h4>";
            echo "<p class=\"" . ($hasList ? "mb-2" : "mb-0") . "\">" . $item["main"] . "</p>";
            if ($hasList) {
                echo "<ul class='mb-0'>";
                foreach ($item["list"] as $line) {
                    echo "<li>" . $line . "</li>";
                }
                echo "</ul>";
            }
            echo "</div>";
            echo "</div>";
        }
    }
    ?>

    <div class="container mb-4">
        <div class="blog-header">
            <div class="col-12 text-center">
                <h1>Mini 500</h1>
            </div>
        </div>
    </div>

    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <img class="img-fluid" src="/homecoming/images/Mini500Banner2020.png">
            </div>
        </div>
    </div>

    <div class="container mb-4">
        <div class="row">
            <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                <p class="mb-0"><a href="mailto:rrchomecoming@gmail.com"><b>Sophia Umaña</b></a></p>
                <p class="mb-0"><i>Reck Club Homecoming Chair</i></p>
                <p class="mb-0">rrchomecoming@gmail.com</p>
            </div>
            <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                <p class="mb-0"><a href="mailto:rrcmini500@gmail.com"><b>Nina Phelan</b></a></p>
                <p class="mb-0"><i>Mini 500 Sub-Chair</i></p>
                <p class="mb-0">rrcmini500@gmail.com</p>
            </div>
            <div class="col-12 col-md-4 text-center">
                <p class="mb-0"><a href="mailto:rrcmini500@gmail.com"><b>SG Pfanstiel</b></a></p>
                <p class="mb-0"><i>Mini 500 Sub-Chair</i></p>
                <p class="mb-0">rrcmini500@gmail.com</p>
            </div>
        </div>
        <hr class="mt-4 mb-0">
    </div>

    <div class="container mb-4">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="mb-4">October 23, 2026, at 5:00PM</h2>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-12 col-sm-auto text-center mb-3 mb-sm-0">
                <a class="btn btn-md btn-primary"
                    href="https://docs.google.com/document/d/1xffVPYUfxsX3MQOQDiVadvDC3ZiLlp8poQqqP1mfIAk/edit?usp=sharing"
                    target="_blank">Event Rules</a>
            </div>
            <div class="col-12 col-sm-auto text-center">
                <a class="btn btn-md btn-secondary"
                    href="https://docs.google.com/forms/d/e/1FAIpQLScUaDLIHtgm2owQhboy4jXfFnviQM3JRECm_rqviOYIEMe6yw/viewform?usp=header">Sign
                    Up Here!</a>
            </div>
        </div>

        <div class="row">
            <p class="col-12 text-center font-weight-bold mb-0">Sign-ups will be available on Tuesday, September 15, at
                9:00 AM via the link above. Registration will be limited to 70 teams.</p>
        </div>
    </div>

    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/VF45Fb0uPU4"
                        frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <hr class="mt-4 mb-0">
    </div>

    <div class="container mb-4">
        <?php

        $info1 = array(
            [
                "image" => '/homecoming/images/M55.jpg',
                "title" => 'The Tradition',
                "main" => 'The Mini 500 is an annual 8 lap tricycle race that takes place around Peter’s Parking 
                           Deck on the Friday afternoon before the Homecoming football game. It is one of Georgia Tech’s most 
                           unique traditions put on by Ramblin’ Reck Club since 1969. Teams consist of seven members: four 
                           racers and three pit crew who are responsible for maintenance and tire rotations. Each team is 
                           required to rotate their front tire three times throughout the course of the race, typically 
                           following the second, fourth, and sixth lap. All teams attempt to complete all 8 laps as quickly 
                           as possible without destroying their tricycle.'

            ],
//                [
//                    "image" => '/homecoming/images/buzz_n_racer.jpg',
//                    "title" => 'Sign Ups',
//                    "main" => 'Sign ups will be available beginning Monday, September 15.'
//                ],
            [
                "image" => '/homecoming/images/fighting_freshmen_hill.jpg',
                "title" => 'Tricycle Pickup',
                "main" => 'Tricycles will be distributed a few weeks prior to the race to allow for proper modification. 
                Please keep an eye out regarding further communication of exact dates and pick up location.'

            ],
            [
                "image" => '/homecoming/images/backwards_racer2.jpg',
                "title" => 'Tricycle Modifications',
                "main" => "Each team must paint their tricycle in order to participate. <b>RED TRICYCLES WILL NOT RACE.</b> 
                             This is the only modification that a team must make, but it is highly encouraged that a 
                             team uses their knowledge and skills as GT students to modify their Tricycle further 
                             because if no further modifications are made the tricycle is almost guaranteed to not 
                             make it through the race. Modified tricycles must still meet tricycle regulations which can be found in the event rules linked above.
                    Common modifications are:",
                "list" => [
                    'Changing out the front tire to be a larger and more reinforced tire',
                    'Adding padding to the seat and handlebars for your arms to rest on',
                    'Adding a foot stopper to the back of the tricycle',
                ]
            ],
        );

        mini500_info_rows($info1);
        ?>
        <hr class="mt-1 mb-0">
    </div>

    <div class="container mb-4">
        <div class="blog-header mb-4">
            <div class="col-12 text-center">
                <h1 id="race-day-info">Race Day Info</h1>
            </div>
        </div>

        <?php
        $info2 = array(
            [
                "image" => '/homecoming/images/M54.jpg',
                "title" => 'Check-In',
                "main" => 'The Race will be around Peters Parking Deck with the Pits for each team lining the 
                        Peters Parking Deck side of Fowler Street and the start being at the corner of Fowler St. 
                        and Bobby Dodd Way. Each team will receive an email with their assigned pit number. 
                        The team will report to THEIR PIT between 4:00 PM and 4:30 PM and check in with their pit boss
                        (A member of Ramblin\' Reck Club). Teams should arrive with their racers, pit crew, 
                        signed waivers, tricycles, and any approved tools required for wheel rotations. Mini 500 shirts
                        and race bibs will be provided at check-in.'

            ],
            [
                "image" => '/homecoming/images/reck_club_finish.jpg',
                "title" => 'Racers',
                "main" => 'Each team will have four members who are deemed racers. They will take turns completing 
                            a lap each until each racer has completed two laps for a total of eight laps done by 
                            the team. There are many different techniques used by racers to propel the tricycle 
                            so just choose what works best for you!'
            ],
            [
                "image" => '/homecoming/images/clown_racer.jpg',
                "title" => 'Apparel',
                "main" => 'It is difficult to propel a tricycle as a full grown human and may result in a few scraps 
                             and bruises so we recommend wearing some form of bottom that covers your legs 
                             (jeans, sweatpants, leggings) as well are wearing reinforcement on your shoes 
                             (such as duct tape) or shoes you don’t care about because they will be hitting the 
                            pavement and may get scuffed up!'
            ],
            [
                "image" => '/homecoming/images/M53.jpg',
                "title" => 'Pit Crew',
                "main" => 'The team will also have 3 pit members who will remain in the pit and facilitate changes
                            in drivers as well as the three front wheel rotations that must be performed 
                            after every 2 laps.'

            ],
            [
                "image" => '/homecoming/images/M56.jpg',
                "title" => 'The Wheel Rotation',
                "main" => 'After every two laps the team is required to perform a rotation of their front tire.
                            This will be monitored by the pit boss assigned to the teams pit and completed after 
                            lap 2, 4, and 6. A wheel reversal consists of removing the front tire, rotating it, and 
                            then reattaching the front tire. No power tools can be used for wheel reversals.'
            ]
        );

        mini500_info_rows($info2);
        ?>
    </div>

    <div class="container mb-4">
        <div class="row">
            <?php include "sponsors.php"; ?>
        </div>
    </div>

    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <p class="text-muted mb-0"><i>Have any questions? Reach out to us at <a
                            href="mailto:rrcmini500@gmail.com">rrcmini500@gmail.com</a> or <a
                            href="mailto:rrchomecoming@gmail.com">rrchomecoming@gmail.com</a>.</i></p>
            </div>
        </div>
    </div>

    <?php require "../partials/footer.php" ?>
    <?php require "../partials/scripts.php" ?>
</body>

</html>
