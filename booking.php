<?php
require_once('./config.php'); // Include the database configuration file

if (!empty($_GET)) {
    echo "<pre>";
    print_r($_GET);
    echo "</pre>";
} else {
    echo "No GET parameters detected!";
}


if (isset($_GET['TurfID'])) {
    echo "TurfID: " . $_GET['TurfID'] . "<br>";
} else {
    echo "TurfID is not set!";
}


// Check if the 'TurfID' parameter exists and is greater than 0
if (isset($_GET['TurfID']) && $_GET['TurfID'] > 0) {
    $turf_id = $_GET['TurfID']; // Assign TurfID from the URL to a variable

    // Query the database for the record matching the given TurfID
    $qry = $conn->query("SELECT * FROM `booking_list` WHERE `turf_id` = '$turf_id'");
    
    // Check if any record is found
    if ($qry->num_rows > 0) {
        // Dynamically create variables for each column
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v; // Create a variable named after the column name
        }
    } else {
        // Handle the case when no record is found
        echo "No booking found for the provided Turf ID!";
    }
} else {
    // Handle the case when TurfID is missing or invalid
    echo "Invalid or missing Turf ID!";
    exit;
}
?>




<div class="container-fluid">
    <form action="" id="booking-form">
        <!-- Hidden fields to pass booking and turf details -->
        <input type="hidden" name="id" value="<?= isset($booking['id']) ? $booking['id'] : '' ?>">
        <input type="hidden" name="turf_id" value="<?= isset($turf_id) ? $turf_id : '' ?>">

        <!-- Booking Form Fields -->
        <div class="form-group">
            <label for="date_from" class="control-label">From Date</label>
            <input name="date_from" id="date_from" type="date" class="form-control form-control-sm rounded-0" 
                   value="<?= isset($booking['date_from']) ? $booking['date_from'] : '' ?>" required />
        </div>
        <div class="form-group">
            <label for="date_to" class="control-label">To Date</label>
            <input name="date_to" id="date_to" type="date" class="form-control form-control-sm rounded-0" 
                   value="<?= isset($booking['date_to']) ? $booking['date_to'] : '' ?>" required />
        </div>

        <button type="submit" class="btn btn-primary">Submit Booking</button>
    </form>
</div>


<script>
$(document).ready(function(){
    $('#booking-form').submit(function(e){
        e.preventDefault(); // Prevent default form submission
        var _this = $(this);
        $('.err-msg').remove(); // Clear previous error messages
        start_loader(); // Start the loader animation

        $.ajax({
            url: './classes/Master.php?f=save_booking', // Adjust path if needed
            data: new FormData(this), // Send form data
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            dataType: 'json',
            error: function(err) {
                console.log(err);
                alert_toast("An error occurred", 'error');
                end_loader();
            },
            success: function(resp) {
                if (resp && resp.status === 'success') {
                    location.href = './?p=booking_list'; // Redirect to the booking list page
                } else if (resp.status === 'failed' && resp.msg) {
                    var el = $('<div>');
                    el.addClass("alert alert-danger err-msg").text(resp.msg);
                    _this.prepend(el);
                    el.show('slow');
                } else {
                    alert_toast("An error occurred", 'error');
                    console.log(resp);
                }
                end_loader();
            }
        });
    });
});
</script>
