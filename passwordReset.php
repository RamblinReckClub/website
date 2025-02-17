<?php

require "database_connect.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: memberLoginForm.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $query = $db->prepare("SELECT password, passwordType FROM Member WHERE username=:username");
    $query->execute(array('username'=>$_SESSION['username']));
    $query->setFetchMode(PDO::FETCH_ASSOC);
    $user = $query->fetch();

    $password = $_POST["password"];
    $newPassword = $_POST['password-new'];
    $confirmPassword = $_POST['password-confirm'];
    $storedHash = $user['password'];
    $passwordType = $user['passwordType'];

    if (($passwordType === 'md5' && md5($password) === $storedHash) ||
        ($passwordType === 'bcrypt' && password_verify($password, $storedHash))) {

        if ($newPassword !== $confirmPassword) {
            header("Location: passwordReset.php?error=ipc");
            exit;
        } else {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

            // Update the password and remove the reset flag
            $query = $db->prepare("UPDATE Member SET password=:password, passwordIsTemp=0 WHERE username=:username");
            $query->execute(['password' => $hashedPassword, 'username' => $_SESSION['username']]);

            // Start session and redirect to dashboard
            session_destroy();
            header("Location: /memberLoginForm.php");
            exit;
        }
    } else {
        header("Location: passwordReset.php?error=ia");
        exit;
    }
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
    <title>Reset Password | Ramblin' Reck Club</title>

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

            <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <form class="form-signin" action="passwordReset.php" method="POST">
                <img class="mb-4 login-image" src="/img/brand/official-logo.png" alt="">
                <div class="message-space"></div>
                <h1 class="mb-3 font-weight-normal">Reset Password</h1>

                <?php if ($_GET['resetRequired'] ?? 0): ?>
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <div>
                            You must change your password to access your account.
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (($_GET['error'] ?? 0) == 'ia'): ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <div>
                            The username or password is incorrect.
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (($_GET['error'] ?? 0) == 'ipc'): ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <div>
                            The new passwords do not match.
                        </div>
                    </div>
                <?php endif; ?>


                <br>

                <label for="username" class="sr-only">Username</label>
                <input disabled type="text" maxlength="32" name="username" id="username" class="form-control" placeholder="Username"
                       value="<?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?>" required>

                <label for="password" class="sr-only">Old Password</label>
                <input type="password" id="password" maxlength="32" name="password" class="form-control" placeholder="Old Password" required>
                <div class="invalid-feedback">
                    Please enter your old password.
                </div>

                <br>
                <label for="password" class="sr-only">New Password</label>
                <input type="password" id="password-new" maxlength="32" name="password-new" class="form-control" placeholder="New Password" required>
                <div class="invalid-feedback">
                    Please enter your new password.
                </div>
                <label for="password" class="sr-only">Confirm Password</label>
                <input type="password" id="password-confirm" maxlength="32" name="password-confirm" class="form-control" placeholder="Confirm Password" required>
                <div class="invalid-feedback">
                    Please enter your new password again.
                </div>

                <br>

                <button type="submit" class="btn btn-lg btn-primary btn-block mb-1">Update Password</button>
            </form>
        </div>
    </div>
</div>


<?php require "partials/scripts.php"; ?>

</body>
</html>
