<?php

// $smsSenderGateway = "Sanona%20Ltd.";
// $smstextGateway = "Ihr%202FA%20Code%20ist%3A%20012345%20%0A%0ADieser%20SMS-dienst%20geh%C3%B6rt%20%0ASanona%20Ltd.%0A%0A(Beta%20TEST%200.0.1)";
// $smsReceiverGateway = "41764997729";


$smsSenderIP = $_SERVER['REMOTE_ADDR'];




$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://rest.nexmo.com/sms/json',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'from=' . $smsSenderGateway . '&text=' . $smstextGateway . '&to=' . $smsReceiverGateway . '&api_key=8a7d8b18&api_secret=ZnsC0UUM2nbSZImJ',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;

// Umwandeln des JSON-Strings in ein PHP-Objekt
$responseObj = json_decode($response);

// Extrahieren der Werte in separate Variablen
$messageCount = $responseObj->{"message-count"};
$to = $responseObj->messages[0]->to;
$messageId = $responseObj->messages[0]->{"message-id"};
$status = $responseObj->messages[0]->status;
$remainingBalance = $responseObj->messages[0]->{"remaining-balance"};
$messagePrice = $responseObj->messages[0]->{"message-price"};
$network = $responseObj->messages[0]->network;

// Ausgabe der Variablen zur Überprüfung
echo "Message Count: $messageCount\n <br>";
echo "To: $to\n <br>";
echo "Message ID: $messageId\n <br>";
echo "Status: $status\n <br>";
echo "Remaining Balance: $remainingBalance\n <br>";
echo "Message Price: $messagePrice\n <br>";
echo "Network: $network\n <br><br>";

if($status == "0"){
  $smsStatus = "success";
}

if ($network == "22801") {
  $networkText = "Swisscom";
} elseif ($network == "22802") {
  $networkText = "Sunrise";
} elseif ($network == "22803") {
  $networkText = "Sunrise";
}

$messageCount;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-send',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'sms_from=' . $smsSenderGateway . '&sms_to=' . $to . '&sms_message=' . $smstextGateway . '&sms_status=' . $smsStatus . '&carrier_status=' . $status . '&sms_network=' . $networkText . '&sms_network_gateway=' . $network . '&sms_message_id=' . $messageId . '&sms_message_price=' . $messagePrice . '&sms_tag=0&sender=20&sender_cost=' . $messageCount . '&sender_ip=' . $smsSenderIP . '&sender_system=SMSLY.CH+%7C+WEB+FORM&sender_gateway=NEXMO',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
