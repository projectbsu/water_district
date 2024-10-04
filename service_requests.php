<?php
$page_title = 'Service Requests';
require_once('includes/load.php');

// Check user level
page_require_level(1);

// Fetch all service requests
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$all_requests = find_all_service_requests($status_filter); // Modify your function to accept a status filter if needed

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Service Requests</span>
                </strong>
                <a href="add_request.php" class="btn btn-info pull-right">Add New Request</a>
            </div>
            <div class="panel-body">
                <form method="GET" class="form-inline" style="margin-bottom: 20px;">
                    <div class="form-group">
                        <label for="status">Filter by Status:</label>
                        <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                            <option value="all" <?php if ($status_filter == 'all') echo 'selected'; ?>>All</option>
                            <option value="pending" <?php if ($status_filter == 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="approved" <?php if ($status_filter == 'approved') echo 'selected'; ?>>Approved</option>
                            <option value="denied" <?php if ($status_filter == 'denied') echo 'selected'; ?>>Denied</option>
                        </select>
                    </div>
                </form>
                
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Gender</th>
                            <th>Barangay</th>
                            <th>Status</th>
                            <th>Date of Request</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($all_requests as $request): ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk(ucwords($request['name'])); ?></td>
                                <td><?php echo remove_junk($request['email']); ?></td>
                                <td><?php echo remove_junk($request['contact']); ?></td>
                                <td><?php echo remove_junk($request['gender']); ?></td>
                                <td><?php echo remove_junk($request['barangay']); ?></td>
                                <td>
                                    <span class="label <?php echo get_status_class($request['status']); ?>">
                                        <?php echo remove_junk(ucwords($request['status'])); ?>
                                    </span>
                                </td>
                                <td><?php echo remove_junk($request['date_of_request']); ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_request.php?id=<?php echo (int)$request['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        <a href="delete_request.php?id=<?php echo (int)$request['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>

<?php
// Helper function to return CSS class based on status
function get_status_class($status) {
    switch (strtolower($status)) {
        case 'pending':
            return 'label-warning'; // Bootstrap warning color
        case 'approved':
            return 'label-success'; // Bootstrap success color
        case 'denied':
            return 'label-danger'; // Bootstrap danger color
        default:
            return 'label-default'; // Default color for unknown status
    }
}
?>
