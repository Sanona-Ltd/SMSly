<?php session_start(); ?>
<?php include("../v3/auth-app/is-login.php"); ?>
<?php $dateipfad = "../version.txt"; ?>

<?php
$firstname = $_SESSION['first_name'];
$lastname = $_SESSION['last_name'];
$adress = $_SESSION['address'];
$email = $_SESSION['email'];

$id = $_GET["id"];
if (isset($id)){
  
} else {
  header('Location: /v3/');
}
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


$hash = $_GET["id"];

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

$sql = "SELECT `id`, `user_id`, `hash`, `link`, `payment_id`, `product`, `contingent`, `price`, `product_name`, `payment_date`, `payment_status`, `reg_date` FROM `payments` WHERE `payment_id` = '$id'";
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
    $price = $row["price"];
    $product_name = $row["product_name"];
    $payment_date = $row["payment_date"];
    $payment_status = $row["payment_status"];
    $reg_date = $row["reg_date"];

    $paddedNumber = padNumber($id); // wird "000018"
    $unpaddedNumber = unpadNumber($id); // wird "18"

    // Ursprüngliches Datum
    // $originalDate = '2024-01-01 00:00:00';

    // Erstelle ein neues DateTime-Objekt
    $date = new DateTime($payment_date);

    // Setze die Locale auf Deutsch
    // setlocale(LC_TIME, 'de_DE', 'de_DE.UTF-8');

    // Konvertiere das Datum in das gewünschte Format
    $formattedDate = strftime('%e. %B. %Y', $date->getTimestamp());

    // Ausgabe des konvertierten Datums
    // echo $formattedDate;

    // Umwandlung in 5,00
    $paymentValue = number_format($price / 100, 2, ',', '');

    if ($payment_status == 0) {
      $paymentbadge = "<span class='mb-1 badge text-bg-danger'>Not yet Paid</span>";
    } elseif ($payment_status == 4) {
      $paymentbadge = "<span class='mb-1 badge text-bg-warning'>Cancelled</span>";
    } elseif ($payment_status == 6) {
      $paymentbadge = "<span class='mb-1 badge text-bg-info'>Refunded</span>";
    } elseif ($payment_status == 9) {
      $paymentbadge = "<span class='mb-1 badge text-bg-success'>Paid</span>";
    }
  }
} else {
  echo "0 results";
}
$conn->close();
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
                  <h4 class="fw-semibold mb-8">Invoice</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="/v3/">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Invoice</li>
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

          <div class="card overflow-hidden invoice-application">
            <div class="col-12 d-flex">
              <div class="w-100 w-xs-100 chat-container">
                <div class="invoice-inner-part h-100">
                  <div class="invoiceing-box">
                    <div class="invoice-header d-flex align-items-center border-bottom p-3">
                      <h4 class="font-medium text-uppercase mb-0">Invoice - <?= $paddedNumber ?></h4>
                      <div class="ms-auto">
                        <h4 class="invoice-number"></h4>
                      </div>
                    </div>
                    <div class="p-3" id="custom-invoice">
                      <div class="invoice-<?= $paddedNumber ?>" id="printableArea">
                        <div class="row pt-3">
                          <div class="col-md-12">

                            <div class="">
                              <address>
                                <h6>&nbsp;From,</h6>
                                <h6 class="fw-bold">&nbsp;SMSly.ch </br> &nbsp;by Sanona Ltd.</h6>
                                <p class="ms-1">
                                  Mitteldorfstrasse 51, <br /> 3072 - Ostermundigen
                                  <br /> Switzerland
                                </p>
                              </address>
                            </div>

                            <div class="">
                              <address>

                                <p class="mt-4 mb-1">
                                  <span>Invoice Number :</span>
                                  SLY - <?= $paddedNumber ?>
                                </p>
                                <p class="mb-1">
                                  <span>Invoice Date :</span>
                                  <i class="ti ti-calendar"></i>
                                  <?= $formattedDate ?>
                                </p>
                                <p class="mb-1">
                                  <span>Due Date :</span>
                                  <i class="ti ti-calendar"></i>
                                  <?= $formattedDate ?>
                                </p>
                                <p class="mt-4 mb-1">
                                  <span>Status : </span>
                                  <?= $paymentbadge ?>
                                </p>
                              </address>
                            </div>

                            <div class="text-end">
                              <address>
                                <h6>To,</h6>
                                <h6 class="fw-bold invoice-customer">
                                  <?= $firstname ?> <?= $lastname ?>,
                                </h6>
                                <p class="ms-4">
                                  <?= $adress ?>
                                </p>
                                <p class="ms-4">
                                  <?= $email ?>
                                </p>
                                <!-- <p class="mt-4 mb-1">
                                  <span>Status : </span>
                                  <span class="mb-1 badge text-bg-success">Paid</span>
                                </p>
                                <p class="mt-4 mb-1">
                                  <span>Invoice Date :</span>
                                  <i class="ti ti-calendar"></i>
                                  23rd Jan 2021
                                </p>
                                <p>
                                  <span>Due Date :</span>
                                  <i class="ti ti-calendar"></i>
                                  25th Jan 2021
                                </p> -->
                              </address>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="table-responsive mt-5" style="clear: both">
                              <table class="table table-hover">
                                <thead>
                                  <!-- start row -->
                                  <tr>
                                    <th class="text-center">#</th>
                                    <th>Description</th>
                                    <th class="text-end">Quantity</th>
                                    <th class="text-end">Unit Cost</th>
                                    <th class="text-end">Total</th>
                                  </tr>
                                  <!-- end row -->
                                </thead>
                                <tbody>
                                  <!-- start row -->
                                  <tr>
                                    <td class="text-center">1</td>
                                    <td><?= $product_name ?></td>
                                    <td class="text-end">1</td>
                                    <td class="text-end"><?= $paymentValue ?> CHF</td>
                                    <td class="text-end"><?= $paymentValue ?> CHF</td>
                                  </tr>
                                  <!-- end row -->
                                </tbody>
                              </table>
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="pull-right mt-4 text-end">
                              <p>Sub - Total amount: <?= $paymentValue ?> CHF</p>
                              <!-- <p>vat (10%) : 2,085</p> -->
                              <hr />
                              <h3><b>Total :</b> <?= $paymentValue ?> CHF</h3>
                            </div>
                            <div class="clearfix"></div>
                            <hr />
                            <div class="text-end">
                              <?php 
                              if ($payment_status == 0){
                              echo "<a class='btn btn-info' href='$link' type='submit'>
                                      Continue to payment of invoice SLY - $paddedNumber</a>";
                              }; ?>
                              
                              <button class="btn btn-primary btn-default print-page" type="button">
                                <span><i class="ti ti-printer fs-5"></i>
                                  Print</span>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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

  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/js/app.init.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.min.js"></script>

  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/theme.js"></script>

  <script src="assets/libs/fullcalendar/index.global.min.js"></script>
  <script src="assets/js/apps/invoice.js"></script>
  <script src="assets/js/apps/jquery.PrintArea.js"></script>
</body>

</html>