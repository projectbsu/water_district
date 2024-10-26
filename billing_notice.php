<?php
$page_title = 'Add Billing Notice';
require_once('includes/load.php');
page_require_level([1, 2]); // Admin-level access

// Correct form submission check
if (isset($_POST['add_billing'])) {
    // Existing variable declarations...
    $name = remove_junk($db->escape($_POST['name']));
    $account_number = remove_junk($db->escape($_POST['account_number']));
    $reading_date = $db->escape($_POST['reading_date']);
    $bill_number = remove_junk($db->escape($_POST['bill_number']));
    $meter_number = remove_junk($db->escape($_POST['meter_number']));
    $due_date = $db->escape($_POST['due_date']);
    $present_reading = (float)$_POST['present_reading'];
    $previous = (float)$_POST['previous'];
    $total = (float)$_POST['total'];
    $penalty = (float)$_POST['penalty'];
    $total_after_due = (float)$_POST['total_after_due'];
    
    // Adjusted status handling
    $status = (int)$_POST['status']; // 0 for Unpaid, 1 for Paid, 2 for Overdue
    
    $paymentMethod = remove_junk($db->escape($_POST['paymentMethod']));
    $maintenance = (float)$_POST['maintenance'];

    $query  = "INSERT INTO Billing_list (";
    $query .= "name, account_number, reading_date, bill_number, meter_number, due_date, present_reading, previous, total, penalty, total_after_due, status, paymentMethod, maintenance";
    $query .= ") VALUES (";
    $query .= " '{$name}', '{$account_number}', '{$reading_date}', '{$bill_number}', '{$meter_number}', '{$due_date}', '{$present_reading}', '{$previous}', '{$total}', '{$penalty}', '{$total_after_due}', '{$status}', '{$paymentMethod}', '{$maintenance}'";
    $query .= ")";

    // Run the query and check for success
    if ($db->query($query)) {
        $session->msg('s', "Billing notice has been created.");
        redirect('billing_notice.php', false);
    } else {
        $session->msg('d', ' Sorry, failed to create billing notice!');
        redirect('billing_notice.php', false);
    }
}
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-8">
        <?php echo display_msg($msg); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Create Billing Notice</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="billing_notice.php">
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Customer Name" required>
                    </div>
                    <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="text" class="form-control" name="account_number" placeholder="Account Number" required>
                    </div>
                    <div class="form-group">
                        <label for="reading_date">Reading Date</label>
                        <input type="date" class="form-control" name="reading_date" required>
                    </div>
                    <div class="form-group">
                        <label for="bill_number">Bill Number</label>
                        <input type="text" class="form-control" name="bill_number" placeholder="Bill Number" required>
                    </div>
                    <div class="form-group">
                        <label for="meter_number">Meter Number</label>
                        <input type="text" class="form-control" name="meter_number" placeholder="Meter Number" required>
                    </div>
                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" name="due_date" required>
                    </div>
                    <div class="form-group">
                        <label for="present_reading">Present Reading</label>
                        <input type="number" step="0.01" class="form-control" name="present_reading" placeholder="Present Reading" required>
                    </div>
                    <div class="form-group">
                        <label for="previous">Previous Reading</label>
                        <input type="number" step="0.01" class="form-control" name="previous" placeholder="Previous Reading" required>
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" step="0.01" class="form-control" name="total" placeholder="Total Amount" required>
                    </div>
                    <div class="form-group">
                        <label for="penalty">Penalty</label>
                        <input type="number" step="0.01" class="form-control" name="penalty" placeholder="Penalty">
                    </div>
                    <div class="form-group">
                        <label for="total_after_due">Total After Due Date</label>
                        <input type="number" step="0.01" class="form-control" name="total_after_due" placeholder="Total After Due Date" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status">
                            <option value="0">Unpaid</option>
                            <option value="1">Paid</option>
                            <option value="2">Overdue</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="paymentMethod">Payment Method</label>
                        <input type="text" class="form-control" name="paymentMethod" placeholder="Payment Method" required>
                    </div>
                    <div class="form-group">
                        <label for="maintenance">Maintenance Fee</label>
                        <input type="number" step="0.01" class="form-control" name="maintenance" placeholder="Maintenance Fee" required>
                    </div>
                    <div class="form-group clearfix">
                        <button type="submit" name="add_billing" class="btn btn-primary">Create Billing Notice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
