<?php session_start(); ?>
<?php include("/auth/is-login.php"); ?>

<?php

// Zerstört die gesamte Session
session_destroy();

// Weiterleitung
header('Location: /v4/');
exit;

?>