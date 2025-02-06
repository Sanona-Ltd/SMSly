<?php require_once("auth/login-checker.php"); ?>
<?php header('Content-Type: text/html; charset=utf-8'); ?>


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
                                    <h4 class="fw-semibold mb-8">Identity Platform</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="#">Home</a>
                                            </li>
                                            <li class="breadcrumb-item" aria-current="page">Identity Platform</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="col-3">
                                    <div class="text-center mb-n5">
                                        <img src="./assets/images/breadcrumb/ChatBc.png" alt=""
                                            class="img-fluid mb-n4" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h2 class="fw-bolder mb-0 fs-8 lh-base">We will check the information you provide.</h2>
                        </div>
                    </div>
                    </br>
                    </br>

                    <div class="row">
                        <div class="col-12 text-center">

                            <a href="auth/stripe-identity.php" class="btn btn-primary fw-bolder rounded-2 py-6 w-100 text-capitalize">
                                Start Verification
                            </a>
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