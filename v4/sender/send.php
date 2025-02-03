<?php 
require_once("../auth/login-checker.php");

// Überprüfe ob alle erforderlichen Felder ausgefüllt sind
if (!isset($_GET['smsto']) || !isset($_GET['smsfrom']) || !isset($_GET['smstext'])) {
    $_SESSION['sms-status'] = 'MISSING_PARAMETERS';
    header('Location: ../sms-send.php');
    exit();
}

// Basis-Validierung der Telefonnummer
$phone = trim($_GET['smsto']);
if (!preg_match('/^\+?[1-9]\d{1,14}$/', $phone)) {
    $_SESSION['sms-status'] = 'INVALID_PHONE';
    header('Location: ../sms-send.php');
    exit();
}

// Platzhalter für Blacklist-Prüfung
$isBlacklisted = false; // TODO: Implementiere Blacklist-Prüfung
if ($isBlacklisted) {
    $_SESSION['sms-status'] = 'BLACKLISTED';
    header('Location: ../sms-send.php');
    exit();
}

// Platzhalter für Yellowlist-Prüfung
$needsYellowlistCheck = false; // TODO: Implementiere Yellowlist-Prüfung
if ($needsYellowlistCheck) {
    // TODO: Spezielle Behandlung für Yellowlist
}

// Validierung des Absendernamens
$isValidSender = false;
if ($GLOBALS_USER_OWNSENDER === 'Yes') {
    $isValidSender = true;
} else {
    // API-Aufruf für Absendernamen
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-sender-name?whereRelation[user][email]=' . urlencode($_SESSION['email']) . '&timestamps=null',
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
    $senderNames = json_decode($response, true);
    
    foreach ($senderNames as $sender) {
        if ($sender['validation-status'] === 'Approved' && 
            $sender['sender-name'] === $_GET['smsfrom']) {
            $isValidSender = true;
            break;
        }
    }
}

if (!$isValidSender) {
    $_SESSION['sms-status'] = 'INVALID_SENDER';
    header('Location: ../sms-send.php');
    exit();
}

// SMS-Parameter vorbereiten
$smsData = [
    'to' => $_GET['smsto'],
    'from' => $_GET['smsfrom'],
    'text' => $_GET['smstext'],
    'sender_id' => $_GET['sender_id'],
    'sender_ip' => $_GET['sender_ip'],
    'system' => $_GET['smssystem'],
    'callback_url' => $_GET['cburl']
];

// Provider-Auswahl (aktuell nur Nexmo)
$provider = 'nexmo';

// SMS senden
try {
    require_once("worker/{$provider}.php");
    // Die Response wird von nexmo.php zurückgegeben
    $responseData = json_decode($response, true);
    
    if (isset($responseData['messages'][0]['status']) && $responseData['messages'][0]['status'] == '0') {
        $_SESSION['sms-status'] = '0'; // Erfolg
    } else {
        $_SESSION['sms-status'] = $responseData['messages'][0]['status'] ?? 'UNKNOWN_ERROR';
    }
} catch (Exception $e) {
    $_SESSION['sms-status'] = 'SENDING_ERROR';
}

header('Location: ../sms-send.php');
exit();

