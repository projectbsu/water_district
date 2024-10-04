<?php
$page_title = 'Transactions';
require_once('includes/load.php');

// Check user level
page_require_level(1);

// Fetch all transactions
$all_transactions = find_all_transactions();
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
                    <span>Transactions</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>User ID</th>
                            <th>Transaction Detail</th>
                            <th>Transaction Time</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($all_transactions as $transaction): ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk($transaction['customer_user_id']); ?></td>
                                <td><?php echo remove_junk($transaction['transaction_detail']); ?></td>
                                <td><?php echo remove_junk($transaction['transaction_time']); ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_transaction.php?id=<?php echo (int)$transaction['id'];?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        <a href="delete_transaction.php?id=<?php echo (int)$transaction['id'];?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
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
