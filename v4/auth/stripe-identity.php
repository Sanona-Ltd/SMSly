<?php
session_start();
require_once '../../vendor/autoload.php';

// Stripe API-Key (Ersetzen Sie dies mit Ihrem tatsächlichen Secret Key)
$stripe = new \Stripe\StripeClient('sk_test_YOUR_STRIPE_SECRET_KEY');

try {
    // Überprüfen ob Benutzer angemeldet ist
    if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
        throw new Exception("Benutzer nicht angemeldet");
    }

    // Erstellen einer neuen Verification Session
    $session = $stripe->identity->verificationSessions->create([
        'type' => 'document',
        'metadata' => [
            'user_id' => $_SESSION["user_id"]
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