<aside class="left-sidebar with-vertical">
  <div><!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="./main/index.html" class="text-nowrap logo-img">
        <img src="./assets/images/logo2.png" class="dark-logo" alt="Logo-Dark" />
        <img src="./assets/images/logos/light-logo.svg" class="light-logo" alt="Logo-light" />
      </a>
      <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
        <i class="ti ti-x"></i>
      </a>
    </div>


    <nav class="sidebar-nav scroll-sidebar" data-simplebar>
      <ul id="sidebarnav">
        <!-- ---------------------------------- -->
        <!-- Home -->
        <!-- ---------------------------------- -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Home</span>
        </li>
        <!-- ---------------------------------- -->
        <!-- Dashboard -->
        <!-- ---------------------------------- -->
        <li class="sidebar-item">
          <a class="sidebar-link" href="./" aria-expanded="false">
            <span>
              <i class="ti ti-home"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>


        <!-- ---------------------------------- -->
        <!-- SMS -->
        <!-- ---------------------------------- -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">SMS</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="./sms-send" aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-device-mobile-message"></i>
              </span>
              <span class="hide-menu">Send SMS</span>
            </div>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="./sms-history" aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-history"></i>
              </span>
              <span class="hide-menu">SMS history</span>
            </div>
          </a>
        </li>
        <?php if ($GLOBALS_USER_OWNSENDER == "No") {
          echo '<li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="./sms-sender" aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-writing-sign"></i>
              </span>
              <span class="hide-menu">SMS Sender</span>
            </div>
          </a>
        </li>';
        } ?>


        <!-- ---------------------------------- -->
        <!-- Account -->
        <!-- ---------------------------------- -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Account</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="./account-settings" aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-user-circle"></i>
              </span>
              <span class="hide-menu">Account Settings</span>
            </div>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="./add-credits" aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-report-money"></i>
              </span>
              <span class="hide-menu">Add credits</span>
            </div>
            <span class="hide-menu badge rounded-pill border border-dark text-dark fs-2 py-1 px-2">NEW</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="./payment-history" aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-history"></i>
              </span>
              <span class="hide-menu">Payment history</span>
            </div>
            <!-- <span class="hide-menu badge rounded-pill border border-dark text-dark fs-2 py-1 px-2">NEW</span> -->
          </a>
        </li>


        <!-- ---------------------------------- -->
        <!-- Developer -->
        <!-- ---------------------------------- -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Developer</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="#" aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-code-circle-2"></i>
              </span>
              <span class="hide-menu">API</span>
            </div>
            <span class="hide-menu badge rounded-pill border border-dark text-dark fs-2 py-1 px-2">SOON</span>
          </a>
        </li>


        <!-- ---------------------------------- -->
        <!-- ADMIN -->
        <!-- ---------------------------------- -->
        <?php if ($GLOBALS_USER_RANK == "Admin") {
          echo '
                
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">ADMIN</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="./admin-history" aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-history"></i>
              </span>
              <span class="hide-menu">SMS History</span>
            </div>
            <span class="hide-menu badge rounded-pill border border-dark text-dark fs-2 py-1 px-2">ADMIN</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link justify-content-between" href="./app-contact" aria-expanded="false">
            <div class="d-flex align-items-center gap-3">
              <span class="d-flex">
                <i class="ti ti-user-exclamation"></i>
              </span>
              <span class="hide-menu">All User</span>
            </div>
            <span class="hide-menu badge rounded-pill border border-dark text-dark fs-2 py-1 px-2">ADMIN</span>
          </a>
        </li>';
        }
        ?>



      </ul>
    </nav>

    <!-- <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded sidebar-ad mt-3">
      <div class="hstack gap-3">
        <div class="john-img">
          <img src="./assets/images/icon.png" class="rounded-circle" width="40" height="40" alt="" />
        </div>
        <div class="john-title">
          <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
          <span class="fs-2">Designer</span>
        </div>
        <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
          <i class="ti ti-power fs-6"></i>
        </button>
      </div>
    </div> -->

    <!-- ---------------------------------- -->
    <!-- Start Vertical Layout Sidebar -->
    <!-- ---------------------------------- -->
  </div>
</aside>