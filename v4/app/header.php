<header class="topbar">
    <div class="with-vertical"><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Header -->
        <!-- ---------------------------------- -->
        <nav class="navbar navbar-expand-lg p-0">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse"
                        href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <!-- <li class="nav-item d-none d-lg-block">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="ti ti-search"></i>
                    </a>
                </li> -->
            </ul>

            <ul class="navbar-nav quick-links d-none d-lg-flex">
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class='nav-link' onclick="sp_sidebar_help1('contact');">Contact</a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link SP_OpenChangeLogSideBar_Cls">Chanchlog</a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link" href="https://sanona.org">Powered by Sanona Ltd.</a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link"></a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link"><?php echo $GLOBAL_VARIABLE_sms_contingent; ?> credits left</a>
                </li>
            </ul>

            <div class="d-block d-lg-none">
                <img src="./assets/images/logo2.png" width="180" alt="" />
            </div>
            <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="p-2">
                    <i class="ti ti-dots fs-7"></i>
                </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between">
                    <a href="javascript:void(0)"
                        class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                        aria-controls="offcanvasWithBothOptions">
                        <i class="ti ti-align-justified fs-7"></i>
                    </a>
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-bell-ringing"></i>
                                <!-- <div class="notification bg-primary rounded-circle"></div> -->
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop2">
                                <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                    <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                    <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">0 new</span>
                                </div>
                                <div class="message-body" data-simplebar>
                                </div>
                                <div class="py-6 px-7 mb-1">
                                    <button class="btn btn-outline-primary w-100" disabled>See All
                                        Notifications</button>
                                </div>

                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end notification Dropdown -->
                        <!-- ------------------------------- -->

                        <!-- ------------------------------- -->
                        <!-- start profile Dropdown -->
                        <!-- ------------------------------- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="./assets/images/icon.png" class="rounded-circle" width="35"
                                            height="35" alt="" />
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <img src="./assets/images/icon.png" class="rounded-circle" width="80"
                                            height="80" alt="" />
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-3"><?php // Prüfen Sie, ob 'first_name' und 'last_name' gesetzt sind und nicht leer sind
                                            if (!empty($_SESSION['first_name']) && !empty($_SESSION['last_name'])) {
                                                echo $_SESSION['first_name'] . " " . $_SESSION['last_name'];
                                            } else {
                                                // Wenn sie leer sind, geben Sie nur die E-Mail aus
                                                echo $_SESSION['email'];
                                            } ?></h5>
                                            <p class="mb-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-mail fs-4"></i> <?php echo $_SESSION['email']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <a href="./account-settings" class="py-8 px-7 mt-8 d-flex align-items-center">
                                            <span
                                                class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                <img src="./assets/images/svgs/icon-account.svg" alt="" width="24"
                                                    height="24" />
                                            </span>
                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">My Profile</h6>
                                                <span class="fs-2 d-block text-body-secondary">Account Settings</span>
                                            </div>
                                        </a>
                                        <a href="./sms-send" class="py-8 px-7 d-flex align-items-center">
                                            <span
                                                class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                <img src="./assets/images/svgs/icon-inbox.svg" alt="" width="24"
                                                    height="24" />
                                            </span>
                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">Websender</h6>
                                                <span class="fs-2 d-block text-body-secondary">Send your SMS</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-grid py-4 px-7 pt-8">
                                        <a href="./logout" class="btn btn-outline-primary">Log Out</a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- ---------------------------------- -->
        <!-- End Vertical Layout Header -->
        <!-- ---------------------------------- -->


    </div>
    <div class="app-header with-horizontal">
        <nav class="navbar navbar-expand-xl container-fluid p-0">
            <ul class="navbar-nav">
                <!-- <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler ms-n3" id="sidebarCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li> -->
                <li class="nav-item d-none d-xl-block">
                    <a href="./" class="text-nowrap nav-link">
                        <img src="./assets/images/logo2.png" class="dark-logo" width="180" alt="" />
                        <img src="./assets/images/logo2.png" class="light-logo" width="180" alt="" />
                    </a>
                </li>
                <li class="nav-item d-none d-xl-block">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        <i class="ti ti-search"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav quick-links d-none d-xl-flex">
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link" href="./sms-send">SMS Sender</a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link SP_OpenChangeLogSideBar_Cls">Chanchlog</a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link" href="https://sanona.org">Powered by Sanona Ltd.</a>
                </li>
                <li class="nav-item dropdown-hover d-none d-lg-block">
                    <a class="nav-link">25 credits left</a>
                </li>
            </ul>
            <div class="d-block d-xl-none">
                <a href="./main/index.html" class="text-nowrap nav-link">
                    <img src="./assets/images/logo2.png" width="180" alt="" />
                </a>
            </div>
            <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="p-2">
                    <i class="ti ti-dots fs-7"></i>
                </span>
            </a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center justify-content-between px-0 px-xl-8">
                    <a href="javascript:void(0)"
                        class="nav-link round-40 p-1 ps-0 d-flex d-xl-none align-items-center justify-content-center"
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar"
                        aria-controls="offcanvasWithBothOptions">
                        <i class="ti ti-align-justified fs-7"></i>
                    </a>
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-bell-ringing"></i>
                                <!-- <div class="notification bg-primary rounded-circle"></div> -->
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop2">
                                <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                    <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                    <span class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">0 new</span>
                                </div>
                                <div class="message-body" data-simplebar>
                                </div>
                                <div class="py-6 px-7 mb-1">
                                    <button class="btn btn-outline-primary w-100" disabled>See All
                                        Notifications</button>
                                </div>

                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="user-profile-img">
                                        <img src="./assets/images/icon.png" class="rounded-circle" width="35"
                                            height="35" alt="" />
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                                aria-labelledby="drop1">
                                <div class="profile-dropdown position-relative" data-simplebar>
                                    <div class="py-3 px-7 pb-0">
                                        <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                                    </div>
                                    <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                        <img src="./assets/images/icon.png" class="rounded-circle" width="80"
                                            height="80" alt="" />
                                        <div class="ms-3">
                                            <h5 class="mb-1 fs-3">
                                                <?php
                                                    if (!empty($GLOBALS_USER_NAME) && !empty($GLOBALS_USER_SURNAME)) {
                                                        echo $GLOBALS_USER_NAME . " " . $GLOBALS_USER_SURNAME;
                                                    } else {
                                                        echo $GLOBALS_USER_EMAIL;
                                                    }
                                                ?>
                                            </h5>
                                            <p class="mb-0 d-flex align-items-center gap-2">
                                                <i class="ti ti-mail fs-4"></i> <?php echo $_SESSION['email']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="message-body">
                                        <a href="./account-settings" class="py-8 px-7 mt-8 d-flex align-items-center">
                                            <span
                                                class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                <img src="./assets/images/svgs/icon-account.svg" alt="" width="24"
                                                    height="24" />
                                            </span>
                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">My Profile</h6>
                                                <span class="fs-2 d-block text-body-secondary">Account Settings</span>
                                            </div>
                                        </a>
                                        <a href="./sms-send" class="py-8 px-7 d-flex align-items-center">
                                            <span
                                                class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                                                <img src="./assets/images/svgs/icon-inbox.svg" alt="" width="24"
                                                    height="24" />
                                            </span>
                                            <div class="w-75 d-inline-block v-middle ps-3">
                                                <h6 class="mb-1 fs-3 fw-semibold lh-base">Websender</h6>
                                                <span class="fs-2 d-block text-body-secondary">Send your SMS</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-grid py-4 px-7 pt-8">
                                        <a href="./logout" class="btn btn-outline-primary">Log Out</a>
                                    </div>
                                </div>

                            </div>
                        </li>
                        <!-- ------------------------------- -->
                        <!-- end profile Dropdown -->
                        <!-- ------------------------------- -->
                    </ul>
                </div>
            </div>
        </nav>

    </div>
</header>