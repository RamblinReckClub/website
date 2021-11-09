<div class="container">
    <?php if (isset($_SESSION["memberID"]) && $_SESSION["status"] == "member"): ?>
        <nav class="navbar navbar-expand-lg d-flex bg-light navbar-light px-0" style="background: #BA0C2F !important;">
            <div class="blog-header col-12 pt-2 pb-3 px-0" style="background: #BA0C2F;">
                <div class="row" style="background: #BA0C2F !important;">
                    <div class="col-3">
                        <button class="btn btn-md btn-outline-primary navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar2">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="col-6 text-center">
                        <a class="blog-header-logo text-dark text-center" href="/">Ramblin' Wreck Club</a>
                    </div>
                    <div class="col-3">
                        <a class="float-right btn btn-sm btn-outline-primary" href="/points.php">Log In</a>
                    </div>
                </div>
            </div>

        </nav>
        <nav class="navbar navbar-expand-lg bg-light navbar-light pt-0  px-0" style="background: #fff !important;" id="navbar2parent">
            <div class="navbar-collapse collapse" id="navbar2">
                <ul class="navbar-nav" style="background: #BA0C2F !important;>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    About Us
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/about">Club History</a>
                    <a class="dropdown-item" href="/about/roster.php">Club Roster</a>
                    <a class="dropdown-item" href="/endowments.php">Endowments</a>
                    <a class="dropdown-item" href="/about/t-book.php">The T-Book</a>
                    <a class="dropdown-item" href="/t-night.php">T-Night</a>
                </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        The Wreck
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/reck">The Tradition</a>
                        <a class="dropdown-item" href="/reck/drivers.php">Drivers</a>
                        <a class="dropdown-item" href="/reckhistory">History</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Homecoming
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/homecoming/mini-500.php">Mini 500</a>
                        <a class="dropdown-item" href="/homecoming/cake-race.php">Freshman Cake Race</a>
                        <a class="dropdown-item" href="/homecoming/wreck-parade.php">Wreck Parade</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        WRECKruitment
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/reckruitment">Process</a>
                        <a class="dropdown-item" href="/reckruitment/why.php">Why You Should Join</a>
                        <a class="dropdown-item" href="/reckruitment/probateship.php">Hazing</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Wrequests
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/reck/request.php">Request the Wreck</a>
                        <a class="dropdown-item" href="/big-buzz">Request Big Buzz</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-link" href="https://reckclub.ecwid.com">Buy our overpriced scarves</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-link" href="/traditionkeepers">Please care about our Traditions</a>
                </li>
                </ul>
            </div>
        </nav>
    <?php else: ?>
        <nav class="navbar navbar-expand-lg d-flex bg-light navbar-light px-0" style="background: #fff !important;">
            <div class="blog-header col-12 pt-2 pb-3 px-0">
                <div class="row">
                    <div class="col-3">
                        <button class="btn btn-md btn-outline-primary navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar2">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                    <div class="col-6 text-center">
                        <a class="blog-header-logo text-dark text-center" href="/">Ramblin' Reck Club</a>
                    </div>
                    <div class="col-3">
                        <a class="float-right btn btn-sm btn-outline-primary" href="/points.php">Log In</a>
                    </div>
                </div>
            </div>

        </nav>
        <nav class="navbar navbar-expand-lg bg-light navbar-light pt-0  px-0" style="background: #fff !important;" id="navbar2parent">
            <div class="navbar-collapse collapse" id="navbar2">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            About Us
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/about">Club History</a>
                            <a class="dropdown-item" href="/about/roster.php">Club Roster</a>
                            <a class="dropdown-item" href="/endowments.php">Endowments</a>
                            <a class="dropdown-item" href="/about/t-book.php">The T-Book</a>
                            <a class="dropdown-item" href="/t-night.php">T-Night</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            The Reck
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/reck">The Tradition</a>
                            <a class="dropdown-item" href="/reck/drivers.php">Drivers</a>
                            <a class="dropdown-item" href="/reckhistory">History</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Homecoming
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/homecoming/mini-500.php">Mini 500</a>
                            <a class="dropdown-item" href="/homecoming/cake-race.php">Freshman Cake Race</a>
                            <a class="dropdown-item" href="/homecoming/wreck-parade.php">Wreck Parade</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            RECKruitment
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/reckruitment">Process</a>
                            <a class="dropdown-item" href="/reckruitment/why.php">Why You Should Join</a>
                            <a class="dropdown-item" href="/reckruitment/probateship.php">Probateship</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Requests
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/reck/request.php">Request the Wreck</a>
                            <a class="dropdown-item" href="/big-buzz">Request Big Buzz</a>
                        </div>
                    </li>
                    <!--                <li class="nav-item">-->
                    <!--                    <a class="nav-link btn-link" href="https://reckclub.ecwid.com">Store</a>-->
                    <!--                </li>-->
                    <li class="nav-item">
                        <a class="nav-link btn-link" href="/traditionkeepers">Tradition Keepers</a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>
</div>