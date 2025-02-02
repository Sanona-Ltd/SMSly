<?php

session_start();

$name = $_GET['name'];
$surname = $_GET['surname'];
$email = $_GET['email'];
$password = $_GET['password'];
$password_confirmation = $_GET['password_confirmation'];

$_SESSION["name"] = "$name";
$_SESSION["surname"] = "$surname";

$usermane = "$name$surname";

// Pfad zur Datei
$dateipfad = "../../version.txt";

// Inhalt der Datei in eine Variable lesen
$inhalt = file_get_contents($dateipfad);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://auth.smsly.ch/api/register',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "username": "' . $usermane . '",
  "email": "' . $email . '",
  "password": "' . $password . '",
  "password_confirmation": "' . $password_confirmation . '",
  "g-recaptcha-response": false,
  "tos": false
}',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);



curl_close($curl);
echo $response;

if ($response === '{"requires_email_confirmation":false}') {

    // Weiterleitung
    $_SESSION["code"] = "00.010.00";
    header('Location: /' . $inhalt . '/sign-in.php');
    exit;
  }

  if ($response === '{"message":"The email has already been taken.","errors":{"email":["The email has already been taken."]}}') {

    // Weiterleitung
    $_SESSION["code"] = "00.010.14";
    header('Location: /' . $inhalt . '/sign-up.php');
    exit;
  }

  if ($response === '{"message":"The username has already been taken.","errors":{"username":["The username has already been taken."]}}') {

    // Weiterleitung
    $_SESSION["code"] = "00.010.15";
    header('Location: /' . $inhalt . '/sign-up.php');
    exit;
  }

  if ($response === '{"message":"The password confirmation does not match.","errors":{"password":["The password confirmation does not match."]}}') {

    // Weiterleitung
    $_SESSION["code"] = "00.010.16";
    header('Location: /' . $inhalt . '/sign-up.php');
    exit;
  }

  if ($response === '{"message":"The email has already been taken. (and 1 more error)","errors":{"email":["The email has already been taken."],"username":["The username has already been taken."]}}') {

    // Weiterleitung
    $_SESSION["code"] = "00.010.19";
    header('Location: /' . $inhalt . '/sign-up.php');
    exit;
  }