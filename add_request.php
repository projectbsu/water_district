<?php
$page_title = 'Add Service Request';
require_once('includes/load.php');

// Check user level
page_require_level([3]);

// Fetch categories from the database
$categories = find_all('categories');

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
    $category = remove_junk($db->escape($_POST['category']));
    $status = 'Pending'; // Default status

    // Insert data into the database
    $query = "INSERT INTO service_requests (name, email, contact, account_number, gender, barangay, status, category)
              VALUES ('{$name}', '{$email}', '{$contact}', '{$account_number}', '{$gender}', '{$barangay}', '{$status}','{$category}')";

    if ($db->query($query)) {
        $msg = "Service request added successfully.";
    } else {
        $msg = "Error: " . $db->error; // Capture any error
    }

    // Redirect or refresh after submission
    header('Location: service_requests.php'); // Redirect to the requests page
    exit();
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
                        <label for="account_number">Account Number</label>
                        <input type="text" class="form-control" name="account_number" required>
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
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select name="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['name']; ?>">
                                    <?php echo ucfirst($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
