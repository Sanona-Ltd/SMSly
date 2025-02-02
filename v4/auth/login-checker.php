<?php
session_start();

// Prüfen ob Benutzer angemeldet ist
if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
    // Benutzer ist angemeldet - Globale Variablen setzen
    
    // User-Daten
    $GLOBALS["GLOBAL_VARIABLE_USER_ID"] = $_SESSION["user_id"];
    $GLOBALS["GLOBAL_VARIABLE_USER_EMAIL"] = $_SESSION["email"];
    
    // Namen
    $GLOBALS["GLOBAL_VARIABLE_USER_USERNAME"] = $_SESSION["username"];
    $GLOBALS["GLOBAL_VARIABLE_USER_NAME"] = $_SESSION["name"];
    $GLOBALS["GLOBAL_VARIABLE_USER_SURNAME"] = $_SESSION["surname"];
    
    // Adresse
    $GLOBALS["GLOBAL_VARIABLE_USER_STREET"] = $_SESSION["street"];
    $GLOBALS["GLOBAL_VARIABLE_USER_NUMBER"] = $_SESSION["number"];
    $GLOBALS["GLOBAL_VARIABLE_USER_ZIPCODE"] = $_SESSION["zip_code"];
    $GLOBALS["GLOBAL_VARIABLE_USER_CITY"] = $_SESSION["city"];
    $GLOBALS["GLOBAL_VARIABLE_USER_COUNTRY"] = $_SESSION["country"];
    
    // Sicherheit & Berechtigungen
    $GLOBALS["GLOBAL_VARIABLE_USER_CANLOGIN"] = $_SESSION["can_login"];
    $GLOBALS["GLOBAL_VARIABLE_USER_SMSCONTINGENT"] = $_SESSION["sms_contingent"];
    $GLOBALS["GLOBAL_VARIABLE_USER_OWNSENDER"] = $_SESSION["own_sender"];
    $GLOBALS["GLOBAL_VARIABLE_USER_RANK"] = $_SESSION["rank"];

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
