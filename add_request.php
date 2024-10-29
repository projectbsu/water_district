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
    header('Location: add_request.php'); // Redirect to the requests page
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
                    <select class="form-control" name="barangay">
                    <option value="Anilao Proper">Anilao Proper</option>
                    <option value="Anilao East">Anilao East</option>
                    <option value="Bagalangit">Bagalangit</option>
                    <option value="Bulacan">Bulacan</option>
                    <option value="Calamias">Calamias</option>
                    <option value="Estrella">Estrella</option>
                    <option value="Gasang">Gasang</option>
                    <option value="Laurel">Laurel</option>
                    <option value="Ligaya">Ligaya</option>
                    <option value="Mainaga">Mainaga</option>
                    <option value="Mainit">Mainit</option>
                    <option value="Majuben">Majuben</option>
                    <option value="Malimatoc I">Malimatoc I</option>
                    <option value="Malimatoc II">Malimatoc II</option>
                    <option value="Nag-Iba">Nag-Iba</option>
                    <option value="Pilahan">Pilahan</option>
                    <option value="Poblacion">Poblacion</option>
                    <option value="Pulang Lupa">Pulang Lupa</option>
                    <option value="Pulong Anahao">Pulong Anahao</option>
                    <option value="Pulong Balibaguhan">Pulong Balibaguhan</option>
                    <option value="Pulong Niogan">Pulong Niogan</option>
                    <option value="Saguing">Saguing</option>
                    <option value="Sampaguita">Sampaguita</option>
                    <option value="San Francisco">San Francisco</option>
                    <option value="San Jose">San Jose</option>
                    <option value="San Juan">San Juan</option>
                    <option value="San Teodoro">San Teodoro</option>
                    <option value="Santa Ana">Santa Ana</option>
                    <option value="Santa Mesa">Santa Mesa</option>
                    <option value="Santo Niño">Santo Niño</option>
                    <option value="Santo Tomas">Santo Tomas</option>
                    <option value="Solo">Solo</option>
                    <option value="Talaga Proper">Talaga Proper</option>
                    <option value="Talaga East">Talaga East</option>
                    </select>
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
