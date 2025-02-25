<?php

include_once '../v4/log/send-logs.php';

// Webhook-Daten aus dem POST-Request als JSON empfangen und dekodieren
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

// Daten in Variablen speichern
$event = $data['event'] ?? null;
$message = $data['message'] ?? null;
$payment_id = $data['payment_id'] ?? null;
$payment_method = $data['payment_method'] ?? null;

$payment_date = date('Y-m-d H:i:s');

if ($event === 'event.charge.failed') {
    sendLogAsync('titanpay.webhook', $payment_id, 'payment.event.failed', 'Payment failed: ' . $message);
    exit;
}

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
    $product_name = $payment_data[0]['product_name'];
    $contingent = $payment_data[0]['contingent'];
    $user_id = $payment_data[0]['user']['id'];
    $sms_contingent = $payment_data[0]['user']['sms_contingent'];

    // Überprüfe ob es sich um eine erfolgreiche Zahlung handelt
    if ($event !== 'event.charge.succeeded') {
        sendLogAsync('titanpay.webhook', $payment_id, 'payment.event.invalid', 'Unexpected event: ' . $event);
        http_response_code(400);
        exit;
    }

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
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($http_status !== 200 || curl_errno($curl)) {
        sendLogAsync('titanpay.webhook', $payment_id, 'api.error', 'API request failed: ' . curl_error($curl));
    }
    curl_close($curl);

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
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
        ),
    ));

    $response = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if ($http_status !== 200 || curl_errno($curl)) {
        sendLogAsync('titanpay.webhook', $payment_id, 'api.error', 'Failed to update payment status: ' . curl_error($curl));
    }

    curl_close($curl);

    // Erfolgreiche Verarbeitung
    http_response_code(200);
    sendLogAsync('titanpay.webhook', $payment_id, 'payment.processed', 'Payment processed successfully');


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/account-movements',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('relation' => $user_id, 'title' => $product_name . ' Paket', 'description' => 'SMSly', 'quantity' => $contingent, 'type' => 'positive'),
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
}
