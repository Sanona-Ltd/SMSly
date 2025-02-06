<?php
session_start();
require_once '../vendor/autoload.php';

// Stripe API-Key (Ersetzen Sie dies mit Ihrem tatsächlichen Secret Key)
$stripe = new \Stripe\StripeClient('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');

try {
    // Überprüfen ob Benutzer angemeldet ist
    if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
        throw new Exception("Benutzer nicht angemeldet");
    }

    // Erstellen einer neuer Verification Session
    $session = $stripe->identity->verificationSessions->create([
        'type' => 'document',
        'metadata' => [
            'user_id' => $_SESSION["user_id"]
        ],
        'return_url' => 'https://smsly.ch/v4/identity-helper',
        'options' => [
            'document' => [
                'allowed_types' => ['id_card', 'passport'],
                'require_matching_selfie' => true,
                'require_live_capture' => true
            ]
        ]
    ]);

    // Weiterleitung zur Stripe Verification URL
    header("Location: " . $session->url);
    exit();

} catch (Exception $e) {
    // Fehlerbehandlung
    echo "Ein Fehler ist aufgetreten: " . $e->getMessage();
    // Optional: Weiterleitung zur Fehlerseite
    // header("Location: /v4/error.php?message=" . urlencode($e->getMessage()));
    exit();
}