<?php

// Stripe Webhook Payload empfangen
$payload = @file_get_contents('php://input');
$event = json_decode($payload, true);

// Logging für Debugging-Zwecke
error_log("Stripe Webhook empfangen: " . print_r($event, true));
echo "Stripe Webhook empfangen: " . print_r($event, true);

// Überprüfen ob es sich um ein gültiges Verifizierungs-Event handelt
if ($event && isset($event['data']['object']) && $event['data']['object']['object'] === 'identity.verification_session') {
    $verificationSession = $event['data']['object'];
    
    // User ID aus den Metadaten extrahieren
    $userId = isset($verificationSession['metadata']['user_id']) ? $verificationSession['metadata']['user_id'] : null;
    
    // Überprüfen ob die Verifizierung erfolgreich war
    if ($verificationSession['status'] === 'verified' && $userId) {
        handleSuccessfulVerification($userId);
    } else {
        error_log("Verifizierung nicht erfolgreich oder keine User ID gefunden. Status: " . 
                 $verificationSession['status'] . ", User ID: " . $userId);
                 echo "Verifizierung nicht erfolgreich oder keine User ID gefunden. Status: " . $verificationSession['status'] . ", User ID: " . $userId;
    }
} else {
    error_log("Ungültiges oder nicht unterstütztes Webhook-Event empfangen");
    echo "Ungültiges oder nicht unterstütztes Webhook-Event empfangen";
}

/**
 * Verarbeitet eine erfolgreiche Identitätsverifizierung
 * @param string $userId Die ID des verifizierten Benutzers
 */
function handleSuccessfulVerification($userId) {
    try {
        // API-Aufruf an Sanona
        $curl = curl_init();
        $apiEndpoint = "https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user/update/" . $userId;
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiEndpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['verified' => true]),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
            ),
        ));

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if (curl_errno($curl)) {
            throw new Exception("cURL Fehler: " . curl_error($curl));
        }
        
        curl_close($curl);

        // Response überprüfen
        if ($httpCode !== 200) {
            throw new Exception("API-Aufruf fehlgeschlagen. HTTP-Code: " . $httpCode . ", Response: " . $response);
        }

        error_log("Verifizierung erfolgreich aktualisiert für User ID: " . $userId);
        echo "Verifizierung erfolgreich aktualisiert für User ID: " . $userId;
    } catch (Exception $e) {
        error_log("Fehler bei der Verarbeitung der Identitätsverifizierung: " . $e->getMessage());
        http_response_code(500);
        echo "Fehler bei der Verarbeitung der Identitätsverifizierung: " . $e->getMessage();
    }
}
