<?php

require 'vendor/autoload.php';

// Setzen Sie Ihren geheimen Schlüssel sicher. Vermeiden Sie es, den Schlüssel direkt im Code zu hartcodieren.
\Stripe\Stripe::setApiKey('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');

// Ersetzen Sie 'vs_1OgnXdLo0trzi5hlUXqMnXMH' mit der ID Ihrer Verification Session
$session = \Stripe\Identity\VerificationSession::retrieve('vs_1OXKz4CLtfLs0o0a0vYA7IOc');

// Zugriff auf das Verification Report Objekt
if (isset($session->last_verification_report)) {
    $reportId = $session->last_verification_report;
    $report = \Stripe\Identity\VerificationReport::retrieve($reportId);

    // Korrigierte Überprüfung, ob Dokumentinformationen verfügbar sind
    if (isset($report->document) && isset($report->document->front) && !empty($report->document->front->url)) {
        // Die URL direkt vom 'front' Objekt abrufen
        $frontImageUrl = $report->document->front->url;

        // Zum Herunterladen des Bildes (Beispiel)
        $imageContent = file_get_contents($frontImageUrl);
        if ($imageContent !== false) {
            $savePath = '/save/front_image.jpg'; // Stellen Sie sicher, dass dieser Pfad existiert und beschreibbar ist
            file_put_contents($savePath, $imageContent);
        } else {
            echo "Fehler beim Herunterladen des Bildes.";
        }
    } else {
        echo "Dokument oder Vorderseite des Dokuments ist nicht korrekt verfügbar.";
    }
} else {
    echo "Kein Verification Report verfügbar.";
}

?>
