<?php $pageTitle = "Spreading Joy Since 1930"; ?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php" ?>

<body>
<?php require "partials/public-header.php" ?>

<?php if (isset($_SESSION["memberID"]) && $_SESSION["status"] == "member"): ?>
    <div class="mb-3">
        <div id="img-carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#img-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#img-carousel" data-slide-to="1"></li>
                <li data-target="#img-carousel" data-slide-to="2"></li>
                <li data-target="#img-carousel" data-slide-to="3"></li>

            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="img-responsive d-block w-100" src="img/2021/wreck.jpeg" alt="2021 T-night picture">
                    <div class="gradient">
                    </div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Welcome to the online home of the Ramblin' Wreck Club!</h5>
                        <p>Since its founding in 1930, the Ramblin’ Wreck Club has been an organization of students, committed to the education and promotion of Tech spirit, history and tradition. Learn more about us <a href="/about/index.php">here</a>!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="img-responsive d-block w-100" src="/img/2021/exposed.png" alt="2021 Mercedes-Benz game ride-out">
                    <div class="gradient">
                    </div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Interested in the Wreck?</h5>
                        <p>While many people believe that there are multiple Recks serving as Georgia Tech’s mascot, in actuality there is only one official Ramblin’ Wreck which has led the football team and served as a symbol of the institute since 1961. Learn more about the car <a href="/reckhistory">here</a>!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="img-responsive d-block w-100" src="/img/2021/vibbes.png" alt="2017 Reck at Clough turnaround for Ride Out in Style">
                    <div class="gradient">
                    </div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Want the Reck at your event?</h5>
                        <p>When not on official duty, the Ramblin’ Wreck may appear at various alumni functions. Proceeds are used to support the maintenance and upkeep of the car. Click <a href="/requests.php">here</a> to make your request!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="img-responsive d-block w-100" src="/img/2021/redacted.jpg" alt="2021 Alma mater on the Mercedes Benz field">
                    <div class="gradient">
                    </div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Want to join the team?</h5>
                        <p>Wrecruitment happens every Spring, find out more information about the process <a href="/reckruitment/index.php">here!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="background: #BA0C2F !important;">
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250" style="background:#00A3AD !important;">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-primary">The Wreck</strong>
                        <h3 class="mb-1 text-dark">Drivers</h3>
                        <p class="card-text mb-auto">Each year some unlucky fool is forced to drive the car around and the whole club prays they don't end up on barstool</p>
                        <a href="/reck/drivers.php">Read more</a>
                    </div>
                    <img class="card-img-right img-fluid flex-auto d-none d-md-block" data-src="/img/2021/rosman_gone.jpeg" style="width: 200px; height: 250px;" src="/img/2021/rosman_gone.jpeg" data-holder-rendered="true">
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start" style="background:#00A3AD !important;">
                        <strong class="d-inline-block mb-2 text-secondary">Traditions</strong>
                        <h3 class="mb-1 text-dark">The T-Book</h3>
                        <p class="card-text mb-auto">The Georgia Tech book that's been around for a while, makes a great monitor stand...</p>
                        <a href="/about/t-book.php">Continue reading</a>
                    </div>
                    <img class="card-img-right img-fluid flex-auto d-none d-md-block" src="/img/promo/mantle-tbook.jpg" style="width: 200px !important; height: 250px;" data-holder-rendered="true">
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250" style="background:#00A3AD !important;">
                    <img class="card-img-left img-fluid flex-auto d-none d-md-block" src="/img/promo/1961-reck-debut.jpg" style="width: 200px !important; height: 250px;" data-holder-rendered="true">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-secondary">History</strong>
                        <h3 class="mb-1 text-dark">The Wreck</h3>
                        <p class="card-text mb-auto">The Wreck(soon to be electric) was donated by a notable UGA graduate and is a sign of friendship between our schools...</p>
                        <a href="/reckhistory">Continue reading</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250" style="background:#00A3AD !important;">
                    <img class="card-img-left img-fluid flex-auto d-none d-md-block" src="/img/2021/cade.jpg" style="width: 200px !important; height: 250px;" data-holder-rendered="true">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-primary">WRECKruitment</strong>
                        <h3 class="mb-1 text-dark">Want to join the tradition?</h3>
                        <p class="card-text mb-auto">Learn more about what it is to be a part of Wreck Club and get bullied by members, RPC is a bonus!</p>
                        <a href="/reckruitment">Read more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="mb-3">
        <div id="img-carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#img-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#img-carousel" data-slide-to="1"></li>
                <li data-target="#img-carousel" data-slide-to="2"></li>
                <li data-target="#img-carousel" data-slide-to="3"></li>

            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="img-responsive d-block w-100" src="img/2021/club_before_game.jpg" alt="2021 T-night picture">
                    <div class="gradient">
                    </div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Welcome to the online home of the Ramblin' Reck Club!</h5>
                        <p>Since its founding in 1930, the Ramblin’ Reck Club has been an organization of students, committed to the education and promotion of Tech spirit, history and tradition. Learn more about us <a href="/about/index.php">here</a>!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="img-responsive d-block w-100" src="/img/2021/merc_ride_out.jpg" alt="2021 Mercedes-Benz game ride-out">
                    <div class="gradient">
                    </div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Interested in the Reck?</h5>
                        <p>While many people believe that there are multiple Recks serving as Georgia Tech’s mascot, in actuality there is only one official Ramblin’ Reck which has led the football team and served as a symbol of the institute since 1961. Learn more about the car <a href="/reckhistory">here</a>!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="img-responsive d-block w-100" src="/img/promo/2013-wreck-parade.jpg" alt="2017 Reck at Clough turnaround for Ride Out in Style">
                    <div class="gradient">
                    </div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Want the Reck at your event?</h5>
                        <p>When not on official duty, the Ramblin’ Reck may appear at various alumni functions. Proceeds are used to support the maintenance and upkeep of the car. Click <a href="/requests.php">here</a> to make your request!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="img-responsive d-block w-100" src="/img/2021/merc_alma_mater.jpg" alt="2021 Alma mater on the Mercedes Benz field">
                    <div class="gradient">
                    </div>
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Want to join the team?</h5>
                        <p>Recruitment happens every Spring, find out more information about the process <a href="/reckruitment/index.php">here!</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-primary">The Reck</strong>
                        <h3 class="mb-1 text-dark">Drivers</h3>
                        <p class="card-text mb-auto">Each year, one student is chosen from the ranks of the club to be the sole driver and primary caretaker of the Ramblin’ Reck.</p>
                        <a href="/reck/drivers.php">Read more</a>
                    </div>
                    <img class="card-img-right img-fluid flex-auto d-none d-md-block" data-src="/img/2021/rosman.jpg" style="width: 200px; height: 250px;" src="/img/2021/rosman.jpg" data-holder-rendered="true">
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-secondary">Traditions</strong>
                        <h3 class="mb-1 text-dark">The T-Book</h3>
                        <p class="card-text mb-auto">The Georgia Tech T-book was originally published by the Georgia Tech YMCA with the intention of providing a guide to the new Tech students abo...</p>
                        <a href="/about/t-book.php">Continue reading</a>
                    </div>
                    <img class="card-img-right img-fluid flex-auto d-none d-md-block" src="/img/promo/mantle-tbook.jpg" style="width: 200px !important; height: 250px;" data-holder-rendered="true">
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <img class="card-img-left img-fluid flex-auto d-none d-md-block" src="/img/promo/1961-reck-debut.jpg" style="width: 200px !important; height: 250px;" data-holder-rendered="true">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-secondary">History</strong>
                        <h3 class="mb-1 text-dark">The Reck</h3>
                        <p class="card-text mb-auto">The Reck was formally introduced as Georgia Tech's mascot when it led the football team out on to Grant Field for the 1961 homecoming game...</p>
                        <a href="/reckhistory">Continue reading</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card flex-md-row mb-4 box-shadow h-md-250">
                    <img class="card-img-left img-fluid flex-auto d-none d-md-block" src="/img/promo/2017-gameday-rideout.jpg" style="width: 200px !important; height: 250px;" data-holder-rendered="true">
                    <div class="card-body d-flex flex-column align-items-start">
                        <strong class="d-inline-block mb-2 text-primary">RECKruitment</strong>
                        <h3 class="mb-1 text-dark">Want to join the tradition?</h3>
                        <p class="card-text mb-auto">Learn more about what it is to be a part of Reck Club and kickstart your recruitment process!</p>
                        <a href="/reckruitment">Read more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require "partials/footer.php" ?>
<?php require "partials/scripts.php" ?>
</body>

</html>
