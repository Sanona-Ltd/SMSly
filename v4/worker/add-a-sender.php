<?php

require_once("../auth/login-checker.php");

$senderName = $_POST['senderName'];
$senderDescription = $_POST['senderDescription'];



$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-sender-name',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('user' => $GLOBALS_USER_ID, 'sender-name' => $senderName, 'validation-status' => 'Under Review', 'senderdescription' => $senderDescription),
    CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;



$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://push.sanona.org/api/personal-notifications',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('name' => 'SMSly | Action', 'website_id' => '8', 'subscriber_id' => '26', 'title' => 'SMSly - Neuer Absender', 'description' => 'Jemand will einen Neuen Absender nutzen', 'urgency' => 'high', 'url' => 'https://pager.sanona.org/?cmd=action&title=SMSly%20%7C%20Neuer%20Absender&content=Der%20Benutzer%20%22%24GLOBALS_USER_EMAIL%22%20will%20den%20Absender%20%22%24senderName%22%20nutzen.%20Seine%20Begr%C3%BCndung%20ist%3A%20%24senderDescription&url1=https%3A%2F%2Fsanona.org%2Fpush%2Fapp%2Faction-dummy.php&url1text=NOT%20WORKING&url2=https%3A%2F%2Fsanona.org%2Fpush%2Fapp%2Faction-dummy.php&url2text=NOT%20WORKING', 'send' => ''),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer 59fc371e44a8124c7d0829aa414ad138',
        'Cookie: PHPSESSID=p9bsm7douq8qgkklbt4qe8o3qn'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;

header("Location: ../sms-sender");
