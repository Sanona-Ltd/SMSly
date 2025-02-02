<?php

function generateRandomString($length = 10)
    {
        // Zeichensatz definieren, aus dem der zufällige String generiert werden soll
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';

        // Zufälligen String generieren
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user?where[email]=florin.schildknecht%40sanona.org&timestamps=null',
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


// Annahme: $response enthält die JSON-Antwort
$responseArray = json_decode($response, true);

// Überprüfen, ob die Antwort ein Array ist und mindestens ein Element enthält
if (is_array($responseArray) && count($responseArray) > 0) {
    // Zugriff auf das erste Element des Arrays
    $firstItem = $responseArray[0];

    // Speichern der Werte in separate Variablen
    $apiKey = $firstItem['api_key'];
    $apiSecret = $firstItem['api_secret'];

    // Beispiel, um zu demonstrieren, wie man eine Variable verwendet
    // echo "Name: $name, Stadt: $city";
}

// Wenn Sie separat prüfen möchten, ob BEIDE leer sind
if (empty($apiKey) && empty($apiSecret)) {

    

    // Zufälligen String generieren und in einer Variable speichern
    $GLOBAL_VARIABLE_api_key = generateRandomString(10); // Sie können die Länge anpassen, indem Sie einen anderen Wert als 10 übergeben
    $GLOBAL_VARIABLE_api_secret = generateRandomString(20); // Sie können die Länge anpassen, indem Sie einen anderen Wert als 10 übergeben

    // Zufälligen String ausgeben
    // echo $randomString;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user/update/20',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('api_key' => '' . $GLOBAL_VARIABLE_api_key . '', 'api_secret' => '' . $GLOBAL_VARIABLE_api_secret . ''),
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
}
