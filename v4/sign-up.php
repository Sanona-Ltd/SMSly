<?php 
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['FIRST_NAME'];
    $last_name = $_POST['LAST_NAME'];
    $email = $_POST['EMAIL'];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://mailing.sanona.org/api/v1/public/subscribers',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'list_uid' => '67afcaaca4bbd',
            'EMAIL' => $email,
            'FIRST_NAME' => $first_name,
            'LAST_NAME' => $last_name
        ]),
        CURLOPT_HTTPHEADER => [
            'accept: application/json'
        ]
    ]);

    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    curl_close($curl);

    if ($http_code == 200 || $http_code == 201) {
        $_SESSION["successText"] = "Vielen Dank für Ihre Registrierung! Wir werden Sie benachrichtigen, sobald SMSly.ch verfügbar ist.";
    } else {
        $_SESSION["errorText"] = "Es gab einen Fehler bei der Registrierung. Bitte versuchen Sie es später erneut.";
    }
    
    header("Location: " . $_SERVER['PHP_SELF']);
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
                            <h4 class='alert-heading'>Erfolg!</h4>
                            <p>$successText</p>
                          </div>";
                    unset($_SESSION["successText"]);
                }
                ?>

                <div class='alert alert-light-info bg-info-subtle bg-info-subtle text-info' role='alert'>
                  <h4 class='alert-heading'>Beta Version</h4>
                  <p>Aktuell ist ist SMSly.ch nur in der Beta Version verfügbar. Wir arbeiten daran, dass Sie bald wieder auf Ihre SMSly.ch zugreifen können. Trage deine Email ein und wir werden dich benachrichtigen, sobald SMSly.ch wieder verfügbar ist.</p>
                </div>

                <form method="post" action="">
                  <div class="mb-3">
                    <label for="firstName" class="form-label">Vorname</label>
                    <input type="text" name="FIRST_NAME" class="form-control" id="firstName" required>
                  </div>
                  <div class="mb-3">
                    <label for="lastName" class="form-label">Nachname</label>
                    <input type="text" name="LAST_NAME" class="form-control" id="lastName" required>
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">E-Mail Adresse</label>
                    <input type="email" name="EMAIL" class="form-control" id="exampleInputEmail1" required>
                  </div>
                  <input type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2" value="Registrieren">
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">Sie haben bereits ein Konto?</p>
                    <a class="text-primary fw-medium ms-2" href="./sign-in">Anmelden</a>
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