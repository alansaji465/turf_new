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
        <link rel="stylesheet" href="assets/css/common.css?v=1">
        <link rel="stylesheet" href="assets/css/styles.css?v=4">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>

   
        <style>
            
            /* General Styles */
            body {
                margin: 0;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-size: 1rem;
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                text-align: left;
                background-color: #fff;
            }

            .book-now-button {   
                text-align: center;
                margin-top: 55px;
            }

            .carousel {
                margin-bottom: 20px; /* Adds spacing between the carousel and button */
            }

            @media (max-width: 768px) {
                .book-now-button {
                    text-align: center; /* Center the button for smaller screens */
                }
            }


            /* Turf Info Section */
            .turf-info {
                padding: 40px 0;
                background-color: #fff;
                border-bottom: 2px solid #ddd;
            }

            .turf-info .carousel-inner img {
                width: 100%;
                height: 450px;
                object-fit: cover;
                border-radius: 8px;
            }

            .info-cards .card {
                background-color: #fff;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 20px;
                margin-top: 20px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }

            .info-cards .card:hover {
                transform: translateY(-10px);
            }

            .info-cards .card-title {
                font-weight: 700;
                font-size: 1.3rem;
                color: #2c3e50;
            }

            .info-cards .card-text {
                font-size: 1.1rem;
                margin-top: 12px;
                color: #555;
            }

            /* Booking Form Section */
            .booking-form {
                padding: 50px 20px;
                background-color: #fff;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                border-radius: 12px;
                margin-top: 40px;
            }

            .booking-form .section-title {
                font-size: 2rem;
                font-weight: 600;
                margin-bottom: 30px;
                text-align: center;
                color: #2c3e50;
            }

            .booking-form .form-group label {
                font-weight: 600;
                color: #2c3e50;
            }

            .booking-form .form-control {
                font-size: 1.1rem;
                padding: 12px;
                margin-top: 12px;
                border-radius: 8px;
                border: 1px solid #ddd;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .booking-form .btn {
                background-color: #117215;
                border: none;
                font-size: 1.3rem;
                padding: 18px 35px;
                color: white;
                border-radius: 8px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .booking-form .btn:hover {
                background-color: #06560a;
            }

            /* Responsive Adjustments */
            @media (max-width: 768px) {
                .time-slot-grid {
                    grid-template-columns: repeat(2, 1fr);  /* For smaller screens, 2 columns */
                }

                .hero-title {
                    font-size: 2.5rem;
                }

                .hero-location {
                    font-size: 1rem;
                }
            }

            /* Miscellaneous */
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 15px;
            }

        </style>     
    </head>
    <body>

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
                    <button class="btn btn-large btn-primary rounded-pill w-25" id="book_now" type="button">Book Now</button>
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
    
    $(function() {
    $('#book_now').click(function() {
        if("<?= $_settings->userdata('id') && $_settings->userdata('login_type') == 2 ?>" == 1) {
            // Open the booking modal
            uni_modal("Book Facility", "booking.php?fid=<?= $turf_id ?>", 'modal-sm');
        } else {
            // Redirect to login page
            location.href = './login.php';
        }
    });

    // Date change event to fetch available slots for the selected date
    $('#booking_date').change(function() {
        var selectedDate = $(this).val();
        $.ajax({
            url: 'fetch_slots.php', // PHP file that fetches available slots for the selected date
            type: 'POST',
            data: { turf_id: <?= $turf_id ?>, date: selectedDate },
            success: function(response) {
                // Update the available slots dropdown based on the response
                $('#time_slots').html(response);
            }
        });
    });
});


</script>
