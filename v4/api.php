<?php session_start(); ?>
<!-- Zu Löschen bei Releas von V4 -->
<?php include("../v4/auth-app/is-login.php"); ?>
<!-- Zu Löschen bei Releas von V4 -->


<?php $filePath = "../version.txt"; ?>
<?php $SystemVersion = file_get_contents($filePath); ?>
<?php // include("../$SystemVersion/auth-app/is-login.php"); ?>


<?php include("./app/check-api-credentials.php"); ?>

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

      <?php include("app/sidebar.php"); ?>

      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">API Credentials</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">API Credentials</li>
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


          <!-- ---------------------------
            start Sample Form with the Icons
            ---------------------------- -->
          <div class="card">
            <div class="card-body">
              <h5>My API Credentials</h5>
              <p class="card-subtitle mb-3">
                Display the API credentials and build your own applications.
              </p>
              <div class="row pt-3">
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <input type="password" id="apiKeyField" class="form-control" placeholder="API Key" value="<?php echo $GLOBAL_VARIABLE_api_key ?>" readonly/>
                    <label><i class="ti ti-user me-2 fs-4"></i>API Key</label>
                  </div>
                </div>
                <!--/span-->
                <div class="col-md-6">
                  <div class="form-floating mb-3">
                    <input type="password" id="apiSecretField" class="form-control" placeholder="API Secret" value="<?php echo $GLOBAL_VARIABLE_api_secret ?>" readonly/>
                    <label><i class="ti ti-lock me-2 fs-4"></i>API Secret</label>
                  </div>
                </div>
                <!--/span-->
              </div>

              <div class="d-md-flex align-items-center">
                <div class="mt-3 mt-md-0 ms-auto">
                  <button class="btn btn-primary font-medium rounded-pill px-4" id="submitButton">
                    <div class="d-flex align-items-center">
                      <i class="ti ti-eye me-2 fs-4"></i>
                      Show me the API credentials
                    </div>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- -------------------------
            end Sample Form with the Icons
            -------------------------- -->


          <!-- <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="text-center mb-7">
                <h3 class="fw-semibold">Frequently asked questions</h3>
                <p class="fw-normal mb-0 fs-4">Get to know more about ready-to-use admin dashboard templates</p>
              </div>
              <div class="accordion accordion-flush mb-5 card position-relative overflow-hidden" id="accordionFlushExample">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed fs-4 fw-semibold shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                      What is an Admin Dashboard?
                    </button>
                  </h2>
                  <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body fw-normal">
                      Admin Dashboard is the backend interface of a website or an application that helps to manage the
                      website's overall content and settings. It is widely used by the site owners to keep track of
                      their website,
                      make changes to their content, and more.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed fs-4 fw-semibold shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                      What should an admin dashboard template include?
                    </button>
                  </h2>
                  <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body fw-normal">
                      Admin dashboard template should include user & SEO friendly design with a variety of components
                      and
                      application designs to help create your own web application with ease. This could include
                      customization
                      options, technical support and about 6 months of future updates.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button collapsed fs-4 fw-semibold shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                      Why should I buy admin templates from AdminMart?
                    </button>
                  </h2>
                  <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body fw-normal">
                      Adminmart offers high-quality templates that are easy to use and fully customizable. With over
                      101,801
                      happy customers & trusted by 10,000+ Companies. AdminMart is recognized as the leading online
                      source
                      for buying admin templates.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="flush-headingfour">
                    <button class="accordion-button collapsed fs-4 fw-semibold shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsefour" aria-expanded="false" aria-controls="flush-collapsefour">
                      Do Adminmart offers a money back guarantee?
                    </button>
                  </h2>
                  <div id="flush-collapsefour" class="accordion-collapse collapse" aria-labelledby="flush-headingfour" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body fw-normal">
                      There is no money back guarantee in most companies, but if you are unhappy with our product,
                      Adminmart
                      gives you a 100% money back guarantee.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="card bg-info-subtle rounded-2">
            <div class="card-body text-center">
              <div class="d-flex align-items-center justify-content-center mb-4 pt-8">
              </div>
              <h3 class="fw-semibold">Read the SMSly documentation</h3>
              <p class="fw-normal mb-4 fs-4">Here you can find the documentation of the platform and code examples that you can use.</p>
              <a href="https://docs.smsly.ch/" class="btn btn-primary mb-8">Jump to the documentation</a>
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
    document.getElementById("submitButton").addEventListener("click", function() {
      var apiKeyField = document.getElementById("apiKeyField");
      var apiSecretField = document.getElementById("apiSecretField");

      // Ändere den Typ von 'password' zu 'text'
      apiKeyField.type = "text";
      apiSecretField.type = "text";

      // Setze den Typ nach 30 Sekunden zurück zu 'password'
      setTimeout(function() {
        apiKeyField.type = "password";
        apiSecretField.type = "password";
      }, 30000);
    });
  </script>

</body>

</html>