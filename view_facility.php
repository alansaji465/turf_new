<?php
// Connect to the database
include_once("config.php");

if(isset($_GET['TurfID']) && $_GET['TurfID'] > 0){
    $qry = $conn->query("SELECT * FROM `turfs` WHERE turf_id = '{$_GET['TurfID']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=stripslashes($v);
        }
    }
}


// Ensure TurfID is set and sanitized
if (isset($_GET['TurfID'])) {
    $TurfID = intval($_GET['TurfID']);  // Convert to integer for security

    // Query the database for turf details
    $turfQuery = "SELECT * FROM turfs WHERE turf_id = ?";
    $stmt = $conn->prepare($turfQuery);
    $stmt->bind_param("i", $TurfID);
    $stmt->execute();
    $turfResult = $stmt->get_result();

    if ($turfResult->num_rows > 0) {
        // Fetch the turf details
        $turfDetails = $turfResult->fetch_assoc();
    } else {
        // Redirect if the turf ID is invalid
        header("Location: facility_available.php");
        exit();
    }

    

    // Fetch images associated with the turf
    $image1 = $turfDetails['image'];
    $image2 = $turfDetails['image_2'];

} else {
    // If TurfID is not set, handle accordingly (e.g., redirect or show a message)
    echo "TurfID parameter is missing.";
    exit();
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        


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
                <div class="book-now-button mt-3">
                        <button type="button" class="btn btn-success btn-lg" id="book_now">Book Now</button>
                </div>
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
                        <p class="card-text"><?php echo htmlspecialchars($turfDetails['amenities']); ?></p>
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
            uni_modal("Book Facility","booking.php?fid=<?= $TurfID ?>",'modal-sm');
        else
        location.href = './login.php';
    })
  })

</script>