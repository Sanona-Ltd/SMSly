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
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />

  <!-- Core Css -->
  <link rel="stylesheet" href="../assets/css/styles.css" />

  <!-- Analytics -->
  <?php include("app/analytics.php"); ?>

  <title>SMSly | V4</title>
</head>

<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="../assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid" />
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
                  <h4 class="fw-semibold mb-8">checkout</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">checkout</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3">
                  <div class="text-center mb-n5">
                    <img src="../assets/images/breadcrumb/ChatBc.png" alt="" class="img-fluid mb-n4" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="checkout">
            <div class="card shadow-none border">
              <div class="card-body p-4">
                <div class="wizard-content">
                  <form action="#" class="tab-wizard wizard-circle">
                    <!-- Step 1 -->
                    <h6>Cart</h6>
                    <section>
                      <div class="table-responsive">
                        <table class="table align-middle text-nowrap mb-0">
                          <thead class="fs-2">
                            <tr>
                              <th>Product</th>
                              <th>Quantity</th>
                              <th class="text-end">Price</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="border-bottom-0">
                                <div class="d-flex align-items-center gap-3 overflow-hidden">
                                  <div>
                                    <h6 class="fw-semibold fs-4 mb-0">Cute Soft Teddybear</h6>
                                    <p class="mb-0">toys</p>
                                    <a href="javascript:void(0)" class="text-danger fs-4"><i class="ti ti-trash"></i></a>
                                  </div>
                                </div>
                              </td>
                              <td class="border-bottom-0">
                                <div class="input-group input-group-sm flex-nowrap rounded">
                                  <p class="mb-0">1x</p>
                                </div>
                              </td>
                              <td class="text-end border-bottom-0">
                                <h6 class="fs-4 fw-semibold mb-0">$285</h6>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div class="order-summary border rounded p-4 my-4">
                        <div class="p-3">
                          <h5 class="fs-5 fw-semibold mb-4">Order Summary</h5>
                          <div class="d-flex justify-content-between mb-4">
                            <p class="mb-0 fs-4">Sub Total</p>
                            <h6 class="mb-0 fs-4 fw-semibold">$285</h6>
                          </div>
                          <!-- <div class="d-flex justify-content-between mb-4">
                            <p class="mb-0 fs-4">Discount 5%</p>
                            <h6 class="mb-0 fs-4 fw-semibold text-danger">-$14</h6>
                          </div> -->
                          <div class="d-flex justify-content-between mb-4">
                            <p class="mb-0 fs-4">Shipping</p>
                            <h6 class="mb-0 fs-4 fw-semibold">Digital</h6>
                          </div>
                          <div class="d-flex justify-content-between">
                            <h6 class="mb-0 fs-4 fw-semibold">Total</h6>
                            <h6 class="mb-0 fs-5 fw-semibold">$271</h6>
                          </div>
                        </div>
                      </div>
                    </section>
                    <!-- Step 2 -->
                    <h6>Billing & address</h6>
                    <section>
                      <div class="billing-address-content">
                        <div class="row">
                          <div class="col-lg-4">
                          </div>
                          <div class="col-lg-4">
                            <div class="card shadow-none border">
                              <div class="card-body p-4">
                                <h6 class="mb-3 fs-4 fw-semibold"><?= $GLOBAL_VARIABLE_name ?> <?= $GLOBAL_VARIABLE_surname ?></h6>
                                <p class="mb-1 fs-2"><?= $GLOBAL_VARIABLE_address_street ?> <?= $GLOBAL_VARIABLE_address_number ?>,<br> <?= $GLOBAL_VARIABLE_address_zip ?> <?= $GLOBAL_VARIABLE_address_place ?><br><?= $GLOBAL_VARIABLE_address_country ?></p>
                                <h6 class="d-flex align-items-center gap-2 my-4 fw-semibold fs-4"><i class="ti ti-device-mobile fs-7"></i><?= $GLOBAL_VARIABLE_email ?></h6>
                                <!-- <a href="javascript:void(0)" class="btn btn-outline-primary  billing-address">Deliver To
                                  this address</a> -->
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-4">
                          </div>
                        </div>
                        <div class="order-summary border rounded p-4 my-4">
                          <div class="p-3">
                            <h5 class="fs-5 fw-semibold mb-4">Order Summary</h5>
                            <div class="d-flex justify-content-between mb-4">
                              <p class="mb-0 fs-4">Sub Total</p>
                              <h6 class="mb-0 fs-4 fw-semibold">$285</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                              <p class="mb-0 fs-4">Discount 5%</p>
                              <h6 class="mb-0 fs-4 fw-semibold text-danger">-$14</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                              <p class="mb-0 fs-4">Shipping</p>
                              <h6 class="mb-0 fs-4 fw-semibold">Free</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                              <h6 class="mb-0 fs-4 fw-semibold">Total</h6>
                              <h6 class="mb-0 fs-5 fw-semibold">$271</h6>
                            </div>
                          </div>
                        </div>
                      </div>

                    </section>
                    <!-- Step 3 -->
                    <h6>Payment</h6>
                    <section class="payment-method text-center">
                      <div class="payment-method-list payment-method">
                        <div class="delivery-option btn-group-active  card shadow-none border">
                          <div class="card-body p-4">
                            <h6 class="mb-3 fw-semibold fs-4">Delivery Option</h6>
                            <div class="btn-group row w-100" role="group" aria-label="Basic radio toggle button group">
                              <div class="position-relative col-lg-6">
                                <input type="radio" class="btn-check z-1 top-50 start-0 ms-4 round-16 position-relative" name="deliveryOpt1" id="btnradio1" autocomplete="off" checked>
                                <label class="btn btn-outline-primary mb-0 p-3 rounded ps-5 w-100" for="btnradio1">
                                  <div class="text-start ps-2">
                                    <h6 class="fs-4 fw-semibold mb-0">Free delivery</h6>
                                    <p class="mb-0 text-muted">Delivered on Firday, May 10</p>
                                  </div>
                                </label>
                              </div>
                              <div class="position-relative col-lg-6">
                                <input type="radio" class="btn-check z-1 top-50 start-0 ms-4 round-16 position-relative" name="deliveryOpt1" id="btnradio2" autocomplete="off">
                                <label class="btn btn-outline-primary mb-0 p-3 rounded ps-5 w-100" for="btnradio2">
                                  <div class="text-start ps-2">
                                    <h6 class="fs-4 fw-semibold mb-0">Fast delivery ($2,00)</h6>
                                    <p class="mb-0 text-muted">Delivered on Wednesday, May 8</p>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="payment-option btn-group-active  card shadow-none border">
                          <div class="card-body p-4">
                            <h6 class="mb-3 fw-semibold fs-4">Payment Option</h6>
                            <div class="row">
                              <div class="col-lg-8">
                                <div class="btn-group row" role="group" aria-label="Basic radio toggle button group">
                                  <div class="position-relative col-12 mb-3">
                                    <input type="radio" class="btn-check z-1 top-50 start-0 ms-4 round-16 position-relative" name="paymentType1" id="btnradio3" autocomplete="off" checked>
                                    <label class="btn btn-outline-primary mb-0 p-3 rounded ps-5 w-100" for="btnradio3">
                                      <div class="d-flex align-items-center">
                                        <div class="text-start ps-2">
                                          <h6 class="fs-4 fw-semibold mb-0">Pay with Paypal</h6>
                                          <p class="mb-0 text-muted">You will be redirected to PayPal website to
                                            complete your purchase securely.</p>
                                        </div>
                                        <img src="../assets/images/svgs/paypal.svg" alt="" class="img-fluid ms-auto">
                                      </div>
                                    </label>
                                  </div>
                                  <div class="position-relative col-12 mb-3">
                                    <input type="radio" class="btn-check z-1 top-50 start-0 ms-4 round-16 position-relative" name="paymentType1" id="btnradio4" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-0 p-3 rounded ps-5 w-100" for="btnradio4">
                                      <div class="d-flex align-items-center">
                                        <div class="text-start ps-2">
                                          <h6 class="fs-4 fw-semibold mb-0">Credit / Debit Card</h6>
                                          <p class="mb-0 text-muted">We support Mastercard, Visa, Discover and Stripe.
                                          </p>
                                        </div>
                                        <img src="../assets/images/svgs/mastercard.svg" alt="" class="img-fluid ms-auto">
                                      </div>
                                    </label>
                                  </div>
                                  <div class="position-relative col-12">
                                    <input type="radio" class="btn-check z-1 top-50 start-0 ms-4 round-16 position-relative" name="paymentType1" id="btnradio5" autocomplete="off">
                                    <label class="btn btn-outline-primary mb-0 p-3 rounded ps-5 w-100" for="btnradio5">
                                      <div class="text-start ps-2">
                                        <h6 class="fs-4 fw-semibold mb-0">Cash on Delivery</h6>
                                        <p class="mb-0 text-muted">Pay with cash when your order is delivered.</p>
                                      </div>
                                    </label>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-4">
                                <img src="../assets/images/products/payment.svg" alt="" class="img-fluid">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="order-summary border rounded p-4 my-4">
                          <div class="p-3">
                            <h5 class="fs-5 fw-semibold mb-4">Order Summary</h5>
                            <div class="d-flex justify-content-between mb-4">
                              <p class="mb-0 fs-4">Sub Total</p>
                              <h6 class="mb-0 fs-4 fw-semibold">$285</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                              <p class="mb-0 fs-4">Discount 5%</p>
                              <h6 class="mb-0 fs-4 fw-semibold text-danger">-$14</h6>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                              <p class="mb-0 fs-4">Shipping</p>
                              <h6 class="mb-0 fs-4 fw-semibold">Free</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                              <h6 class="mb-0 fs-4 fw-semibold">Total</h6>
                              <h6 class="mb-0 fs-5 fw-semibold">$271</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                  </form>
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

  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/js/app.min.js"></script>
  <script src="../assets/js/app.init.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>

  <script src="../assets/js/sidebarmenu.js"></script>
  <script src="../assets/js/theme.js"></script>

  <script src="../assets/libs/jquery-steps/build/jquery.steps.min.js"></script>
  <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
  <script src="../assets/js/forms/form-wizard.js"></script>
  <script src="../assets/js/apps/ecommerce.js"></script>
</body>

</html>