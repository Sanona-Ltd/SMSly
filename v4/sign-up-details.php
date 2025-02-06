<?php session_start(); ?>

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
        <img src="./assets/images/logo.png" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 w-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="/" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                                    <img src="./assets/images/logo.png" class="dark-logo" alt="Logo-Dark" />
                                    <img src="./assets/images/logo.png" class="light-logo" alt="Logo-light" />
                                </a>

                                <?php
                                if (isset($_SESSION["errorText"])) {
                                    $errorcode = $_SESSION["errorText"];
                                    echo "<div class='alert alert-light-warning bg-danger-subtle bg-warning-subtle text-warning' role='alert'>
                                        <h4 class='alert-heading'>Oh No! An error has occurred.</h4>
                                         <p>$errorcode</p>
                                        </div>";
                                    unset($_SESSION["errorText"]);
                                }
                                ?>

                                <form method="get" action="auth-app/register2.php">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" id="exampleInputtext"
                                            aria-describedby="textHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                                        <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control"
                                            id="exampleInputPassword1">
                                    </div>
                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label">Password
                                            confirmation</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="exampleInputPassword1">
                                    </div>
                                    <input type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2"
                                        value="Sign Up">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-medium">You already have an account?</p>
                                        <a class="text-primary fw-medium ms-2" href="./sign-in">Sign In</a>
                                    </div>
                                </form>
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