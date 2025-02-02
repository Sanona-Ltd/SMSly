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
                  <h4 class="fw-semibold mb-8">All User</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="./">Home</a>
                      </li>
                      <li class="breadcrumb-item" aria-current="page">All User</li>
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

          <div class="card overflow-hidden chat-application">
            <div class="d-flex align-items-center justify-content-between gap-3 m-3 d-lg-none">
              <button class="btn btn-primary d-flex" type="button" data-bs-toggle="offcanvas" data-bs-target="#chat-sidebar" aria-controls="chat-sidebar">
                <i class="ti ti-menu-2 fs-5"></i>
              </button>
              <form class="position-relative w-100">
                <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search Contact">
                <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
              </form>
            </div>
            <div class="d-flex w-100">
              <!-- <div class="left-part border-end w-20 flex-shrink-0 d-none d-lg-block">
                <div class="px-9 pt-4 pb-3">
                  <button class="btn btn-primary fw-semibold py-8 w-100">Add New Contact</button>
                </div>
                <ul class="list-group" style="height: calc(100vh - 400px)" data-simplebar>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-inbox fs-5"></i>All Contacts </a>
                  </li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-star"></i>Starred </a>
                  </li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-file-text fs-5"></i>Pening Approval </a>
                  </li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-alert-circle"></i>Blocked </a>
                  </li>
                  <li class="border-bottom my-3"></li>
                  <li class="fw-semibold text-dark text-uppercase mx-9 my-2 px-3 fs-2">CATEGORIES</li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-bookmark fs-5 text-primary"></i>Engineers </a>
                  </li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-bookmark fs-5 text-warning"></i>Support Staff </a>
                  </li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-bookmark fs-5 text-success"></i>Sales Team </a>
                  </li>
                </ul>
              </div> -->
              <div class="d-flex w-100">
                <div class="min-width-340">
                  <div class="border-end user-chat-box h-100">
                    <div class="px-4 pt-9 pb-6 d-none d-lg-block">
                      <form class="position-relative">
                        <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh" placeholder="Search" />
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                      </form>
                    </div>
                    <div class="app-chat">
                      <ul class="chat-users" style="height: calc(100vh - 400px)" data-simplebar>



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
                            $firstName = $user['first_name'] ?? 'N/A';
                            $lastName = $user['last_name'] ?? 'N/A';
                            $email = $user['email'];

                            echo "
                                  <li>
                                      <a href='javascript:void(0)' class='px-4 py-3 bg-hover-light-black d-flex align-items-center chat-user bg-light' id='chat_user_" . $user['id'] . "' data-user-id='" . $user['id'] . "'>
                                          <div class='ms-6 d-inline-block w-75'>
                                              <h6 class='mb-1 fw-semibold chat-title'>{$firstName} {$lastName}</h6>
                                              <span class='fs-2 text-body-color d-block'>{$email}</span>
                                          </div>
                                      </a>
                                  </li>";
                          }
                        }

                        // Rufen Sie die Funktion auf, um die Daten aller Benutzer auszugeben
                        printAllUserDataBar($data);

                        ?>

                      </ul>
                    </div>
                  </div>
                </div>
                <div class=" w-100">
                  <div class="chat-container h-100 w-100">
                    <div class="chat-box-inner-part h-100">
                      <div class="chatting-box app-email-chatting-box">
                        <div class="p-9 py-3 border-bottom chat-meta-user d-flex align-items-center justify-content-between">
                          <h5 class="text-dark mb-0 fw-semibold">Contact Details</h5>
                          <ul class="list-unstyled mb-0 d-flex align-items-center">
                            <li class="d-lg-none d-block">
                              <a class="text-dark back-btn px-2 fs-5 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                                <i class="ti ti-arrow-left"></i>
                              </a>
                            </li>
                            <li class="position-relative" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="important">
                              <a class="text-dark px-2 fs-5 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                                <i class="ti ti-star"></i>
                              </a>
                            </li>
                            <li class="position-relative" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                              <a class="d-block text-dark px-2 fs-5 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                                <i class="ti ti-pencil"></i>
                              </a>
                            </li>
                            <li class="position-relative" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                              <a class="text-dark px-2 fs-5 bg-hover-primary nav-icon-hover position-relative z-index-5" href="javascript:void(0)">
                                <i class="ti ti-trash"></i>
                              </a>
                            </li>
                          </ul>
                        </div>
                        <div class="position-relative overflow-hidden">
                          <div class="position-relative">
                            <div class="chat-box p-9" style="height: calc(100vh - 428px)" data-simplebar="init">
                              <div class="simplebar-wrapper" style="margin: -20px;">
                                <div class="simplebar-height-auto-observer-wrapper">
                                  <div class="simplebar-height-auto-observer"></div>
                                </div>
                                <div class="simplebar-mask">
                                  <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;">
                                      <div class="simplebar-content" style="padding: 20px;">

                                        <?php
                                        $curl = curl_init();

                                        // Laden Sie den API-Schlüssel aus einer Umgebungsdatei oder einer sicheren Quelle
                                        $api_key = '174|7kUa4RkVhGPwgOVKBNKcNVLoaBMK9m8cFbW4tlib';

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
                                            'Authorization: Bearer ' . $api_key
                                          ),
                                        ));

                                        $response = curl_exec($curl);

                                        if (curl_errno($curl)) {
                                          echo 'Curl error: ' . curl_error($curl);
                                        }

                                        curl_close($curl);

                                        $data = json_decode($response, true);

                                        if (!is_array($data) || !isset($data['data'])) {
                                          die("Fehler beim Abrufen der Daten oder ungültiges Datenformat.");
                                        }

                                        function printAllUserData($data)
                                        {
                                          foreach ($data['data'] as $user) {
                                            // Dynamisches Laden der Benutzerinformationen, falls verfügbar
                                            $firstName = $user['first_name'] ?? 'N/A';
                                            $lastName = $user['last_name'] ?? 'N/A';
                                            $address = $user['address'] ?? 'N/A';
                                            $email = $user['email'] ?? 'N/A';
                                            $phone = $user['phone'] ?? 'N/A';
                                            // ... Fügen Sie hier zusätzliche Felder hinzu, wie Telefonnummer, Adresse usw.

                                            // Ausgabe der Benutzerdaten
                                            echo "
                                              <div class='chat-list chat active-chat' data-user-id='" . $user['id'] . "'>
                                                <div class='hstack align-items-start mb-7 pb-1 align-items-center justify-content-between'>
                                                  <div class='d-flex align-items-center gap-3'>
                                                    <div>
                                                      <h6 class='fw-semibold fs-4 mb-0'>{$firstName} {$lastName} </h6>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class='row'>
                                                  <div class='col-4 mb-7'>
                                                    <p class='mb-1 fs-2'>Phone number</p>
                                                    <h6 class='fw-semibold mb-0'>{$phone}</h6>
                                                  </div>
                                                  <div class='col-8 mb-7'>
                                                    <p class='mb-1 fs-2'>Email address</p>
                                                    <h6 class='fw-semibold mb-0'>{$email}</h6>
                                                  </div>
                                                  <div class='col-12 mb-9'>
                                                    <p class='mb-1 fs-2'>Address</p>
                                                    <h6 class='fw-semibold mb-0'>{$address}</h6>
                                                  </div>
                                                  <div class='col-8 mb-7'>
                                                    <p class='mb-1 fs-2'>Country</p>
                                                    <h6 class='fw-semibold mb-0'>Switzerland</h6>
                                                  </div>
                                                </div>
                                                <div class='border-bottom pb-7 mb-4'>
                                                  <p class='mb-2 fs-2'>Notes</p>
                                                  <p class='mb-0 text-dark'>No notes...</p>
                                                </div>
                                                <!-- <div class='d-flex align-items-center gap-2'>
                                                  <button class='btn btn-primary fs-2' fdprocessedid='pk6kl8'>Edit</button>
                                                  <button class='btn btn-danger fs-2' fdprocessedid='83zpb'>Delete</button>
                                                </div> -->
                                              </div>";
                                          }
                                        }

                                        printAllUserData($data);
                                        ?>


                                        <div class="chat-list chat" data-user-id="2">
                                          <div class="hstack align-items-start mb-7 pb-1 align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-3">
                                              <img src="./assets/images/profile/user-4.jpg" alt="user4" width="72" height="72" class="rounded-circle">
                                              <div>
                                                <h6 class="fw-semibold fs-4 mb-0">Jonathan Higgins</h6>
                                                <p class="mb-0">Sales Manager</p>
                                                <p class="mb-0">Digital Arc Pvt. Ltd.</p>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="col-4 mb-7">
                                              <p class="mb-1 fs-2">Phone number</p>
                                              <h6 class="fw-semibold mb-0">+1 (203) 3458</h6>
                                            </div>
                                            <div class="col-8 mb-7">
                                              <p class="mb-1 fs-2">Email address</p>
                                              <h6 class="fw-semibold mb-0">alexandra@modernize.com</h6>
                                            </div>
                                            <div class="col-12 mb-9">
                                              <p class="mb-1 fs-2">Address</p>
                                              <h6 class="fw-semibold mb-0">312, Imperical Arc, New western corner</h6>
                                            </div>
                                            <div class="col-4 mb-7">
                                              <p class="mb-1 fs-2">City</p>
                                              <h6 class="fw-semibold mb-0">New York</h6>
                                            </div>
                                            <div class="col-8 mb-7">
                                              <p class="mb-1 fs-2">Country</p>
                                              <h6 class="fw-semibold mb-0">United Stats</h6>
                                            </div>
                                          </div>
                                          <div class="border-bottom pb-7 mb-4">
                                            <p class="mb-2 fs-2">Notes</p>
                                            <p class="mb-3 text-dark">
                                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque bibendum
                                              hendrerit lobortis. Nullam ut lacus eros. Sed at luctus urna, eu fermentum
                                              diam.
                                              In et tristique mauris.
                                            </p>
                                            <p class="mb-0 text-dark">Ut id ornare metus, sed auctor enim. Pellentesque
                                              nisi magna, laoreet a augue eget, tempor volutpat diam.</p>
                                          </div>
                                          <div class="d-flex align-items-center gap-2">
                                            <button class="btn btn-primary fs-2">Edit</button>
                                            <button class="btn btn-danger fs-2">Delete</button>
                                          </div>
                                        </div>


                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="simplebar-placeholder" style="width: auto; height: 578px;"></div>
                              </div>
                              <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                              </div>
                              <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                <div class="simplebar-scrollbar" style="height: 128px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="offcanvas offcanvas-start user-chat-box" tabindex="-1" id="chat-sidebar" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header">
                  <h5 class="offcanvas-title" id="offcanvasExampleLabel"> Contact </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="px-9 pt-4 pb-3">
                  <button class="btn btn-primary fw-semibold py-8 w-100">Add New Contact</button>
                </div>
                <ul class="list-group" style="height: calc(100vh - 150px)" data-simplebar>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-inbox fs-5"></i>All Contacts </a>
                  </li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-star"></i>Starred </a>
                  </li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-file-text fs-5"></i>Pening Approval </a>
                  </li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-alert-circle"></i>Blocked </a>
                  </li>
                  <li class="border-bottom my-3"></li>
                  <li class="fw-semibold text-dark text-uppercase mx-9 my-2 px-3 fs-2">CATEGORIES</li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-bookmark fs-5 text-primary"></i>Engineers </a>
                  </li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-bookmark fs-5 text-warning"></i>Support Staff </a>
                  </li>
                  <li class="list-group-item border-0 p-0 mx-9">
                    <a class="d-flex align-items-center gap-2 list-group-item-action text-dark px-3 py-8 mb-1 rounded-1" href="javascript:void(0)">
                      <i class="ti ti-bookmark fs-5 text-success"></i>Sales Team </a>
                  </li>
                </ul>
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

  <script src="./assets/js/apps/chat.js"></script>
</body>

</html>