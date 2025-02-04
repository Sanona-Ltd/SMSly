<?php

$product_name = $_GET['product'];
require_once '../../auth/login-checker.php';


$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/product?where[product_id]=' . $product_name,
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

// JSON Response dekodieren
$response_data = json_decode($response, true);

// Daten aus dem ersten Element extrahieren
$product_id = $response_data[0]['product_id'];
$product_name = $response_data[0]['name'];
$product_description = $response_data[0]['description'];
$product_contingent = $response_data[0]['contingent'];
$product_price = $response_data[0]['price'];
$product_locale = $response_data[0]['locale'];
$product_is_public = $response_data[0]['is-public'];
$product_badge_public = $response_data[0]['badge-public'];
$product_id_internal = $response_data[0]['id'];

$product_price = $product_price * 100;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.titanpay.ch?amount=' . $product_price . '&callback=https%3A%2F%2Fsmsly.ch%2Fv4%2Fpayment-history&message=Auf%20dem%20Kontoauszug%20ist%20%3Cb%3ESanona%20Ltd.%3C%2Fb%3E%20angegeben%2C%20bei%20der%20es%20sich%20um%20unsere%20Muttergesellschaft%20handelt.&cancel=https%3A%2F%2Fsmsly.ch%2Fv4%2Fadd-credits',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'api-key: 0194cb57-d332-7252-b3bb-c53d49b3e102'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;

// JSON Response dekodieren
$response_data = json_decode($response, true);

// Hauptvariablen extrahieren
$payment_status = $response_data['status'];

// Daten aus dem data-Objekt extrahieren
$payment_amount = $response_data['data']['amount'];
$payment_id = $response_data['data']['id'];
$payment_url = $response_data['data']['url'];
$payment_company = $response_data['data']['company_name'];

$payment_date = date('d.m.Y');
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/payments',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('user' => $GLOBALS_USER_ID,'hash' => $payment_id,'link' => $payment_url,'payment_id' => $payment_id,'product' => $product_id,'contingent' => $product_contingent,'price' => $product_price,'product_name' => $product_name,'payment_date' => $payment_date,'contingent_added' => 'false ','payment_status' => 'open'),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;

header('Location: ' . $payment_url);
