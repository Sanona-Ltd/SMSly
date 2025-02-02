<?php

include("../auth-app/is-login.php");

$url = "../sms-send";
if (isset($_GET["scode"]) && isset($_GET["smsfrom"]) && isset($_GET["smsto"]) && isset($_GET["smstext"])) {

  /*Init Variable*/
  $scode = $_GET["scode"];
  $smsSenderGateway = $_GET["smsfrom"];
  $smsReceiverGateway = $_GET["smsto"];
  $smstextGateway = urldecode($_GET["smstext"]);
  /* $sender_id = $_GET["sender_id"]; */
  /* $sender_ip = $_GET["sender_ip"]; */
  /* $smssystem = $_GET["smssystem"]; */
  /* $sms_tag = "0"; */



  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/logs',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => 'type=sms.sending&user=' . $GLOBAL_VARIABLE_userid . '&action=try+to+send&storage=scode+%3D+' . $scode . '%0D%0Asmsto+%3D+' . $smsReceiverGateway . '%0D%0Asmstext+%3D+' . $smstextGateway . '%0D%0Asmsfrom+%3D+' . $smsSenderGateway . '',
    CURLOPT_HTTPHEADER => array(
      'Content-Type: application/x-www-form-urlencoded',
      'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
    ),
  )
  );

  $response = curl_exec($curl);

  curl_close($curl);
  // echo $response;





  // Retrieve the users current SMS quota
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user?where[id]=' . $GLOBAL_VARIABLE_userid . '&timestamps=null',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
    ),
  )
  );

  $response = curl_exec($curl);
  curl_close($curl);

  // Konvertiert die JSON-Antwort in ein PHP-Objekt
  $responseObj = json_decode($response);

  // Zugriff auf das "sms_contingent" und Speicherung in einer Variablen
  $sms_contingent = $responseObj[0]->sms_contingent;



  if (strrpos(file_get_contents("secret/scode.txt"), $scode) !== false) {

    if ($sms_contingent > 0) {


      require("gateway/nexmo.php");


      $remainingSMS = $sms_contingent - $messageCount;




      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user/update/' . $GLOBAL_VARIABLE_userid . '',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('sms_contingent' => '' . $remainingSMS . ''),
        CURLOPT_HTTPHEADER => array(
          'Accept: application/json',
          'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
        ),
      )
      );

      $response = curl_exec($curl);

      curl_close($curl);
      // echo $response;


      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/logs',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'type=sms.sending&user=' . $GLOBAL_VARIABLE_userid . '&action=sent+to+gateway&storage=scode+%3D+' . $scode . '%0D%0Asmsto+%3D+' . $smsReceiverGateway . '%0D%0Asmstext+%3D+' . $smstextGateway . '%0D%0Asmsfrom+%3D+' . $smsSenderGateway . '%0D%0AStatus+%3D+' . $status . '',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/x-www-form-urlencoded',
          'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
        ),
      )
      );

      $response = curl_exec($curl);

      curl_close($curl);
      // echo $response;

      header("Location: $url?status=$status");
      echo "<br><br><br><br>$url?status=$status | hat geklappt";
      exit();



    } else {
      // header("Location: $url?status=89");
      echo "SMS Contigent > 0";
      exit();
    }


  } else {
    // header("Location: $url?smserror=falssc");
    echo "Falscher \"scode\"";
    exit();
  }


} else {
  // header("Location: $url?smserror=falspar");
  echo "Ein Parameter ist nicht richtig angegeben...";
  exit();
}
