<?php
require_once('includes/load.php');

// Check user permission
page_require_level(1);

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch all archived feedback from the database
$query = "SELECT f.*, u.name AS user_name FROM archived_feedback f LEFT JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC";
$archived_feedback = find_by_sql($query);

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
                    <span>Archived Feedback</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Rating</th>
                            <th>Feedback</th>
                            <th>Sentiment Score</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($archived_feedback as $feedback): ?>
                        <tr>
                            <td><?php echo remove_junk(ucwords($feedback['user_name'])); ?></td>
                            <td><?php echo remove_junk($feedback['reaction']); ?></td>
                            <td><?php echo remove_junk($feedback['feedback_text']); ?></td>
                            <td><?php echo remove_junk($feedback['sentiment_score']); ?></td>
                            <td><?php echo read_date($feedback['created_at']); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="unarchive_feedback.php?id=<?php echo (int)$feedback['id']; ?>" class="btn btn-success btn-xs">Unarchive</a>
                                    <a href="delete_archived_feedback.php?id=<?php echo (int)$feedback['id']; ?>" class="btn btn-danger btn-xs">Delete</a>
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
