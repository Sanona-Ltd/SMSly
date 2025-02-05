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
                  <h4 class="fw-semibold mb-8">Account Setting</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Account Setting</li>
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


          <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-account" role="tabpanel"
                aria-labelledby="pills-account-tab" tabindex="0">
                <div class="row">

                  <div class="col-12">
                    <div class="card w-100 position-relative overflow-hidden mb-0">
                      <div class="card-body p-4">
                        <h5 class="card-title fw-semibold">Personal Details</h5>
                        <p class="card-subtitle mb-4">To change your personal detail , edit and save from here</p>
                        <form action="app/update-account.php" method="GET">
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="mb-4">
                                <label for="exampleInputtext" class="form-label fw-semibold">Name</label>
                                <input type="text" name="first_name" class="form-control" id="first_name"
                                  placeholder="Max" value="<?= $GLOBALS_USER_NAME ?>">
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="mb-4">
                                <label for="exampleInputtext2" class="form-label fw-semibold">Surname</label>
                                <input type="text" name="last_name" class="form-control" id="last_name"
                                  placeholder="Mustermann" value="<?= $GLOBALS_USER_SURNAME ?>">
                              </div>
                            </div>
                            <div class="col-8">
                              <div class="mb-4">
                                <label for="addressInput" class="form-label fw-semibold">Street</label>
                                <input type="text" name="address_street" class="form-control" id="address_street"
                                  placeholder="Sample street " value="<?= $GLOBALS_USER_STREET ?>">
                              </div>
                            </div>
                            <div class="col-4">
                              <div class="mb-4">
                                <label for="addressInput" class="form-label fw-semibold">Number</label>
                                <input type="text" name="address_number" class="form-control" id="address_number"
                                  placeholder="99" value="<?= $GLOBALS_USER_NUMBER ?>">
                              </div>
                            </div>
                            <div class="col-5">
                              <div class="mb-4">
                                <label for="addressInput" class="form-label fw-semibold">Zip code</label>
                                <input type="text" name="address_zip" class="form-control" id="address_zip"
                                  placeholder="1234" value="<?= $GLOBALS_USER_ZIPCODE ?>">
                              </div>
                            </div>
                            <div class="col-7">
                              <div class="mb-4">
                                <label for="addressInput" class="form-label fw-semibold">City</label>
                                <input type="text" name="address_place" class="form-control" id="address_place"
                                  placeholder="Sample City" value="<?= $GLOBALS_USER_CITY ?>">
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="mb-4">
                                <label class="form-label fw-semibold">Currency</label>
                                <select class="form-select" aria-label="Default select example">
                                  <option selected>Swiss Franc (CHF)</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="mb-4">
                                <label class="form-label fw-semibold">Location</label>
                                <select class="form-select" aria-label="Default select example">
                                  <option selected>Switzerland</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-12">
                              <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn bg-danger-subtle text-danger">Cancel</button>
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

</body>

</html>