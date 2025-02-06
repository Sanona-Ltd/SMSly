<?php
session_start();

// Ermittlung der Besucher-IP
$visitor_ip = '';
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $visitor_ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $visitor_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $visitor_ip = $_SERVER['REMOTE_ADDR'];
}

// Bereinigung der IP-Adresse
$visitor_ip = filter_var($visitor_ip, FILTER_VALIDATE_IP);

// Falls keine gültige IP gefunden wurde, setze einen Standardwert
if (!$visitor_ip) {
    $visitor_ip = "0.0.0.0";
}

// Prüfen ob Benutzer angemeldet ist
if (isset($_SESSION["user_id"]) && !empty($_SESSION["user_id"])) {
    // API-Abfrage für aktuelle Benutzerdaten
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user?where[email]=' . urlencode($_SESSION["email"]) . '&timestamps=null',
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
    
    $userData = json_decode($response, true);
    
    if (!empty($userData) && is_array($userData) && isset($userData[0])) {
        $user = $userData[0];
        
        // Session-Variablen mit aktuellen Daten aktualisieren
        $_SESSION["email"] = $user["email"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["surname"] = $user["surname"];
        $_SESSION["street"] = $user["street"];
        $_SESSION["number"] = $user["number"];
        $_SESSION["zip_code"] = $user["zip-code"];
        $_SESSION["city"] = $user["city"];
        $_SESSION["country"] = $user["country"];
        $_SESSION["can_login"] = $user["can-login"];
        $_SESSION["reason"] = $user["reason"];
        $_SESSION["sms_contingent"] = $user["sms_contingent"];
        $_SESSION["own_sender"] = $user["own-sender"];
        $_SESSION["rank"] = $user["rank"];
        $_SESSION["verified"] = $user["verified"];
        $_SESSION["api_key"] = $user["api_key"];
        $_SESSION["api_secret"] = $user["api_secret"];
        
        // Globale Variablen setzen
        $GLOBALS_USER_ID = $_SESSION["user_id"];
        $GLOBALS_USER_EMAIL = $_SESSION["email"];
        $GLOBALS_USER_USERNAME = $_SESSION["username"];
        $GLOBALS_USER_NAME = $_SESSION["name"];
        $GLOBALS_USER_SURNAME = $_SESSION["surname"];
        $GLOBALS_USER_STREET = $_SESSION["street"];
        $GLOBALS_USER_NUMBER = $_SESSION["number"];
        $GLOBALS_USER_ZIPCODE = $_SESSION["zip_code"];
        $GLOBALS_USER_CITY = $_SESSION["city"];
        $GLOBALS_USER_COUNTRY = $_SESSION["country"];
        $GLOBALS_USER_CANLOGIN = $_SESSION["can_login"];
        $GLOBALS_USER_REASON = $_SESSION["reason"];
        $GLOBALS_USER_SMSCONTINGENT = $_SESSION["sms_contingent"];
        $GLOBALS_USER_OWNSENDER = $_SESSION["own_sender"];
        $GLOBALS_USER_RANK = $_SESSION["rank"];
        $GLOBALS_USER_VERIFIED = $_SESSION["verified"];
        $GLOBALS_USER_API_KEY = $_SESSION["api_key"];
        $GLOBALS_USER_API_SECRET = $_SESSION["api_secret"];

        // Überprüfung des Verifizierungsstatus und erlaubte Seiten
        if ($GLOBALS_USER_VERIFIED === "false") {
            $current_path = $_SERVER['REQUEST_URI'];
            $allowed_pages = array(
                '/v4/identity',
                '/v4/identity-helper',
                '/v4/auth/stripe-identity'
            );
            
            $is_allowed = false;
            foreach ($allowed_pages as $page) {
                if (strpos($current_path, $page) !== false) {
                    $is_allowed = true;
                    break;
                }
            }
            
            if (!$is_allowed) {
                header("Location: /v4/identity");
                exit;
            }
        }
    }
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
