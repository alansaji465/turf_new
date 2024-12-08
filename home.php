<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A modern turf booking website for a seamless booking experience.">
    <title><?php echo $_settings->info('name') ?> - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap">
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Hero Section */
        .hero-section {
            background: url('assets/images/hero-banner.jpg') no-repeat center center/cover;
            height: 80vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .hero-section h1,
        .hero-section p,
        .hero-section a {
            z-index: 1;
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        /* Features Section */
        .features {
            background: #f8f9fa;
            padding-bottom: 50px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .card {
            border: none;
            overflow: hidden;
            border-radius: 12px;
        }

        .card img {
            height: 200px;
            object-fit: cover;
        }

        .card h5 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        /* Footer */
        footer {
            background: #343a40;
            color: #fff;
        }

        footer p {
            margin: 0;
        }
    </style>
</head>

<body>
    <!-- Header -->
<!-- Header -->
    <header class="hero-section" id="main-header">
        <div class="container d-flex flex-column align-items-center justify-content-center text-center text-white h-100">
            <h1 class="display-4 fw-bold text-uppercase mb-3"><?php echo $_settings->info('name') ?></h1>
            <p class="lead mb-4">Book your turf effortlessly and enjoy the game like never before.</p>
            <a class="btn btn-primary btn-lg px-4 py-2 rounded-pill" 
            href="<?php echo isset($_SESSION['user_id']) ? './?p=facility_available' : './?p=login'; ?>">Book Now</a>
        </div>
    </header>


    <!-- Main Content -->
    <main>
        <section class="features py-5">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <h2 class="section-title mb-4">Why Choose Us?</h2>
                        <p class="text-muted">We provide the best platform for turf booking with reliable features, secure transactions, and the convenience you deserve.</p>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-4">
                        <div class="card shadow">
                            <img src="uploads\feature1.webp" alt="Feature 1" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">Easy Booking</h5>
                                <p class="card-text">Book your preferred turf in just a few clicks with our user-friendly interface.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow">
                            <img src="uploads\feature2.jpg" alt="Feature 2" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">Affordable Rates</h5>
                                <p class="card-text">We offer competitive pricing for all our turfs without compromising quality.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow">
                            <img src="uploads\feature3.jpg" alt="Feature 3" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">Premium Locations</h5>
                                <p class="card-text">Choose from a wide range of turfs located in prime areas across the city.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="py-4">
        <div class="container text-center">
            <p class="mb-0">© <?php echo date('Y') ?> <?php echo $_settings->info('name') ?>. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function () {
            // Navbar scroll effect
            $(document).scroll(function () {
                $('#topNavBar').toggleClass('navbar-dark bg-transparent text-light', $(window).scrollTop() === 0);
                $('#topNavBar').toggleClass('navbar-light bg-gradient-light', $(window).scrollTop() > 0);
            });
            $(document).trigger('scroll');
        });
    </script>
</body>

</html>
