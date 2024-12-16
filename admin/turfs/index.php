<?php if ($_settings->chk_flashdata('success')): ?>
<script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
</script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Turfs</h3>
        <div class="card-tools">
            <a href="?page=turfs/manage_facility" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-bordered table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="20%">
                        <col width="20%">
                        <col width="25%">
                        <col width="15%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        // Modify query to select all turfs, regardless of status
                        $qry = $conn->query("SELECT * FROM `turfs` ORDER BY `turf_name` ASC");
                        while ($row = $qry->fetch_assoc()):
                            foreach ($row as $k => $v) {
                                $row[$k] = trim(stripslashes($v));
                            }
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo ucwords($row['turf_name']); ?></td>
                            <td><?php echo ucwords($row['location']); ?></td>
                            <td><?php echo ($row['description']); ?></td>
                            <td><?php echo number_format($row['price'], 2); ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] == 'Available'): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger px-3 rounded-pill">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" href="?page=turfs/view_turf&id=<?php echo $row['turf_id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="?page=turfs/manage_facility&id=<?php echo $row['turf_id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item toggle_status" href="javascript:void(0)" data-id="<?php echo $row['turf_id'] ?>" data-status="<?php echo $row['status'] ?>">
                                        <?php if ($row['status'] == 'Available'): ?>
                                            <span class="fa fa-times text-warning"></span> Mark Inactive
                                        <?php else: ?>
                                            <span class="fa fa-check text-success"></span> Mark Active
                                        <?php endif; ?>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['turf_id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle delete turf action
        $('.delete_data').click(function() {
            _conf("Are you sure to delete this Turf permanently?", "delete_turf", [$(this).attr('data-id')])
        });

        // Handle toggle status action
        $('.toggle_status').click(function() {
            var turf_id = $(this).data('id');
            var current_status = $(this).data('status');
            var new_status = (current_status === 'Available') ? 'Unavailable' : 'Available';
            console.log(turf_id, current_status, new_status);
            _conf("Are you sure to change the status to " + new_status + "?", "toggle_turf_status", [turf_id, new_status]);
        });

        // Add classes and initialize DataTable
        $('.table th, .table td').addClass("align-middle px-2 py-1");
        $('.table').dataTable();
    });

    // Function to delete a turf
    function delete_turf($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "../classes/Master.php?f=delete_turf",
            method: "POST",
            data: { id: $id },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }

    // Function to toggle turf status
    function toggle_turf_status(turf_id, new_status) {
        start_loader();
        $.ajax({
            url: _base_url_ + "../classes/Master.php?f=toggle_status",
            method: "POST",
            data: { id: turf_id, status: new_status },
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
