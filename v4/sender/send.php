<?php 
require_once("../auth/login-checker.php");
require_once('../log/send-logs.php');

// Überprüfe ob alle erforderlichen Felder ausgefüllt sind
if (!isset($_GET['smsto']) || !isset($_GET['smsfrom']) || !isset($_GET['smstext'])) {
    $_SESSION['sms-status'] = 'MISSING_PARAMETERS';
    header('Location: ../sms-send.php');
    exit();
}

// Überprüfen ob die Session-ID existiert
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    $_SESSION['sms-status'] = 'SESSION_ERROR';
    header('Location: ../sms-send.php');
    exit();
}

// Basis-Validierung der Telefonnummer
$phone = trim($_GET['smsto']);
if (!preg_match('/^\+?[1-9]\d{1,14}$/', $phone)) {
    $_SESSION['sms-status'] = 'INVALID_PHONE';
    header('Location: ../sms-send.php');
    exit();
}

// Platzhalter für Yellowlist-Prüfung
$needsYellowlistCheck = false; // TODO: Implementiere Yellowlist-Prüfung
if ($needsYellowlistCheck) {
    // TODO: Spezielle Behandlung für Yellowlist
}

// Validierung des Absendernamens
$isValidSender = false;
if ($GLOBALS_USER_OWNSENDER === 'Yes') {
    $isValidSender = true;
} else {
    // API-Aufruf für Absendernamen
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-sender-name?whereRelation[user][email]=' . urlencode($_SESSION['email']) . '&timestamps=null',
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
    $senderNames = json_decode($response, true);
    
    foreach ($senderNames as $sender) {
        if ($sender['validation-status'] === 'Approved' && 
            $sender['sender-name'] === $_GET['smsfrom']) {
            $isValidSender = true;
            break;
        }
    }
}

if (!$isValidSender) {
    $_SESSION['sms-status'] = 'INVALID_SENDER';
    sendLogAsync('sms.sending', $GLOBALS_USER_ID, 'sending.error', 'Invalid sender name (' . $_GET['smsfrom'] . ')');
    header('Location: ../sms-send.php');
    exit();
}

// ChatGPT API Integration für Fraud-Erkennung
function checkFraudWithGPT($smsText, $smsFrom, $countryCode) {
    $api_key = getenv('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'); // API-Key aus Umgebungsvariablen
    
    $prompt = <<<EOT
Du agierst als Fraud-System. Dir werden per API drei Parameter übermittelt:

SMS-Text
SMS-Absender
Ländercode der Empfängernummer

Dein Auftrag ist es, basierend auf diesen Daten einen Fraud-Score zu berechnen, der angibt, wie wahrscheinlich es ist, dass die SMS betrügerisch oder auf Scam ausgelegt ist. Der Score soll ein numerischer Wert zwischen 0 und 100 sein, wobei 0 für kein Betrugsrisiko und 100 für ein sehr hohes Betrugsrisiko steht.

Beachte dabei folgende Analyse-Schritte:
- Keyword-Analyse
- Absender-Analyse
- Regionale Analyse
- Score-Berechnung
- Detaillierte Begründung

Eingabe:
SMS-Absender: "$smsFrom"
Empfänger-Ländercode: "$countryCode"
SMS-Text: "$smsText"

Antworte ausschließlich im JSON-Format.
EOT;

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $api_key,
            'Content-Type: application/json',
            'X-Data-Usage-Agreement: Data must not be used for training or model improvements'
        ],
        CURLOPT_POSTFIELDS => json_encode([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a fraud detection system. Respond only in the specified JSON format.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.7
        ])
    ]);

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($httpcode !== 200) {
        throw new Exception('GPT API error');
    }

    $result = json_decode($response, true);
    $fraudAnalysis = json_decode($result['choices'][0]['message']['content'], true);
    
    return $fraudAnalysis;
}

// Fraud-Check durchführen
try {
    $countryCode = preg_replace('/^\+?/', '', $_GET['smsto']);
    $countryCode = substr($countryCode, 0, strpos($countryCode, ' ') ?: strlen($countryCode));
    
    $fraudAnalysis = checkFraudWithGPT(
        $_GET['smstext'],
        $_GET['smsfrom'],
        $countryCode
    );
    
    // Log der KI-Antwort
    sendLogAsync('sms.sending.ai', $GLOBALS_USER_ID, 'ai.response', json_encode([
        'fraud_score' => $fraudAnalysis['fraud_score'],
        'analysis' => $fraudAnalysis['analysis'],
        'sms_data' => [
            'from' => $_GET['smsfrom'],
            'country_code' => $countryCode,
            'text' => $_GET['smstext']
        ]
    ]));
    
    // Debug: Logging der finalen Entscheidung
    /* writeDebugLog([
        'fraud_score' => $fraudAnalysis['fraud_score'],
        'action' => $fraudAnalysis['fraud_score'] > 80 ? 'blocked' : 'allowed'
    ], 'fraud_decision'); */
    
    if ($fraudAnalysis['fraud_score'] > 80) {
        $_SESSION['sms-status'] = 'FRAUD_DETECTED';
        sendLogAsync('sms.sending', $GLOBALS_USER_ID, 'sending.blocked', 'Fraud detection: ' . $fraudAnalysis['analysis']['overall_assessment']);
        header('Location: ../sms-send.php');
        exit();
    }
    
} catch (Exception $e) {
    // Bei API-Fehlern fortfahren, aber loggen
    sendLogAsync('sms.sending', $GLOBALS_USER_ID, 'fraud.check.error', 'Error during fraud check: ' . $e->getMessage());
}

// SMS-Parameter vorbereiten
$smsData = [
    'to' => $_GET['smsto'],
    'from' => $_GET['smsfrom'],
    'text' => $_GET['smstext'],
    'sender_id' => $_SESSION['id'],
    'sender_ip' => $visitor_ip,
    'system' => $_GET['smssystem'],
    'callback_url' => $_GET['cburl']
];

// Provider-Auswahl (aktuell nur Nexmo)
$provider = 'nexmo';

// SMS senden
try {
    require_once("worker/{$provider}.php");
    // Die Response wird von nexmo.php zurückgegeben
    $responseData = json_decode($response, true);
    
    if (isset($responseData['messages'][0]['status']) && $responseData['messages'][0]['status'] == '0') {
        $_SESSION['sms-status'] = '0'; // Erfolg
        sendLogAsync('sms.sending', $GLOBALS_USER_ID, 'sending.success', 'The user has successfully sent a SMS');
    } else {
        $_SESSION['sms-status'] = $responseData['messages'][0]['status'] ?? 'UNKNOWN_ERROR';
        sendLogAsync('sms.sending', $GLOBALS_USER_ID, 'sending.error', 'Unknown error. Provider: ' . $provider);
    }
} catch (Exception $e) {
    $_SESSION['sms-status'] = 'SENDING_ERROR';
    sendLogAsync('sms.sending', $GLOBALS_USER_ID, 'sending.error', 'Unknown error. Provider: ' . $provider);
}

header('Location: ../sms-send.php');
exit();

