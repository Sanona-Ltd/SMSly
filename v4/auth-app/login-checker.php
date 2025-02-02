<?php
session_start();

// Prüfen ob Benutzer angemeldet ist
if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
    // Benutzer ist angemeldet - Globale Variablen setzen
    
    // User-Daten
    $GLOBALS["GLOBAL_USER_ID"] = $_SESSION["user_id"];
    $GLOBALS["GLOBAL_USER_EMAIL"] = $_SESSION["email"];
    
    // Namen
    $GLOBALS["GLOBAL_USER_USERNAME"] = $_SESSION["username"];
    $GLOBALS["GLOBAL_USER_NAME"] = $_SESSION["name"];
    $GLOBALS["GLOBAL_USER_SURNAME"] = $_SESSION["surname"];
    
    // Adresse
    $GLOBALS["GLOBAL_USER_STREET"] = $_SESSION["street"];
    $GLOBALS["GLOBAL_USER_NUMBER"] = $_SESSION["number"];
    $GLOBALS["GLOBAL_USER_ZIPCODE"] = $_SESSION["zip_code"];
    $GLOBALS["GLOBAL_USER_CITY"] = $_SESSION["city"];
    $GLOBALS["GLOBAL_USER_COUNTRY"] = $_SESSION["country"];
    
    // Sicherheit & Berechtigungen
    $GLOBALS["GLOBAL_USER_CANLOGIN"] = $_SESSION["can_login"];
    $GLOBALS["GLOBAL_USER_SMSCONTINGENT"] = $_SESSION["sms_contingent"];
    $GLOBALS["GLOBAL_USER_OWNSENDER"] = $_SESSION["own_sender"];
    $GLOBALS["GLOBAL_USER_RANK"] = $_SESSION["rank"];

} else {
    // Benutzer ist nicht angemeldet
    
    // Aktuelle URL für Callback erfassen
    $current_url = urlencode($_SERVER['REQUEST_URI']);
    
    // Zur Login-Seite weiterleiten mit Callback
    header("Location: /v4/sign-in.php?callback=" . $current_url);
    exit;
}
?>
