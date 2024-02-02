<?php $pageTitle = "Reck Drivers"; ?>
<?php require "../utils/array_formatter.php"; ?>

<!DOCTYPE html>
<html>
<?php require "../partials/head.php" ?>

<body>
<?php require "../partials/public-header.php" ?>
<div class="container">
    <h2 class="mb-3">Drivers</h2>
    <hr class="mb-3">

<img class="img-responsive mb-3" width="100%" src="/img/2024/driverwide.jpeg">
<p>Each year, one student is chosen from the ranks of the club to be the sole driver and primary caretaker of the Ramblin’ Reck. They are the only person with keys to the car, and the only person allowed to drive or transport the Reck. They know the ins and outs of the car better than the back of their hand and spends countless hours every week not only making sure that the car is running in tip-top shape, but also scheduling appearances, meeting with alumni and administration, and working on other projects in the best interest of the Reck. Despite the hard work, the job is perhaps the most meaningful and fulfilling on campus, and an unforgettable experience for every driver.</p>

<h4 class="mb-3">The History of Drivers</h4>
        <hr class="mb-3">
<p class="text-muted">Since 1968, drivers have been selected by the Ramblin' Reck Club.</p>
<div class="row">
    <?php
    $drivers = [

        [
            "year" => "2024",
            "name" => "Matthew Kistner"
        ],
        [
            "year" => "2023",
            "name" => "Omar Khan"
        ],
        [
            "year" => "2022",
            "name" => "Evalyn Edwards"
        ],
        [
            "year" => "2021",
            "name" => "Ethan Rosman"
        ],
        [
            "year" => "2020",
            "name" => "Abi Ivemeyer"
        ],
        [
            "year" =>"2019",
            "name" =>"Ben Damus"
        ],
        [
            "year" =>"2018",
            "name" =>"Hannah Todd"
        ],
        [
            "year" =>"2017",
            "name" =>"Chris Healy",
        ],
        [
            "year" =>"2016",
            "name" =>"Mitch Brown"
        ],
        [
            "year" =>"2015",
            "name" =>"Hillary Degenkolb"
        ],
        [
            "year" =>"2015",
            "name" =>"Jake Meisner"
        ],
        [
            "year" =>"2014",
            "name" =>"Raj Desai"
        ],
        [
            "year" =>"2013",
            "name" =>"Barrett Ahlers"
        ],
        [
            "year" =>"2012",
            "name" =>"Stephen Webber"
        ],
        [
            "year" =>"2011",
            "name" =>"Mike Macmillan"
        ],
        [
            "year" =>"2010",
            "name" =>"Austin Berry"
        ],
        [
            "year" =>"2009",
            "name" =>"Winfield Tufts"
        ],
        [
            "year" =>"2008",
            "name" =>"Brandon Kearse"
        ],
        [
            "year" =>"2007",
            "name" =>"John Bird",
        ],
        [
            "year" =>"2006",
            "name" =>"Bryan Popka"
        ],
        [
            "year" =>"2005",
            "name" =>"Ryan McFerrin"
        ],
        [
            "year" =>"2004",
            "name" =>"Dustin Bergman"
        ],
        [
            "year" =>"2003",
            "name" =>"Justin Barnes"
        ],
        [
            "year" =>"2002",
            "name" =>"Brian T. Waits"
        ],
        [
            "year" =>"2001",
            "name" =>"Andy McNeil"
        ],
        [
            "year" =>"2000",
            "name" =>"Joseph Nilsestuen"
        ],
        [
            "year" =>"2000",
            "name" =>"Patrick Edwards"
        ],
        [
            "year" =>"1999",
            "name" =>"Joseph Nilsestuen"
        ],
        [
            "year" =>"1998",
            "name" =>"Michael M. Eckert"
        ],
        [
            "year" =>"1997",
            "name" =>"Patrick Edwards"
        ],
        [
            "year" =>"1996",
            "name" =>"Patrick Edwards"
        ],
        [
            "year" =>"1995",
            "name" =>"Brad Sand"
        ],
        [
            "year" =>"1994",
            "name" =>"Philip H. Burrus, 4th"
        ],
        [
            "year" =>"1993",
            "name" =>"Thomas Penny"
        ],
        [
            "year" =>"1992",
            "name" =>"Thomas Priest"
        ],
        [
            "year" =>"1991",
            "name" =>"Jeffrey Waller"
        ],
        [
            "year" =>"1990",
            "name" =>"Phillip Kelley"
        ],
        [
            "year" =>"1989",
            "name" =>"Phillip Kelley"
        ],
        [
            "year" =>"1988",
            "name" =>"Steven Powell"
        ],
        [
            "year" =>"1988",
            "name" =>"Evelyn Dale Morgan"
        ],
        [
            "year" =>"1987",
            "name" =>"Richard Coblens",
        ],
        [
            "year" =>"1986",
            "name" =>"Barry Whitton"
        ],
        [
            "year" =>"1985",
            "name" =>"Todd Kelso"
        ],
        [
            "year" =>"1984",
            "name" =>"Lisa Volmar"
        ],
        [
            "year" =>"1984",
            "name" =>"Bruce Wheeler"
        ],
        [
            "year" =>"1983",
            "name" =>"Darryl Dykes"
        ],
        [
            "year" =>"1982",
            "name" =>"Christopher \"Kit\" Baker"
        ],
        [
            "year" =>"1981",
            "name" =>"John Hodges"
        ],
        [
            "year" =>"1980",
            "name" =>"Wesley Combs"
        ],
        [
            "year" =>"1979",
            "name" =>"Bruce Wittschiebe"
        ],
        [
            "year" =>"1978",
            "name" =>"L. Michael Lopez"
        ],
        [
            "year" =>"1977",
            "name" =>"W. Thomas Smith, Jr.",
        ],
        [
            "year" =>"1976",
            "name" =>"Kenneth Box"
        ],
        [
            "year" =>"1975",
            "name" =>"Kenneth Box"
        ],
        [
            "year" =>"1974",
            "name" =>"W. Scott Innes"
        ],
        [
            "year" =>"1973",
            "name" =>"M. Russell Smith"
        ],
        [
            "year" =>"1972",
            "name" =>"Thomas Robertson"
        ],
        [
            "year" =>"1971",
            "name" =>"Steve Clark"
        ],
        [
            "year" =>"1970",
            "name" =>"Patrick Hurley"
        ],
        [
            "year" =>"1969",
            "name" =>"William Cherry"
        ],
        [
            "year" =>"1968",
            "name" =>"William Cherry"
        ]];

    chunkAndFormatArray($drivers, 6, function ($chunk) {
        echo '<div class="col-md-2">';
        foreach ($chunk as $item) {
            echo "<p><strong>". $item["year"] .":</strong> " . $item["name"] . "</p>";
        }
        echo '</div>';
    });
    ?>
</div>
<p class="text-muted">Between 1961 and 1967, drivers were selected by the Student Council (now Student Government Association).</p>
<div class="row">
    <?php
    $drivers = [
        [
            "year" =>"1967",
            "name" =>"Tom Feld"
        ],
        [
            "year" =>"1966",
            "name" =>"Tim O'Shea"
        ],
        [
            "year" =>"1965",
            "name" =>"John Ryan"
        ],
        [
            "year" =>"1965",
            "name" =>"Doug Chandler"
        ],
        [
            "year" =>"1964",
            "name" =>"Jack Painter"
        ],
        [
            "year" =>"1963",
            "name" =>"Jack Painter"
        ],
        [
            "year" =>"1963",
            "name" =>"Phil Gingrey"
        ],
        [
            "year" =>"1962",
            "name" =>"Henry Sawyer"
        ],
        [
            "year" =>"1961",
            "name" =>"Dekle Rountree"
        ],
        [
            "year" =>"1961",
            "name" =>"Donald Gentry"
        ]];

    chunkAndFormatArray($drivers, 4, function ($chunk) {
        echo '<div class="col-md-3">';
        foreach ($chunk as $item) {
            echo "<p><strong>". $item["year"] .":</strong> " . $item["name"] . "</p>";
        }
        echo '</div>';
    });
    ?>
</div>
<br>
    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-secondary">The Reck</strong>
                    <h3 class="mb-1 text-dark">The Tradition</h3>
                    <p class="card-text mb-auto">The Reck is an iconic mascot of Georgia Tech; An interesting start and a rich history make it one of the most beloved and unique mascots in the country!</p>
                    <a href="/reck/">Read more</a>
                </div>
                <img class="card-img-right img-fluid flex-auto d-none d-md-block" src="/img/2023/ReckGarageDark.jpg" style="width: 200px; height: 250px;">
            </div>
        </div>
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-secondary">The Reck</strong>
                    <h3 class="mb-1 text-dark">History</h3>
                    <p class="card-text mb-auto">The Reck was formally introduced as Georgia Tech's mascot when it led the football team out on to Grant Field for the 1961 homecoming game...</p>
                    <a href="/reckhistory">Continue reading</a>
                </div>
                <img class="card-img-right img-fluid flex-auto d-none d-md-block" src="/img/promo/1961-reck-debut.jpg" style="width: 200px; height: 250px;">
            </div>
        </div>
    </div>
</div>
<?php require "../partials/footer.php" ?>
<?php require "../partials/scripts.php" ?>
</body>

</html>