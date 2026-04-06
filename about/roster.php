<?php $pageTitle = "Roster"; ?>
<?php require "../utils/array_formatter.php"; ?>
<?php require "../database_connect.php" ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>
<div class="container">


    <h4 class="mb-3">2026 Executive Board</h4>
    <hr class="mb-3">
    <div class="row">
        <div class="col-md-6">

            <p><strong>Faculty Advisor:</strong> <a href="mailto:kristina.clement@studentlife.gatech.edu">Dr. Kristina Clement</a></p>
            <p><strong>Reck Driver:</strong> <a href="mailto:driver@reckclub.org">Sof Zambrano Molina</a></p>
            <p><strong>President:</strong> <a href="mailto:president@reckclub.org">Bodan Pittman</a></p>
            <p><strong>Vice President:</strong> <a href="mailto:vp@reckclub.org">Daniel Wood</a></p>
        </div>
        <div class="col-md-6">
            <p><strong>Treasurer:</strong> <a href="mailto:treasurer@reckclub.org">Rush Maples</a></p>
            <p><strong>Secretary:</strong> <a href="mailto:secretary@reckclub.org">Kaylie Afshani</a></p>
            <p><strong>Member-at-Large:</strong> Omkar Tamhane</p>
            <p><strong>Member-at-Large:</strong> Caelyn Grimes</p>
        </div>
    </div>

    <br>
    <h4 class="mb-3">2026 Chairs</h4>
    <hr class="mb-3">

    <div class="row mb-3">
        <?php $chairs = array(
            [
                "chair" => 'Alumni Relations',
                "name" => 'Ajay Dakoriya',
                "email" => 'alumnirelations@reckclub.org'
            ],
            [
                "chair" => 'Baseball',
                "name" => 'Austin Barret',
                "email" => 'rrcbaseball@gmail.com'
            ],
            [
                "chair" => 'Basketball',
                "name" => 'Daniel Wood',
                "email" => 'rrcbasketballchair@gmail.com'
            ],
            [
                "chair" => 'Big Buzz',
                "name" => 'Holland Feeney',
                "email" => 'rrcbigbuzz@gmail.com'
            ],
            [
                "chair" => 'Campus Outreach',
                "name" => 'Divya Basu',
                "email" => 'rrccampusoutreach@gmail.com'
            ],
            [
                "chair" => 'Fundraising',
                "name" => 'Keneh Nwizubo',
                "email" => 'rrcfundraisingchair@gmail.com'
            ],
            [
                "chair" => 'Football',
                "name" => 'Stephen Harvey',
                "email" => 'rrcfootball@gmail.com'
            ],
            [
                "chair" => 'Homecoming',
                "name" => 'Sophia Umaña',
                "email" => 'rrchomecoming@gmail.com'
            ],
            [
                "chair" => 'Olympic Sports',
                "name" => 'Syaam Khandaker',
                "email" => 'rrcolympicsports@gmail.com'
            ],
            [
                "chair" => 'Public Relations',
                "name" => 'Rostan Baisch',
                "email" => 'rrcpublicrelations@gmail.com'
            ],
            [
                "chair" => 'Probate Guides',
                "name" => 'Harrison Burnside & Katie Park',
                "email" => ''
            ],
            [
                "chair" => 'Recruitment',
                "name" => 'Kyle Ralyea and Ria Nayar',
                "email" => 'membershipchair@reckclub.org'
            ],
            [
                "chair" => 'T-Book',
                "name" => 'Holland Feeney',
                "email" => 'rrctbook@gmail.com'
            ],
            [
                "chair" => 'T-Night',
                "name" => 'Kaeyshia Kesh',
                "email" => 'rrctnight@gmail.com'
            ],
            [
                "chair" => 'Technology',
                "name" => 'Stephen Harvey',
                "email" => 'rrctechnologychair@gmail.com'
            ],
            [
                "chair" => 'History and Traditions',
                "name" => 'Katie Larson',
                "email" => 'rrctraditions@gmail.com'
            ],
            [
                "chair" => 'Spirit',
                "name" => 'Meredith Gaines',
                "email" => ''
            ],
            [   "chair" => 'Diversity and Inclusion',
                "name" => 'Peter Anzideo',
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
                if ($item["email"] == '') {
                    echo "<p class='text-left'><strong>". $item["chair"] .":</strong> " . $item["name"] . "</p>";
                } else {
                    echo "<p class='text-left'><strong>". $item["chair"] .":</strong> <a href=\"mailto:". $item["email"] . "\">". $item["name"] ."</a>";
                }
            }
            echo "</div>";
        });

        ?>
    </div>

    <h4 class="mb-3">2025 Members</h4>
    <hr class="mb-3">
    <div class="row mb-3">
    <?php
    // SQL query to get first and last names where status is "member" or "social"
    $query = $db->prepare("
        SELECT CONCAT(firstName, ' ', lastName) AS fullName 
        FROM Member 
        WHERE status IN ('member', 'social') 
        ORDER BY firstName
    ");
    $query->execute();

    // Fetch all results as a simple indexed array
    $members = $query->fetchAll(PDO::FETCH_COLUMN);

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
