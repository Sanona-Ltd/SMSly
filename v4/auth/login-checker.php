<?php
session_start();

// Prüfen ob Benutzer angemeldet ist
if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
    // Benutzer ist angemeldet - Globale Variablen setzen
    
    // User-Daten
    $GLOBALS["USER_ID"] = $_SESSION["user_id"];
    $GLOBALS["USER_EMAIL"] = $_SESSION["email"];
    
    // Namen
    $GLOBALS["USER_USERNAME"] = $_SESSION["username"];
    $GLOBALS["USER_NAME"] = $_SESSION["name"];
    $GLOBALS["USER_SURNAME"] = $_SESSION["surname"];
    
    // Adresse
    $GLOBALS["USER_STREET"] = $_SESSION["street"];
    $GLOBALS["USER_NUMBER"] = $_SESSION["number"];
    $GLOBALS["USER_ZIPCODE"] = $_SESSION["zip_code"];
    $GLOBALS["USER_CITY"] = $_SESSION["city"];
    $GLOBALS["USER_COUNTRY"] = $_SESSION["country"];
    
    // Sicherheit & Berechtigungen
    $GLOBALS["USER_CANLOGIN"] = $_SESSION["can_login"];
    $GLOBALS["USER_REASON"] = $_SESSION["reason"];
    $GLOBALS["USER_SMSCONTINGENT"] = $_SESSION["sms_contingent"];
    $GLOBALS["USER_OWNSENDER"] = $_SESSION["own_sender"];
    $GLOBALS["USER_RANK"] = $_SESSION["rank"];
    
    // Zusätzliche Variablen
    $GLOBALS["USER_VERIFIED"] = $_SESSION["verified"];
    $GLOBALS["USER_API_KEY"] = $_SESSION["api_key"];
    $GLOBALS["USER_API_SECRET"] = $_SESSION["api_secret"];

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
