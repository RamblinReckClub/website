<?php
// Get the current page's filename
$currentPage = basename($_SERVER['PHP_SELF']);

// Define an array mapping pages to their respective navigation items
$pages = [
    "index.php" => "Home",
    "w-or-r.php" => "Wreck or Reck?",
    "other-cars.php" => "Other Cars",
    "pre-1960s.php" => "Pre-1960s",
    "1960s.php" => "1960s",
    "1970s.php" => "1970s",
    "1980s.php" => "1980s",
    "1990s.php" => "1990s",
    "2000s.php" => "2000s",
    "2010s.php" => "2010s",
    "2020s.php" => "2020s"
];
?>

<div class="px-0">
    <br>
    <h2 class="text-dark text-center pb-0 mb-0">History of the Reck</h2>
    <div class="navbar-container-wrapper">
        <button class="scroll-arrow left" id="scrollLeft" aria-label="Scroll left">
            <i class="bi bi-chevron-left"></i>
        </button>
        <div class="navbar-container" id="scrollableNavbar">
            <ul class="navbar-nav d-flex flex-row">
                <?php foreach ($pages as $file => $label): ?>
                    <li class="rh-nav-item <?php echo ($currentPage === $file) ? 'rh-active' : ''; ?>">
                        <a class="rh-nav-link" href="/reckhistory/<?php echo $file; ?>"><?php echo $label; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <button class="scroll-arrow right" id="scrollRight" aria-label="Scroll right">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>
</div>
