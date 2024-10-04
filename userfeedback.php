<?php
require_once('includes/load.php');

// Check user permission
page_require_level(1);

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch all feedback from database
$query = "SELECT f.*, u.username FROM feedback f LEFT JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC";
$all_feedback = find_by_sql($query);
if ($all_feedback === false) {
    die("Query failed: " . $db->error); // Change this line based on your error handling
}

include_once('layouts/header.php');
?>

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
                    <span>All Feedback</span>
                </strong>
            </div>
            <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Customer Name</th> <!-- Change this header to User Name -->
                        <th>Reaction</th>
                        <th>Feedback</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_feedback as $feedback): ?>
                    <tr>
                        <td><?php echo remove_junk(ucwords($feedback['user_name'])); ?></td> <!-- Show user name here -->
                        <td><?php echo remove_junk($feedback['reaction']); ?></td>
                        <td><?php echo remove_junk($feedback['feedback_text']); ?></td>
                        <td><?php echo read_date($feedback['created_at']); ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="delete_feedback.php?id=<?php echo (int)$feedback['id']; ?>" class="btn btn-danger btn-xs">Delete</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
