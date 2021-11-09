<?php $pageTitle = "Roster"; ?>
<?php require "../utils/array_formatter.php"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>

<?php if (isset($_SESSION["memberID"]) && $_SESSION["status"] == "member"): ?>
    <div class="container" style="color: white">
        <h2 class="mb-3">2021 Roster</h2>
        <h4 class="mb-4">Executive Board</h4>
        <div class="row" style="color:white">
            <div class="col-md-6">
                <p><strong>Faculty Advisor:</strong> <a href="mailto:estephens34@gatech.edu">Jake Grant</a></p>
                <p><strong>Reck Driver:</strong> <a href="mailto:driver@reckclub.org">Jake Grant</a></p>
                <p><strong>President:</strong> <a href="mailto:president@reckclub.org">Jake Grant</a></p>
                <p><strong>Vice President:</strong> <a href="mailto:tgray43@gatech.edu">Jake Grant</a></p>
            </div>
            <div class="col-md-6">
                <p><strong>Treasurer:</strong> <a href="mailto:treasurer@reckclub.org">Jake "In White & Gold & Xoxi" Grant</a></p>
                <p><strong>Secretary:</strong> <a href="mailto:secretary@reckclub.org">Jake Grant</a></p>
                <p><strong>Member-at-Large:</strong> <a href="mailto:bthaler3@gatech.edu">Jake Grant</a></p>
                <p><strong>Member-at-Large:</strong> <a href="mailto:ewojack3@gatech.edu">Jake Grant</a></p>
            </div>
        </div>
        <hr class="mb-3">
        <h4 class="mb-3">Chairs</h4>

        <div class="row mb-3" style="color: white">
            <?php $chairs = array(
                [
                    "chair" => 'Alumni Relations',
                    "name" => 'Annie Robinson'
                ],
                [
                    "chair" => 'Baseball',
                    "name" => 'Kassie "the catcher" Lee'
                ],
                [
                    "chair" => 'Basketball',
                    "name" => 'Keshav Ramanathan'
                ],
                [
                    "chair" => 'Fundraising and Big Buzz',
                    "name" => 'Paul Weiland'
                ],
                [
                    "chair" => 'Campus Outreach',
                    "name" => 'Abby Ivemeyer'
                ],
                [
                    "chair" => 'Football',
                    "name" => 'Keshav Ramanathan'
                ],
                [
                    "chair" => 'CSON',
                    "name" => 'Adam "This is a chair?" Lederer'
                ],
                [
                    "chair" => 'Homecoming',
                    "name" => 'Anilyn Benge and Jack Crawford(?)'
                ],
                [
                    "chair" => 'Non-Revenue Sports',
                    "name" => 'Charlie Hammer'
                ],
                [
                    "chair" => 'Public Relations',
                    "name" => 'Haley McElroy'
                ],
                [
                    "chair" => 'Probate Guide',
                    "name" => 'Caroline Means'
                ],
                [
                    "chair" => 'WRECKruitment',
                    "name" => 'Whitney Miller'
                ],
                [
                    "chair" => 'T-Book',
                    "name" => 'Isheeta Mukherjee'
                ],
                [
                    "chair" => 'T-Night',
                    "name" => 'Big D Prusener'
                ],
                [
                    "chair" => 'Technology',
                    "name" => 'Dean PlASSkon'
                ],
                [
                    "chair" => 'Traditions',
                    "name" => 'Kadeh Lawson'
                ],
                [   "chair" => 'Diversity and Inclusion',
                    "name" => 'Noah Bryant'
                ]);
            uasort($chairs, function($a, $b) {
                return $a["chair"] > $b["chair"];
            });
            chunkAndFormatArray($chairs, 2, function ($chunk) {
                echo "<div class=\"col-md-6 text-center\">";
                foreach ($chunk as $item) {
                    echo "<p class='text-left'><strong>". $item["chair"] .":</strong> " . $item["name"] . "</p>";
                }
                echo "</div>";
            });

            ?>
        </div>
        <hr class="mb-3">
        <h4 class="mb-3">Members</h4>
        <div class="row mb-3">
            <?php
            $members = ['Abi Ivemeyer','Adam Lederer','Anilyn Benge','Annie Robinson', 'Austin Gies', 'Brandon Dobson','Brendan Mindiak', 'Brendon Thaler', 'Briana Sims', 'Cade Lawson','Caroline Means', 'Carter Kubes', 'Dean Plaskon', 'Derek Prusener', 'Emma Wojack', 'Ethan Rosman', 'Isheeta Mukherjee', 'Jacob Lewis', 'Jen O\'Brien','Kassie Lee', 'Katie Earles', 'Keshav Ramanathan','Paul Weiland', 'Ross LeRoy','Sofia Eidizadeh','Sydney Weisenburger', 'Taylor Gray', 'Zach Bellis'];
            sort($members);
            chunkAndFormatArray($members, 6, function ($chunk) {
                echo "<div class=\"col-md-2 text-center\">";
                foreach ($chunk as $item) {
                    echo "<p class='text-left'>" . $item . "</p>";
                }
                echo "</div>";
            });
            ?>
        </div>
        <hr class="mb-3">
        <h4 class="mb-3">Probates</h4>
        <div class="row mb-3">
            <?php
            $probates = ['Andreea Juravschi','Andrew McGraw','Andrew Norlin','Austin Reitano','Bethany McMorris','Charlie Hammer','Eleanor Froula','Erin Prusener','Evalyn Edwards',"Joey D'Adamio",'Jonathan Brooks','Jordan Lawson','Josh Fernandes','Josh Thrift','Kayvon Dibai','Kelsey Watkins','Madison Meyers','Matt Warrington','Melissa Braunstein','Reid Spencer','Sam Derry','Sarah Wiedetz','Shawn McKelvey','Sumayyah Ahmed ','Will Hancock' ];
            sort($probates);
            chunkAndFormatArray($probates,6, function ($chunk) {
                echo "<div class=\"col-md-2 text-center\">";
                foreach ($chunk as $item) {
                    echo "<p class='text-left'>" . $item . "</p>";
                }
                echo "</div>";
            });
            ?>
        </div>
        <hr class="mb-3">
    </div>
<?php else: ?>
    <div class="container">
        <h2 class="mb-3">2021 Roster</h2>
        <h4 class="mb-4">Executive Board</h4>
        <div class="row">
            <div class="col-md-6">
                <p><strong>Faculty Advisor:</strong> <a href="mailto:estephens34@gatech.edu">Gerome Stephens</a></p>
                <p><strong>Reck Driver:</strong> <a href="mailto:driver@reckclub.org">Ethan Rosman</a></p>
                <p><strong>President:</strong> <a href="mailto:president@reckclub.org">Jen O'Brien</a></p>
                <p><strong>Vice President:</strong> <a href="mailto:tgray43@gatech.edu">Taylor Gray</a></p>
            </div>
            <div class="col-md-6">
                <p><strong>Treasurer:</strong> <a href="mailto:treasurer@reckclub.org">Grace Mallon</a></p>
                <p><strong>Secretary:</strong> <a href="mailto:secretary@reckclub.org">Austin Gies</a></p>
                <p><strong>Member-at-Large:</strong> <a href="mailto:bthaler3@gatech.edu">Brendon Thaler</a></p>
                <p><strong>Member-at-Large:</strong> <a href="mailto:ewojack3@gatech.edu">Emma Wojack</a></p>
            </div>
        </div>
        <hr class="mb-3">
        <h4 class="mb-3">Chairs</h4>

        <div class="row mb-3">
            <?php $chairs = array(
                [
                    "chair" => 'Alumni Relations',
                    "name" => 'Annie Robinson'
                ],
                [
                    "chair" => 'Baseball',
                    "name" => 'Kassie Lee'
                ],
                [
                    "chair" => 'Basketball',
                    "name" => 'Keshav Ramanathan'
                ],
                [
                    "chair" => 'Fundraising and Big Buzz',
                    "name" => 'Paul Weiland'
                ],
                [
                    "chair" => 'Campus Outreach',
                    "name" => 'Abi Ivemeyer'
                ],
                [
                    "chair" => 'Football',
                    "name" => 'Keshav Ramanathan'
                ],
                [
                    "chair" => 'CSON',
                    "name" => 'Adam Lederer'
                ],
                [
                    "chair" => 'Homecoming',
                    "name" => 'Anilyn Benge and Jack Crawford'
                ],
                [
                    "chair" => 'Non-Revenue Sports',
                    "name" => 'Charlie Hammer'
                ],
                [
                    "chair" => 'Public Relations',
                    "name" => 'Melissa Braunstein and Sarah Wieditz'
                ],
                [
                    "chair" => 'Probate Guide',
                    "name" => 'Caroline Means'
                ],
                [
                    "chair" => 'RECKruitment',
                    "name" => 'Whitney Miller'
                ],
                [
                    "chair" => 'T-Book',
                    "name" => 'Isheeta Mukherjee'
                ],
                [
                    "chair" => 'T-Night',
                    "name" => 'Derek Prusener'
                ],
                [
                    "chair" => 'Technology',
                    "name" => 'Dean Plaskon'
                ],
                [
                    "chair" => 'Traditions',
                    "name" => 'Cade Lawson'
                ],
                [   "chair" => 'Diversity and Inclusion',
                    "name" => 'Andrew McGraw and Kayvon Dibai'
                ]);
            uasort($chairs, function($a, $b) {
                return $a["chair"] > $b["chair"];
            });
            chunkAndFormatArray($chairs, 2, function ($chunk) {
                echo "<div class=\"col-md-6 text-center\">";
                foreach ($chunk as $item) {
                    echo "<p class='text-left'><strong>". $item["chair"] .":</strong> " . $item["name"] . "</p>";
                }
                echo "</div>";
            });

            ?>
        </div>
        <hr class="mb-3">
        <h4 class="mb-3">Members</h4>
        <div class="row mb-3">
            <?php
            $members = ['Abi Ivemeyer','Adam Lederer','Anilyn Benge','Annie Robinson', 'Austin Gies', 'Brandon Dobson','Brendan Mindiak', 'Brendon Thaler', 'Briana Sims', 'Cade Lawson','Caroline Means', 'Carter Kubes', 'Dean Plaskon', 'Derek Prusener', 'Emma Wojack', 'Ethan Rosman', 'Grace Mallon', 'Isheeta Mukherjee', 'Jacob Lewis', 'Jen O\'Brien','Kassie Lee', 'Katie Earles', 'Keshav Ramanathan','Paul Weiland', 'Ross LeRoy','Sofia Eidizadeh','Sydney Weisenburger', 'Taylor Gray', 'Zach Bellis'];
            sort($members);
            chunkAndFormatArray($members, 6, function ($chunk) {
                echo "<div class=\"col-md-2 text-center\">";
                foreach ($chunk as $item) {
                    echo "<p class='text-left'>" . $item . "</p>";
                }
                echo "</div>";
            });
            ?>
        </div>
        <hr class="mb-3">
        <h4 class="mb-3">Probates</h4>
        <div class="row mb-3">
            <?php
            $probates = ['Andreea Juravschi','Andrew McGraw','Andrew Norlin','Austin Reitano','Bethany McMorris','Charlie Hammer','Eleanor Froula','Erin Prusener','Evalyn Edwards',"Joey D'Adamio",'Jonathan Brooks','Jordan Lawson','Josh Fernandes','Josh Thrift','Kayvon Dibai','Kelsey Watkins','Madison Meyers','Matt Warrington','Melissa Braunstein','Reid Spencer','Sam Derry','Sarah Wiedetz','Shawn McKelvey','Sumayyah Ahmed ','Will Hancock' ];
            sort($probates);
            chunkAndFormatArray($probates,6, function ($chunk) {
                echo "<div class=\"col-md-2 text-center\">";
                foreach ($chunk as $item) {
                    echo "<p class='text-left'>" . $item . "</p>";
                }
                echo "</div>";
            });
            ?>
        </div>
        <hr class="mb-3">
    </div>
<?php endif; ?>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>
