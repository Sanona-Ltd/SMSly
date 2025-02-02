<?php

function sendLogAsync($type, $user, $action, $storage)
{
    // API-URL und Token
    $apiUrl = 'https://cdn.sanona.org/api/b872c5a521a44cc0983443494237e81e/logs';
    $bearerToken = 'hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB';

    // Daten vorbereiten
    $postData = http_build_query([
        'type' => $type,
        'user' => $user,
        'action' => $action,
        'storage' => $storage
    ]);

    // Asynchroner Request
    $cmd = "curl -X POST -H 'Content-Type: application/x-www-form-urlencoded' "
        . "-H 'Authorization: Bearer $bearerToken' "
        . "-d \"$postData\" '$apiUrl' > /dev/null 2>&1 &";

    // Shell-Befehl ausführen
    exec($cmd);
}

// Beispielnutzung
// sendLogAsync('user.login.success', '20', 'signin.default', 'The user has successfully logged in');

?>