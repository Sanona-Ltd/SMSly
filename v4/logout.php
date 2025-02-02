<?php
include_once 'log/send-logs.php';

// Session starten (falls noch nicht geschehen)
session_start();

// User-ID aus Session holen
$user_id = $_SESSION["user_id"];

// Log schreiben
sendLogAsync('user.logout', $user_id, 'signout.default', 'The user has successfully logged out');

// Alle Session-Variablen löschen
$_SESSION = array();

// Session-Cookie löschen
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Session zerstören
session_destroy();

// Weiterleitung zur Hauptseite
header("Location: ../");
exit;
?>