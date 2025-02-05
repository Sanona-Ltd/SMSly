<?php
session_start();

// Konfigurationsdatei einbinden
require_once 'config/config.php';

// CSRF-Token generieren
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

class LoginManager {
    private $api_url;
    private $api_token;
    
    public function __construct() {
        $this->api_url = API_URL;
        $this->api_token = API_TOKEN;
    }

    public function handleLoginError($code, $text = '') {
        $_SESSION["login_error_code"] = $code;
        if ($text) {
            $_SESSION["login_error_text"] = $text;
        }
        return false;
    }

    public function validateInput($email, $password) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->handleLoginError("00.199.04", "Ungültige E-Mail-Adresse");
        }
        if (strlen($password) < 8) {
            return $this->handleLoginError("00.199.05", "Passwort zu kurz");
        }
        return true;
    }

    public function processLogin($email, $password) {
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->api_url . '/user?where[email]=' . urlencode($email) . '&timestamps',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->api_token
            ],
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($curl);
        
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            error_log("Login API Error: " . $error);
            return $this->handleLoginError("00.199.06", "Serverfehler");
        }
        
        curl_close($curl);
        return json_decode($response);
    }

    public function setSessionVariables($user) {
        $sessionVars = [
            "user_id" => $user->id,
            "email" => $user->email,
            "username" => $user->username,
            "name" => $user->name,
            "surname" => $user->surname,
            "street" => $user->street,
            "number" => $user->number,
            "zip_code" => $user->{'zip-code'},
            "city" => $user->city,
            "country" => $user->country,
            "can_login" => $user->{'can-login'},
            "reason" => $user->reason,
            "sms_contingent" => $user->sms_contingent,
            "own_sender" => $user->{'own-sender'},
            "rank" => $user->rank,
            "verified" => $user->verified,
            "api_key" => $user->api_key,
            "api_secret" => $user->api_secret
        ];

        foreach ($sessionVars as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public function validateCallback($url) {
        if (empty($url)) return false;
        
        $allowed_domains = ['smsly.ch', 'sanona.org'];
        $parsed = parse_url($url);
        
        // Prüfe ob es sich um einen relativen Pfad handelt
        if (!isset($parsed['host'])) return true;
        
        return in_array($parsed['host'] ?? '', $allowed_domains);
    }
}

// Login-Verarbeitung
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF Token ungültig');
    }

    $loginManager = new LoginManager();
    
    if (isset($_POST["email"], $_POST["password"]) && 
        !empty($_POST["email"]) && 
        !empty($_POST["password"])) {
        
        if (!$loginManager->validateInput($_POST["email"], $_POST["password"])) {
            header("Location: sign-in.php");
            exit;
        }

        $data = $loginManager->processLogin($_POST["email"], $_POST["password"]);

        if ($data === null || empty($data)) {
            $loginManager->handleLoginError("00.199.02", "Ungültige Antwort vom Server");
        } else {
            if (!isset($data[0])) {
                $loginManager->handleLoginError("00.199.03", "Benutzer nicht gefunden");
                header("Location: sign-in.php");
                exit;
            }
            
            $user = $data[0];
            
            if (password_verify($_POST["password"], $user->password)) {
                switch ($user->{'can-login'}) {
                    case "Allowed":
                        $loginManager->setSessionVariables($user);
                        
                        // Callback-Verarbeitung für beide Parameter (callback und cb)
                        if (isset($_GET['callback']) && $loginManager->validateCallback($_GET['callback'])) {
                            header("Location: /v4" . $_GET['callback']);
                        } elseif (isset($_GET['cb']) && $loginManager->validateCallback($_GET['cb'])) {
                            header("Location: /v4" . $_GET['cb']);
                        } else {
                            header("Location: /v4");
                        }

                        exit;
                        
                    case "Disallowed":
                        $loginManager->handleLoginError("00.200.01");
                        break;
                        
                    case "Fraud":
                        $loginManager->handleLoginError("00.200.02", $user->reason);
                        break;
                        
                    case "Review":
                        $loginManager->handleLoginError("00.200.03", $user->reason);
                        break;
                }
            } else {
                $loginManager->handleLoginError("00.199.01");
            }
        }
    }
    header("Location: sign-in.php");
    exit;
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

                <form action="" method="post" id="loginForm">
                  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                  <div class="mb-3">
                    <label for="email" class="form-label">E-Mail</label>
                    <input type="email" name="email" class="form-control" id="email" 
                           required autocomplete="email">
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Passwort</label>
                    <input type="password" name="password" class="form-control" id="password" 
                           required autocomplete="current-password">
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                    </div>
                    <!-- <a class="text-primary fw-medium" href="./main/authentication-forgot-password.html">Forgot Password ?</a> -->
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Anmelden</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-medium">Neu bei SMSly.ch?</p>
                    <a class="text-primary fw-medium ms-2" href="./sign-up">Account erstellen</a>
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

  <!-- Client-seitige Validierung -->
  <script>
  document.getElementById('loginForm').addEventListener('submit', function(e) {
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      
      if (!email || !password) {
          e.preventDefault();
          alert('Bitte füllen Sie alle Felder aus.');
          return;
      }
      
      if (password.length < 8) {
          e.preventDefault();
          alert('Das Passwort muss mindestens 8 Zeichen lang sein.');
          return;
      }
  });
  </script>

</body>

</html>