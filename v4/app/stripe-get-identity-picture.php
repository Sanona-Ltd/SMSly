<?php

require '../vendor/autoload.php'; // Vorausgesetzt, Sie verwenden Composer für Stripe PHP SDK

use Stripe\Stripe;
use Stripe\Identity\VerificationSession;

Stripe::setApiKey('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');

// Verifizierungssitzung ID
$verificationSessionId = 'vs_1OXKz4CLtfLs0o0a0vYA7IOc';

try {
    // Verifizierungssitzung abrufen
    $verificationSession = VerificationSession::retrieve($verificationSessionId);

    // Debug: Ausgabe der abgerufenen Daten
    echo '<pre>';
    print_r($verificationSession);
    echo '</pre>';

    // URLs der Identitätsbilder abrufen
    if (isset($verificationSession['last_verification_report']['document'])) {
        $document = $verificationSession['last_verification_report']['document'];
        
        $documentFrontUrl = isset($document['front']['url']) ? $document['front']['url'] : null;
        $documentBackUrl = isset($document['back']['url']) ? $document['back']['url'] : null;

        if ($documentFrontUrl) {
            downloadAndSaveImage($documentFrontUrl, 'document_front.jpg');
        } else {
            throw new Exception('Front-Dokument-URL nicht gefunden.');
        }

        if ($documentBackUrl) {
            downloadAndSaveImage($documentBackUrl, 'document_back.jpg');
        } else {
            throw new Exception('Back-Dokument-URL nicht gefunden.');
        }

        echo "Bilder heruntergeladen und gespeichert.";
    } else {
        throw new Exception('Dokumentdaten nicht gefunden.');
    }
} catch (\Exception $e) {
    echo 'Fehler: ' . $e->getMessage();
}

function downloadAndSaveImage($url, $saveTo)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . Stripe::getApiKey()
    ]);
    $data = curl_exec($ch);
    curl_close($ch);

    if ($data) {
        file_put_contents($saveTo, $data);
    } else {
        throw new Exception('Bild konnte nicht heruntergeladen werden.');
    }
}
?>
