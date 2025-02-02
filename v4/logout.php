<?php


// Pfad zur Datei
$dateipfad = "../version.txt";
$inhalt = file_get_contents($dateipfad);

// To Delet after V4 Releas
$inhalt = "v4";



// Weiterleitung
header("Location: /$inhalt/auth-app/logout.php");
exit;
?>