<?php

function successfulLogin($user, $db) {

    $currentDate = new DateTime();
    $passwordExpiration = new DateTime($user['passwordExpiration']);
    error_log($currentDate->format('Y-m-d H:i:s'));
    error_log($passwordExpiration->format('Y-m-d H:i:s'));
    if ($passwordExpiration <= $currentDate) {
        session_start();
        $_SESSION['username'] = $user['username'];

        header("Location: /memberPasswordReset.php?resetRequired=1&error=none");
        exit;
    }

    $currentTimestamp = date('Y-m-d H:i:s');
    $query = $db->prepare("UPDATE Member SET lastLogin = :lastLogin WHERE memberID = :memberID");
    $query->execute([
        ':lastLogin' => $currentTimestamp,
        ':memberID'  => $user['memberID']
    ]);

    session_start();
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
