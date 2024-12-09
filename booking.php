<?php
require_once('./config.php'); // Ensure your config contains the DB connection

if (isset($_GET['TurfID']) && $_GET['TurfID'] > 0) {
    $turf_id = $_GET['TurfID'];

    // Fetch turf booking details
    $qry = $conn->query("SELECT * FROM `booking_list` WHERE `id` = '$turf_id'");
    if ($qry->num_rows > 0) {
        $booking = $qry->fetch_assoc(); // Fetch as associative array
    } else {
        echo "Invalid Turf ID!";
        exit;
    }
} else {
    echo "No Turf ID provided!";
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
