<?php session_start(); ?>
<?php include("../v4/auth-app/is-login.php"); ?>


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
                          /* $sender_id = $_SESSION['id'];

                          $servername = "localhost";
                          $username = "smsly_sms";
                          $password = "4^Y9F5y3amjecvFms";
                          $dbname = "smsly_sms";

                          $popout = "1";

                          // Create connection
                          $conn = new mysqli($servername, $username, $password, $dbname);
                          // Check connection
                          if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                          }

                          $sql = "SELECT * FROM `sms_send` WHERE sender_id = $sender_id";
                          $result = $conn->query($sql);

                          if ($result->num_rows > 0) {
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {

                              $id = $row["id"];
                              $sms_from = $row["sms_from"];
                              $sms_to = $row["sms_to"];
                              $sms_message = $row["sms_message"];
                              $sms_status = $row["sms_status"];
                              $carrier_status = $row["carrier_status"];
                              $sms_network = $row["sms_network"];
                              $sms_message_id = $row["sms_message_id"];
                              $sms_message_price = $row["sms_message_price"];
                              $sms_tag = $row["sms_tag"];
                              $sender_cost = $row["sender_cost"];
                              $sender_id = $row["sender_id"];
                              $sender_ip = $row["sender_ip"];
                              $sender_isp = $row["sender_isp"];
                              $sender_system = $row["sender_system"];
                              $reg_date = $row["reg_date"];

                              $dateTime = new DateTime($reg_date);
                              $formattedTime = $dateTime->format('H:i d.m.Y');

                              $sms_message_decodeed = urldecode($sms_message);
                              $sms_from_decodeed = urldecode($sms_from);

                              if ($sms_status === "Versendet" || $sms_status === "SUCCESS") {
                                $sms_status_badge = "<span class='badge bg-success-subtle rounded-3 py-2 text-success fw-semibold fs-2 d-inline-flex align-items-center gap-1'><i class='ti ti-check fs-4'></i>Send</span>";
                                $sms_status_txt = "Delivered";
                                $error_text = "";
                              } else {
                                $sms_status_badge = "<span class='badge bg-danger-subtle rounded-3 py-2 text-danger fw-semibold fs-2 d-inline-flex align-items-center gap-1'><i class='ti ti-file-alert fs-4' data-bs-toggle='tooltip' title='$sms_status'></i>ERROR</span>";
                                $sms_status_txt = "Error";
                                $error_text = "<div class='alert alert-light-warning bg-warning-subtle bg-warning-subtle text-warning' role='alert'>
                                              <h4 class='alert-heading'>We have discovered a mistake!</h4>
                                              <p>
                                              We have detected an error with this message.</br>
                                              The error was reported by the system as follows: $sms_status</br>

                                              </p>
                                              <hr>
                                              <p class='mb-0'>
                                                If you have any questions about the error, please contact us at info@smsly.ch
                                              </p>
                                            </div>";
                              };

                              if (is_numeric($sender_cost) && $sender_cost < 0) {
                                // Wird ausgeführt, wenn $sender_cost eine Zahl ist und kleiner als 0
                                $cost = "$sender_cost";
                              } elseif ($sender_cost === "-") {
                                // Wird ausgeführt, wenn $sender_cost genau das Minuszeichen "-" ist
                                $cost = "0";
                              } else {
                                // Wird ausgeführt, wenn keine der obigen Bedingungen zutrifft
                                $cost = "$sender_cost";
                              }

                              echo "<tr>
                                            <td>$id</td>
                                            <td>$sms_from_decodeed</td>
                                            <td>$sms_to</td>
                                            <td>$sms_status_badge</td>
                                            <td>$formattedTime</td>
                                            <td>
                                              <div>
                                                <button type='button' class='justify-content-center btn mb-1 btn-rounded btn-outline-info d-flex align-items-center' data-bs-toggle='modal' data-bs-target='#bs-example-modal-xlg$popout'>
                                                  <i class='ti ti-info-circle'></i>
                                                </button>
                                                <!-- ------------------------------------------ -->
                                                <!-- Extra Large -->
                                                <!-- ------------------------------------------ -->
                                                <!-- sample modal content -->
                                                <div class='modal fade' id='bs-example-modal-xlg$popout' tabindex='-1' aria-labelledby='bs-example-modal-lg' style='display: none;' aria-hidden='true'>
                                                  <div class='modal-dialog modal-xl'>
                                                    <div class='modal-content'>
                                                      <div class='col-lg-12'>
                
                                                        <div class='px-4 py-3 border-bottom'>
                                                          <h5 class='card-title fw-semibold mb-0'>SMS History details</h5>
                                                        </div>
                                                        <div class='card-body p-4'>
                                                          <div class='card-body p-4 border-bottom'>
                                                            <div class='row'>
                                                            $error_text
                                                              <div class='col-lg-6'>
                                                                <div class='mb-4'>
                                                                  <label for='exampleInputtext3' class='form-label fw-semibold'>Cost:</label>
                                                                  <input type='text' class='form-control' id='exampleInputtext3' value='$cost' readonly>
                                                                </div>
                                                                <div class=''>
                                                                  <div class='mb-4'>
                                                                    <label for='exampleInputPassword1' class='form-label fw-semibold'>From:</label>
                                                                    <div class='input-group border rounded-1'>
                                                                      <input type='text' class='form-control border-0' id='inputPassword' value='$sms_from' readonly>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <div class='col-lg-6'>
                                                                <div class='mb-4'>
                                                                  <label for='exampleInputPassword1' class='form-label fw-semibold'>Status:</label>
                                                                  <div class='input-group border rounded-1'>
                                                                    <input type='text' class='form-control border-0' value='$sms_status_txt' readonly>
                                                                  </div>
                                                                </div>
                                                                <div class='mb-4'>
                                                                  <div class=''>
                                                                    <label for='exampleInputPassword1' class='form-label fw-semibold'>To:</label>
                                                                    <div class='input-group border rounded-1'>
                                                                      <input type='text' class='form-control border-0' id='inputPassword' value='$sms_to' readonly>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <div class='col-lg-12'>
                                                                <div class='mb-4'>
                                                                  <label for='exampleInputPassword1' class='form-label fw-semibold'>Email</label>
                                                                  <textarea class='form-control p-7' name='' id='' cols='20' rows='5' placeholder='SMS Message' readonly>$sms_message_decodeed</textarea>
                                                                </div>
                                                              </div>
                                                            </div>
                                                          </div>
                
                                                        </div>
                
                                                      </div>
                                                      <div class='modal-footer'>
                                                        <button type='button' class='btn bg-info-subtle text-info font-medium waves-effect text-start' data-bs-dismiss='modal'>
                                                          Close
                                                        </button>
                                                      </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                  </div>
                                                  <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->
                                              </div>
                                            </td>
                                          </tr>";
                              $popout++;
                            }
                          } else { */
                            echo "<tr>
                                        <td></td>
                                        <td></td>
                                        <td>No SMS sent found...</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>";
                          /* }
                          $conn->close(); */
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