<?php

session_start();

// Eingaben validieren und säubern (Beispiel mit filter_input)
$username = filter_input(INPUT_GET, 'username', FILTER_SANITIZE_STRING);
/* $surname = filter_input(INPUT_GET, 'surname', FILTER_SANITIZE_STRING); */
$email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_STRING);
$password_confirmation = filter_input(INPUT_GET, 'password_confirmation', FILTER_SANITIZE_STRING);

$_SESSION["name"] = $name;
$_SESSION["surname"] = $surname;

/* function generateRandomString($length = 10) {
  return bin2hex(random_bytes($length));
}

$randomString = generateRandomString(10); // Generiert einen 20 Zeichen langen zufälligen String

$username = $name . "." . $surname . "----$randomString"; */ // Korrektur des Variablennamens

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
  CURLOPT_POSTFIELDS => json_encode(array(
    "username" => $username,
    "email" => $email,
    "password" => $password,
    "password_confirmation" => $password_confirmation,
    "g-recaptcha-response" => false,
    "tos" => false
  )),
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);

// Konvertieren Sie die Antwort in ein Array
$responseArray = json_decode($response, true);

// Initialisieren Sie die Variable für die Fehlermeldungen
$errorMessages = "";

// Überprüfen Sie, ob der 'errors' Schlüssel existiert
if (isset($responseArray['errors'])) {
    // Durchlaufen Sie alle Fehler
    foreach ($responseArray['errors'] as $errors) {
        foreach ($errors as $error) {
            // Fügen Sie jeden Fehler zur Fehlermeldungsvariable hinzu
            $errorMessages .= "- " . $error . "</br>";
        }
    }
    $_SESSION["errorText"] = $errorMessages;
    header('Location: /' . urlencode($inhalt) . '/sign-up.php');
    exit;
}

// Weiterleitung, wenn keine Fehler vorhanden sind
$_SESSION["code"] = "00.010.00";
header('Location: /' . urlencode($inhalt) . '/sign-in.php');
exit;
?>
