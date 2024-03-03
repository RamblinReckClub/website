<?php

$renterName = $_POST["renterName"];
$renterPhoneNumber = $_POST["renterPhoneNumber"];
$renterEmail = $_POST["renterEmail"];
$eventDetails = $_POST["eventDetails"];
$eventName = $_POST["eventName"];
$eventLocation = $_POST["eventLocation"];
$eventDate = $_POST["eventDate"];
$eventStartTime = $_POST["eventStartTime"];
$eventEndTime = $_POST["eventEndTime"];
$eventDistanceAway = $_POST["eventDistanceAway"];

$url = "https://api.sendgrid.com/v3/mail/send";

$mailOptions = [
    "personalizations" => [
        [
            "to" => [
                [
                    "name" => "Ramblin\' Reck Driver",
                    "email" => getenv("RECK_REQUEST_RECIPIENT") // add the actual email here from the .env IN PLESK. DO NOT ADD IT IN THE SOURCE CODE.
                ]
            ],
            "bcc" => [
                [
                    "name" => "Backup Email",
                    "email" => getenv("BACKUP_REQUEST_RECIPIENT") //add the actual email here ""
                ]
            ]
        ]
    ],
    "from" => [
        "name" => "Ramblin' Reck Club",
        "email" => "no-reply@reckclub.org"
    ],
    "reply_to" => [
        "name" => $renterName,
        "email" => $renterEmail
    ],
    "subject" => "Appearance Request from " . $renterName,
    "content" => [
        [
            "type" => "text/html",
            "value" => nl2br("A new Ramblin' Reck appearance request has been submitted.\n\n" .
                "<b>Requestor:</b> " . $renterName . " \n" .
                "<b>Phone Number:</b> " . $renterPhoneNumber . " \n" .
                "<b>Email:</b> " . $renterEmail . " \n" .
                "<b>Event Name:</b> " . $eventName . "\n" .
                "<b>Event Location:</b> " . $eventLocation . "\n" .
                "<b>Event Date:</b> " . $eventDate . "\n" .
                "<b>Event Start Time:</b> " . $eventStartTime . "\n" .
                "<b>Event End Time:</b> " . $eventEndTime . "\n" .
                "<b>Distance from GT:</b> " . $eventDistanceAway . (strpos($eventDistanceAway, 'miles') ? '' : ' miles') . "\n" .
                "<b>Event Details:</b> " . ((strlen($eventDetails) > 0) ? $eventDetails : "No additional information provided.") . "\n" .
                "\n" .
                "--\nThis email was sent automatically from reckclub.org. If you received this email in error, please contact secretary@reckclub.org.")
        ]
    ]
];

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
$authorization = "Authorization: Bearer " . getenv("SENDGRID_API_KEY"); // add the actual API key here from the .env IN PLESK. DO NOT ADD IT IN THE SOURCE CODE.
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", $authorization));
curl_setopt($ch,CURLOPT_POST, count($mailOptions));
curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($mailOptions));

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

$result_dict = json_decode($result);
if ($result && array_key_exists("errors", $result_dict)) {
    echo json_encode([
        "status" => "bad",
        "message" => "Something bad happened to this request. :("
    ]);
} else {
    echo json_encode([
        "status" => "ok",
        "message" => "Reck request email sent successfully!"
    ]);
}

