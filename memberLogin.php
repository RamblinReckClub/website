<?php
require "database_connect.php";

$query = $db->prepare("SELECT * FROM Member WHERE username=:username AND password=:password");
$query->execute(array('username'=>$_POST['username'], 'password'=>md5($_POST['password'])));
$query->setFetchMode(PDO::FETCH_ASSOC);
$count = $query->rowCount();

if ($count==1) {
    $row = $query->fetch();
    session_start();
    $_SESSION['memberID'] = $row['memberID'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['firstName'] = $row['firstName'];
    $_SESSION['lastName'] = $row['lastName'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['twitter'] = $row['twitter'];
    $_SESSION['phone'] = $row['phone'];
    $_SESSION['streetAddress'] = $row['streetAddress'];
    $_SESSION['city'] = $row['city'];
    $_SESSION['state'] = $row['state'];
    $_SESSION['zipCode'] = $row['zipCode'];
    $_SESSION['status'] = $row['status'];
    $_SESSION['joinYear'] = $row['joinYear'];
    $_SESSION['gradYear'] = $row['gradYear'];
    $_SESSION['gradMonth'] = $row['gradMonth'];
    $_SESSION['reckerPair'] = $row['reckerPair'];
    $_SESSION['memFamilyID'] = $row['memFamilyID'];
    $_SESSION['isAdmin'] = $row['isAdmin'];
    $_SESSION['isSecretary'] = $row['isSecretary'];
    $_SESSION['isTreasurer'] = $row['isTreasurer'];
    $_SESSION['isVP'] = $row['isVP'];
    $_SESSION['isEventAdmin'] = $row['isEventAdmin'];
    $_SESSION['memberPoints'] = $row['memberPoints'];
    $_SESSION['mandatoryEventCount'] = $row['mandatoryEventCount'];
    $_SESSION['sportsEventCount'] = $row['sportsEventCount'];
    $_SESSION['socialEventCount'] = $row['socialEventCount'];
    $_SESSION['workEventCount'] = $row['workEventCount'];
} else {}

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