<?php
require_once('includes/load.php');

// Check user permission
page_require_level([1, 2]);

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch all feedback from the database with the actual user name
$query = "SELECT f.*, u.name AS user_name FROM feedback f LEFT JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC";
$all_feedback = find_by_sql($query);
if ($all_feedback === false) {
    die("Query failed: " . $db->error); // Change this line based on your error handling
}

// Include the header
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
                    <span>All Feedback Transactions</span>
                </strong>
                <a href="archived_feedback.php" class="btn btn-info pull-right btn-sm"> View Archive List</a>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th> <!-- New column for ID -->
                            <th>Customer Name</th>
                            <th>Rating</th>
                            <th>Feedback</th>
                            <th>Sentiment Score</th> <!-- New column for sentiment score -->
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <?php
                // Define the mapping for the reactions
                $reaction_map = array(
                    'Angry' => 'Very Unsatisfied',
                    'Sad' => 'Unsatisfied',
                    'Neutral' => 'Neutral',
                    'Happy' => 'Satisfied',
                    'Very Happy' => 'Very Satisfied'
                );
                ?>

                <tbody>
                    <?php foreach ($all_feedback as $feedback): ?>
                    <tr>
                        <td><?php echo remove_junk((int)$feedback['id']); ?></td> <!-- Display ID -->
                        <td><?php echo remove_junk(ucwords($feedback['user_name'])); ?></td>
                        <td>
                            <?php
                            // Check if the reaction exists in the map, and display the mapped reaction or default to the original value
                            $reaction = $feedback['reaction'];
                            echo isset($reaction_map[$reaction]) ? remove_junk($reaction_map[$reaction]) : remove_junk($reaction);
                            ?>
                        </td>
                        <td><?php echo remove_junk($feedback['feedback_text']); ?></td>
                        <td><?php echo remove_junk($feedback['sentiment_score']); ?></td> <!-- Display sentiment score -->
                        <td><?php echo read_date($feedback['created_at']); ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="archive_feedback.php?id=<?php echo (int)$feedback['id']; ?>" class="btn btn-warning btn-xs">Archive</a>
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
