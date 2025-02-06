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
                      <h4 class="card-title text-dark"><?= $GLOBALS_USER_SMSCONTINGENT ?> / SMS Credits</h4>
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

            <!-- Modulare Komponenten -->
            <div id="sms-send-container"></div>
            <div id="payments-container"></div>

            <script>
              $(document).ready(function() {
                $('#sms-send-container').load('module/sms-send-index.php');
                $('#payments-container').load('module/payments-index.php');
              });
            </script>
            
            <!-- Entferne die direkten PHP includes -->
            <?php /* include("module/sms-send-index.php"); */ ?>
            <?php /* include("module/payments-index.php"); */ ?>

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