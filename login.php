<?php


// Pfad zur Datei
$dateipfad = "version.txt";

// Inhalt der Datei in eine Variable lesen
$inhalt = file_get_contents($dateipfad);

// Inhalt ausgeben (optional)
// echo $inhalt;


// Weiterleitung
header("Location: /$inhalt/");
exit;
?>