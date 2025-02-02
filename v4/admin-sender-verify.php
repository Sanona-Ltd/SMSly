<?php session_start(); ?>
<?php include("./v3/auth-app/is-login.php"); ?>
<?php $dateipfad = "./version.txt"; ?>
<?php /* if (isset($_SESSION['smsly.admin'])) {
    // Code, der ausgeführt werden soll, wenn die Session-Variable gesetzt ist
} else {
    header("Location: ./");
} */
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
        <img src="./assets/images/fav.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <!-- Sidebar Start -->
        <?php include("app/sidebar.php"); ?>
        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <?php include("app/header.php"); ?>
            <!--  Header End -->

            <?php include("app/header2.php"); ?>

            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">User Profile</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="main/index.html">Home</a>
                                            </li>
                                            <li class="breadcrumb-item" aria-current="page">User Profile</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="col-3">
                                    <div class="text-center mb-n5">
                                        <img src="assets/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card shadow-none border">
                                        <div class="card-body">
                                            <form>
                                                <h2 class='fw-semibold mb-3 align-items-center'>Absendername: </h2>
                                                <h4 class='fw-semibold mb-3 align-items-center'>Den Grund für die Ablehnung</h4>
                                                <div class="form-floating mb-3">
                                                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 137px" required></textarea>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <a class="btn btn-success">Absendername Freigeben</a>
                                                    <input type="submit" class="btn btn-danger ms-auto" value="Absendername Ablehnen">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">


                                    <?php

                                    $curl = curl_init();

                                    curl_setopt_array($curl, array(
                                        CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-sender-name?where[id]=22',
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => '',
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => 'GET',
                                        CURLOPT_HTTPHEADER => array(
                                            'Accept: application/json',
                                            'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
                                        ),
                                    ));

                                    $response = curl_exec($curl);
                                    curl_close($curl);

                                    // Konvertieren der JSON-Antwort in ein PHP-Array
                                    $responseArray = json_decode($response, true);

                                    // Schleife über jedes Element in der Antwort
                                    foreach ($responseArray as $item) {
                                        // Zugriff auf die Hauptebene der Antwort
                                        $id = $item['id'];
                                        $locale = $item['locale'];
                                        $senderName = $item['sender-name'];
                                        $validationStatus = $item['validation-status'];

                                        // Zugriff auf die 'user'-Daten
                                        $user = $item['user'];
                                        // ... (restliche User-Daten wie vorher)

                                        // Verarbeitung des 'validation-helper' JSON-Strings
                                        $validationHelperJson = $item['validation-helper'];
                                        $validationHelperArray = json_decode($validationHelperJson, true);

                                        // Zugriff auf 'validation-helper' Daten
                                        $validationHelperScore = $validationHelperArray[0]['score'];
                                        $validationHelperCompany = $validationHelperArray[0]['companys']['company'];
                                        $validationHelperDescription = $validationHelperArray[0]['companys']['description'];
                                        $validationHelperCountry = $validationHelperArray[0]['companys']['country'];
                                        $validationHelperIndustry = $validationHelperArray[0]['companys']['industry'];
                                        $validationHelperUrl = $validationHelperArray[0]['companys']['url'];
                                        // ... (restliche Validation-Helper-Daten wie vorher)


                                        if ($validationHelperScore < "25") {
                                            $validationHelperScoreColor = "success";
                                        } elseif ($validationHelperScore < "75") {
                                            $validationHelperScoreColor = "warning";
                                        } else {
                                            $validationHelperScoreColor = "danger";
                                        }

                                        // Ausgabe der Daten für dieses Element

                                        echo "<div class='card shadow-none border'>
                                        <div class='card-body'>
                                            <h4 class='fw-semibold mb-3 align-items-center'>Trust Score</h4>

                                            <div class='col d-flex align-items-center justify-content-center'>
                                                <div data-label='$validationHelperScore%' class='css-bar mb-0 css-bar-$validationHelperScoreColor css-bar-$validationHelperScore'>
                                                </div>
                                            </div>
                                            </br>
                                            </br>
                                            <h4 class='fw-semibold mb-3 align-items-center'>Ähnliche Unternehmen</h4>
                                            <ul class='list-unstyled mb-0'>
                                                <li class='d-flex align-items-center gap-3 mb-4'>
                                                    <i class='ti ti-briefcase text-dark fs-6'></i>
                                                    <h6 class='fs-4 fw-semibold mb-0'>$validationHelperCompany</h6>
                                                </li>
                                                <li class='d-flex align-items-center gap-3 mb-4'>
                                                    <i class='ti ti-mail text-dark fs-6'></i>
                                                    <h6 class='fs-4 fw-semibold mb-0'>$validationHelperIndustry</h6>
                                                </li>
                                                <li class='d-flex align-items-center gap-3 mb-4'>
                                                    <i class='ti ti-map-pin text-dark fs-6'></i>
                                                    <h6 class='fs-4 fw-semibold mb-0'>$validationHelperCountry</h6>
                                                </li>
                                                <li class='d-flex align-items-center gap-3 mb-4'>
                                                    <i class='ti ti-device-desktop text-dark fs-6'></i>
                                                    <h6 class='fs-4 fw-semibold mb-0'>$validationHelperUrl</h6>
                                                </li>
                                                <li class='d-flex align-items-center gap-3 mb-4'>
                                                    <i class='ti ti-notes text-dark fs-6'></i>
                                                    <span class='text-dark'>$validationHelperDescription</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>";
                                    }

                                    ?>





                                    <!-- <div class="card shadow-none border">
                                        <div class="card-body">
                                            <h4 class="fw-semibold mb-3 align-items-center">Ändliche Unternehmen</h4>

                                            <div class="col d-flex align-items-center justify-content-center">
                                                <div data-label="80%" class="css-bar mb-0 css-bar-danger css-bar-80">
                                                </div>
                                            </div>
                                            </br>
                                            </br>

                                            <ul class="list-unstyled mb-0">
                                                <li class="d-flex align-items-center gap-3 mb-4">
                                                    <i class="ti ti-briefcase text-dark fs-6"></i>
                                                    <h6 class="fs-4 fw-semibold mb-0">Sir, P P Institute Of Science</h6>
                                                </li>
                                                <li class="d-flex align-items-center gap-3 mb-4">
                                                    <i class="ti ti-mail text-dark fs-6"></i>
                                                    <h6 class="fs-4 fw-semibold mb-0">xyzjonathan@gmail.com</h6>
                                                </li>
                                                <li class="d-flex align-items-center gap-3 mb-4">
                                                    <i class="ti ti-device-desktop text-dark fs-6"></i>
                                                    <h6 class="fs-4 fw-semibold mb-0">www.xyz.com</h6>
                                                </li>
                                                <li class="d-flex align-items-center gap-3 mb-2">
                                                    <i class="ti ti-map-pin text-dark fs-6"></i>
                                                    <h6 class="fs-4 fw-semibold mb-0">Newyork, USA - 100001</h6>
                                                </li>
                                            </ul>
                                        </div>
                                    </div> -->
                                </div>
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

    <script src="./assets/js/apps/chat.js"></script>
</body>

</html>