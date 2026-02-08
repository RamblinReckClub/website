<?php
require "database_connect.php";
require __DIR__ . "/auth/auth_login.php";

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
        session_destroy();
        print("<h3>Login successful! Alumni accounts are currently disabled.</h3>");
        print("<meta http-equiv=\"refresh\" ");
        print("content=\"2; url=history.php\">");
    } else{
        print("content=\"1; url=points.php\">");
    header('Location: points.php');exit();
    }
} else {
    print("<h3>Login failed</h3>\n");
    print("<meta http-equiv=\"refresh\" ");
    print("content=\"2; url=memberLoginForm.php\">");
}

// require "html_footer.txt";
?>