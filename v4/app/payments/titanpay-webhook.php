<?php

include_once '../../log/send-logs.php';

// Webhook-Daten aus dem POST-Request als JSON empfangen und dekodieren
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

// Daten in Variablen speichern
$event = $data['event'] ?? null;
$message = $data['message'] ?? null;
$payment_id = $data['payment_id'] ?? null;
$payment_method = $data['payment_method'] ?? null;

$payment_date = date('Y-m-d H:i:s');

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/payments?where[payment_id]=' . $payment_id . '&timestamps=null',
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

// JSON-Antwort dekodieren
$payment_data = json_decode($response, true);

if (empty($payment_data)) {
    // Wenn keine Zahlung gefunden wurde, erstelle einen Log-Eintrag
    sendLogAsync('titanpay.webhook', '', 'payment.id.not.found', 'The payment id was not found');
} else {
    // Zahlung wurde gefunden, speichere die ID in einer Variable
    $payment_database_id = $payment_data[0]['id'];
    $contingent = $payment_data[0]['contingent'];
    $user_id = $payment_data[0]['user']['id'];
    $sms_contingent = $payment_data[0]['user']['sms_contingent'];



    $new_sms_contingent = $sms_contingent + $contingent;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user/update/' . $user_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('sms_contingent' => $new_sms_contingent),
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
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/payments/update/' . $payment_database_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('payment_date' => $payment_date, 'payment_method' => $payment_method, 'contingent_added' => 'true', 'payment_status' => 'paid'),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
}