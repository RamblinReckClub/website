<?php
	// Screw licenses.  This is too trivial.  Use this code any way you want.
	if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'iPod') !== FALSE) {
		//header('Location: http://www.google.com');
	}
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="The online home of the Ramblin' Reck Club, a campus organization at the Georgia Institute of Technology dedicated to the promotion of Georgia Tech traditions and spirit and responsible for the Institute's mascot car - the Ramblin' Reck.">
    <meta name="author" content="Ramblin' Reck Club">
    <title>Member Login | Ramblin' Reck Club</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap.min.css?v=<?php echo filemtime(getcwd() . '/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="/css/main.css?v=<?php echo filemtime(getcwd() . '/css/main.css'); ?>">
    <link rel="stylesheet" href="/css/login.css?v=<?php echo filemtime(getcwd() . '/css/login.css'); ?>">
    <link rel="stylesheet" href="/css/fontawesome-all.min.css?v=<?php echo filemtime(dirname(__FILE__, 2) . '/css/login.css'); ?>">

</head>

<body>
<div class="container text-center">
    <div class="card">
        <div class="card-body">
            <form class="form-signin" id="sign-in-form" novalidate action="/memberLogin.php" method="POST">
                <img class="mb-4 login-image" src="/img/brand/official-logo.png" alt="">
                <div class="message-space"></div>
                <h1 class="mb-3 font-weight-normal">Member Login</h1>
                <label for="username" class="sr-only">Username</label>
                <input type="email" id="username" name="username" class="form-control" placeholder="Username" required autofocus="" onKeyPress="return letternumber(event)">
                <div class="invalid-feedback">
                    Please enter your email.
                </div>
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" maxlength="32" name="password" class="form-control" placeholder="Password" required>
                <div class="invalid-feedback">
                    Please enter your password.
                </div>
                <button class="btn btn-lg btn-primary btn-block mb-1" type="submit">Sign in</button>
                <a class="btn btn-link" href="mailto:technology@reckclub.org?subject=Create%20account">Don't have an account?</a>
                <p class="mt-3 text-muted copyright-notice">© <?php echo date('Y'); ?> Ramblin' Reck Club. All Rights Reserved.</p>
            </form>
        </div>
    </div>
</div>


<?php require "partials/scripts.php"; ?>

</body>
</html>
