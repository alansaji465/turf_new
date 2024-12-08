<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="en">
  <?php require_once('inc/header.php') ?>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
      html, body {
        width: 100%;
        height: 100%;
        font-family: 'Poppins', sans-serif;
      }
      body {
        background-image: url('<?= validate_image($_settings->info('cover')) ?>');
        background-repeat: no-repeat;
        background-size: cover;
      }
      .card {
        background-color: rgba(255, 255, 255, 0.8) !important;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease-in-out;
      }
      .card-body {
        padding: 2rem;
        border-radius: 15px;
      }
      .form-control, .custom-select {
        border-radius: 10px;
        transition: all 0.3s ease;
      }
      .form-control:focus {
        border-color: #153b75;
        box-shadow: 0 0 10px rgba(17, 114, 21, 0.5);
      }
      .btn-primary {
        background-color: #153b75;
        border: none;
        border-radius: 10px;
        transition: background-color 0.3s ease;
      }
      .btn-primary:hover {
        background-color: #324f74;
      }
      .pass_type {
        cursor: pointer;
      }
      .input-group-append span {
        cursor: pointer;
      }
      .card-header {
        background: none;
        border-bottom: none;
      }
      .card-header a {
        color: #153b75;
        font-weight: 600;
        font-size: 1.5rem;
        transition: color 0.3s ease;
      }
      .card-header a:hover {
        color: #153b75;
      }
      #logo-img {
        width: 15em;
        height: 15em;
        object-fit: scale-down;
        object-position: center center;
        margin-bottom: 1rem;
      }
      @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
      }
    </style>
  </head>
  <body class="">
    <script>
      start_loader()
    </script>
    <div class="d-flex align-items-center justify-content-center h-100">
      <div class="d-flex h-100 justify-content-center align-items-center col-lg-5">
        <center><img src="<?= validate_image($_settings->info('logo')) ?>" alt="System Logo" class="img-thumbnail rounded-circle" id="logo-img"></center>
      </div>
      <div class="d-flex h-100 justify-content-center align-items-center col-lg-7 bg-gradient-light text-dark">
        <div class="card card-outline card-primary w-75">
          <div class="card-header text-center">
            <a href="./" class="text-decoration-none text-dark"><b>Create an Account</b></a>
          </div>
          <div class="card-body">
            <form id="register-frm" action="" method="post">
              <input type="hidden" name="id">
              <div class="row">
                <input type="text" name="firstname" id="firstname" placeholder="Enter First Name" autofocus class="form-control form-control-sm form-control-border" required>
                <small class="ml-3">Full Name</small>
              </div>
              <div class="row">
                <div class="form-group col-md-12">
                  <input type="email" name="email" id="email" placeholder="jsmith@sample.com" class="form-control form-control-sm form-control-border" required>
                  <small class="ml-3">Email</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <input type="password" name="password" id="password" placeholder="Enter Password" class="form-control form-control-sm form-control-border" required>
                    <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                      <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                    </div>
                  </div>
                  <small class="ml-3">Password</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <div class="input-group">
                    <input type="password" id="cpassword" placeholder="Confirm Password" class="form-control form-control-sm form-control-border" required>
                    <div class="input-group-append border-bottom border-top-0 border-left-0 border-right-0">
                      <span class="input-append-text text-sm"><i class="fa fa-eye-slash text-muted pass_type" data-type="password"></i></span>
                    </div>
                  </div>
                  <small class="ml-3">Confirm Password</small>
                </div>
              </div>
              <div class="row">
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-primary btn-sm btn-flat btn-block">Register</button>
                </div>
              </div>
              <div class="row">
                <div class="col-12 text-center">
                  <a href="<?php echo base_url.'login.php' ?>" style="color: #153b75;">
                    Already have an Account?
                  </a>
                </div>
              </div>
              <div class="row">
              <div class="col-12 text-center">
                <span id="response-msg" class="message" style="display: none;"></span>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="<?= base_url ?>plugins/jquery/jquery.min.js"></script>
    <script src="<?= base_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
  window.displayImg = function(input, _this) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#cimg').attr('src', e.target.result);
        _this.siblings('.custom-file-label').html(input.files[0].name);
      }
      reader.readAsDataURL(input.files[0]);
    } else {
      $('#cimg').attr('src', "<?php echo validate_image(isset($image_path) ? $image_path : "") ?>");
      _this.siblings('.custom-file-label').html("Choose file");
    }
  }

  $(document).ready(function() {
    end_loader();

    // Password visibility toggle
    $('.pass_type').click(function() {
        var type = $(this).attr('data-type');
        if (type === 'password') {
            $(this).attr('data-type', 'text');
            $(this).closest('.input-group').find('input').attr('type', "text");
            $(this).removeClass("fa-eye-slash").addClass("fa-eye");
        } else {
            $(this).attr('data-type', 'password');
            $(this).closest('.input-group').find('input').attr('type', "password");
            $(this).removeClass("fa-eye").addClass("fa-eye-slash");
        }
    });

    // Form submit handler
    $('#register-frm').submit(function(e) {
        e.preventDefault();
        var _this = $(this);
        $('.err-msg').remove();

        // Check if passwords match
        if ($('#password').val() !== $('#cpassword').val()) {
            var el = $('<div>').addClass('alert alert-danger err-msg').text('Password does not match.');
            _this.prepend(el);
            el.show('slow');
            return false;
        }

        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Users.php?f=save_client",
            data: new FormData($(this)[0]),
            cache: false,
            processData: false,
            contentType: false,
            method: 'POST',
            dataType: 'json',
            success: function(resp) {
                end_loader();

                // Show the message below the "Already have an Account?" link
                $('#response-msg').show().text(resp.msg);

                // Apply color based on response
                if (resp.status === 'success') {
                    $('#response-msg').css('color', 'green');
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 1500);
                } else {
                    $('#response-msg').css('color', 'red');
                }
            },
            error: function(xhr, status, error) {
                end_loader();
                console.error("AJAX Error:", status, error);
                console.error("Response Text:", xhr.responseText);
                $('#response-msg').show().text('An error occurred while processing your request. Please try again.').css('color', 'red');
            }
        });
    });
});


</script>

  </body>
</html>
