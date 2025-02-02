<?php require_once("auth/login-checker.php"); ?>


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
          <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100 bg-info-subtle overflow-hidden shadow-none">
                <div class="card-body position-relative">
                  <div class="row">
                    <div class="col-sm-7">
                      <div class="d-flex align-items-center mb-7">
                        <div class="rounded-circle overflow-hidden me-6">
                          <img src="./assets/images/icon.png" alt="" width="40" height="40">
                        </div>
                        <h5 class="fw-semibold mb-0 fs-5">Welcome back
                          <?php
                            if (!empty($GLOBALS_USER_NAME) && !empty($GLOBALS_USER_SURNAME)) {
                              echo $GLOBALS_USER_NAME . " " . $GLOBALS_USER_SURNAME;
                            } else {
                              echo $GLOBALS_USER_EMAIL;
                            }
                          ?>!
                        </h5>
                      </div>
                      <div class="d-flex align-items-center">
                        <!-- <div class="border-end pe-4 border-muted border-opacity-10">
                          <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">150</h3>
                          <p class="mb-0 text-dark">Total credits</p>
                        </div> -->
                        <!-- <div class="ps-4">
                          <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">PrePaid</h3>
                          <p class="mb-0 text-dark">Current subscription</p>
                        </div> -->
                      </div>
                    </div>
                    <div class="col-sm-5">
                      <div class="welcome-bg-img mb-n7 text-end">
                        <img src="./assets/images/backgrounds/welcome-bg.svg" alt="" class="img-fluid">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-md-6 col-lg-6">
              <div class="card rounded-3 card-hover">
                <a href="" class="stretched-link"></a>
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <span class="flex-shrink-0"><i class="ti ti-building-bank text-primary display-6"></i></span>
                    <div class="ms-4">
                      <h4 class="card-title text-dark"><?= $GLOBALS_USER_SMSCONTINGENT ?></h4>
                      <span class="fs-2 mt-1 ">current balance</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-6">
              <div class="card rounded-3 card-hover">
                <a href="" class="stretched-link"></a>
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <span class="flex-shrink-0"><i class="ti ti-script text-primary display-6"></i></span>
                    <div class="ms-4">
                      <h4 class="card-title text-dark">PrePaid</h4>
                      <span class="fs-2 mt-1 ">Current subscription</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-md-12 col-lg-8 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body">
                  <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                    <div class="mb-3 mb-sm-0">
                      <h5 class="card-title fw-semibold">SMS History</h5>
                      <p class="card-subtitle">Here you can see the last two SMS</p>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table align-middle text-nowrap mb-0">
                      <thead>
                        <tr class="text-muted fw-semibold">
                          <th scope="col" class="ps-0">To</th>
                          <th scope="col" class="ps-0">From</th>
                          <th scope="col">Status</th>
                          <th scope="col">Cost</th>
                          <th scope="col">Time</th>
                        </tr>
                      </thead>
                      <tbody class="border-top">
                        <tr>

                          <?php


                          $curl = curl_init();

                          curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-send?sort=created_at%3ADESC&limit=5',
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
                          // echo $response;
                          // Konvertiere die JSON-Antwort in ein PHP-Array
                          $data = json_decode($response, true);

                          // Konvertiere die JSON-Antwort in ein PHP-Array
                          $data = json_decode($response, true);

                          if (count($data) > 0) {
                            // Verarbeitung jedes Datensatzes
                            foreach ($data as $sms) {
                              $id = $sms['id'];
                              $locale = $sms['locale'];
                              $sms_from = $sms['sms_from'];
                              $sms_to = $sms['sms_to'];
                              $sms_message = $sms['sms_message'];
                              $sms_network = $sms['sms_network'];
                              $carrier_status = $sms['carrier_status'];
                              $sms_network_gateway = $sms['sms_network_gateway'];
                              $sms_message_id = $sms['sms_message_id'];
                              $sms_message_price = $sms['sms_message_price'];
                              $sender_id = $sms['sender']['id'];
                              $sender_locale = $sms['sender']['locale'];
                              $email = $sms['sender']['email'];
                              $username = $sms['sender']['username'];
                              $password = $sms['sender']['password'];
                              $name = $sms['sender']['name'];
                              $surname = $sms['sender']['surname'];
                              $street = $sms['sender']['street'];
                              $number = $sms['sender']['number'];
                              $zip_code = $sms['sender']['zip-code'];
                              $city = $sms['sender']['city'];
                              $country = $sms['sender']['country'];
                              $can_login = $sms['sender']['can-login'];
                              $reason = $sms['sender']['reason'];
                              $sms_contingent = $sms['sender']['sms_contingent'];
                              $own_sender = $sms['sender']['own-sender'];
                              $rank = $sms['sender']['rank'];
                              $api_key = $sms['sender']['api_key'];
                              $api_secret = $sms['sender']['api_secret'];
                              $sender_cost = $sms['sender_cost'];
                              $sender_ip = $sms['sender_ip'];
                              $sender_system = $sms['sender_system'];
                              $sender_gateway = $sms['sender_gateway'];

                              // Hier kannst du mit den Variablen arbeiten, z.B. sie ausgeben oder in einer Datenbank speichern
                              echo "<tr>
                              <td>$sms_to</td>
                              <td>$sms_from</td>
                              <td>$carrier_status</td>
                              <td>-$sender_cost</td>
                              <td></td>
                              
                            </tr>";
                            }
                          } else {
                            echo "<tr>
                                    <td></td>
                                    <td></td>
                                    <td>No SMS sent found...</td>
                                    <td></td>
                                    <td></td>
                                    
                                  </tr>";
                          }




                          ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body">
                  <h5 class="card-title fw-semibold">Account movements</h5>
                  <p class="card-subtitle mb-7">All movements of credits on your account</p>
                  <div class="position-relative">

                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex">
                        <div
                          class="p-8 bg-success-subtle rounded-2 d-flex align-items-center justify-content-center me-6">
                          <img src="./app/plus.svg" alt="" class="img-fluid" width="24" height="24">
                        </div>
                        <div>
                          <h6 class="mb-1 fs-4 fw-semibold">Create Account</h6>
                          <p class="fs-3 mb-0">Credits for the Start</p>
                        </div>
                      </div>
                      <h6 class="mb-0 fw-semibold">Add 10 Credits</h6>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex">
                        <div
                          class="p-8 bg-danger-subtle rounded-2 d-flex align-items-center justify-content-center me-6">
                          <img src="./app/minus.svg" alt="" class="img-fluid" width="24" height="24">
                        </div>
                        <div>
                          <h6 class="mb-1 fs-4 fw-semibold">Create Account</h6>
                          <p class="fs-3 mb-0">Credits for the Start</p>
                        </div>
                      </div>
                      <h6 class="mb-0 fw-semibold">Add 10 Credits</h6>
                    </div>

                  </div>
                  <button class="btn btn-outline-primary w-100">View all Payments</button>
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex border-bottom title-part-padding px-0 mb-3 align-items-center">
            <div>
              <h4 class="mb-0 fs-5">Quicklinks</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-lg-4">
              <div class="card rounded-3 card-hover">
                <a href="./sms-send" class="stretched-link"></a>
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <span class="flex-shrink-0"><i
                        class="ti ti-device-mobile-message text-primary display-6"></i></span>
                    <div class="ms-4">
                      <h4 class="card-title text-dark">Send SMS</h4>
                      <span class="fs-2 mt-1 ">Send SMS via the web</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="card rounded-3 card-hover">
                <a href="./api" class="stretched-link"></a>
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <span class="flex-shrink-0"><i class="ti ti-code-circle-2 text-primary display-6"></i></span>
                    <div class="ms-4">
                      <h4 class="card-title text-dark">My API</h4>
                      <span class="fs-2 mt-1 ">See your API credentials</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="card rounded-3 card-hover">
                <a href="./account-settings" class="stretched-link"></a>
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <span class="flex-shrink-0"><i class="ti ti-user-circle text-primary display-6"></i></span>
                    <div class="ms-4">
                      <h4 class="card-title text-dark">My account</h4>
                      <span class="fs-2 mt-1 ">Change your account details</span>
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

      <script src="./assets/libs/apexcharts/dist/apexcharts.min.js"></script>
      <script src="./assets/js/dashboards/dashboard2.js"></script>
</body>

</html>