<?php
if (!defined('NEXMO_API_KEY')) {
    define('NEXMO_API_KEY', '8a7d8b18');
    define('NEXMO_API_SECRET', 'ZnsC0UUM2nbSZImJ');
}

// Überprüfe ob die notwendigen Variablen existieren
if (!isset($smsData)) {
    throw new Exception('SMS data not provided');
}

$curl = curl_init();

$postFields = http_build_query([
    'from' => $smsData['from'],
    'text' => $smsData['text'],
    'to' => $smsData['to'],
    'api_key' => NEXMO_API_KEY,
    'api_secret' => NEXMO_API_SECRET
]);

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://rest.nexmo.com/sms/json',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $postFields,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
    ),
));

$response = curl_exec($curl);

if ($response === false) {
    throw new Exception('Curl error: ' . curl_error($curl));
}

curl_close($curl);
