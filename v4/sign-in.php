<?php
session_start();

if (isset($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];

  $curl = curl_init(); // Initialisierung von cURL

  curl_setopt_array(
    $curl,
    array(
      CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user?where[email]=' . urlencode($email) . '&timestamps',
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
  if (curl_errno($curl)) {
    echo 'Curl error: ' . curl_error($curl);
    curl_close($curl);
    exit;
  }
  curl_close($curl);

  $data = json_decode($response);

  if ($data === null) {
    echo "Fehler beim Parsen des JSON-Strings.";
  } else {
    $responses = $data;

    if (password_verify($password, $responses[0]->password)) {
      if ($responses[0]->{'can-login'} === "Allowed") {

        //User
        $_SESSION["user_id"] = $responses[0]->id;
        $_SESSION["email"] = $responses[0]->email;

        //Names
        $_SESSION["username"] = $responses[0]->username;
        $_SESSION["name"] = $responses[0]->name;
        $_SESSION["surname"] = $responses[0]->surname;

        //Adress
        $_SESSION["street"] = $responses[0]->street;
        $_SESSION["number"] = $responses[0]->number;
        $_SESSION["zip_code"] = $responses[0]->{'zip-code'};
        $_SESSION["city"] = $responses[0]->city;
        $_SESSION["country"] = $responses[0]->country;

        // Security
        $_SESSION["can_login"] = $responses[0]->{'can-login'};
        $_SESSION["sms_contingent"] = $responses[0]->{'sms_contingent'};
        $_SESSION["own_sender"] = $responses[0]->{'own-sender'};
        $_SESSION["rank"] = $responses[0]->rank;




        header("Location: ./");

      } elseif ($responses[0]->{'can-login'} === "Disallowed") {
        $_SESSION["login_error_code"] = "00.200.01";
      } elseif ($responses[0]->{'can-login'} === "Fraud") {
        $_SESSION["login_error_code"] = "00.200.02";
        $_SESSION["login_error_text"] = $responses[0]->reason;
      } elseif ($responses[0]->{'can-login'} === "Review") {
        $_SESSION["login_error_code"] = "00.200.03";
        $_SESSION["login_error_text"] = $responses[0]->reason;
      }
    } else {
      $_SESSION["login_error_code"] = "00.199.01";
    }
  }
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
  <div i d="main-wrapper">
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
                if (isset($_SESSION["login_error_code"])) {
                  $errorcode = $_SESSION["login_error_code"];

                  if ($errorcode === "00.199.01") {
                    $errorcolor = "danger";
                    $errorhead = "Oh a mistake";
                    $errortext = "These credentials do not match our records";
                  } elseif ($errorcode === "00.200.01") {
                    $errorcolor = "danger";
                    $errorhead = "Oh a mistake";
                    $errortext = "These credentials do not match our records";
                  } elseif ($errorcode === "00.200.02") {
                    $errorcolor = "warning";
                    $errorhead = "Your account is blocked for fraud";
                    $errortext = "Your account has been suspended by the support team as there have been some cases of fraud.</br>If you have any questions, please contact us at info@smsly.ch </br></br><strong>Reason:</strong></br>" . $_SESSION["login_error_text"] . "";
                  } elseif ($errorcode === "00.200.03") {
                    $errorcolor = "info";
                    $errorhead = "Your account is under review";
                    $errortext = "Your account is currently under review.</br>If you have any questions, please contact us at info@smsly.ch </br></br><strong>Reason:</strong></br>" . $_SESSION["login_error_text"] . "";
                  }

                  echo "<div class='alert alert-light-$errorcolor bg-$errorcolor-subtle bg-$errorcolor-subtle text-$errorcolor' role='alert'>
                    <h4 class='alert-heading'>$errorhead</h4>
                    <p>$errortext</p>
                    <hr>
                    <p class='mb-0'>
                      Code #$errorcode
                    </p>
                  </div>";
                  unset($_SESSION["login_error_code"]);
                  unset($_SESSION["login_error_text"]);
                }


                ?>

                <form action="" method="post">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>

                    <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                      aria-describedby="emailHelp">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                    </div>
                    <!-- <a class="text-primary fw-medium" href="./main/authentication-forgot-password.html">Forgot Password ?</a> -->
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign In</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">New to SMSly.ch?</p>
                    <a class="text-primary fw-medium ms-2" href="./sign-up">Create an account</a>
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