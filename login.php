<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
  <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <style>
      /* General styles */
      body {
          width: 100%;
          height: 100%;
          background-image: url('<?= validate_image($_settings->info('cover')) ?>');
          background-size: cover;
          background-repeat: no-repeat;
          background-position: center;
          font-family: 'Poppins', sans-serif; /* Modern font for a fresh look */
          display: flex;
          justify-content: center;
          align-items: center;
          color: #333;
      }

      /* Login card styles */
      .login-box {
          background: rgba(255, 255, 255, 0.9);
          box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
          border-radius: 12px;
          padding: 30px;
          width: 100%;
          max-width: 420px;
          animation: fadeIn 1s ease-out;
      }

      /* Header logo */
      #logo-img {
          width: 100px;
          height: 100px;
          border-radius: 50%;
          object-fit: cover;
          object-position: center center;
          border: 2px solid #153b75;
          animation: scaleUp 1s ease-out;
      }

      .card-header {
          text-align: center;
          font-size: 1.8rem;
          color: #153b75;
          font-weight: bold;
      }

      /* Updated Welcome Message Styles */
      .login-box-msg {
          font-size: 1.2rem;
          color: #666;
          margin: 15px 0;
          padding: 20px;
          background: #f1f1f1;
          border-radius: 10px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
          text-align: center;
          font-weight: 600;
          animation: fadeIn 1s ease-out;
      }

      /* Input styles */
      .form-control {
          border: 1px solid #ddd;
          border-radius: 8px;
          background: #f9f9f9;
          color: #333;
          padding: 10px 15px;
          font-size: 0.95rem;
      }

      .form-control:focus {
          border-color: #153b75;
          box-shadow: 0 0 6px rgba(17, 114, 21, 0.4);
      }

      .input-group-text {
          background: #153b75;
          color: #fff;
          border: none;
          border-radius: 0 8px 8px 0;
      }

      /* Button styles */
      .btn-primary {
          background: #153b75;
          border: none;
          border-radius: 8px;
          font-size: 1rem;
          padding: 10px;
          transition: all 0.3s ease;
      }

      .btn-primary:hover {
          background:#324f74;
          transform: translateY(-2px);
          box-shadow: 0 4px 8px rgba(6, 86, 10, 0.3);
      }

      /* Link styles */
      a {
          color: #153b75;
          font-weight: 500;
          text-decoration: none;
          transition: color 0.3s ease;
      }

      a:hover {
          color: #06560a;
      }

      /* Animations */
      @keyframes fadeIn {
          from {
              opacity: 0;
              transform: translateY(20px);
          }
          to {
              opacity: 1;
              transform: translateY(0);
          }
      }

      @keyframes scaleUp {
          from {
              transform: scale(0.8);
              opacity: 0.5;
          }
          to {
              transform: scale(1);
              opacity: 1;
          }
      }

      /* Footer link styles */
      .footer-link {
          margin-top: 10px;
          text-align: center;
          font-size: 0.9rem;
      }
  </style>
<div class="login-box">
 
<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear any existing success message before checking for error messages
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}

// Display only error flash messages (if any)
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']); // Clear the flash message
}
?>


    <!-- Logo -->
    <center><img src="<?= validate_image($_settings->info('logo')) ?>" alt="System Logo" class="img-thumbnail" id="logo-img"></center>
    <div class="clear-fix my-3"></div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            Login
        </div>
        <div class="card-body">
            <form id="clogin-frm" action="" method="post">
                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" autofocus placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </form>

            <div class="footer-link">
                <a href="<?php echo base_url . 'register.php' ?>">Create an Account</a> | 
                <a href="<?php echo base_url ?>">Back to Home</a>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
  $(document).ready(function () {
    end_loader();
  });
</script>
</body>
</html>
