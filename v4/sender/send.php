<?php

include("../auth-app/is-login.php");
include("../log/send-logs.php");

$url = "../sms-send";

// Überprüfe ob alle erforderlichen Parameter vorhanden sind
if (!isset($_GET["scode"]) || !isset($_GET["smsfrom"]) || !isset($_GET["smsto"]) || !isset($_GET["smstext"])) {
    header("Location: $url?smserror=falspar");
    echo "Ein Parameter ist nicht richtig angegeben...";
    exit();
}

// Init Variable
$scode = $_GET["scode"];
$smsSenderGateway = $_GET["smsfrom"];
$smsReceiverGateway = $_GET["smsto"];
$smstextGateway = urldecode($_GET["smstext"]);

// Überprüfe den Security Code
if (strrpos(file_get_contents("secret/scode.txt"), $scode) === false) {
    header("Location: $url?smserror=falssc");
    echo "Falscher \"scode\"";
    exit();
}

// Hole das aktuelle SMS Kontingent
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user?where[id]=' . $GLOBAL_VARIABLE_userid . '&timestamps=null',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
    ),
));
$response = curl_exec($curl);
curl_close($curl);

$responseObj = json_decode($response);
$sms_contingent = $responseObj[0]->sms_contingent;

// Überprüfe ob genügend SMS Kontingent vorhanden ist
if ($sms_contingent <= 0) {
    header("Location: $url?status=89");
    echo "SMS Contigent <= 0";
    exit();
}

// Sende die SMS
require("gateway/nexmo.php");


// Aktualisiere das SMS Kontingent
$remainingSMS = $sms_contingent - $messageCount;
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user/update/' . $GLOBAL_VARIABLE_userid . '',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('sms_contingent' => '' . $remainingSMS . ''),
    CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
    ),
));
$response = curl_exec($curl);
curl_close($curl);

// Sende Log über die neue Funktion
sendLogAsync(
    'sms.sending',
    $GLOBAL_VARIABLE_userid,
    "sent to gateway",
    "scode = $scode\nsmsto = $smsReceiverGateway\nsmstext = $smstextGateway\nsmsfrom = $smsSenderGateway\nStatus = $status"
);

header("Location: $url?status=$status");
echo "<br><br><br><br>$url?status=$status | hat geklappt";
exit();
