<?php $pageTitle = "Freshman Cake Race"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>

<div class="container mb-3">
    <div class= 'blog-header'>
        <div class='col-12' style="text-align: center;">
            <h1>Freshman Cake Race</h1>
        </div>
    </div>
</div>

<div class="container mb-3">
    <div class="row">
        <div class="col-12">
            <img class="img-fluid img-responsive" src="/homecoming/images/CakeRaceBanner2021.png">
        </div>
    </div>
</div>
<div class="container mb-3">
    <div class="row">
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:rrchomecoming@gmail.com"><b>Bethany McMorris</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Reck Club Homecoming Chair</i></p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:rrccakerace@gmail.com"><b>Matthew Kistner</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Freshman Cake Race Sub-Chair</i></p>
        </div>
        <div class="col-4 text-center">
            <p class="mb-0" style="text-align:center"><a href="mailto:rrccakerace@gmail.com"><b>Tyler Gavaletz</b></a></p>
            <p class="mb-0" style="text-align:center"><i>Freshman Cake Race Sub-Chair</i></p>
        </div>
    </div>
    <hr class="mb-3">
</div>

<div class="container">
    <div class= 'blog-header'>
        <div class='col-12' style="text-align: center;">
            <h1>6:30 AM October 28th</h1>
        </div>
<!--    </div>-->

    <div class='row text-center'>
        <div class='col-sm-4 col-xs-12 mb-0 mb-sm-3'>
            <a class='btn btn-md btn-primary' href="#race-day-logistics">Event Information</a>
        </div>
<!--        sign up button-->
        <div class='col-sm-4 col-xs-12 mb-3 mb-sm-6' style="text-align: center;">
            <a class='btn btn-md btn-secondary' href="https://forms.gle/hrUzURL8h1V5mxdq8">Sign Up</a>
        </div>
        <div class='col-sm-4 col-xs-12 mb-sm-3'>
            <?php //If you change the name of the rules section further down, change the href here too. ?>
            <a class='btn btn-md btn-primary' href="#race-rules">Event Rules</a>
        </div>
        <div class='row text-center'>
<!--        <div class='col-sm-4 col-xs-12 mb-3 mb-sm-6' style="text-align: center;">-->
            <i>The Ramblin Reck Club’s sign-up form is for individual registrations. Organizations wishing to receive
             points must also sign up for this event using SCPC’s Homecoming waiver, found at <a href="https://gatech.universitytickets.com/w/event.aspx?id=1837&p=1">this link</a></i>
        </div>
    </div>
    <hr class="mb-3">

    <div class="container">
        <div class="row justify-content-center">
            <div margin="col-4">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/7ZbW9P1A7xY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        <hr class="mb-3">
    </div>

    <?php

    $info1 = array(
        [
            "image" => '/homecoming/images/fcr-001.jpg',
            "title" => 'The Tradition',
            "main" => 'The Freshman Cake Race is a half-mile race held before sunrise on the morning of the Homecoming game every year. This unique long-standing tradition is open to all <strong>first year</strong> Georgia Tech students. Each first year receives a cupcake at the end of the race. The male and female winners of the race receive a cake and are brought to the field during halftime of the Homecoming game where they are congratulated by the Ramblin’ Royalty. This race dates back to 1911, when the first Cake Race was held as an open cross-country run at Georgia Tech. Two years later, some of the faculty member’s wives started baking cakes for the winners, thus the name Cake Race was created. While the race’s original purpose was to scout men for the track team, today\'s participants are encouraged to run, jog, or walk. First years, sign up today to take part in one of Georgia Tech’s greatest traditions!'
        ],
 /*       [
            "image" => '/homecoming/images/fcr-003.jpg',
            "title" => 'COVID Update',
            "main" => 'Due to the current situation with COVID-19, Freshman Cake Race will look slightly different than previous years. But fear not! The spirit and fun of one of Georgia Tech’s oldest traditions will be kept intact. We have listed a few of the changes below that we have made to keep the event safe!  
                             <ul> <li>The race will be held on a day when there is no football game scheduled to accommodate a longer race time. The race will span 6 hours in order to run a larger amount of heats, with a maximum of 15 freshmen in each heat spaced 6 feet apart to begin the race</li>
                              <li>Each residence hall will be given a time block for its residents to come and race during any time within the block. Each freshman will undergo a temperature check upon arrival.</li><ul>'

        ],
        [
            "image" => '/homecoming/images/fcr-004.jpg',
            "main" => ' <ul> <li>All volunteers helping execute the event will be wearing proper PPE and will be screened before they begin working the event</li>
                              <li>Freshmen will be appropriately spaced 6 feet apart throughout the race staging and start</li>
                              <li>At the finish line, cupcakes and water bottles will be spaced multiple feet apart on tables. Volunteers wearing PPE will restock the cupcakes as they are taken by freshmen as they finish.</li>
                              <li>Freshmen will be encouraged to quickly take a photo with the Reck and then move through the finish area to discourage crowding.</li>
                              <li>The top three female and male racers will have a cake delivered to their residence hall!</li> </ul>
                              We are so excited to still get to put on this event and are taking every precaution we can to keep it safe and fun! If you have any questions or concerns please reach out to gtfreshmancakerace@gmail.com.
                              '

        ],*/
        [
            "image" => '/homecoming/images/fcr-002.jpg',
            "title" => 'Sign Ups',
            "main" => '2023 Freshman Cake Race Interest Form can be found here: 
                                    <a href="https://forms.gle/hrUzURL8h1V5mxdq8">Freshman Cake Race Sign-up</a> 
                                    <i>Note: filling out the interest form did not sign you up for the Freshman Cake Race. 
                                    You must still complete the official sign-up.</i>'

        ],
        [
            "image" => '/homecoming/images/fcr-005.jpg',
            "title" => 'Race Bib Pickup',
            "main" => 'If you are an on-campus resident in a first-year dorm, 
            your RA will distribute your bib to you one or two days before the race. 
            Otherwise, a member will be in touch with you a few days before the race with pick-up details. 
            Bibs WILL NOT be distributed on the morning of the race unless you email <a href="mailto:rrccakerace@gmail.com"><b>rrccakerace@gmail.com</b></a> with an accommodation request.'
        ]
    );

    foreach ($info1 as $item) {
        echo "<div class='row mb-3'>";
        echo "<div class='col-md-5 col-sm-12'><img class= \"img-fluid mb-3 mb-md-0\" src=\"" . $item["image"] . "\"/></div>";
        echo "<div class='col-md-7 col-sm-12'>";
        echo "<h4>". $item["title"] . "</h4> " . $item['main'] . "</div>";
        echo "</div>";
    }
    ?>
</div>
<div class="container">

    <?php
    $info2 = array(
               [
            "image" => '/homecoming/images/fcr-004.jpg',
            "title" => 'Clothing Recommendations',
            "main" => 'Be sure to wear tennis shoes/sneakers and clothes that you would be comfortable running 
                            or walking in. Remember, you are encouraged to run or walk at your own pace. 
                            Depending on the temperature, make sure to dress in clothes that will keep you warm 
                            (sweatshirt/jacket, pants, hats, gloves, etc). With this year’s cake race on Halloween weekend, we encourage all racers to wear a costume!'
        ],
        [
            "image" => '/homecoming/images/fcr-003.jpg',
            "title" => 'Race Rules',
            "main" => '<ul><li>Participants must start the race at the designated start line.</li>
<li>No pushing or shoving is allowed during the race.</li>
<li>Students must wear their race bib for the entirety of the race.</li> 
<li>Race bibs must be visible and worn outside of clothing and blankets.</li> 
<li>Any student that is intoxicated will <strong>not</strong> be allowed to race.</li> 
<li>Students are not allowed to litter the trash from cupcakes and cakes.</li> 
</ul><p><strong>Any violations of these rules will result in disqualification of the participant and that participant’s organization will not receive points towards Homecoming. The violator’s organization will not be allowed to participate in Homecoming the following year.</strong> Violators will be brought to the Office of Student Integrity.</p>
The full rule book can be found here: <a href="https://docs.google.com/document/d/1iWAjlXLN0hJ4s_TWiy6fEXVTar39WjkWMf89LXT8urM/edit?usp=sharing
">FCR 2023 Rule Book
</a> '
        ]
    );

    echo "<div class= 'blog-header'>";
    echo "<div class='col-12' style=\"text-align: center;\">";
    echo "<h1 id='race-day-logistics'>Race Day Logistics</h1></div></div><br>";


    foreach ($info2 as $item) {
        echo "<div class='row mb-3' id='" . str_ireplace(' ', '-', strtolower($item['title'])) ."'>";
        echo "<div class='col-md-5 col-sm-12'><img class= \"img-fluid mb-3 mb-md-0\" src=\"" . $item["image"] . "\"/></div>";
        echo "<div class='col-md-7 col-sm-12'>";
        echo "<h4>". $item["title"] . "</h4>";
        $lines = explode('\n', $item['main']);
        foreach ($lines as $line) {
            echo "<p> " . $line . "<p>";
        }
        echo "</div>";
        echo "</div>";
    }

    ?>
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <p class="text-muted"><i>Have any questions? Reach out to us at <a href="mailto:rrccakerace@gmail.com">rrccakerace@gmail.com</a> or <a href="mailto:rrchomecoming@gmail.com">rrchomecoming@gmail.com</a>.</i></p>
        </div>
    </div>
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>