<?php
$page_title = 'Add Service Request';
require_once('includes/load.php');

// Check user level
page_require_level(1);

if (isset($_POST['submit'])) {
    // Debug: Check if the form is submitted
    echo "Form submitted"; // Debugging line

    // Capture current user ID from session
    $current_user_id = $_SESSION['user_id'] ?? null; // Ensure this is set

    // Prepare data
    $name = remove_junk($db->escape($_POST['name']));
    $email = remove_junk($db->escape($_POST['email']));
    $contact = remove_junk($db->escape($_POST['contact']));
    $account_number = remove_junk($db->escape($_POST['account_number']));
    $gender = remove_junk($db->escape($_POST['gender']));
    $barangay = remove_junk($db->escape($_POST['barangay']));
    $status = 'Pending'; // Default status
}


?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>Add Service Request</strong>
            </div>
            <div class="panel-body">
                <form method="post" action="add_request.php">
                <div class="form-group">
                    <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="contact">Contact</label>
                        <input type="text" class="form-control" name="contact" required>
                    </div>
                    <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="text" class="form-control" name="account_number" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="barangay">Barangay</label>
                        <input type="text" class="form-control" name="barangay" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
