<?php

session_start();
$_SESSION['test']="test";
header('Location: session.php');
exit();