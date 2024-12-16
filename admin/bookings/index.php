<div class="card card-outline card-primary shadow rounded-0">
    <div class="card-header">
        <h3 class="card-title"><b>Booking List</b></h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-striped table-bordered">
                <colgroup>
                    <col width="5%">
                    <col width="15%">
                    <col width="15%">
                    <col width="20%">
                    <col width="20%">
                    <col width="15%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr class="bg-gradient-dark text-light">
                        <th class="text-center">#</th>
                        <th class="text-center">Date Booked</th>
                        <th class="text-center">Ref. Code</th>
                        <th class="text-center">Turf</th>
                        <th class="text-center">Client</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    $bookings = $conn->query("
                        SELECT 
                            b.*, 
                            CONCAT(c.lastname, ', ', c.firstname, ' ', COALESCE(c.middlename, '')) AS client, 
                            t.turf_name AS turf 
                        FROM `booking_list` b 
                        INNER JOIN `client_list` c ON b.client_id = c.id 
                        INNER JOIN `turfs` t ON b.turf_id = t.turf_id 
                        ORDER BY UNIX_TIMESTAMP(b.date_created) DESC
                    ");
                    while ($row = $bookings->fetch_assoc()):
                    ?>
                        <tr>
                            <td class="text-center"><?= $i++ ?></td>
                            <td><?= date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
                            <td><?= $row['ref_code'] ?></td>
                            <td>
                                <p class="truncate-1 m-0"><?= $row['turf'] ?></p>
                            </td>
                            <td><?= $row['client'] ?></td>
                            <td class="text-center">
                                <?php 
                                    switch ($row['status']) {
                                        case 0:
                                            echo "<span class='badge badge-secondary bg-gradient-secondary px-3 rounded-pill'>Pending</span>";
                                            break;
                                        case 1:
                                            echo "<span class='badge badge-primary bg-gradient-primary px-3 rounded-pill'>Confirmed</span>";
                                            break;
                                        case 2:
                                            echo "<span class='badge badge-warning bg-gradient-success px-3 rounded-pill'>Done</span>";
                                            break;
                                        case 3:
                                            echo "<span class='badge badge-danger bg-gradient-danger px-3 rounded-pill'>Cancelled</span>";
                                            break;
                                    }
                                ?>
                            </td>
                            <td class="text-center">
                                <a class="btn btn-flat btn-sm btn-default border view_data" href="javascript:void(0)" data-id="<?= $row['id'] ?>">
                                    <i class="fa fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.table th, .table td').addClass("align-middle px-2 py-1");
        $('.table').dataTable();
        $('.view_data').click(function() {
            uni_modal("Booking Details", "bookings/view_booking.php?id=" + $(this).attr('data-id'));
        });
    });
</script>
