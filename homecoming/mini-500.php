<?php $pageTitle = "Mini 500"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<!--<link href="https://fonts.googleapis.com/css?family=Saira+Semi+Condensed:400,600&display=swap" rel="stylesheet">-->

<body>
    <?php require "../partials/public-header.php" ?>

    <div class="container mb-3">
        <div class='blog-header'>
            <div class='col-12' style="text-align: center;">
                <h1>Mini 500</h1>
            </div>
        </div>
    </div>
    <div class="container mb-3">
        <div class="row">
            <div class="col-12">
                <img class="img-fluid img-responsive" src="/homecoming/images/Mini500Banner2020.png">
            </div>
        </div>
    </div>
    <div class="container mb-3">

        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-0" style="text-align:center"><a href="mailto:rrchomecoming@gmail.com"><b>Sadie Zeigler</b></a></p>
                <p class="mb-0" style="text-align:center"><i>Reck Club Homecoming Chair</i></p>
                <p class="mb-0" style="text-align:center">rrchomecoming@gmail.com</p>
            </div>
<!--            <div class="col-4 text-center">-->
<!--                <p class="mb-0" style="text-align:center"><a href="mailto:rrcmini500@gmail.com"><b>Gal Ovadia</b></a>-->
<!--                </p>-->
<!--                <p class="mb-0" style="text-align:center"><i>Mini 500 Sub-Chair</i></p>-->
<!--                <p class="mb-0" style="text-align:center">rrcmini500@gmail.com</p>-->
<!--            </div>-->
<!--            <div class="col-4 text-center">-->
<!--                <p class="mb-0" style="text-align:center"><a href="mailto:rrcmini500@gmail.com"><b>Kaitlyn Park</b></a>-->
<!--                </p>-->
<!--                <p class="mb-0" style="text-align:center"><i>Mini 500 Sub-Chair</i></p>-->
<!--                <p class="mb-0" style="text-align:center">rrcmini500@gmail.com</p>-->
<!--            </div>-->
        </div>
        <hr class="mb-3">
    </div>
    <div class="container">
        <div class='blog-header'>
            <div class='col-12 d-none' style="text-align: center;">
                <h1>November 8th, 2024 at 5:00PM</h1>
            </div>
            <div class='row text-center d-none'>
                <!--        <div class='col-sm-4 col-xs-12 mb-3 mb-sm-0'>-->
                <!--            <a class='btn btn-md btn-secondary' href="#race-day-info">Race Day Info</a>-->
                <!--        </div>-->
                <!--        to go back to 3 buttons, change primary to secondary, change the 6 to 4 on the col-sm-6-->
                <div class='col-sm-4 col-xs-12 mb-3 mb-sm-0'>
                    <a class='btn btn-md btn-primary' href="#race-day-info">Event Information</a>
                </div>
                <div class='col-sm-4 col-xs-12 mb-3 mb-sm-6' style="text-align: center;">
                    <a class='btn btn-md btn-secondary' href="https://docs.google.com/forms/d/e/1FAIpQLSf0zaCPwgi3r77Ej0Mo5HU_7WSaqXv6dlEh4Pioy-yaPTkRHg/viewform">Sign up here!</a>
                </div>
                <div class='col-sm-4 col-xs-12 mb-3 mb-sm-0'>
                    <a class='btn btn-md btn-primary'
                        href="https://docs.google.com/document/d/1uAHWLy-fwvqne7czwceORQ8dd-rK8VeTybIrVDpEFso/edit?usp=sharing"
                        target="_blank">Event Rules</a>
                </div>
                <!--        <div class='col-sm-4 col-xs-12'>-->
                <!--            <a class='btn btn-md btn-secondary' href="/assets/A-Guide-to-Mini-500.pdf" target="_blank">Guide to Mini 500</a>-->
                <!--        </div>-->
            </div>
            <hr class="mb-3 d-none">
            <div class="container">
                <div class="row justify-content-center">
                    <div margin="col-4">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/VF45Fb0uPU4" frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                </div>
                <hr class="mb-3">
            </div>

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
                /*        [
                      "image" => '/homecoming/images/M59.jpg',
                       "title" => 'COVID Update',
                       "main" => 'In light of the COVID-19 situation, this year\'s Mini 500 has undergone some new changes to keep participants and spectators healthy. However, the spirit and fun of one of Georgia Tech’s most beloved traditions will be upheld!

               The event itself has been moved from Peters Parking Deck to the track around the Stamps Recreation Fields. This change will allow for entrance monitoring of participants and spectators. Every person entering the premises will have a standard temperature check and must be wearing a face covering.

               To limit the amount of teams racing at one time, only four teams will race at a time in a time trial fashion. Each team will start at opposing sides of the field and 4 racers from each team will compete. Racers will complete a half lap before sanitizing their trikes and passing it along to the next rider. Every team will compete two laps around the track!

               We are excited to be able to adapt the Mini 500 to keep everyone involved safe. If you are interested in competing in the Mini 500 this year please fill out the form here: <a href="https://forms.gle/LCZJM4VhE3tvF3Sh8">Mini 500 Form</a>. Stay safe and race on!

                  "image" => '/homecoming/images/M51.jpg',
                            "title" => 'Sign Ups',
                            "main" => Sign-Ups open on Friday, September 2nd. You can sign up <a href="https://gatech.universitytickets.com/w/event.aspx?id=1914&r=8a10173f13e34f03832cae5ad05a7802">here</a>.
                            Before registering, be sure you’re logged in, and then press “Get Tickets”. Scroll until you find Mini 500.
                            Only one team member needs to sign up and pay the registration fee of $10.
                '

                       ],*/
                [
                    "image" => '/homecoming/images/buzz_n_racer.jpg',
                    "title" => 'Sign Ups',
                    "main" => 'Please click <a href="https://docs.google.com/forms/d/e/1FAIpQLSf0zaCPwgi3r77Ej0Mo5HU_7WSaqXv6dlEh4Pioy-yaPTkRHg/viewform">here</a> to sign up!'
                ],
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
                                 make it through the race.
                        Common modifications are:
                        <li>Changing out the front tire to be a larger and more reinforced tire</li>
                        <li>Adding padding to the seat and handlebars for your arms to rest on</li>
                        <li>Adding a foot stopper to the back of the tricycle</li>"
                ],
            );

            foreach ($info1 as $item) {
                echo "<div class='row mb-3'>";
                echo "<div class='col-md-5 col-sm-12'><img class= \"img-fluid mb-3 mb-md-0\" src=\"" . $item["image"] . "\"/></div>";
                echo "<div class='col-md-7 col-sm-12'>";
                echo "<h4>" . $item["title"] . "</h4><p> " . $item["main"] . "</p></div>";
                echo "</div>";
            }
            ?>
        </div>
        <div class="container">

            <?php
            $info2 = array(
                [
                    "image" => '/homecoming/images/M54.jpg',
                    "title" => 'Check-In',
                    "main" => 'The Race will be around Peters Parking Deck with the Pits for each team lining the 
                            Peters Parking Deck side of Fowler Street and the start being at the corner of Fowler St. 
                            and Bobby Dodd Way. Each team will receive an email with their assigned pit number. 
                            The team will report to THEIR PIT between 4:30pm and 4:55PM and check in with their 
                            pit boss (A member of Ramblin Reck Club). Teams should arrive with their racers, pit crew, 
                            tricycles, and any approved tools required for wheel rotations. Mini 500 shirts will be 
                            provided at your assigned pit.'

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
                                then reattaching the front tire.'
                ]
            );

            echo "<br><div class= 'blog-header'>";
            echo "<div class='col-12' style=\"text-align: center;\">";
            echo "<h1 id='race-day-info'>Race Day Info</h1></div></div><br>";


            foreach ($info2 as $item) {
                echo "<div class='row mb-3'>";
                echo "<div class='col-md-5 col-sm-12'><img class= \"img-fluid mb-3 mb-md-0\" src=\"" . $item["image"] . "\"/></div>";
                echo "<div class='col-md-7 col-sm-12'>";
                echo "<h4>" . $item["title"] . "</h4><p> " . $item["main"] . "</p></div>";
                echo "</div>";
            }

            ?>
        </div>

        <?php include "sponsors.php"; ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="text-muted"><i>Have any questions? Reach out to us at <a
                                href="mailto:rrcmini500@gmail.com">rrcmini500@gmail.com</a> or <a
                                href="mailto:rrchomecoming@gmail.com">rrchomecoming@gmail.com</a>.</i></p>
                </div>
            </div>
        </div>

        <?php require "../partials/footer.php" ?>
        <?php require "../partials/scripts.php" ?>
</body>

</html>