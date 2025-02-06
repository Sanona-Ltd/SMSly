<?php
// Stelle sicher, dass keine Ausgaben vor dem Header gesendet werden
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verifizierung läuft</title>
</head>
<body>
    <div id="status">Verifizierung wird überprüft...</div>

    <script>
    function checkVerification() {
        fetch('check-verification.php')
            .then(response => response.json())
            .then(data => {
                if (data.length > 0 && data[0].verified === "true") {
                    window.location.href = '/v4/'; // Hier die Ziel-URL anpassen
                }
            })
            .catch(error => console.error('Fehler:', error));
    }

    // Prüfe alle 3 Sekunden
    setInterval(checkVerification, 3000);
    </script>
</body>
</html>
