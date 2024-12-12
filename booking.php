<?php
require_once('./config.php');
if(isset($_GET['TurfID']) && $_GET['TurfID'] > 0){
    $qry = $conn->query("SELECT * from `booking_list` where turf_id = '{$_GET['TurfID']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>

<div class="container-fluid">
    <form action="" id="booking-form">
        <!-- Hidden Inputs -->
        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
        <input type="hidden" name="turf_id" value="<?= isset($_GET['TurfID']) ? $_GET['TurfID'] : (isset($turf_id) ? $turf_id : "") ?>">

        <!-- Booking Date Fields -->
        <div class="form-group">
            <label for="date_from" class="control-label">From Date</label>
            <input name="date_from" id="date_from" type="date" class="form-control form-control-sm rounded-0" required />
        </div>
        <div class="form-group">
            <label for="date_to" class="control-label">To Date</label>
            <input name="date_to" id="date_to" type="date" class="form-control form-control-sm rounded-0" required />
        </div>
    </form>
</div>


<script>
    $(document).ready(function(){
        // Bind submit event for the booking form
        $('#booking-form').submit(function(e){
            e.preventDefault(); // Prevent page reload
            var _this = $(this);
            $('.err-msg').remove(); // Remove previous error messages
            start_loader(); // Show loader

            // AJAX request to save booking
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_booking", // Adjusted URL
                data: new FormData($(this)[0]), // Form data
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err); // Log errors
                    alert_toast("sorry An error occurred", 'error'); // Show error toast
                    end_loader(); // Hide loader
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        // Redirect on successful booking
                        location.href = './?p=booking_list';
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        // Display error message
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        end_loader();
                    } else {
                        // Handle unexpected errors
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                    $("html, body, .modal").scrollTop(0); // Scroll to top
                }
            });
        });
    });
</script>

