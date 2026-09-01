<div class="container">
    <nav class="navbar navbar-expand-md d-flex bg-light navbar-light px-0" style="background: #fff !important;">
        <div class="blog-header col-12 pt-2 pb-3 px-0">
            <div class="row">
                <div class="col-3">
                    <button class="btn btn-sm btn-outline-primary navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar2">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="col-6 text-center">
                    <a class="blog-header-logo text-dark text-center" href="/points.php">Ramblin' Reck Club</a>
                </div>
                <div class="col-3">
<!--                    <a class="float-right btn btn-sm btn-outline-primary" href="/points.php">Log In</a>-->
                    <a class="float-right btn btn-sm btn-secondary" href="/memberLogout.php">Sign Out</a>
                </div>
            </div>
        </div>

    </nav>
    <nav class="navbar navbar-expand-md bg-light navbar-light pt-0  px-0" style="background: #fff !important;" id="navbar2parent">
        <div class="navbar-collapse collapse" id="navbar2">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link btn-link" href="/events.php">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-link" href="/rankings.php">Members</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-link" href="/families.php">Families</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-link" href="/memberProfile.php">Profile</a>
                </li>
                <?php if(isset($_SESSION['status']) && $_SESSION['status'] == 'probate') :?>
                <li class="nav-item">
                    <a class="nav-link btn-link" href="/myTs.php">My Ts</a>
                </li>
                <?php endif; ?>
                <?php if((isset($isProbateGuide) && $isProbateGuide == 1) || $isAdmin == 1) :?>
                <li class="nav-item">
                    <a class="nav-link btn-link" href="/probateTs.php">Probate Ts</a>
                </li>
                <?php endif; ?>
                <!--<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Records
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/allTimeEvents.php">All Time Events</a>
                        <a class="dropdown-item" href="/pointsLeaders.php">Point Leaders</a>
                    </div>
                </li>-->
                <?php if($isSecretary == 1 || $isVP == 1 || $isEventAdmin == 1 || $isAdmin == 1) :?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Admin
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/editEvents.php">Edit Events</a>
                        <?php if($isSecretary == 1 || $isVP == 1 || $isAdmin == 1) :?>
                        <a class="dropdown-item" href="/manageMembers.php">Manage Members</a>
<!--                        <a class="dropdown-item" href="/managePositions.php">Manage Positions</a>-->
                        <a class="dropdown-item" href="/manageWebsite.php">Manage Website</a>
                        <?php endif; ?>
                    </div>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>