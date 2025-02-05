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
                  <h4 class="fw-semibold mb-8">Payment history</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Payment history</li>
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

          <div class="card w-100 position-relative overflow-hidden">
            <div class="px-4 py-3 border-bottom">
              <h5 class="card-title fw-semibold mb-0 lh-sm">Overview of all payments to SMSly.ch</h5>
            </div>
            <div class="card-body p-4">

              <div class="table-responsive rounded-2 mb-4">
                <table class="table border text-nowrap customize-table mb-0 align-middle">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Invoice</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Product</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Action</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                      </th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>


                    <?php

                    // Zahl mit führenden Nullen auffüllen
                    function padNumber($number)
                    {
                      return str_pad($number, 6, "0", STR_PAD_LEFT);
                    }

                    // Führende Nullen entfernen
                    function unpadNumber($number)
                    {
                      return ltrim($number, "0");
                    }

                    // Neue API-Abfrage
                    $curl = curl_init();
                    $email = urlencode($_SESSION['email']); // E-Mail aus der Session

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/payments?whereRelation[user][email]={$email}&timestamps=null",
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

                    $payments = json_decode($response, true);

                    if (!empty($payments)) {
                        foreach ($payments as $payment) {
                            $id = $payment['id'];
                            $hash = $payment['hash'];
                            $link = $payment['link'];
                            $payment_id = $payment['payment_id'];
                            $product = $payment['product_name'];
                            $contingent = $payment['contingent'];
                            $payment_status = $payment['payment_status'];

                            // Status-Badge basierend auf payment_status
                            if ($payment_status == "open") {
                                $payment_status_badge = "<span class='badge bg-warning-subtle rounded-3 py-2 text-warning fw-semibold fs-2 d-inline-flex align-items-center gap-1'>
                                                        <div class='spinner-border text-warning spinner-border-sm' role='status'><span class='visually-hidden'>Loading...</span></div>pending
                                                      </span>";
                                $action_dropdown = "<div class='dropdown dropstart'>
                                                    <a href='#' class='text-muted' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                                                        <i class='ti ti-dots-vertical fs-6'></i>
                                                    </a>
                                                    <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                        <li>
                                                            <a class='dropdown-item d-flex align-items-center gap-3' href='$link'><i class='fs-4 ti ti-receipt-2'></i>Pay Now</a>
                                                        </li>
                                                        <li>
                                                            <a class='dropdown-item d-flex align-items-center gap-3' href='app/cancel-payment?id=$hash'><i class='fs-4 ti ti-circle-x'></i>Cancel Payment</a>
                                                        </li>
                                                    </ul>
                                                </div>";
                            } elseif ($payment_status == "cancelled") {
                                $payment_status_badge = "<span class='badge bg-danger-subtle rounded-3 py-2 text-danger fw-semibold fs-2 d-inline-flex align-items-center gap-1'><i class='ti ti-x fs-4'></i>cancelled</span>";
                                $action_dropdown = "<div class='dropdown dropstart'>
                                                    <a href='#' class='text-muted' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                                                        <i class='ti ti-dots-vertical fs-6'></i>
                                                    </a>
                                                    <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                        <li>
                                                            <a class='dropdown-item d-flex align-items-center gap-3' href='/v3/invoice?id=$payment_id'><i class='fs-4 ti ti-info-circle'></i>Info</a>
                                                        </li>
                                                    </ul>
                                                </div>";
                            } elseif ($payment_status == "paid") {
                                $payment_status_badge = "<span class='badge bg-success-subtle rounded-3 py-2 text-success fw-semibold fs-2 d-inline-flex align-items-center gap-1'><i class='ti ti-check fs-4'></i>paid</span>";
                                $action_dropdown = "<div class='dropdown dropstart'>
                                                    <a href='#' class='text-muted' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
                                                        <i class='ti ti-dots-vertical fs-6'></i>
                                                    </a>
                                                    <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                                        <li>
                                                            <a class='dropdown-item d-flex align-items-center gap-3' href='/v3/invoice?id=$payment_id'><i class='fs-4 ti ti-info-circle'></i>Info</a>
                                                        </li>
                                                    </ul>
                                                </div>";
                            }

                            $paddedNumber = padNumber($id);

                            echo "<tr>
                                    <td>
                                        <h6 class='fw-semibold mb-0'>SLY-$paddedNumber</h6>
                                    </td>
                                    <td>
                                        <div class='d-flex align-items-center'>
                                            <h6 class='fs-4 fw-semibold mb-0'>$product</h6>
                                        </div>
                                    </td>
                                    <td>
                                        <span class='badge bg-light-subtle rounded-3 py-2 text-dark fw-semibold fs-2 d-inline-flex align-items-center gap-1'><i class='ti ti-text-plus fs-4'></i>add $contingent Credits</span>
                                    </td>
                                    <td>
                                        $payment_status_badge
                                    </td>
                                    <td>
                                        $action_dropdown
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td></td>
                                <td></td>
                                <td>No transaction found</td>
                                <td></td>
                                <td></td>
                              </tr>";
                    }
                    ?>


                    </tr>
                  </tbody>
                </table>
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
    /* $(document).ready(function() {
      $('#meineTabelle').DataTable({
        "order": [
          [1, "desc"]
        ] // Sortiert die erste Spalte (Index 0) in absteigender Reihenfolge
      });
    }); */
  </script>

</body>

</html>