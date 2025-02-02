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




                    /* $sessionid = $_SESSION['id'];

                    $servername = "localhost";
                    $username = "smsly_sms";
                    $password = "4^Y9F5y3amjecvFms";
                    $dbname = "smsly_sms";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT `id`, `user_id`, `hash`, `link`, `payment_id`, `product`, `contingent`, `payment_status`, `reg_date` FROM `payments` WHERE `user_id` = $sessionid ORDER BY id DESC;";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                      // output data of each row
                      while ($row = $result->fetch_assoc()) {
                        $id = $row["id"];
                        $user_id = $row["user_id"];
                        $hash = $row["hash"];
                        $link = $row["link"];
                        $payment_id = $row["payment_id"];
                        $product = $row["product"];
                        $contingent = $row["contingent"];
                        $payment_status = $row["payment_status"];
                        $reg_date = $row["reg_date"];

                        if ($payment_status == "0") {
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
                        } elseif ($payment_status == "4") {
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
                        } elseif ($payment_status == "6") {
                          $payment_status_badge = "<span class='badge bg-secondary-subtle rounded-3 py-2 text-secondary fw-semibold fs-2 d-inline-flex align-items-center gap-1'><i class='ti ti-arrow-back-up fs-4'></i>refunded</span>";
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
                        } elseif ($payment_status == "9") {
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


                        $paddedNumber = padNumber($id); // wird "000018"
                        $unpaddedNumber = unpadNumber($id); // wird "18"



                        echo "
                          <tr>
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
                    } else { */
                      echo "<tr>
                      <td>
                        
                      </td>
                      <td>
                        
                      </td>
                      <td>
                        No transaction found
                      </td>
                      <td>
                        
                      </td>
                      <td>
                        
                      </td>
                    </tr>";
                    /* }
                    $conn->close(); */
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