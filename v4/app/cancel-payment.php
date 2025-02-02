<?php

$hash = $_GET["id"];


$servername = "localhost";
$username = "smsly_sms";
$password = "4^Y9F5y3amjecvFms";
$dbname = "smsly_sms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE `payments` SET `payment_status`='4' WHERE `hash` = '$hash' ";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
header('Location: ../payment-history');
