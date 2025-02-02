<?php

session_start();

// Überprüfen, ob eine der Variablen nicht gesetzt ist oder leer ist
if (
    !isset($_SESSION["user_id"]) || empty($_SESSION["user_id"]) ||
    !isset($_SESSION["username"]) || empty($_SESSION["username"]) ||
    !isset($_SESSION["email"]) || empty($_SESSION["email"])
) {

    // Weiterleitung zur Anmelde-Seite oder einer anderen Seite
    header("Location: ./sign-in");
    exit; // Stellt sicher, dass der nachfolgende Code nicht ausgeführt wird
}



$curl = curl_init(); // Initialisierung von cURL

curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user?where[email]=' . urlencode($_SESSION["email"]) . '&timestamps',
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
    )
);

$response = curl_exec($curl);
if (curl_errno($curl)) {
    echo 'Curl error: ' . curl_error($curl);
    curl_close($curl);
    exit;
}
curl_close($curl);

$data = json_decode($response);

if ($data === null) {
    echo "Fehler beim Parsen des JSON-Strings.";
} else {
    $responses = $data;


    if ($responses[0]->{'can-login'} === "Allowed") {

        //User
        $_SESSION["user_id"] = $responses[0]->id;
        $_SESSION["email"] = $responses[0]->email;

        //Names
        $_SESSION["username"] = $responses[0]->username;
        $_SESSION["name"] = $responses[0]->name;
        $_SESSION["surname"] = $responses[0]->surname;

        //Adress
        $_SESSION["street"] = $responses[0]->street;
        $_SESSION["number"] = $responses[0]->number;
        $_SESSION["zip_code"] = $responses[0]->{'zip-code'};
        $_SESSION["city"] = $responses[0]->city;
        $_SESSION["country"] = $responses[0]->country;

        // Security
        $_SESSION["can_login"] = $responses[0]->{'can-login'};
        $_SESSION["sms_contingent"] = $responses[0]->{'sms_contingent'};
        $_SESSION["own_sender"] = $responses[0]->{'own-sender'};
        $_SESSION["rank"] = $responses[0]->rank;
        $_SESSION["api_key"] = $responses[0]->{'api_key'};
        $_SESSION["api_secret"] = $responses[0]->{'api_secret'};




        /* header("Location: /v4/"); */
    } elseif ($responses[0]->{'can-login'} === "Disallowed") {
        $_SESSION["login_error_code"] = "00.200.01";
    } elseif ($responses[0]->{'can-login'} === "Fraud") {
        $_SESSION["login_error_code"] = "00.200.02";
        $_SESSION["login_error_text"] = $responses[0]->reason;
    } elseif ($responses[0]->{'can-login'} === "Review") {
        $_SESSION["login_error_code"] = "00.200.03";
        $_SESSION["login_error_text"] = $responses[0]->reason;
    }

}




// User Variabels
$GLOBAL_VARIABLE_userid = $_SESSION["user_id"];
$GLOBAL_VARIABLE_email = $_SESSION["email"];
$GLOBAL_VARIABLE_username = $_SESSION["username"];
$GLOBAL_VARIABLE_name = $_SESSION["name"];
$GLOBAL_VARIABLE_surname = $_SESSION["surname"];

//Adress
$GLOBAL_VARIABLE_address_street = $_SESSION["street"];
$GLOBAL_VARIABLE_address_number = $_SESSION["number"];
$GLOBAL_VARIABLE_address_zip = $_SESSION["zip_code"];
$GLOBAL_VARIABLE_address_place = $_SESSION["city"];
$GLOBAL_VARIABLE_address_country = $_SESSION["country"];

//Security
$GLOBAL_VARIABLE_can_login = $_SESSION["can_login"];
$GLOBAL_VARIABLE_sms_contingent = $_SESSION["sms_contingent"];
$GLOBAL_VARIABLE_own_sender = $_SESSION["own_sender"];
$GLOBAL_VARIABLE_rank = $_SESSION["rank"];
$GLOBAL_VARIABLE_api_key = $_SESSION["api_key"];
$GLOBAL_VARIABLE_api_secret = $_SESSION["api_secret"];
// echo "login $GLOBAL_VARIABLE_name";