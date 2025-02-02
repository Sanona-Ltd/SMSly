<?php
session_start();
$auth_id = $_SESSION['id'];

$product = $_GET["product"];

$erlaubteZeichen = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$refid = substr(str_shuffle($erlaubteZeichen), 0, 50);

echo $refid;



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

$sql = "SELECT `id`, `product_id`, `name`, `description`, `contingent`, `price`, `reg_date` FROM `products` WHERE product_id = $product";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    
    $id = $row["id"];
    $product_id = $row["product_id"];
    $name = $row["name"];
    $description = $row["description"];
    $contingent = $row["contingent"];
    $price = $row["price"];
    $reg_date = $row["reg_date"];

    

  }
} else {
  echo "0 results";
}





$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.sanona.org/pay/examples/payment.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('amount' => '' . $price . '','lookandfeel' => '3d2182ce','secret' => '1sP11s5K8PB6wRDKK3urvW6WPELjbh','currency' => 'CHF','successredirecturl' => 'https://smsly.ch/v3/payment-history?id=' . $refid . '&s=success','failedredirecturl' => 'https://smsly.ch/v3/payment-history?id=' . $refid . '&s=failed','cancelredirecturl' => 'https://smsly.ch/v3/payment-history?id=' . $refid . '&s=cancel','referenceid' => '' . $refid . '','psp' => '3, 44, 36, 15, 11','preauthorization' => 'false','chargeonauthorization' => 'false'),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

echo '</br></br></br></br></br>';

$data = json_decode($response, true);

// Separate Variablen für jede Position erstellen
$ID = $data['ID'];
$referenceid = $data['referenceid'];
$Hash = $data['Hash'];
$link = $data['link'];

// Jetzt kannst du auf die einzelnen Werte in ihren eigenen Variablen zugreifen
echo "ID: " . $ID . "<br>";
echo "referenceid: " . $referenceid . "<br>";
echo "Hash: " . $Hash . "<br>";
echo "link: " . $link . "<br>";

$price = $price * 100;
$aktuellesDatum = date('Y-m-d H:i:s');

$sql = "INSERT INTO `payments`(`user_id`, `hash`, `link`, `payment_id`, `product`, `contingent`, `price`, `product_name`, `payment_date`, `payment_status`) 
VALUES ('$auth_id','$Hash','$link','$referenceid','$product','$contingent','$price','$name','$aktuellesDatum','0')";

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


    header('Location: ' . $link . '');
    // or die();
    exit();