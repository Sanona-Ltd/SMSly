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
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Send SMS over Web</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Send SMS over Web</li>
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

          <div class="row">
            <div class="col-md-6 col-lg-6">
              <div class="card rounded-3 card-hover">
                <a href="" class="stretched-link"></a>
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <span class="flex-shrink-0"><i class="ti ti-building-bank text-primary display-6"></i></span>
                    <div class="ms-4">
                      <h4 class="card-title text-dark">
                        <?php echo $GLOBAL_VARIABLE_sms_contingent; ?>
                      </h4>
                      <span class="fs-2 mt-1 ">Current balance</span>
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
          </div>

          <div class="row">
            <div class="col-12">
              <!-- ----------------------------------------- -->
              <!-- 1. Basic Form -->
              <!-- ----------------------------------------- -->
              <!-- ---------------------
                                                  start Basic Form
                                              ---------------- -->
              <div class="card">
                <div class="card-body">
                  <h5 class="mb-3">Send SMS over Web</h5>
                  <form method="get" action="sender/send.php">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input type="text" name="smsto" class="form-control" id="smsto"
                            placeholder="Enter Name here" />
                          <label for="tb-fname">SMS Recipient</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="smsfrom" id="smsfrom"
                            placeholder="name@example.com" />
                          <label for="smsfrom">SMS Sender</label>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-floating">
                          <div class="form-group">
                            <textarea name="smstext" class="form-control" rows="3"
                              placeholder="Here is the SMS text..."></textarea>
                            <small id="textHelp" class="form-text text-muted">Approx. 160 characters / 1 SMS
                              Credit</small>
                          </div>
                        </div>
                      </div>
                      <input name="scode" type="text" value="wwSYyLN3Pe3K1hZtmehD1Y2xrubhXzCgwtH2cbSk" hidden>
                      <input name="smssystem" type="text" value="SMSly.ch | WEB | V3" hidden>
                      <input name="cburl" type="text" value="https://smsly.ch/v4/app/sms-callback" hidden>
                      <input name="sender_id" type="text" value="<?php echo $_SESSION['id'] ?>" hidden>
                      <input name="sender_ip" type="text" value="<?php echo $visitor_ip ?>" hidden>
                      <div class="col-12">
                        <div class="d-md-flex align-items-center mt-3">
                          <div class="ms-auto mt-3 mt-md-0">
                            <button type="submit" class="btn btn-info font-medium rounded-pill px-4">
                              <div class="d-flex align-items-center">
                                <i class="ti ti-send me-2 fs-4"></i>
                                Send SMS
                              </div>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

  <!-- SMS Success Modal -->
  <div class="modal fade" id="al-success-alert" tabindex="-1" aria-labelledby="vertical-center-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content modal-filled bg-light-success text-success">
        <div class="modal-body p-4">
          <div class="text-center text-success">
            <i class="ti ti-circle-check fs-7"></i>
            <h4 class="mt-2">Congratulations!</h4>
            <p class="mt-3 text-success-50">
              The SMS has been delivered.</br>
              Thank you very much</br>
              for using SMSly.ch.</br>
            </p>
            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">
              Continue
            </button>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </div>

  <!-- SMS low Credits Modal -->
  <div class="modal fade" id="al-warning-alert" tabindex="-1" aria-labelledby="vertical-center-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content modal-filled bg-light-warning">
        <div class="modal-body p-4">
          <div class="text-center text-warning">
            <i class="ti ti-alert-octagon fs-7"></i>
            <h4 class="mt-2">Attention! Less credits</h4>
            <p class="mt-3">
              Your account has too less SMS credits.
              Top up your account to
              continue sending SMS...</br>
            </p>
            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">
              Continue
            </button>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </div>

  <!-- SMS low Credits Modal -->
  <div class="modal fade" id="al-warning-alert2" tabindex="-1" aria-labelledby="vertical-center-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content modal-filled bg-light-warning">
        <div class="modal-body p-4">
          <div class="text-center text-warning">
            <i class="ti ti-alert-octagon fs-7"></i>
            <h4 class="mt-2">ERROR!</h4>
            <p class="mt-3">
              There was an error,
              please try again. </br>
              If the error occurs again, </br>
              please contact support.</br>
              (
              <?php
              $text = $_SESSION['sms-status'];
              echo "$text"; ?>)
            </p>
            <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">
              Continue
            </button>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
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

  <!-- JavaScript to automatically open the modal when the page loads -->
  <?php
  if (isset($_SESSION['sms-status']) && ($_SESSION['sms-status'] == '0' || $_SESSION['sms-status'] == 'SUCCESS')) {
    // JavaScript-Code für das Anzeigen des Modals
    echo "<script>
          document.addEventListener('DOMContentLoaded', (event) => {
            const modalElement = new bootstrap.Modal(document.getElementById('al-success-alert'));
            modalElement.show();
          });
          </script>";
  } elseif (isset($_SESSION['sms-status']) && $_SESSION['sms-status'] == '89') {
    // JavaScript-Code für das Anzeigen des Modals
    echo "<script>
          document.addEventListener('DOMContentLoaded', (event) => {
            const modalElement = new bootstrap.Modal(document.getElementById('al-warning-alert'));
            modalElement.show();
          });
          </script>";
  } elseif (isset($_SESSION['sms-status'])) {
    // JavaScript-Code für das Anzeigen des Modals
    echo "<script>
          document.addEventListener('DOMContentLoaded', (event) => {
            const modalElement = new bootstrap.Modal(document.getElementById('al-warning-alert2'));
            modalElement.show();
          });
          </script>";
  }

  // Lösche die Session-Variable unmittelbar danach
  unset($_SESSION['sms-status']);
  ?>


</body>

</html>