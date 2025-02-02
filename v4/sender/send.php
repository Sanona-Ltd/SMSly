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

