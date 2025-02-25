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
                  <h4 class="fw-semibold mb-8">SMS Sender</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">SMS Sender Names <?= $GLOBAL_VARIABLE_own_sender ?></li>
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
                        SMS Sender Names
                      </h5>
                      <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addSenderModal">
                        Neuen Absender hinzufügen
                      </button>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered border text-inputs-searching text-nowrap"
                        id="SMSHistory">
                        <thead>
                          <!-- start row -->
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Timestamp</th>
                            <th></th>
                          </tr>
                          <!-- end row -->
                        </thead>
                        <tbody>
                          <!-- start row -->
                          <?php

                          $popoutCode = "1";

                          $curl = curl_init();

                          curl_setopt_array(
                            $curl,
                            array(
                              CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-sender-name?whereRelation[user][email]=' . $GLOBALS_USER_EMAIL . '&timestamps=null',
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
                          curl_close($curl);

                          // Umwandeln des JSON-Strings in ein PHP-Array
                          $data = json_decode($response, true);

                          if (!empty($data)) {
                            // Durchlaufen jedes Elements in $data
                            foreach ($data as $item) {
                              // Speichern der Werte in separaten Variablen
                              $id = $item['id'];
                              $locale = $item['locale'];
                              $createdAt = $item['created_at'];
                              $updatedAt = $item['updated_at'];
                              $publishedAt = $item['published_at'];

                              // user
                              $userId = $item['user']['id'];
                              $useremail = $item['user']['email'];
                              $userusername = $item['user']['username'];

                              //
                              $SenderName = $item['sender-name'];
                              $ValidationStatus = $item['validation-status'];
                              $ReasonForRejection = $item['reason-for-rejection'];


                              // Konvertiert die Zeit in das Gewünste Format
                              $date = DateTime::createFromFormat('Y-m-d H:i:s', $createdAt);
                              $formattedDate = $date->format('H:i d.m.Y');

                              if ($ValidationStatus == "Approved") {
                                $ValidationStatusCode = "<span class='mb-1 badge font-medium bg-success-subtle text-success'>Approved</span>";
                                $ValidationRejectedButton = "";
                              } elseif ($ValidationStatus == "Under Review") {
                                $ValidationStatusCode = "<span class='mb-1 badge font-medium bg-info-subtle text-info'>Under Review</span>";
                                $ValidationRejectedButton = "";
                              } elseif ($ValidationStatus == "Rejected") {
                                $ValidationStatusCode = "<span class='mb-1 badge font-medium bg-danger-subtle text-danger'>Rejected</span>";
                                $ValidationRejectedButton = '<button class="btn mb-1 waves-effect waves-light btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modal' . $popoutCode . '">What is the reason</button>
                                  
                                  <div class="modal fade" id="modal' . $popoutCode . '" tabindex="-1" aria-labelledby="modal' . $popoutCode . '" style="display: none;" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                      <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center">
                                          <h4 class="modal-title" id="myLargeModalLabel">
                                            Reason for rejection
                                          </h4>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="col-md-12">
                                            <div class="form-floating">
                                              <div class="form-group">
                                                <textarea name="smstext" class="form-control" rows="9"
                                                  placeholder="" disabled>
' . $ReasonForRejection . '



                                                  </textarea>
                                                <small id="textHelp" class="form-text text-muted">If you wish to make an objection, please send us an mail with the subject "Sender name #' . $id . '"</small>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn bg-danger-subtle text-danger font-medium waves-effect text-start" data-bs-dismiss="modal">
                                            Close
                                          </button>
                                        </div>
                                      </div>
                                      <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                  </div>';
                              }

                              // Anzeigen der Daten
                              echo "
                              <tr>
                                <td>$id</td>
                                <td>$SenderName</td>
                                <td>$ValidationStatusCode</td>
                                <td>$formattedDate</td>
                                <td>$ValidationRejectedButton</td>
                              </tr>";
                            }
                          } else {
                            echo "
                            <tr>
                              <td></td>
                              <td></td>
                              <td>No sender name has been created...</td>
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
                            <th>Name</th>
                            <th>Status</th>
                            <th>Timestamp</th>
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

  <!-- Modal zum Hinzufügen eines neuen Absenders -->
  <div class="modal fade" id="addSenderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Neuen Absender hinzufügen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="worker/add-a-sender.php" method="POST">
            <div class="mb-3">
              <label for="senderName" class="form-label">Absendername</label>
              <input type="text" class="form-control" id="senderName" name="senderName" required>
            </div>
            <div class="mb-3">
              <label for="senderDescription" class="form-label">Beschreibung</label>
              <textarea class="form-control" id="senderDescription" name="senderDescription" rows="4" required></textarea>
            </div>
            <div class="text-end">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
              <button type="submit" class="btn btn-primary">Absender hinzufügen</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>