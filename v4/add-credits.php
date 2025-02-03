<?php session_start(); ?>
<!-- Zu Löschen bei Releas von V4 -->
<?php include("../v4/auth-app/is-login.php"); ?>
<!-- Zu Löschen bei Releas von V4 -->


<?php $filePath = "../version.txt"; ?>
<?php $SystemVersion = file_get_contents($filePath); ?>
<?php // include("../$SystemVersion/auth-app/is-login.php"); 
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
                  <h4 class="fw-semibold mb-8">Add Credits</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Add Credits</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3">
                  <div class="text-center mb-n5">
                    <img src="./assets/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
              <h2 class="fw-bolder mb-0 fs-8 lh-base">Add credit to your account </h2>
            </div>
          </div>
          </br>
          </br>
          <!-- <div class="d-flex align-items-center justify-content-center my-7">
            <span class="text-dark fw-bolder text-capitalize me-3">Monthly</span>
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
            </div>
            <span class="text-dark fw-bolder text-capitalize ms-2">Yearly</span>
          </div> -->
          <div class="row">


            <!-- <div class="col-sm-6 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <span class="fw-bolder text-uppercase fs-2 d-block mb-7">bronze</span>
                  <div class="d-flex mb-3">
                    <h2 class="fw-bolder fs-12 ms-2 mb-0">2</h2>
                    <h5 class="fw-bolder fs-6 mb-0">CHF</h5>
                  </div>
                  <ul class="list-unstyled mb-7">
                    <li class="d-flex align-items-center gap-2 py-2">
                      <i class="ti ti-plus text-primary fs-4"></i>
                      <span class="text-dark">add 40 Credits</span>
                    </li>
                  </ul>
                  <form action="app/add-credits-payment.php" method="get">
                    <input type="text" name="product" value="001" hidden>
                    <input type="submit" class="btn btn-primary fw-bolder rounded-2 py-6 w-100 text-capitalize" value="choose bronze">
                  </form>
                </div>
              </div>
            </div> -->

            <?php

            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/product?where[is-public]=true&timestamps=null',
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

            // Antwort in ein PHP-Array umwandeln
            $products = json_decode($response, true);

            // Über die Produkte iterieren und Daten in Variablen speichern
            foreach ($products as $product) {
              $id = $product['id'];
              $locale = $product['locale'];
              $createdAt = $product['created_at'];
              $updatedAt = $product['updated_at'];
              $publishedAt = $product['published_at'];
              $isPublic = $product['is-public'];
              $productId = $product['product_id'];
              $name = $product['name'];
              $description = $product['description'];
              $contingent = $product['contingent'];
              $price = $product['price'];
              $badgePublic = $product['badge-public'];

              // Wenn verfügbar, Badge-Text und Badge-Farbe speichern
              $badgeText = isset($product['badge-text']) ? $product['badge-text'] : null;
              $badgeColor = isset($product['badge-color']) ? $product['badge-color'] : null;

              // Variablen für jeden Produkt hier verwenden oder verarbeiten...
              // Zum Beispiel: Echo der Produktinformationen
              echo '<div class="col-sm-6 col-lg-4">
                      <div class="card">
                        <div class="card-body pt-6">
                          ';

              if ($badgePublic == "true") {
                echo "
                          <div class='text-end'>
                            <span class='badge fw-bolder py-1 bg-$badgeColor-subtle text-$badgeColor text-uppercase fs-2 rounded-3'>$badgeText</span>
                          </div>
                          ";
              } else {
                echo "<br>";
              }

              echo '
                          
                          <span class="fw-bolder text-uppercase fs-2 d-block mb-7">' . $name . '</span>
                          <div class="d-flex mb-3">
                            <h2 class="fw-bolder fs-12 ms-2 mb-0">' . $price . '</h2>
                            <h5 class="fw-bolder fs-6 mb-0">CHF</h5>
                          </div>
                          <ul class="list-unstyled mb-7">
                            <li class="d-flex align-items-center gap-2 py-2">
                              <i class="ti ti-plus text-primary fs-4"></i>
                              <span class="text-dark">' . $description . '</span>
                            </li>
                          </ul>
                          <form action="app/add-credits-payment.php" method="get">
                            <input type="text" name="product" value="' . $productId . '" hidden>
                            <input type="submit" class="btn btn-primary fw-bolder rounded-2 py-6 w-100 text-capitalize" value="choose ' . $name . '">
                          </form>
                        </div>
                      </div>
                    </div>';

              // Hier könnten Sie die Daten auch in einer Datenbank speichern oder weitere Verarbeitungen durchführen
            }

            ?>


            <!-- <div class="col-sm-6 col-lg-4">
              <div class="card">
                <div class="card-body pt-6">
                  <div class="text-end">
                    <span class="badge fw-bolder py-1 bg-info-subtle text-info text-uppercase fs-2 rounded-3">BEST
                      VALUE</span>
                  </div>
                  <span class="fw-bolder text-uppercase fs-2 d-block mb-7">gold</span>
                  <div class="d-flex mb-3">
                    <h2 class="fw-bolder fs-12 ms-2 mb-0">10</h2>
                    <h5 class="fw-bolder fs-6 mb-0">CHF</h5>
                  </div>
                  <ul class="list-unstyled mb-7">
                    <li class="d-flex align-items-center gap-2 py-2">
                      <i class="ti ti-plus text-primary fs-4"></i>
                      <span class="text-dark">add 220 Credits</span>
                    </li>
                  </ul>
                  <form action="app/add-credits-payment.php" method="get">
                    <input type="text" name="product" value="003" hidden>
                    <input type="submit" class="btn btn-primary fw-bolder rounded-2 py-6 w-100 text-capitalize" value="choose gold">
                  </form>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
      <!-- Button trigger modal -->
      <!-- <button type="button" class="btn mb-1 bg-primary-subtle text-primary btn-lg px-4 fs-4 font-medium" data-bs-toggle="modal" data-bs-target="#staticBackdrop" aria-hidden="true">
        Static backdrop modal
      </button> -->

      <!-- Modal -->
      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
              <h4 class="modal-title" id="myLargeModalLabel">
                Your account is not complete
              </h4>
            </div>
            <div class="modal-body">
              <p>
                The following points must be entered in the user account in order to be able to make a purchase: </br>
                <?php
                if (!isset($GLOBAL_VARIABLE_name) || empty($GLOBAL_VARIABLE_name)) {
                  echo "- First name<br>";
                }
                if (!isset($GLOBAL_VARIABLE_surname) || empty($GLOBAL_VARIABLE_surname)) {
                  echo "- Surname<br>";
                }
                if (!isset($GLOBAL_VARIABLE_address_street) || empty($GLOBAL_VARIABLE_address_street)) {
                  echo "- Street<br>";
                }
                if (!isset($GLOBAL_VARIABLE_address_number) || empty($GLOBAL_VARIABLE_address_number)) {
                  echo "- Street Number<br>";
                }
                if (!isset($GLOBAL_VARIABLE_address_zip) || empty($GLOBAL_VARIABLE_address_zip)) {
                  echo "- Zip code<br>";
                }
                if (!isset($GLOBAL_VARIABLE_address_place) || empty($GLOBAL_VARIABLE_address_place)) {
                  echo "- City<br>";
                }

                ?>
                </br>
                Some of the data provided has been entered incorrectly or not at all, please adjust the data.</br>
                </br>
              </p>
              <div class="col-md-12 d-grid gap-2">
                <a href="account-settings" type="button" class="btn rounded-pill waves-effect waves-light btn-outline-primary">
                  Complete your account now!
                </a>
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
    <?php
    // Überprüfen, ob die Session-Variablen nicht gesetzt sind oder leer sind
    /* if (
      !isset($GLOBAL_VARIABLE_email) || empty($GLOBAL_VARIABLE_email) ||
      !isset($GLOBAL_VARIABLE_name) || empty($GLOBAL_VARIABLE_name) ||
      !isset($GLOBAL_VARIABLE_surname) || empty($GLOBAL_VARIABLE_surname) ||
      !isset($GLOBAL_VARIABLE_address_street) || empty($GLOBAL_VARIABLE_address_street) ||
      !isset($GLOBAL_VARIABLE_address_number) || empty($GLOBAL_VARIABLE_address_number) ||
      !isset($GLOBAL_VARIABLE_address_zip) || empty($GLOBAL_VARIABLE_address_zip) ||
      !isset($GLOBAL_VARIABLE_address_place) || empty($GLOBAL_VARIABLE_address_place) ||
      !isset($GLOBAL_VARIABLE_address_country) || empty($GLOBAL_VARIABLE_address_country)
    ) {

      // JavaScript-Code für das Anzeigen des Modals
      echo "<script>
          document.addEventListener('DOMContentLoaded', (event) => {
            const modalElement = new bootstrap.Modal(document.getElementById('staticBackdrop'));
            modalElement.show();
          });
          </script>";
    } */
    ?>
</body>

</html>