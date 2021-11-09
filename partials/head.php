<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="description" content="The online home of the Ramblin' Reck Club, a campus organization at the Georgia Institute of Technology dedicated to the promotion of Georgia Tech traditions and spirit and responsible for the Institute's mascot car - the Ramblin' Reck.">
    <meta name="author" content="Ramblin' Reck Club">
    <link rel="stylesheet" href="/css/bootstrap.min.css?v=<?php echo filemtime(dirname(__FILE__, 2) . '/css/bootstrap.min.css'); ?>">
    <?php if (isset($_SESSION['memberID']) && $_SESSION['status'] == "member"): ?>
        <title><?php echo $pageTitle. " | Ramblin' Wreck Club" ?></title>
        <link rel="stylesheet" href="/css/prank.css?v=<?php echo filemtime(dirname(__FILE__, 2) . '/css/prank.css'); ?>">
    <?php else: ?>
        <title><?php echo $pageTitle. " | Ramblin' Reck Club" ?></title>
        <link rel="stylesheet" href="/css/main.css?v=<?php echo filemtime(dirname(__FILE__, 2) . '/css/main.css'); ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="/css/fontawesome-all.min.css?v=<?php echo filemtime(dirname(__FILE__, 2) . '/css/login.css'); ?>">
</head>