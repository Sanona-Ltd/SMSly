<?php

// Empfangen des Webhook-Payloads
$payload = @file_get_contents('php://input');
$event = json_decode($payload, true);

// Überprüfen ob es sich um ein gültiges Event handelt
if ($event && $event['object'] === 'identity.verification_session') {
    $session = $event;
    
    // User ID aus den Metadaten extrahieren
    $userId = isset($session['metadata']['user_id']) ? $session['metadata']['user_id'] : null;
    
    // Überprüfen ob die Verifizierung erfolgreich war
    if ($session['status'] === 'verified' && $userId) {
        // Hier können Sie die gewünschte Aktion ausführen
        handleSuccessfulVerification($userId);
    }
}

/**
 * Verarbeitet eine erfolgreiche Identitätsverifizierung
 * @param string $userId Die ID des verifizierten Benutzers
 */
function handleSuccessfulVerification($userId) {
    global $db;
    
    try {
        // Aktualisieren des Verifizierungsstatus in der Datenbank
        
        // API-Aufruf an Sanona
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user/update/$userId",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('verified' => 'true'),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Überprüfen des API-Responses
        if ($httpCode !== 200) {
            throw new Exception("API-Aufruf fehlgeschlagen. HTTP-Code: " . $httpCode . ", Response: " . $response);
        }
        
    } catch (Exception $e) {
        error_log("Fehler bei der Verarbeitung der Identitätsverifizierung: " . $e->getMessage());
    }
}
