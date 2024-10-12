<?php
$page_title = 'Edit Billing';
require_once('includes/load.php');

// Check if the user has permission to view this page (Admin-level access)
page_require_level(1);

// Get the billing record by ID
$bill_id = (int)$_GET['id'];
$billing = find_by_id('Billing_list', $bill_id);

if (!$billing) {
    $session->msg("d", "Missing billing ID.");
    redirect('billing_list.php', false);
}

// Update the billing info after submission
if (isset($_POST['update_billing'])) {
    $req_fields = array('name', 'account_number', 'reading_date', 'due_date', 'present_reading', 'previous', 'total', 'penalty', 'total_after_due', 'status', 'paymentMethod', 'maintenance');
    validate_fields($req_fields);

    if (empty($errors)) {
        $name = remove_junk($db->escape($_POST['name']));
        $account_number = remove_junk($db->escape($_POST['account_number']));
        $reading_date = remove_junk($db->escape($_POST['reading_date']));
        $due_date = remove_junk($db->escape($_POST['due_date']));
        $present_reading = (float)$_POST['present_reading'];
        $previous_reading = (float)$_POST['previous'];
        $total = (float)$_POST['total'];
        $penalty = (float)$_POST['penalty'];
        $total_after_due = (float)$_POST['total_after_due'];
        $status = (int)$_POST['status']; // Status from form (0=Unpaid, 1=Paid, 2=Overdue)
        $payment_method = remove_junk($db->escape($_POST['paymentMethod']));
        $maintenance = (float)$_POST['maintenance'];

        // Check if the due date has passed and if the status is "Unpaid"
        if (strtotime($due_date) < time() && $status == 0) {
            $status = 2; // Update status to "Overdue"
        }

        $query = "UPDATE Billing_list SET ";
        $query .= "name='{$name}', account_number='{$account_number}', reading_date='{$reading_date}', ";
        $query .= "due_date='{$due_date}', present_reading={$present_reading}, previous={$previous_reading}, total={$total}, ";
        $query .= "penalty={$penalty}, total_after_due={$total_after_due}, status={$status}, paymentMethod='{$payment_method}', maintenance={$maintenance} ";
        $query .= "WHERE id='{$bill_id}'";

        if ($db->query($query)) {
            $session->msg('s', "Billing updated successfully.");
            redirect('billing_list.php', false);
        } else {
            $session->msg('d', ' Sorry, failed to update billing.');
        }
    } else {
        $session->msg("d", $errors);
    }
}
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<!-- Billing Form and Receipt -->
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span>Edit Billing Info</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_billing.php?id=<?php echo (int)$billing['id']; ?>">
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo remove_junk($billing['name']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="text" class="form-control" name="account_number" value="<?php echo remove_junk($billing['account_number']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="reading_date">Reading Date</label>
                        <input type="date" class="form-control" name="reading_date" value="<?php echo $billing['reading_date']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" name="due_date" value="<?php echo $billing['due_date']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="present_reading">Present Reading</label>
                        <input type="number" step="any" class="form-control" name="present_reading" value="<?php echo $billing['present_reading']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="previous">Previous Reading</label>
                        <input type="number" step="any" class="form-control" name="previous" value="<?php echo $billing['previous']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input type="number" step="any" class="form-control" name="total" value="<?php echo $billing['total']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="penalty">Penalty</label>
                        <input type="number" step="any" class="form-control" name="penalty" value="<?php echo $billing['penalty']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="total_after_due">Total After Due</label>
                        <input type="number" step="any" class="form-control" name="total_after_due" value="<?php echo $billing['total_after_due']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status">
                            <option value="0" <?php if($billing['status'] == 0) echo 'selected'; ?>>Unpaid</option>
                            <option value="1" <?php if($billing['status'] == 1) echo 'selected'; ?>>Paid</option>
                            <option value="2" <?php if($billing['status'] == 2) echo 'selected'; ?>>Overdue</option>
                        </select>

                    </div>
                    <div class="form-group">
                        <label for="paymentMethod">Payment Method</label>
                        <input type="text" class="form-control" name="paymentMethod" value="<?php echo remove_junk($billing['paymentMethod']); ?>">
                    </div>
                    <div class="form-group">
                        <label for="maintenance">Maintenance Fee</label>
                        <input type="number" step="any" class="form-control" name="maintenance" value="<?php echo $billing['maintenance']; ?>">
                    </div>
                    <button type="submit" name="update_billing" class="btn btn-primary">Update Billing</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
    <!-- Display Billing Receipt -->
    <div class="col-md-6">
        <div id="receipt" style="max-width: 500px; margin: 0 auto; border: 2px solid #666; padding: 20px; font-family: Arial, sans-serif; font-size: 12px; border-radius: 5px;">
            <div class="header" style="text-align: center;">
                <img src="uploads/photo/logo.png" alt="Logo" style="width: 80px;">
                <h3 style="margin: 10px 0;">MABINI WATER DISTRICT</h3>
                <p style="margin: 5px 0;">Mabini, Batangas</p>
                <p style="margin: 5px 0;">NON-VAT Registered</p>
            </div>

            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <tr>
                    <td style="border: 1px solid #aaa; padding: 8px;"><strong>Account No:</strong> <?php echo remove_junk($billing['account_number']); ?></td>
                    <td style="border: 1px solid #aaa; padding: 8px; text-align: right;"><strong>Bill No:</strong> <?php echo remove_junk($billing['bill_number']); ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #aaa; padding: 8px;"><strong>Name:</strong> <?php echo remove_junk($billing['name']); ?></td>
                    <td style="border: 1px solid #aaa; padding: 8px; text-align: right;"><strong>Meter No:</strong> <?php echo remove_junk($billing['meter_number']); ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="border: 1px solid #aaa; padding: 8px;"><strong>Address:</strong> ANILAO EAST, MABINI, BATANGAS</td>
                </tr>
            </table>

            <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <tr>
                    <th style="border: 2px solid #666; padding: 8px;">PERIOD COVERED</th>
                    <th style="border: 2px solid #666; padding: 8px;">METER READING</th>
                    <th style="border: 2px solid #666; padding: 8px;">CONSUMED</th>
                    <th style="border: 2px solid #666; padding: 8px;">AMOUNT</th>
                </tr>
                <tr>
                    <td style="border: 1px solid #aaa; padding: 8px;"><?php echo date('m/d/y', strtotime($billing['reading_date'])); ?> to <?php echo date('m/d/y', strtotime($billing['due_date'])); ?></td>
                    <td style="border: 1px solid #aaa; padding: 8px;"><?php echo $billing['present_reading']; ?> (Present) <br> <?php echo $billing['previous']; ?> (Previous)</td>
                    <td style="border: 1px solid #aaa; padding: 8px;"><?php echo $billing['present_reading'] - $billing['previous']; ?></td>
                    <td style="border: 1px solid #aaa; padding: 8px;">₱<?php echo number_format($billing['total'], 2); ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="border: 1px solid #aaa; padding: 8px;"><strong>Meter Maintenance Fee/ACA/FR. Tax</strong></td>
                    <td style="border: 1px #aaa; padding: 8px;">₱<?php echo number_format($billing['maintenance'], 2); ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="border: 1px solid #aaa; padding: 8px;"><strong>Total Amount Due</strong></td>
                    <td style="border: 1px solid #aaa; padding: 8px;">₱<?php echo number_format($billing['total'], 2); ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="border: 1px solid #aaa; padding: 8px;"><strong>Penalty after Due Date (10%)</strong></td>
                    <td style="border: 1px solid #aaa; padding: 8px;">₱<?php echo number_format($billing['penalty'], 2); ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="border: 1px solid #aaa; padding: 8px;"><strong>Amount Due After Due Date</strong></td>
                    <td style="border: 1px solid #aaa; padding: 8px;">₱<?php echo number_format($billing['total_after_due'], 2); ?></td>
                </tr>
            </table>

            <div style="margin-top: 20px; text-align: center;">
                <p>Signature of Collector / Date: _________________________</p>
            </div>
        </div>

        <!-- Print and Send buttons -->
        <div style="text-align: center; margin-top: 20px;">
            <button onclick="printReceipt()" class="btn btn-primary">Print</button>
            <button onclick="sendReceipt()" class="btn btn-secondary">Send</button>
        </div>
    </div>
</div>



<script>
    // Print only the receipt content
    function printReceipt() {
        var content = document.getElementById("receipt").innerHTML;
        var originalContent = document.body.innerHTML;

        document.body.innerHTML = content;
        window.print();
        document.body.innerHTML = originalContent;
    }

    // Placeholder function for sending the receipt
    function sendReceipt() {
        alert("The receipt will be sent via email.");
        // Implement email sending functionality here.
    }
</script>



<?php include_once('layouts/footer.php'); ?>
