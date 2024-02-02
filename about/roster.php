<?php $pageTitle = "Roster"; ?>
<?php require "../utils/array_formatter.php"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>
<div class="container">


    <h4 class="mb-3">Executive Board</h4>
    <hr class="mb-3">
    <div class="row">
        <div class="col-md-6">

            <p><strong>Faculty Advisor:</strong> <a href="mailto:kristina.clement@studentlife.gatech.edu">Dr. Kristina Clement</a></p>
            <p><strong>Reck Driver:</strong> <a href="mailto:driver@reckclub.org">Matthew Kistner</a></p>
            <p><strong>President:</strong> <a href="mailto:president@reckclub.org">Simran Patel</a></p>
            <p><strong>Vice President:</strong> <a href="mailto:vp@reckclub.org">Matthew Aronin</a></p>
        </div>
        <div class="col-md-6">
            <p><strong>Treasurer:</strong> <a href="mailto:treasurer@reckclub.org">Connor White</a></p>
            <p><strong>Secretary:</strong> <a href="mailto:secretary@reckclub.org">Arnav Mardia</a></p>
            <p><strong>Member-at-Large:</strong> <a href="mailto:kralyea@gatech.edu">Kyle Ralyea</a></p>
            <p><strong>Member-at-Large:</strong> <a href="mailto:mmoffitt6@gatech.edu">Mya Moffitt</a></p>
        </div>
    </div>

    <br>
    <h4 class="mb-3">Chairs</h4>
    <hr class="mb-3">

    <div class="row mb-3">
        <?php $chairs = array(
            [
                "chair" => 'Alumni Relations',
                "name" => 'Sam Auborn',
                "email" => 'alumnirelations@reckclub.org'
            ],
            [
                "chair" => 'Baseball',
                "name" => 'Abby Upton',
                "email" => 'rrcbaseball@gmail.com'
            ],
            [
                "chair" => 'Basketball',
                "name" => 'Austin Gies',
                "email" => 'rrcbasketballchair@gmail.com'
            ],
            [
                "chair" => 'Big Buzz',
                "name" => 'Miller Daly',
                "email" => 'rrcbigbuzz@gmail.com'
            ],
            [
                "chair" => 'Campus Outreach',
                "name" => 'Allie Abbott',
                "email" => 'rrccampusoutreach@gmail.com'
            ],
            [
                "chair" => 'Fundraising',
                "name" => 'Nathan Dailey',
                "email" => 'rrcfundraisingchair@gmail.com'
            ],
            [
                "chair" => 'Football',
                "name" => 'Nicholas Unger',
                "email" => 'rrcfootball@gmail.com'
            ],
            [
                "chair" => 'Homecoming',
                "name" => 'Tirth Patel',
                "email" => 'rrchomecoming@gmail.com'
            ],
            [
                "chair" => 'Olympic Sports',
                "name" => 'Abby Hart',
                "email" => 'rrcolympicsports@gmail.com'
            ],
            [
                "chair" => 'Public Relations',
                "name" => 'Carolyn Braun',
                "email" => 'rrcpublicrelations@gmail.com'
            ],
            [
                "chair" => 'Probate Guides',
                "name" => 'Susannah Gordon and Rohan Raman',
                "email" => ''
            ],
            [
                "chair" => 'Recruitment',
                "name" => 'Eleanor Froula',
                "email" => 'membershipchair@reckclub.org'
            ],
            [
                "chair" => 'T-Book',
                "name" => 'Zachary Mohr',
                "email" => 'rrctbook@gmail.com'
            ],
            [
                "chair" => 'T-Night',
                "name" => 'Sadie Zeigler',
                "email" => 'rctnight@gmail.com'
            ],
            [
                "chair" => 'Technology',
                "name" => 'Gal Ovadia',
                "email" => 'rrctechnologychair@gmail.com'
            ],
            [
                "chair" => 'History and Traditions',
                "name" => 'Nina Phelan',
                "email" => 'rrctraditions@gmail.com'
            ],
            [   "chair" => 'Diversity and Inclusion',
                "name" => 'Aditya Prabhakar and Evan Sunny',
                "email" => ''
             ]);
        uasort($chairs, function($a, $b) {
            if ($a["chair"] > $b["chair"]) {
                return 1;
            } elseif ($a["chair"] < $b["chair"]){
                return -1;
            } else {
                return 0;
            }
        });
        chunkAndFormatArray($chairs, 2, function ($chunk) {
            echo "<div class=\"col-md-6 text-center\">";
            foreach ($chunk as $item) {
                if ($item["chair"] == 'Diversity and Inclusion') {
                    echo "<p class='text-left'><strong>". $item["chair"] .":</strong> <a href='mailto:aprabhakar32@gatech.edu'>Aditya Prabhakar</a> and <a href='mailto:esunny7@gatech.edu'>Evan Sunny</a>";
                } elseif  ($item["chair"] == 'Probate Guides') {
                    echo "<p class='text-left'><strong>". $item["chair"] .":</strong> <a href='mailto:sggordon77@gmail.com'>Susannah Gordon</a> and <a href='mailto:roraman199@gmail.com'>Rohan Raman</a>";
                } elseif ($item["email"] == '') {
                    echo "<p class='text-left'><strong>". $item["chair"] .":</strong> " . $item["name"] . "</p>";
                } else {
                    echo "<p class='text-left'><strong>". $item["chair"] .":</strong> <a href=\"mailto:". $item["email"] . "\">". $item["name"] ."</a>";
                }
            }
            echo "</div>";
        });

        ?>
    </div>

    <h4 class="mb-3">Members</h4>
    <hr class="mb-3">
    <div class="row mb-3">
    <?php
  $members = ['Abby Hart', 'Aastha Singh', 'Abby Upton', 'Aditya Prabhakar', 'Ainsley Ronco', 'Ajay Mathur', 'Allie Abbott', 'Arnav Mardia', 'Austin Gies', 'Austin Reitano', 'Bethany McMorris', 'Carolyn Braun', 'Connor White', 'Eleanor Froula', 'Erin Prusener', 'Evalyn Edwards', 'Evan Sunny', 'Gal Ovadia', 'Hiba Kunwer', 'Joey D\'Adamio', 'Jonathan Brooks', 'Jordan Lawson', 'Kate Schutz', 'Kyle Ralyea', 'Lily Adlesick', 'Madison Meyers', 'Matthew Aronin', 'Matthew Kistner', 'Melissa Braunstein', 'Michael DuBose', 'Miller Daly', 'Miriam Guthrie', 'Mya Moffitt', 'Nathan Dailey', 'Nick Unger', 'Nina Phelan', 'Nisha Rockwell', 'Omar Khan', 'Rohan Raman', 'Sadie Zeigler', 'Samuel Auborn', 'Simran Patel', 'Sofia Varmeziar', 'Suraya John', 'Susannah Gordon',  'Tirth Patel', 'Trey Dobson','Tyler Gavaletz', 'Zack Mohr', 'Nick Isaf'];
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
<!--
    <h4 class="mb-3">Probates</h4>
    <hr class="mb-3">
    <div class="row mb-3">
        <?php
        $probates = [     "add probates here"    ];
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
    -->
    <hr class="mb-3">
</div>

<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>
