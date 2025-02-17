<?php
require "database_connect.php";

function successfulLogin($user, $db) {

//    if ($user['passwordIsTemp'] == 1) {
//        // Store user ID in a temporary session variable
//        session_start();
//        $_SESSION['username'] = $user['username'];
//
//        // Redirect to password reset page
//        header("Location: passwordReset.php?resetRequired=1&error=none");
//        exit;
//    }

    // Mark the last successful login datetime
    $currentTimestamp = date('Y-m-d H:i:s');
    $query = $db->prepare("UPDATE Member SET lastLogin = :lastLogin WHERE memberID = :memberID");
    $query->execute([
        ':lastLogin' => $currentTimestamp,
        ':memberID'  => $user['memberID']
    ]);

    // Start the session
    session_start();
    // Now load the session variables
    $_SESSION['memberID'] = $user['memberID'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['firstName'] = $user['firstName'];
    $_SESSION['lastName'] = $user['lastName'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['twitter'] = $user['twitter'];
    $_SESSION['phone'] = $user['phone'];
    $_SESSION['streetAddress'] = $user['streetAddress'];
    $_SESSION['city'] = $user['city'];
    $_SESSION['state'] = $user['state'];
    $_SESSION['zipCode'] = $user['zipCode'];
    $_SESSION['status'] = $user['status'];
    $_SESSION['joinYear'] = $user['joinYear'];
    $_SESSION['gradYear'] = $user['gradYear'];
    $_SESSION['gradMonth'] = $user['gradMonth'];
    $_SESSION['reckerPair'] = $user['reckerPair'];
    $_SESSION['memFamilyID'] = $user['memFamilyID'];
    $_SESSION['isAdmin'] = $user['isAdmin'];
    $_SESSION['isSecretary'] = $user['isSecretary'];
    $_SESSION['isTreasurer'] = $user['isTreasurer'];
    $_SESSION['isVP'] = $user['isVP'];
    $_SESSION['isEventAdmin'] = $user['isEventAdmin'];
    $_SESSION['memberPoints'] = $user['memberPoints'];
    $_SESSION['mandatoryEventCount'] = $user['mandatoryEventCount'];
    $_SESSION['sportsEventCount'] = $user['sportsEventCount'];
    $_SESSION['socialEventCount'] = $user['socialEventCount'];
    $_SESSION['workEventCount'] = $user['workEventCount'];
}

$username = $_POST['username'];
$password = $_POST['password'];

$query = $db->prepare("SELECT * FROM Member WHERE username=:username");
$query->execute(array('username'=>$username));
$query->setFetchMode(PDO::FETCH_ASSOC);
$user = $query->fetch();

if ($user) {
    $storedHash = $user['password'];
    $passwordType = $user['passwordType'];

    if ($passwordType === 'md5' && md5($password) === $storedHash) {
        // Successful md5 login. Time to upgrade the hash to bcrypt!
        $newPasswordHash = password_hash($password, PASSWORD_BCRYPT);
        $passwordUpdateQuery = $db->prepare("UPDATE Member SET password=:password, passwordType='bcrypt' WHERE username=:username");
        $passwordUpdateQuery->execute(array('password'=>$newPasswordHash, 'username'=>$username));
        successfulLogin($user, $db);
    } elseif ($passwordType === 'bcrypt' && password_verify($password, $storedHash)) {
        // Successful bcrypt login
        successfulLogin($user, $db);
    }
}

require "html_header_begin.txt";
?>

    <script type="text/javascript">
        NumberOfImagesToRotate = 18;
        FirstPart = '<img src="images/snap';LastPart = '.jpg">';
        function printImage() {
            var r = Math.ceil(Math.random() * NumberOfImagesToRotate);
            document.write(FirstPart + r + LastPart);
        }
    </script>

<?php
require "html_header_end.txt";
if (isset($_SESSION['memberID'])==1) {
    ("<h3><script type=\"text/javascript\">printImage();</script></h3>");
    // print("<meta http-equiv=\"refresh\" ");
    //print("<h3>Login successful</h3>\n");
    if($_SESSION['status']=="alumni"){
        print("content=\"1; url=history.php\">");
    } else{
        //print("content=\"1; url=points.php\">");
        header('Location: points.php');exit();
    }
} else {
    print("<h3>Login failed</h3>\n");
    print("<meta http-equiv=\"refresh\" ");
    print("content=\"2; url=memberLoginForm.php\">");
}

// require "html_footer.txt";
?>