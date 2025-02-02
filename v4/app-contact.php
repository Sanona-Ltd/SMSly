<?php session_start(); ?>
<?php include("./v3/auth-app/is-login.php"); ?>
<?php $dateipfad = "./version.txt"; ?>
<?php if (isset($_SESSION['smsly.admin'])) {
  // Code, der ausgeführt werden soll, wenn die Session-Variable gesetzt ist
} else {
  header("Location: ./");
}
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
                  <h4 class="fw-semibold mb-8">Contact</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="/v3/">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">Contact</li>
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

          <div class="widget-content searchable-container list">
            <div class="card card-body">
              <div class="row">
                <div class="col-md-4 col-xl-3">
                  <form class="position-relative">
                    <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Search Contacts..." />
                    <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                  </form>
                </div>
                <!-- <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                  <a href="javascript:void(0)" id="btn-add-contact" class="btn btn-info d-flex align-items-center">
                    <i class="ti ti-users text-white me-1 fs-5"></i> Add Contact
                  </a>
                </div> -->
              </div>
            </div>
            <div class="card card-body">
              <div class="table-responsive">
                <table class="table search-table align-middle text-nowrap">
                  <thead class="header-item">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Action</th>
                  </thead>
                  <tbody>

                    <?php

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://auth.smsly.ch/api/users',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'GET',
                      CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        'Content-Type: application/json',
                        'Authorization: Bearer 174|7kUa4RkVhGPwgOVKBNKcNVLoaBMK9m8cFbW4tlib'
                      ),
                    ));

                    $response = curl_exec($curl);

                    if (curl_errno($curl)) {
                      echo 'Curl error: ' . curl_error($curl);
                    }

                    curl_close($curl);

                    // Konvertieren Sie die JSON-Daten in ein PHP-Array
                    $data = json_decode($response, true);

                    // Funktion, um Benutzerdaten für alle Benutzer auszugeben
                    function printAllUserDataBar($data)
                    {
                      foreach ($data['data'] as $user) {
                        $id = $user['id'] ?? 'N/A';
                        $firstName = $user['first_name'] ?? 'N/A';
                        $lastName = $user['last_name'] ?? 'N/A';
                        $address = $user['address'] ?? 'N/A';
                        $username = $user['username'];
                        $email = $user['email'];

                        echo "
                        <!-- start row -->
                        <tr class='search-items'>
                          <td>
                            <div class='d-flex align-items-center'>
                              <!-- <img src='assets/images/profile/user-1.jpg' alt='avatar' class='rounded-circle' width='35' /> -->
                              <div class=''>
                                <div class='user-meta-info'>
                                  <h6 class='user-name mb-0' data-name='$firstName $lastName'>$firstName $lastName</h6>
                                  <span class='user-work fs-3' data-occupation='$username'>$username</span>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span class='usr-email-addr' data-email='$email'>$email</span>
                          </td>
                          <td>
                            <span class='usr-location' data-location='$address'>$address</span>
                          </td>
                          <td>
                            <div class='action-btn'>
                              <a href='admin-user-info?user=$id' class='text-info edit'>
                                <i class='ti ti-eye fs-5'></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                        <!-- end row -->";
                      }
                    }

                    // Rufen Sie die Funktion auf, um die Daten aller Benutzer auszugeben
                    printAllUserDataBar($data);

                    ?>


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

  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/js/app.min.js"></script>
  <script src="assets/js/app.init.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/libs/simplebar/dist/simplebar.min.js"></script>

  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/theme.js"></script>

  <script src="assets/libs/fullcalendar/index.global.min.js"></script>
  <script src="assets/js/apps/contact.js"></script>
</body>

</html>