<?php $pageTitle = "Appearance Requests"; ?>

<!DOCTYPE html>
<html>
<?php require "partials/head.php" ?>

<body>
<?php require "partials/public-header.php" ?>
<div class="container">
    <h2 class="mb-3">Appearance Requests</h2>
    <p>As part of our duties, the Ramblin' Reck Club takes the Reck and our inflatable Buzz mascot to events both on- and off-campus. Please select the mascot you would like to request an appearance from.</p>

    <div class="row mb-2">
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <img class="card-img-right img-fluid flex-auto d-none d-lg-block" src="/img/promo/2017-gameday-rideout.jpg" data-holder-rendered="true" style="width: 200px; height: 250px;">
                <div class="card-body d-flex flex-column align-items-start">
                    <h3 class="mb-1 text-dark">The Ramblin' Reck</h3>
                    <p class="card-text mb-auto">When it is not being used for official Georgia Tech business and events, the Ramblin’ Reck is able to appear at events for Georgia Tech alumni and fans.</p>
                    <a href="/reck/request.php" class="btn btn-outline-primary mt-2">Submit a Reck request</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card flex-md-row mb-4 box-shadow h-md-250">
                <img class="card-img-right img-fluid flex-auto d-none d-lg-block" src="/img/promo/big-buzz.jpg" data-holder-rendered="true" style="width: 200px; height: 250px;">
                <div class="card-body d-flex flex-column align-items-start">
                    <h3 class="mb-1 text-dark">Big Buzz</h3>
                    <p class="card-text mb-auto">If you would like to have Big Buzz appear at your event, please send in a request through the form below.</p>
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSf_BpENGaGoUHUWkO6Ct7SAgJ5kUuFhUGH5vS6d-buwtfOf1w/viewform" class="btn btn-outline-secondary mt-2">Submit a Big Buzz request</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "partials/footer.php" ?>
<?php require "partials/scripts.php" ?>
</body>

</html>
