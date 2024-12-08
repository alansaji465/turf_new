<?php
require_once('./config.php');

if(isset($_GET['TurfID']) && $_GET['TurfID'] > 0){
    $qry = $conn->query("SELECT * from `turfs` where turf_id = '{$_GET['TurfID']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
} else {
    echo "TurfID is missing.";
    exit();
}

if (isset($_GET['user_id']) && $_GET['user_id'] > 0) {
    $user_id = intval($_GET['user_id']);
} else {
    echo "User ID is missing.";
    exit();
}

?>

<div class="container-fluid">
    <form action="" id="booking-form">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="turf_id" value="<?= isset($_GET['TurfID']) ? $_GET['TurfID'] : '' ?>">

        <div class="form-group">
            <label for="booking_date" class="control-label">Select Date</label>
            <input name="booking_date" id="booking_date" type="date" class="form-control form-control-sm rounded-0" required />
        </div>

        <div class="form-group">
            <label for="booking_time" class="control-label">Select Time Slot</label>
            <select name="booking_time" id="booking_time" class="form-control form-control-sm rounded-0" required>
                <option value="">Select a Time Slot</option>
                <?php
                // Fetch available time slots for the selected turf
                $slotQuery = "SELECT * FROM time_slots WHERE turf_id = ? AND is_available = 1";
                $stmt = $conn->prepare($slotQuery);
                $stmt->bind_param("i", $_GET['TurfID']);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['slot_start']} - {$row['slot_end']}</option>";
                }
                ?>
            </select>
        </div>
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#booking-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_booking",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp){
                    if (typeof resp === 'object' && resp.status === 'success') {
                        location.href = './?p=booking_list';
                    } else if (resp.status === 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                    $("html, body, .modal").scrollTop(0);
                }
            });
        });
    });
</script>
