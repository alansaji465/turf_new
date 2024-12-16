<?php
if (isset($_GET['TurfID']) && $_GET['TurfID'] > 0) {
    $qry = $conn->query("SELECT * FROM `turfs` WHERE turf_id = '{$_GET['TurfID']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = stripslashes($v);
        }
    }
}
?>

<style>
    #cimg {
        min-width: 34vw;
        min-height: 25vh;
        max-height: 35vh;
        max-width: 100%;
        object-fit: scale-down;
        object-position: center center;
    }
</style>

<div class="card card-outline card-info rounded-0">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($turf_id) ? "Update " : "Create New " ?> Turf</h3>
    </div>
    <div class="card-body">
        <form action="" id="turf-form">
            <input type="hidden" name="turf_id" value="<?php echo isset($turf_id) ? $turf_id : '' ?>">

            <div class="form-group">
                <label for="turf_name" class="control-label">Turf Name</label>
                <input name="turf_name" id="turf_name" type="text" class="form-control rounded-0" value="<?php echo isset($turf_name) ? $turf_name : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea name="description" id="description" rows="5" class="form-control rounded-0 summernote" required><?php echo isset($description) ? $description : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label for="price" class="control-label">Rent Price</label>
                <input name="price" id="price" type="text" class="form-control rounded-0" value="<?php echo isset($price) ? $price : ''; ?>" required />
            </div>

            <div class="form-group col-md-6">
                <label for="" class="control-label">Turf Image</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input rounded-circle" id="customFile" name="image" onchange="displayImg(this,$(this))">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>

            <div class="form-group col-md-12 d-flex justify-content-center">
                <img src="<?php echo validate_image(isset($image) ? $image : '') ?>" alt="" id="cimg" class="img-fluid img-thumbnail bg-gradient-gray">
            </div>

            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select">
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="turf-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=manage_turfs">Cancel</a>
    </div>
</div>

<script>
    window.displayImg = function(input, _this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#cimg').attr('src', e.target.result);
                _this.siblings('.custom-file-label').html(input.files[0].name);
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            $('#cimg').attr('src', "<?php echo validate_image(isset($image) ? $image : '') ?>");
            _this.siblings('.custom-file-label').html("Choose file");
        }
    }

    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: "Please Select Here"
        });

        $('#turf-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_turf",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=turfs/view_turf&TurfID=" + resp.turf_id;
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                }
            });
        });

        $('.summernote').summernote({
            height: "40vh",
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
