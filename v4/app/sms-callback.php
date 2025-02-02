<?php
session_start();
$status = $_GET["status"];


$_SESSION["sms-status"] = "$status";
header("Location: ../sms-send");

?>