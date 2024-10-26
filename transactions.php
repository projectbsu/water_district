<?php
$page_title = 'Transactions';
require_once('includes/load.php');

// Check user level
page_require_level([1, 2]);

// Fetch all transactions from the database
$query = "SELECT * FROM transactions ORDER BY transaction_time DESC";
$all_transactions = find_by_sql($query);
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
                    <span>All Transactions</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th> <!-- Display User Name -->
                            <th>Account Number</th> <!-- Added Account Number Column -->
                            <th>Transaction Detail</th>
                            <th>Transaction Time</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_transactions as $transaction): ?>
                        <tr>
                            <td><?php echo remove_junk($transaction['user_name']); ?></td>
                            <td><?php echo remove_junk($transaction['account_number']); ?></td>
                            <td><?php echo remove_junk($transaction['transaction_detail']); ?></td>
                            <td><?php echo read_date($transaction['transaction_time']); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="delete_transaction.php?id=<?php echo (int)$transaction['id']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
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
