<?php

// Überprüfen, ob es sich um eine POST-Anfrage handelt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Die gewünschten Werte aus den URL-kodierten Parametern abrufen
    $referenceId = $_POST['transaction']['referenceId'];
    $status = $_POST['transaction']['status'];
    $psp = $_POST['transaction']['psp'];
    $amount = $_POST['transaction']['amount'];

    // Ausgabe der Werte
    echo "referenceId: " . $referenceId . "<br>";
    echo "status: " . $status . "<br>";
    echo "psp: " . $psp . "<br>";
    echo "amount: " . $amount . "<br>";
} else {
    // Fehlerbehandlung, falls keine POST-Anfrage vorliegt
    echo "Dies ist keine POST-Anfrage.";
}

if ($status == "confirmed") {



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



    $sql = "SELECT `id`, `user_id`, `hash`, `link`, `payment_id`, `product`, `contingent`, `payment_status`, `reg_date` FROM `payments` WHERE `payment_id` = '$referenceId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {

            $id = $row["id"];
            $user_id = $row["user_id"];
            $hash = $row["hash"];
            $link = $row["link"];
            $payment_id = $row["payment_id"];
            $product = $row["product"];
            $contingent = $row["contingent"];
            $payment_status = $row["payment_status"];
            $reg_date = $row["reg_date"];

        }
    } else {
        echo "</br> PaymentID not from SMSly.ch </br>";
        exit();
    }

    if($payment_status == 9){
        exit("Zahlung bereits registriert");
    } else {

    $sql = "UPDATE `payments` SET `payment_status`='9' WHERE `payment_id` = '$referenceId'";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "</br></br>Error updating record: " . $conn->error . "</br></br>";
    }



    $sql = "SELECT `id`, `user_id`, `firstname`, `lastname`, `api_key`, `api_secret`, `sms_contingent`, `reg_date` FROM `api_users` WHERE `user_id` = '$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            
            $id = $row["id"];
            $user_id = $row["user_id"];
            $firstname = $row["firstname"];
            $lastname = $row["lastname"];
            $api_key = $row["api_key"];
            $api_secret = $row["api_secret"];
            $sms_contingent = $row["sms_contingent"];
            $reg_date = $row["reg_date"];


        }
    } else {
        echo "</br></br>0 results</br></br>";
    }

    $new_contigent = $sms_contingent + $contingent;

    echo " </br></br></br></br>
    Aktuelles Kontigent: $sms_contingent</br>
    Plus Kontigent: $contingent</br>
    Neues Kontigent: $new_contigent</br>
    ";



    $sql = "UPDATE `api_users` SET `sms_contingent`='$new_contigent' WHERE user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }




    }
    $conn->close();
}

?>