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
    $gender = remove_junk($db->escape($_POST['gender']));
    $barangay = remove_junk($db->escape($_POST['barangay']));
    $status = 'Pending'; // Default status

    // Check if user ID is available
    if ($current_user_id) {
        // Insert into service_requests
        $sql = "INSERT INTO service_requests (customer_user_id, name, email, contact, gender, barangay, status) 
                VALUES ('$current_user_id', '$name', '$email', '$contact', '$gender', '$barangay', '$status')";

        if ($db->query($sql)) {
            // Get the last inserted service request ID
            $last_request_id = $db->insert_id;

            // Insert into transactions table
            $transaction_detail = "$name send a service request.";
            $transaction_time = date('Y-m-d H:i:s'); // Current timestamp

            $transaction_sql = "INSERT INTO transactions (customer_user_id, transaction_detail, transaction_time)
                                VALUES ('$current_user_id', '$transaction_detail', '$transaction_time')";

            if ($db->query($transaction_sql)) {
                $session->msg('s', "Request added and transaction recorded!");
                redirect('service_requests.php', false);
            } else {
                // Handle transaction error
                echo "Transaction SQL Error: " . $db->error; // Temporary for debugging
                $session->msg('d', "Failed to record transaction.");
                redirect('add_request.php', false);
            }
        } else {
            // Debugging: Log the SQL error
            echo "SQL Error: " . $db->error; // Temporary for debugging
            $session->msg('d', "Failed to add request.");
            redirect('add_request.php', false);
        }
    } else {
        echo "No user ID found"; // Debugging message
    }
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
