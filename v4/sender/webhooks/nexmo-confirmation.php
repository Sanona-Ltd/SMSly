<?php
echo "== START PAGE == <br>";

$msisdn = $_GET["msisdn"];
$to = $_GET["to"];
$networkCode = $_GET["network-code"];
$messageId = $_GET["messageId"];
$price = $_GET["price"];
$status = $_GET["status"];
$scts = $_GET["scts"];
$errCode = $_GET["err-code"];
$apiKey = $_GET["api-key"];
$messageTimestamp = $_GET["message-timestamp"];

if ($networkCode == "22801") {
  $networkCodeText = "Swisscom";
} elseif ($networkCode == "22802") {
  $networkCodeText = "Sunrise";
} elseif ($networkCode == "22803") {
  $networkCodeText = "Salt";
} else {
  $networkCodeText = "0";
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/logs',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('type' => 'sms.sending.webhook', 'user' => '0', 'action' => 'NEXMO Sending Webhook', 'storage' => 'messageId = ' . $messageId . '
networkCode = ' . $networkCode . '
status = ' . $status . '
errCode = ' . $errCode . ''),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo "== UNDER LOG ENTRY == <br>";
// echo $response;




$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-send?where[sms_message_id]=' . $messageId . '',
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
echo "== DB REQUEST FOR: $messageId == <br>";
// echo $response;
// Konvertiere die JSON-Antwort in ein PHP-Array
$data = json_decode($response, true);

if (count($data) > 0) {
  // Verarbeitung jedes Datensatzes
  foreach ($data as $sms) {
    $id = $sms['id'];
    $sms_from = $sms['sms_from'];
    $sms_to = $sms['sms_to'];
    $sms_network = $sms['sms_network'];
    $sms_network_gateway = $sms['sms_network_gateway'];
    $sms_message_id = $sms['sms_message_id'];
    $sms_message_price = $sms['sms_message_price'];
    $sender_cost = $sms['sender_cost'];



    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-send/update/' . $id . '',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'sms_message_price=' . $price . '&sms_network=' . $networkCodeText . '&sms_network_gateway=' . $networkCode . '&carrier_status=' . $status . '',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
    echo "== DB ENTRY SUCCESS == <br>";

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/logs',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => array('type' => 'sms.sending.webhook.success', 'user' => '0', 'action' => 'NEXMO Sending Webhook', 'storage' => ''),
      CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo "== UNDER LOG ENTRY 2 == <br>";
  }
} else {
  echo "== NO FOUNDING IN DB == <br>";
}
