<?php

// Check if TurfID is set and valid
if (isset($_GET['TurfID']) && intval($_GET['TurfID']) > 0) {
    $turf_id = intval($_GET['TurfID']); // Sanitize TurfID by converting it to an integer

    // Query to fetch turf details using prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM `turfs` WHERE `turf_id` = ?");
    $stmt->bind_param("i", $turf_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned a result
    if ($result->num_rows > 0) {
        $turfDetails = $result->fetch_assoc(); // Fetch turf details as an associative array

        // Fetch images associated with the turf
        $image1 = $turfDetails['image'];
        $image2 = $turfDetails['image_2'];

        // Fetch turf-specific amenities
        $amenitiesQuery = "SELECT a.amenity_name 
                           FROM turf_amenities ta 
                           JOIN amenities a ON ta.amenity_id = a.amenity_id 
                           WHERE ta.turf_id = ?";
        $amenitiesStmt = $conn->prepare($amenitiesQuery);
        $amenitiesStmt->bind_param("i", $turf_id);
        $amenitiesStmt->execute();
        $amenitiesResult = $amenitiesStmt->get_result();

        // Fetch default amenities if turf has no specific amenities
        if ($amenitiesResult->num_rows === 0) {
            $defaultQuery = "SELECT amenity_name FROM amenities WHERE is_default = 1";
            $amenitiesResult = $conn->query($defaultQuery);
        }

        // Store amenities in an array
        $amenities = [];
        while ($row = $amenitiesResult->fetch_assoc()) {
            $amenities[] = $row['amenity_name'];
        }
    } else {
        // Handle invalid TurfID by redirecting or showing an error
        header("Location: facility_available.php"); // Redirect to facility_available.php for invalid TurfID
        exit;
    }
} else {
    // Handle the case where TurfID is not provided or invalid
    echo "TurfID parameter is missing or invalid.";
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($turfDetails['turf_name']); ?> Turf Details</title>
        <link rel="stylesheet" href="assets/css/view_facility.css">
        <link rel="stylesheet" href="assets/css/common.css?v=1">
        <link rel="stylesheet" href="assets/css/styles.css?v=4">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    </head>
    <body style="height: auto;margin-top: 100px;">

        <!-- Hero Section -->
        <section class="hero-section" style="background-image: url('<?php echo $image1; ?>');">
            <div class="overlay">
                <div class="container text-center">
                    <h1 class="hero-title" style="margin-top: 25px;"><?php echo htmlspecialchars($turfDetails['turf_name']); ?></h1>
                    <p class="hero-location"><?php echo htmlspecialchars($turfDetails['location']); ?></p>
                </div>
            </div>
        </section>

        <!-- Turf Info Section -->
        <section class="turf-info">
    <div class="container">
        <div class="row">
            <!-- Image Section -->
            <div class="col-lg-6"><div class="carousel slide carousel-fade" data-ride="carousel" id="turfCarousel">

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo $image1; ?>" class="d-block w-100" alt="Turf Image 1">
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo $image2; ?>" class="d-block w-100" alt="Turf Image 2">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#turfCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#turfCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                
                <!-- Book Now Button -->
                <center>
                    <button type="submit" class="btn btn-success btn-lg" id="book_now" type="button">Book Now</button>
                </center>
            </div>

            <!-- Details and Amenities Section -->
            <div class="col-lg-6">
                <h3 class="section-title">Turf Details</h3>
                <p class="description"><?php echo nl2br(htmlspecialchars($turfDetails['description'])); ?></p>
                <div class="info-cards">
                    <div class="card">
                        <h5 class="card-title">Price</h5>
                        <p class="card-text">₹<?php echo htmlspecialchars($turfDetails['price']); ?> per Hour</p>
                    </div>
                    <div class="card">
                        <h5 class="card-title">Available Slots</h5>
                        <p class="card-text">5 AM - 12 AM</p>
                    </div>
                    <div class="card">
                        <h5 class="card-title">Amenities</h5>
                        <p class="card-text">
                            <?php 
                            if (!empty($amenities)) {
                                echo htmlspecialchars(implode(', ', $amenities));
                            } else {
                                echo "No amenities available.";
                            }
                        ?>
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    

</section>


<script>
    
    $(function(){
    $('#book_now').click(function(){
        if("<?= $_settings->userdata('id') && $_settings->userdata('login_type') == 2 ?>" == 1)
            uni_modal("Book Facility","booking.php?fid=<?= $turf_id ?>",'modal-sm');
        else
        location.href = './login.php';
    })
  })

</script>
