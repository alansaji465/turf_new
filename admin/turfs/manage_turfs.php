<?php
if(isset($_GET['turf_id']) && $_GET['turf_id'] > 0){
    $qry = $conn->query("SELECT * from `turfs` where turf_id = '{$_GET['turf_id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k = stripslashes($v);
        }
    }
}
?>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($turf_id) ? "Update Turf" : "Create New Turf"; ?> Details</h3>
	</div>
	<div class="card-body">
		<form action="" id="turf-form">
			<input type="hidden" name="turf_id" value="<?php echo isset($turf_id) ? $turf_id : ''; ?>">
			<div class="form-group">
				<label for="turf_name" class="control-label">Turf Name</label>
                <input name="turf_name" id="turf_name" type="text" class="form-control rounded-0" value="<?php echo isset($turf_name) ? $turf_name : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="description" class="control-label">Description</label>
                <textarea name="description" id="description" class="form-control rounded-0" required><?php echo isset($description) ? $description : ''; ?></textarea>
			</div>
			<div class="form-group">
				<label for="location" class="control-label">Location</label>
                <input name="location" id="location" type="text" class="form-control rounded-0" value="<?php echo isset($location) ? $location : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="price" class="control-label">Price</label>
                <input name="price" id="price" type="number" class="form-control rounded-0" value="<?php echo isset($price) ? $price : ''; ?>" required>
			</div>
			<div class="form-group">
				<label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select select">
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                </select>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="turf-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=turfs">Cancel</a>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('#turf-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Turfs.php?f=save_turf",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err);
					alert_toast("An error occurred", 'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp == 'object' && resp.status == 'success'){
						location.href = "./?page=turfs";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg);
                            _this.prepend(el);
                            el.show('slow');
                            $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                            end_loader();
                    }else{
						alert_toast("An error occurred", 'error');
						end_loader();
                        console.log(resp);
					}
				}
			})
		})
	})
</script>
