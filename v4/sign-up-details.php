<?php
session_start();

// Überprüfe ob der Registrierungsschlüssel vorhanden ist
if (!isset($_GET['key'])) {
    header("Location: sign-up.php");
    exit();
}

// API-Anfrage um Benutzer anhand des Registrierungsschlüssels zu finden
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user?where[registration-key]=' . $_GET['key'],
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
));

$response = curl_exec($curl);
curl_close($curl);

$userData = json_decode($response, true);

// Überprüfe ob Benutzer gefunden wurde
if (empty($userData)) {
    header("Location: sign-up.php");
    exit();
}

// Setze die Update ID
$updateID = $userData[0]['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/user/update/' . $updateID,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'name' => $_POST['Fname'] ?? '',
            'surname' => $_POST['Lname'] ?? '',
            'street' => $_POST['street'] ?? '',
            'number' => $_POST['house_number'] ?? '',
            'zip-code' => $_POST['zip_code'] ?? '',
            'city' => $_POST['place'] ?? '',
            'country' => 'Switzerland',
            'can-login' => 'Allowed',
            'phone' => $_POST['phone'] ?? ''
        ),
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/account-movements',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('relation' => $updateID, 'title' => 'Freebie', 'description' => 'Freebie erhalten', 'quantity' => '10', 'type' => 'positive'),
        CURLOPT_HTTPHEADER => array(
            'Accept: application/json',
            'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;


    // Weiterleitung zur index.php nach erfolgreicher Registrierung
    header("Location: index.php");
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
                    <div class="col-md-12 col-lg-6">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="/" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                                    <img src="./assets/images/logo.png" class="dark-logo" alt="Logo-Dark" />
                                    <img src="./assets/images/logo.png" class="light-logo" alt="Logo-light" />
                                </a>

                                <form method="POST" action="" id="registrationForm" onsubmit="return validateAndFormatPhone()">
                                    <div class="d-flex flex-column gap-sm-7 gap-3">
                                        <div class="d-flex flex-sm-row flex-column gap-sm-7 gap-3">
                                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                                <label for="Fname" class="fs-3 fw-semibold text-dark">
                                                    First Name *
                                                </label>
                                                <input type="text" name="Fname" id="Fname" placeholder="First Name"
                                                    class="form-control" spellcheck="false" data-ms-editor="true">
                                            </div>
                                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                                <label for="Lname" class="fs-3 fw-semibold text-dark">
                                                    Last Name *
                                                </label>
                                                <input type="text" name="Lname" id="Lname" placeholder="Last name"
                                                    class="form-control" spellcheck="false" data-ms-editor="true">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-sm-row flex-column gap-sm-7 gap-3">
                                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                                <label for="phone" class="fs-3 fw-semibold text-dark">
                                                    Phone Number * <small class="text-muted">(Format: 079 123 45 67 or +41 79 123 45 67)</small>
                                                </label>
                                                <input type="tel" name="phone" id="phone" placeholder="079 123 45 67"
                                                    class="form-control">
                                                <div id="phoneError" class="text-danger" style="display: none;">
                                                    Bitte geben Sie eine gültige Schweizer Telefonnummer ein.
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="d-flex flex-sm-row flex-column gap-sm-7 gap-3">
                                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                                <label for="street" class="fs-3 fw-semibold text-dark">
                                                    Street *
                                                </label>
                                                <input type="text" name="street" id="street" placeholder="Street"
                                                    class="form-control" spellcheck="false" data-ms-editor="true">
                                            </div>
                                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                                <label for="house_number" class="fs-3 fw-semibold text-dark">
                                                    House Number *
                                                </label>
                                                <input type="text" name="house_number" id="house_number" placeholder="House number"
                                                    class="form-control" spellcheck="false" data-ms-editor="true">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-sm-row flex-column gap-sm-7 gap-3">
                                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                                <label for="zip_code" class="fs-3 fw-semibold text-dark">
                                                    Zip Code *
                                                </label>
                                                <input type="text" name="zip_code" id="zip_code" placeholder="Zip code"
                                                    class="form-control" spellcheck="false" data-ms-editor="true">
                                            </div>
                                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                                <label for="place" class="fs-3 fw-semibold text-dark">
                                                    Place *
                                                </label>
                                                <input type="text" name="place" id="place" placeholder="Place"
                                                    class="form-control" spellcheck="false" data-ms-editor="true">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <label for="enquire" class="fs-3 fw-semibold text-dark">Country *</label>
                                            <select class="form-select w-auto">
                                                <option value="ch">Switzerland</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary mt-sm-7 mt-3 px-9 py-6">Save registration</button>
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

    <script>
        function validateAndFormatPhone() {
            const phoneInput = document.getElementById('phone');
            const phoneError = document.getElementById('phoneError');
            let phoneNumber = phoneInput.value.replace(/\s+/g, ''); // Entfernt alle Leerzeichen

            // Entfernt alle nicht-numerischen Zeichen außer +
            phoneNumber = phoneNumber.replace(/[^\d+]/g, '');

            // Entfernt + am Anfang, falls vorhanden
            if (phoneNumber.startsWith('+')) {
                phoneNumber = phoneNumber.substring(1);
            }

            // Wenn die Nummer mit 0 beginnt, ersetze sie durch 41
            if (phoneNumber.startsWith('0')) {
                phoneNumber = '41' + phoneNumber.substring(1);
            }

            // Fügt 41 hinzu, wenn es nicht vorhanden ist
            if (!phoneNumber.startsWith('41')) {
                phoneNumber = '41' + phoneNumber;
            }

            // Überprüft, ob die Nummer das richtige Format hat (41 + 9 Ziffern)
            const phoneRegex = /^41\d{9}$/;
            if (!phoneRegex.test(phoneNumber)) {
                phoneError.style.display = 'block';
                return false;
            }

            // Setzt die formatierte Nummer zurück ins Eingabefeld
            phoneInput.value = phoneNumber;
            phoneError.style.display = 'none';
            return true;
        }
    </script>

</body>

</html>