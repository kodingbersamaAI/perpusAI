  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/perpus-mini" class="nav-link"><h4>Perpus<strong>AI</strong></h4></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <?php
        if (isset($_SESSION['username'])) {
            // Jika sesi aktif, tampilkan dropdown pengguna
        ?>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-user"></i> <?php echo $_SESSION['username']; ?>
            </a>
            <div class="dropdown-menu dropdown-menu dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Anda login sebagai <?php echo $_SESSION['role']; ?></span>
            <div class="dropdown-divider"></div>
              <a href=".<?php echo $dashboardLink; ?>" class="dropdown-item">
                <i class="fas fa-home mr-2"></i> Dashboard
              </a>
              <div class="dropdown-divider"></div>
              <a href="../server/logout.php" class="dropdown-item">
                <i class="fas fa-arrow-circle-right mr-2"></i> Logout
              </a>
            </div>
          </li>
        <?php
        } else {
            // Jika tidak ada sesi aktif, tampilkan tautan untuk login modal
        ?>
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-user"></i> Login
            </a>
            <div class="dropdown-menu dropdown-menu-right">
            <span class="dropdown-item dropdown-header">Silakan login untuk masuk ke Member Area</span>
            <div class="dropdown-divider"></div>
              <div style="padding-left: 10px; padding-right: 10px;">
                <form action="../server/login.php" method="post">
                  <div class="form-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
                  </div>
                  <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                  </div>
                  <button type="submit" class="btn btn-primary btn-sm">Login</button>
                </form>
              </div>
            </div>
          </li>
        <?php
        }
        ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->