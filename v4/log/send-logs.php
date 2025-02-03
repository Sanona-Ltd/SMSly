<?php

function sendLogAsync($type, $user, $action, $storage)
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/logs',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'type' => $type,
            'user' => $user,
            'action' => $action,
            'storage' => $storage
        ),
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
        ),
    ));

    $response = curl_exec($curl);
    $error = curl_error($curl);
    curl_close($curl);

    // Optional: Fehlerbehandlung
    if ($error) {
        error_log("Log API Error: " . $error);
    }

    return $response;
}

// Beispielnutzung
sendLogAsync('sms.sending', '0', 'signin.default', 'The user has successfully logged in');

?>