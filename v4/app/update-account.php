<?php
session_start();

$user_id = $_SESSION["user_id"];
$first_name = $_GET["first_name"] ?? null;
$last_name = $_GET["last_name"] ?? null;
$address_street = $_GET["address_street"] ?? null;
$address_number = $_GET["address_number"] ?? null;
$address_zip = $_GET["address_zip"] ?? null;
$address_place = $_GET["address_place"] ?? null;

$curl = curl_init();

// Erstellen eines Arrays für die zu sendenden Daten
/* $data = [];
if ($username !== null) $data['username'] = $username;
if ($first_name !== null) $data['first_name'] = $first_name;
if ($last_name !== null) $data['last_name'] = $last_name;
if ($address !== null) $data['address'] = $address; */
/* if ($email !== null) $data['email'] = $email; */

echo "</br></br></br></br>ID: $user_id, </br>Name: $first_name, </br>Nachname: $last_name, </br>Street: $address_street, </br>Number: $address_number, </br>PLZ: $address_zip, </br>City: $address_place,</br></br></br></br>";



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user/update/' . $user_id . '',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('name' => '' . $first_name . '', 'surname' => '' . $last_name . '', 'street' => '' . $address_street . '', 'number' => '' . $address_number . '', 'address-suffix' => '', 'zip-code' => '' . $address_zip . '', 'city' => '' . $address_place . '', 'country' => 'Switzerland'),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;



// Konvertiere JSON in ein PHP-Array
// $responseArray = json_decode($responseJson, true);

// Extrahiere die Werte in separate Variablen
// $id = $responseArray['id'];
// $locale = $responseArray['locale'];
// $createdAt = $responseArray['created_at'];
// $updatedAt = $responseArray['updated_at'];
// $publishedAt = $responseArray['published_at'];
// $email = $responseArray['email'];
// $username = $responseArray['username'];
// $password = $responseArray['password'];
// $name = $responseArray['name'];
// $surname = $responseArray['surname'];
// $street = $responseArray['street'];
// $number = $responseArray['number'];
// $zipCode = $responseArray['zip-code'];
// $city = $responseArray['city'];
// $country = $responseArray['country'];
// $canLogin = $responseArray['can-login'];
// $reason = $responseArray['reason'];
// $smsContingent = $responseArray['sms_contingent'];
// $ownSender = $responseArray['own-sender'];
// $rank = $responseArray['rank'];

// Beispiel, um einige der Variablen zu verwenden
// echo "</br></br>ID: $id, </br>Name: $name, </br>Nachname: $surname, </br>Street: $street, </br>Number: $number, </br>PLZ: $zipCode, </br>City: $city,";
// Update Infos - END








header("Location: ../account-settings");
/* exit(); */