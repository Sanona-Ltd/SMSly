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
  <link rel="stylesheet" href="./assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
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
                  <h4 class="fw-semibold mb-8">SMS History</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">SMS History</li>
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

          <div class="datatables">
            <!-- add row -->
            <!-- Individual column searching (text inputs) -->
            <div class="row">
              <div class="col-12">
                <!-- ---------------------
                                    start Individual column searching (text inputs)
                                ---------------- -->
                <div class="card">
                  <div class="card-body">
                    <div class="mb-2">
                      <h5 class="card-title">
                        SMS History
                      </h5>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered border text-inputs-searching text-nowrap" id="SMSHistory">
                        <thead>
                          <!-- start row -->
                          <tr>
                            <th>ID</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                          </tr>
                          <!-- end row -->
                        </thead>
                        <tbody>
                          <!-- start row -->

                          <?php
                          $curl = curl_init();

                          curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-send?whereRelation[sender][email]=florin.schildknecht%40sanona.org',
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

                          $data = json_decode($response, true);

                          if (!empty($data)) {
                              foreach ($data as $row) {
                                  $id = $row["id"];
                                  $sms_from = $row["sms_from"];
                                  $sms_to = $row["sms_to"];
                                  $sms_message = $row["sms_message"];
                                  $carrier_status = isset($row["carrier_status"]) ? $row["carrier_status"] : "";
                                  $reg_date = date('H:i d.m.Y'); // Aktuelles Datum, da es nicht in der API-Antwort enthalten ist

                                  if ($carrier_status === "delivered") {
                                      $sms_status_badge = "<span class='badge bg-success-subtle rounded-3 py-2 text-success fw-semibold fs-2 d-inline-flex align-items-center gap-1'><i class='ti ti-check fs-4'></i>Send</span>";
                                      $sms_status_txt = "Delivered";
                                      $error_text = "";
                                  } else {
                                      $sms_status_badge = "<span class='badge bg-danger-subtle rounded-3 py-2 text-danger fw-semibold fs-2 d-inline-flex align-items-center gap-1'><i class='ti ti-file-alert fs-4' data-bs-toggle='tooltip' title='$carrier_status'></i>ERROR</span>";
                                      $sms_status_txt = "Error";
                                      $error_text = "<div class='alert alert-light-warning bg-warning-subtle bg-warning-subtle text-warning' role='alert'>
                                                    <h4 class='alert-heading'>We have discovered a mistake!</h4>
                                                    <p>We have detected an error with this message.</br>
                                                    The error was reported by the system as follows: $carrier_status</br></p>
                                                    <hr>
                                                    <p class='mb-0'>If you have any questions about the error, please contact us at info@smsly.ch</p>
                                                    </div>";
                                  }

                                  // Rest des Codes für die Tabellendarstellung bleibt gleich
                                  echo "<tr>
                                          <td>$id</td>
                                          <td>$sms_from</td>
                                          <td>$sms_to</td>
                                          <td>$sms_status_badge</td>
                                          <td>$reg_date</td>
                                          <td>...</td>
                                        </tr>";
                              }
                          } else {
                              echo "<tr>
                                      <td></td>
                                      <td></td>
                                      <td>No SMS sent found...</td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                    </tr>";
                          }
                          ?>


                          <!-- end row -->
                        </tbody>
                        <tfoot>
                          <!-- start row -->
                          <tr>
                            <th>ID</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                          </tr>
                          <!-- end row -->
                        </tfoot>
                      </table>
                      <script>
                        $(document).ready(function() {
                          $('#SMSHistory').DataTable({
                            "order": [
                              [0, "desc"] // Sortiert die ID-Spalte (erste Spalte) absteigend
                            ]
                          });
                        });
                      </script>
                    </div>
                  </div>
                </div>
                <!-- ---------------------
                                    end Individual column searching (text inputs)
                                ---------------- -->
              </div>
            </div>
            <!-- Row selection (multiple rows) -->


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

  <script src="./assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="./assets/js/datatable/datatable-api.init.js"></script>
</body>

</html>