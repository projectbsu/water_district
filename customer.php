<?php
$page_title = 'Customer Management';
require_once('includes/load.php');

// Check what level user has permission to view this page
page_require_level([2]);

// Fetch all customers from the database
// Assuming the '3' is the group ID for "Customer", modify this based on your actual database structure
$all_customers = find_users_by_role(3); // Function to get customers only
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
                    <span>Customers</span>
                </strong>
                <a href="add_user.php" class="btn btn-info pull-right">Add New Customer</a>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Account Number</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Sex</th>
                            <th>Barangay</th>
                            <th>Age</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($all_customers as $customer): ?>
                        <tr>
                            <td class="text-center"><?php echo count_id(); ?></td>
                            <td><?php echo remove_junk(ucwords($customer['name'])); ?></td>
                            <td><?php echo remove_junk(ucwords($customer['username'])); ?></td>
                            <td><?php echo remove_junk($customer['account_number']); ?></td>
                            <td><?php echo remove_junk($customer['email']); ?></td>
                            <td><?php echo remove_junk($customer['contact']); ?></td>
                            <td><?php echo remove_junk($customer['sex']); ?></td>
                            <td><?php echo remove_junk($customer['barangay']); ?></td>
                            <td><?php echo (int)$customer['age']; ?></td>
                            <td class="text-center">
                                <?php if ($customer['status'] === '1'): ?>
                                    <span class="label label-success"><?php echo "Active"; ?></span>
                                <?php else: ?>
                                    <span class="label label-danger"><?php echo "Inactive"; ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_user.php?id=<?php echo (int)$customer['id']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                    <a href="delete_user.php?id=<?php echo (int)$customer['id']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
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
