<?php

$count = 0;

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-sender-name?where[validation-helper]=null',
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

curl_close($curl);
// echo $response;


// Antwort in ein PHP-Array umwandeln
$dataArray = json_decode($response, true);

foreach ($dataArray as $item) {
    // Die 'user'-Information wird ignoriert

    $id = $item['id'];
    $locale = $item['locale'];
    // Andere relevante Daten extrahieren
    $senderName = $item['sender-name'];
    $validationStatus = $item['validation-status'];
    $reasonForRejection = $item['reason-for-rejection'];
    $validationHelper = $item['validation-helper'];

    // Daten für die Verarbeitung speichern oder ausgeben
    // echo "ID: $id\n";
    // echo "Locale: $locale\n";
    // echo "Sender Name: $senderName\n";
    // echo "Validation Status: $validationStatus\n";
    // echo "Reason for Rejection: $reasonForRejection\n";
    // echo "Validation Helper: $validationHelper\n\n";



    $curl = curl_init();

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => 'https://api.infomaniak.com/1/llm/277',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
    "messages": [
        {
            "content": "Erkl%C3%A4rung%3A%0D%0AAls+fortschrittliche+Computer-Schnittstelle+ist+es+Ihre+Aufgabe%2C+einen+Risikoscore+zu+berechnen+und+zu+begr%C3%BCnden.+Der+Score+reicht+von+%26%2334%3B0%26%2334%3B+%28keine+Wahrscheinlichkeit+eines+Betrugs%29+bis+zu+%26%2334%3B100%26%2334%3B+%28absolute+Gewissheit+eines+Betrugs%29.+Sie+erhalten+einen+Namen+oder+eine+Abk%C3%BCrzung%2C+die+jemand+als+SMS-Absender+verwenden+m%C3%B6chte.%0D%0A%0D%0AAufgabe%3A%0D%0ABewerten+Sie+das+Risiko%2C+dass+der+angefragte+Name+f%C3%BCr+betr%C3%BCgerische+Zwecke+missbraucht+wird.+Ein+hoher+Score+soll+vergeben+werden%2C+wenn+es+sich+um+einen+bekannten+Namen+handelt%2C+der+bereits+von+etablierten+Unternehmen+verwendet+wird+oder+wenn+die+Abk%C3%BCrzung+auf+ein+solches+Unternehmen+hinweist.+Bei+Unsicherheit+vergeben+Sie+einen+Score+von+%C3%BCber+25%2C+damit+eine+manuelle+%C3%9Cberpr%C3%BCfung+erfolgen+kann.+Bitte+ermitteln+Sie%2C+ob+der+Name+oder+die+Abk%C3%BCrzung+auf+ein+bestimmtes+Unternehmen+hinweist%2C+einschlie%C3%9Flich+der+Branche%2C+in+der+das+Unternehmen+t%C3%A4tig+ist%2C+und+der+L%C3%A4nder%2C+in+denen+es+aktiv+ist.%0D%0A%0D%0ADie+Antwort+sollte+im+folgenden+JSON-Format+erfolgen%3A%0D%0A%7B%0D%0A++%26%2334%3Bscore%26%2334%3B%3A+0%2C%0D%0A++%26%2334%3Breason%26%2334%3B%3A+%26%2334%3BIhre+Begr%C3%BCndung%26%2334%3B%2C%0D%0A++%26%2334%3Bcompanys%26%2334%3B%3A+%5B%0D%0A++++%7B%0D%0A++++++%26%2334%3Bname%26%2334%3B%3A+%26%2334%3BUnternehmensname%26%2334%3B%2C%0D%0A++++++%26%2334%3Bindustries%26%2334%3B%3A+%26%2334%3BBranche%26%2334%3B%2C%0D%0A++++++%26%2334%3Bpresence%26%2334%3B%3A+%26%2334%3BAktiv+in+folgenden+L%C3%A4ndern%26%2334%3B%0D%0A++++%7D%0D%0A++%5D%0D%0A%7D%0D%0A%0D%0ADer+angefragte+Name+ist%3A+' . $senderName . '",
            "role": "user"
        }
    ]
}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer WT3OZdXYF7P6qUYCFjiRm4zNJB17cGLkfyX8JgWIwZLAOjTY8kXhjnCP9wcu1mmU7emkAmybVd3G995_',
                'Content-Type: application/json'
            ),
        )
    );

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;
// Den JSON-String in ein PHP-Objekt umwandeln
    $responseObj = json_decode($response);

    // Auf den 'content' zugreifen
    $content = $responseObj->data->choices[0]->message->content;


    $curl = curl_init();

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-sender-name/update/' . $id . '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('validation-helper' => '' . $content . ''),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
            ),
        )
    );
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    /* echo $response; */
    $count++ ;


}

echo "Executed tasks: $count";

?>