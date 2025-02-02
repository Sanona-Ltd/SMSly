<?php
// Start the session
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

// Pfad zur Datei
$dateipfad = "../../version.txt";

// Inhalt der Datei in eine Variable lesen
$inhalt = file_get_contents($dateipfad);

// Inhalt ausgeben (optional)
// echo $inhalt;


// Weiterleitung
/* header("Location: /$inhalt/sign-up.php"); */
/* exit; */

/* echo "
User: $email </br>
PW: $password </br>
"; */

$email_encoded = urlencode($email);
$password_encoded = urlencode($password);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://auth.smsly.ch/api/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => "username=" . $email_encoded . "&password=" . $password_encoded . "&device_name=SMC%20WEB%20API%20%7C%20V1",
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

if (empty($response)) {

  // Weiterleitung
  $_SESSION["code"] = "00.100.01";
  header('Location: /' . $inhalt . '/sign-in.php');
  exit;
}
if ($response === '{"message":"Your account is banned by administrators."}') {

  // Weiterleitung
  $_SESSION["code"] = "00.100.05";
  header('Location: /' . $inhalt . '/sign-in.php');
  exit;
}
if ($response === '{"message":"These credentials do not match our records.","errors":{"username":["These credentials do not match our records."]}}') {

  // Weiterleitung
  $_SESSION["code"] = "00.100.01";
  header('Location: /' . $inhalt . '/sign-in.php');
  exit;
} else {

  // JSON-Daten decodieren
  $data = json_decode($response, true);

  // Den Token extrahieren
  $token = isset($data['token']) ? $data['token'] : '';

  // Entfernt alles vor dem "|"-Zeichen und das Zeichen selbst
  $tokenverify = strstr($token, '|', false);

  if (strlen($tokenverify) === 41) {
    echo "Die Variable hat genau 41 Zeichen.</br></br> $token | $response";
  } else {
     echo "Die Variable hat nicht genau 41 Zeichen.</br></br> $token | $response";
    $_SESSION["message"] = "These credentials do not match our records";
    /* header('Location: /index.php?2'); */
    exit;
  }

  // In der Session "signin_token" speichern
  $_SESSION['signin_token'] = $token;



  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://auth.smsly.ch/api/me',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Accept: application/json',
      'Content-Type: application/json',
      "Authorization: Bearer $token",
      'Cookie: XSRF-TOKEN=eyJpdiI6InFNdHllN09kY09NM3hsU2JsdExPM1E9PSIsInZhbHVlIjoiT2dPNXh3UWZuTlJ0eHlGd1Z4ay9KWnNyTG5NcElRdkJkaEwzVWVGVG45Zm9OZi81SWtsRmZMSkVsSTd0WWxLZWZpQTdkZGk2bVJ6MlRHR3ZDbmc0OGxvV3ZLNXFQNE85TVUwZk5jZFdTZkJHekg3Q1lxR0s5OVQ2ZHpHZDN1R0oiLCJtYWMiOiJjNDZlOGFhNjczMTQwN2Y2ZTgxZGY2MDcxN2NkMzZhNDE4OGRlYjAwOWQwNzc1Yzk5ZjQ2ZDczOTQwMzFjZTVkIiwidGFnIjoiIn0%3D; laravel_session=eyJpdiI6IkJUMEFDZDI5dk1DOU01NDFVL1lBR2c9PSIsInZhbHVlIjoiTjhnMGFVdHhCc1FCVVNJMDJRT0VKWXl5TUpJMTFLODAyZkVxV04xbGFiZllHNmp1UGtVeThLemRreHlJb1l0RVlxNGNhOHJUUGtkL1h2UkFobjE4N1U5aFVZTG1mZW1CbXFodDJXdEsyaVJMdEp2UDZSNEd3RXU2TkZoRUtzOUYiLCJtYWMiOiIwNmM2ODQ2ZWJlNTA2ZTM4OTljMGI0OGEzMDI4NGYyYmRhOTdiYzY4N2YyN2IyZWEzYWExOGEzNTU2Mzk2MThiIiwidGFnIjoiIn0%3D'
    ),
  ));

  $userdata = curl_exec($curl);

  curl_close($curl);
  echo $userdata;

  if ($userdata === 'Unauthorized.') {

    // Weiterleitung
    $_SESSION["code"] = "00.100.11";
    header('Location: /' . $inhalt . '/sign-in.php');
    exit;
  } else {

    // Konvertiert das JSON-Objekt in ein PHP-Array
    $data = json_decode($userdata, true);

    // Extrahiert und speichert die gewünschten Daten in separaten Session-Variablen
    $_SESSION['id']         = $data['data']['id'];
    $_SESSION['first_name'] = $data['data']['first_name'];
    $_SESSION['last_name']  = $data['data']['last_name'];
    $_SESSION['username']   = $data['data']['username'];
    $_SESSION['email']      = $data['data']['email'];
    $_SESSION['avatar']     = $data['data']['avatar'];
    $_SESSION['role_id']    = $data['data']['role_id'];
    $_SESSION['status']     = $data['data']['status'];
    $_SESSION['address']     = $data['data']['address'];

    // Optional: Zur Überprüfung, ob die Daten korrekt gespeichert wurden
    echo "Daten erfolgreich in separaten Sessions gespeichert!</br></br>
    Token:" . $_SESSION['signin_token'] . "</br>
    id:" . $_SESSION['id'] . "</br>
    first_name:" . $_SESSION['first_name'] . "</br>
    last_name:" . $_SESSION['last_name'] . "</br>
    username:" . $_SESSION['username'] . "</br>
    email:" . $_SESSION['email'] . "</br>
    avatar:" . $_SESSION['avatar'] . "</br>
    role_id:" . $_SESSION['role_id'] . "</br>
    status:" . $_SESSION['status'] . "</br>
    </br>";



    $curl = curl_init();


    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://auth.smsly.ch/api/roles/' . $_SESSION['role_id'] . '/permissions',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Accept: application/json',
        'Content-Type: application/json',
        "Authorization: Bearer 50|E5WDYsysLLNJDIFALMldGrHHKTIWczbxPPtS4F7E",
      ),
    ));

    $userpermissions = curl_exec($curl);

    curl_close($curl);
    echo $userpermissions;


    $data = json_decode($userpermissions, true);

    if (isset($data['data'])) {
      foreach ($data['data'] as $item) {
        if (isset($item['name'])) {
          $_SESSION[$item['name']] = true;
        }
      }
    }

    
      echo "<br><br>Die Session-Variable 'smsly.login' wurde gesetzt!!<br>";
      $_SESSION["message"] = "You have logged in";
      header('Location: /' . $inhalt . '/');
      exit;
    
  }
}
