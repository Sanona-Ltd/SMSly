<?php
session_start();
$auth_id = $_SESSION['id'];



$curl = curl_init();

$api_key = 'XXXXXXXXXX';
$api_secret = 'XXXXXXXXXX';
$to = '41XXXXXXXXX';
$from = 'Sendername';
$text = 'Hey, this is a test';

$post_data = [
    'apy_key' => $api_key,
    'apy_secret' => $api_secret,
    'to' => $to,
    'from' => $from,
    'text' => $text,
];

$url = 'https://smsly.ch/v2/api/';

curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => http_build_query($post_data),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded'
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
