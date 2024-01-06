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
                "name" => 'Aggie Fowler'
            ],
            [
                "chair" => 'Baseball',
                "name" => 'Michael DuBose'
            ],
            [
                "chair" => 'Basketball',
                "name" => 'Austin Gies'
            ],
            [
                "chair" => 'Big Buzz',
                "name" => 'Joey D\'Adamio'
            ],
            [
                "chair" => 'Campus Outreach',
                "name" => 'Sam Auborn'
            ],
            [
                "chair" => 'Fundraising',
                "name" => 'Matthew Kistner'
            ],
            [
                "chair" => 'Football',
                "name" => 'Susannah Gordon'
            ],
            [
                "chair" => 'Homecoming',
                "name" => 'Bethany McMorris'
            ],
            [
                "chair" => 'Non-Revenue Sports',
                "name" => 'Connor White'
            ],
            [
                "chair" => 'Public Relations',
                "name" => 'Nisha Rockwell'
            ],
            [
                "chair" => 'Probate Guides',
                "name" => 'Eleanor Froula and Jordan Lawson'
            ],
            [
                "chair" => 'RECKruitment',
                "name" => 'Eleanor Froula'
            ],
            [
                "chair" => 'T-Book',
                "name" => 'Matthew Aronin'
            ],
            [
                "chair" => 'T-Night',
                "name" => 'Suraya John'
            ],
            [
                "chair" => 'Technology',
                "name" => 'Tirth Patel'
            ],
            [
                "chair" => 'Traditions',
                "name" => 'Reid Spencer'
            ],
            [   "chair" => 'Diversity and Inclusion',
                "name" => 'Rohan Raman'
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
                echo "<p class='text-left'><strong>". $item["chair"] .":</strong> " . $item["name"] . "</p>";
            }
            echo "</div>";
        });

        ?>
    </div>

    <h4 class="mb-3">Members</h4>
    <hr class="mb-3">
    <div class="row mb-3">
    <?php
  $members = ['Abby Hart', 'Aastha Singh', 'Abby Upton', 'Aditya Prabhakar', 'Agatha Fowler', 'Ainsley Ronco', 'Ajay Mathur', 'Allie Abbott', 'Arnav Mardia', 'Austin Gies', 'Austin Reitano', 'Bethany McMorris', 'Carolyn Braun', 'Connor White', 'Eleanor Froula', 'Erin Prusener', 'Evalyn Edwards', 'Evan Sunny', 'Gal Ovadia', 'Hiba Kunwer', 'Joey D\'Adamio', 'Jonathan Brooks', 'Jordan Lawson', 'Kate Schutz', 'Kyle Ralyea', 'Lily Adlesick', 'Madison Meyers', 'Matthew Aronin', 'Matthew Kistner', 'Melissa Braunstein', 'Michael DuBose', 'Miller Daly', 'Miriam Guthrie', 'Mya Moffitt', 'Nathan Dailey', 'Nick Unger', 'Nina Phelan', 'Nisha Rockwell', 'Omar Khan', 'Reid Spencer', 'Rohan Raman', 'Sadie Zeigler', 'Samuel Auborn', 'Simran Patel', 'Sofia Varmeziar', 'Suraya John', 'Susannah Gordon',  'Tirth Patel', 'Trey Dobson','Tyler Gavaletz', 'Zack Mohr'];
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
