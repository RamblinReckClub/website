<?php

$renterName = $_POST["renterName"];
$renterEmail = $_POST["renterEmail"];
$renterPhoneNumber = $_POST["renterPhoneNumber"];
$orgDeptName = $_POST["orgDeptName"];
$eventDetails = $_POST["eventDetails"];
$eventName = $_POST["eventName"];
$eventLocation = $_POST["eventLocation"];
$eventDate = $_POST["eventDate"];

$url = "https://api.sendgrid.com/v3/mail/send";

$mailOptions = [
    "personalizations" => [
        [
            "to" => [
                [
                    "name" => "RRC Big Buzz Chair",
                    "email" => getenv("BIG_BUZZ_REQUEST_RECIPIENT") // add the actual email here from the .env IN PLESK. DO NOT ADD IT IN THE SOURCE CODE.
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
    "subject" => "[Big Buzz] Appearance Request from " . $renterName,
    "content" => [
        [
            "type" => "text/html",
            "value" => nl2br("A Big Buzz appearance request has been submitted.\n\n" .
                "<b>Requestor:</b> " . $renterName . " \n" .
                "<b>Phone Number:</b> " . $renterPhoneNumber . " \n" .
                "<b>Email:</b> " . $renterEmail . " \n" .
                "<b>Organization/Department:</b> " . $orgDeptName . " \n" .
                "<b>Event Name:</b> " . $eventName . "\n" .
                "<b>Event Location:</b> " . $eventLocation . "\n" .
                "<b>Event Date:</b> " . $eventDate . "\n" .
                "<b>Event Details:</b> " . ((strlen($eventDetails) > 0) ? $eventDetails : "No additional information provided.") . "\n" .
                "\n" .
                "--\nThis email was sent automatically from reckclub.org. If you received this email in error, please contact technology@reckclub.org.")
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
//print_r($result_dict);
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
