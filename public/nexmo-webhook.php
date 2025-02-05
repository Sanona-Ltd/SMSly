<?php
include_once 'v4/log/send-logs.php';

// Webhook-Daten in Variablen speichern
$webhookData = json_decode(file_get_contents('php://input'), true);

sendLogAsync('nexmo.webhook', '0', 'step.1', $webhookData);

$msisdn = $webhookData['msisdn'] ?? '';
$to = $webhookData['to'] ?? '';
$networkCode = $webhookData['network-code'] ?? '';
$messageId = $webhookData['messageId'] ?? '';
$price = $webhookData['price'] ?? '';
$status = $webhookData['status'] ?? '';
$scts = $webhookData['scts'] ?? '';
$errCode = $webhookData['err-code'] ?? '';
$apiKey = $webhookData['api-key'] ?? '';
$messageTimestamp = $webhookData['message-timestamp'] ?? '';

// API-Abfrage mit messageId
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-send?where[sms_message_id]=' . $messageId,
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

// API-Antwort in Variablen speichern
$apiResponse = json_decode($response, true);
if (!empty($apiResponse[0])) {
    $smsData = $apiResponse[0];
    
    $smsId = $smsData['id'] ?? '';
    $smsLocale = $smsData['locale'] ?? '';
    $smsFrom = $smsData['sms_from'] ?? '';
    $smsTo = $smsData['sms_to'] ?? '';
    $smsMessage = $smsData['sms_message'] ?? '';
    $smsNetwork = $smsData['sms_network'] ?? '';
    $smsNetworkGateway = $smsData['sms_network_gateway'] ?? '';
    $smsMessageId = $smsData['sms_message_id'] ?? '';
    $smsMessagePrice = $smsData['sms_message_price'] ?? '';
    
    // Sender-Informationen
    $senderId = $smsData['sender']['id'] ?? '';
    $senderEmail = $smsData['sender']['email'] ?? '';
    $senderUsername = $smsData['sender']['username'] ?? '';
    $senderContingent = $smsData['sender']['sms_contingent'] ?? '';
}

// step 2
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-send/update/' . $smsId,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'carrier_status=' . $status . '&sms_message_price=' . $price,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;