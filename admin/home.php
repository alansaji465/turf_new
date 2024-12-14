<h1 class="">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<style>
  #cover_img_dash {
    width: 100%;
    max-height: 50vh;
    object-fit: cover;
    object-position: bottom center;
  }
</style>
<div class="row">
  <!-- Total Turfs -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-futbol"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Turfs</span>
        <span class="info-box-number">
          <?php 
            $total_turfs = $conn->query("SELECT COUNT(turf_id) as total FROM turfs")->fetch_assoc()['total'];
            echo number_format($total_turfs);
          ?>
        </span>
      </div>
    </div>
  </div>

  <!-- Total Bookings -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-calendar-check"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total Bookings</span>
        <span class="info-box-number">
          <?php 
            $total_bookings = $conn->query("SELECT COUNT(id) as total FROM booking_list")->fetch_assoc()['total'];
            echo number_format($total_bookings);
          ?>
        </span>
      </div>
    </div>
  </div>

  <!-- Total Registered Users -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-warning elevation-1"><i class="fas fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Registered Users</span>
        <span class="info-box-number">
          <?php 
            $total_users = $conn->query("SELECT COUNT(id) as total FROM client_list WHERE delete_flag = 0")->fetch_assoc()['total'];
            echo number_format($total_users);
          ?>
        </span>
      </div>
    </div>
  </div>

  <!-- Pending Approvals -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-tasks"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Pending Approvals</span>
        <span class="info-box-number">
          <?php 
            $pending_approvals = $conn->query("SELECT COUNT(id) as total FROM booking_list WHERE status = 0")->fetch_assoc()['total'];
            echo number_format($pending_approvals);
          ?>
        </span>
      </div>
    </div>
  </div>
</div>

<hr>
<div class="text-center">
  <img src="<?= validate_image($_settings->info('cover')) ?>" alt="System Cover" class="w-100 img-fluid img-thumbnail border" id="cover_img_dash">
</div>