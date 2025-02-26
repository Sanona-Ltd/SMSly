<?php
session_start();
require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Turnstile Überprüfung
  $token = $_POST['cf-turnstile-response'];
  if (!$token) {
    $_SESSION["errorText"] = "Bitte bestätigen Sie, dass Sie kein Roboter sind.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
  }

  $email = $_POST['EMAIL'];
  $password = $_POST['PASSWORD'];

  // UUID v7 generieren mit der Bibliothek
  $uuid = Uuid::uuid7()->toString();

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
      'email' => $email,
      'password' => $password,
      'name' => '',
      'surname' => '',
      'street' => '',
      'number' => '',
      'address-suffix' => '',
      'zip-code' => '',
      'city' => '',
      'country' => 'Switzerland',
      'can-login' => 'Registration',
      'sms_contingent' => '10',
      'own-sender' => 'No',
      'rank' => 'Customer',
      'verified' => 'false',
      'stripe_identity' => '',
      'api_key' => '',
      'api_secret' => '',
      'registration-key' => $uuid
    ),
    CURLOPT_HTTPHEADER => array(
      'Accept: application/json',
      'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
    ),
  ));

  $response = curl_exec($curl);
  curl_close($curl);

  // Nach erfolgreicher Registrierung zur Detailseite weiterleiten
  header("Location: sign-up-details.php?key=" . $uuid);
  exit();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme">


<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="./assets/images/fav.png" />

  <!-- Core Css -->
  <link rel="stylesheet" href="./assets/css/styles.css" />

  <!-- Turnstile -->
  <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

  <!-- Analytics -->
  <?php include("app/analytics.php"); ?>

  <title>SMSly | V4</title>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="./assets/images/logo.png" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="/" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                  <img src="./assets/images/logo.png" class="dark-logo" alt="Logo-Dark" />
                  <img src="./assets/images/logo.png" class="light-logo" alt="Logo-light" />
                </a>

                <?php
                if (isset($_SESSION["errorText"])) {
                  $errorcode = $_SESSION["errorText"];
                  echo "<div class='alert alert-light-warning bg-danger-subtle bg-warning-subtle text-warning' role='alert'>
                          <h4 class='alert-heading'>Oh No! An error has occurred.</h4>
                          <p>$errorcode</p>
                        </div>";
                  unset($_SESSION["errorText"]);
                }
                ?>

                <?php
                if (isset($_SESSION["successText"])) {
                  $successText = $_SESSION["successText"];
                  echo "<div class='alert alert-light-success bg-success-subtle text-success' role='alert'>
                            <h4 class='alert-heading'>Success!</h4>
                            <p>$successText</p>
                          </div>";
                  unset($_SESSION["successText"]);
                }
                ?>

                <div class='alert alert-light-info bg-info-subtle bg-info-subtle text-info' role='alert'>
                  <h4 class='alert-heading'>Beta Version</h4>
                  <p>SMSly.ch is currently only available in beta version. Errors may occur. We appreciate your understanding.</p>
                </div>

                <form method="post" action="">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email Address</label>
                    <input type="email" name="EMAIL" class="form-control" id="exampleInputEmail1" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="PASSWORD" class="form-control" id="password" required>
                  </div>

                  <div class="mb-3 d-flex justify-content-center">
                    <div class="cf-turnstile" data-sitekey="0x4AAAAAAAPn8Fvb0qUiLF9W"></div>
                  </div>

                  <input type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2" value="Pre-register for Beta Version">
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">Already have an account?</p>
                    <a class="text-primary fw-medium ms-2" href="./sign-in">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->

  <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./assets/js/app.min.js"></script>
  <script src="./assets/js/app.init.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/libs/simplebar/dist/simplebar.min.js"></script>

  <script src="./assets/js/sidebarmenu.js"></script>
  <script src="./assets/js/theme.js"></script>

</body>

</html>