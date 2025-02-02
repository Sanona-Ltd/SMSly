<?php
session_start();

// Prüfen ob Benutzer angemeldet ist
if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
    // Benutzer ist angemeldet - Globale Variablen setzen
    
    // User-Daten
    $GLOBALS_USER_ID = $_SESSION["user_id"];
    $GLOBALS_USER_EMAIL = $_SESSION["email"];
    
    // Namen
    $GLOBALS_USER_USERNAME = $_SESSION["username"];
    $GLOBALS_USER_NAME = $_SESSION["name"];
    $GLOBALS_USER_SURNAME = $_SESSION["surname"];
    
    // Adresse
    $GLOBALS_USER_STREET = $_SESSION["street"];
    $GLOBALS_USER_NUMBER = $_SESSION["number"];
    $GLOBALS_USER_ZIPCODE = $_SESSION["zip_code"];
    $GLOBALS_USER_CITY = $_SESSION["city"];
    $GLOBALS_USER_COUNTRY = $_SESSION["country"];
    
    // Sicherheit & Berechtigungen
    $GLOBALS_USER_CANLOGIN = $_SESSION["can_login"];
    $GLOBALS_USER_REASON = $_SESSION["reason"];
    $GLOBALS_USER_SMSCONTINGENT = $_SESSION["sms_contingent"];
    $GLOBALS_USER_OWNSENDER = $_SESSION["own_sender"];
    $GLOBALS_USER_RANK = $_SESSION["rank"];
    
    // Zusätzliche Variablen
    $GLOBALS_USER_VERIFIED = $_SESSION["verified"];
    $GLOBALS_USER_API_KEY = $_SESSION["api_key"];
    $GLOBALS_USER_API_SECRET = $_SESSION["api_secret"];

} else {
    // Benutzer ist nicht angemeldet
    
    // Aktuelle URL für Callback erfassen, v4/ aus Pfad entfernen
    $current_url = $_SERVER['REQUEST_URI'];
    $current_url = str_replace('/v4/', '/', $current_url);
    $current_url = urlencode($current_url);
    
    // Zur Login-Seite weiterleiten mit Callback
    header("Location: /v4/sign-in.php?callback=" . $current_url);
    exit;
}
?>
