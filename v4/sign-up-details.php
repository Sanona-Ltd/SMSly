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
                    <div class="col-md-12 col-lg-6">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="/" class="text-nowrap logo-img text-center d-block mb-5 w-100">
                                    <img src="./assets/images/logo.png" class="dark-logo" alt="Logo-Dark" />
                                    <img src="./assets/images/logo.png" class="light-logo" alt="Logo-light" />
                                </a>

                                <form class="">
                                    <div class="d-flex flex-column gap-sm-7 gap-3">
                                        <div class="d-flex flex-sm-row flex-column gap-sm-7 gap-3">
                                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                                <label for="Fname" class="fs-3 fw-semibold text-dark">
                                                    First Name *
                                                </label>
                                                <input type="text" name="Fname" id="Fname" placeholder="First Name"
                                                    class="form-control" spellcheck="false" data-ms-editor="true">
                                            </div>
                                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                                <label for="Lname" class="fs-3 fw-semibold text-dark">
                                                    Last Name *
                                                </label>
                                                <input type="text" name="Lname" id="Lname" placeholder="Last name"
                                                    class="form-control" spellcheck="false" data-ms-editor="true">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-sm-row flex-column gap-sm-7 gap-3">
                                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                                <label for="phone" class="fs-3 fw-semibold text-dark">
                                                    Phone Number *
                                                </label>
                                                <input type="tel" name="phone" id="phone" placeholder="XXX XXX XXXX"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <label for="enquire" class="fs-3 fw-semibold text-dark">Enquire related
                                                to *</label>
                                            <select class="form-select w-auto">
                                                <option value="1">General Enquiry</option>
                                                <option value="2">Customer Service Enquiry</option>
                                                <option value="3">Legal Enquiry</option>
                                                <option value="4">General Enquiry</option>
                                            </select>
                                        </div>
                                        <div class="d-flex flex-column gap-2">
                                            <label for="message" class="fs-3 fw-semibold text-dark">Message</label>
                                            <textarea name="message" id="message" class="form-control" rows="5"
                                                spellcheck="false" data-ms-editor="true"></textarea>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary mt-sm-7 mt-3 px-9 py-6">Submit</button>
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