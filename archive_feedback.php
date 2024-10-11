<?php
require_once('includes/load.php');

// Check user permission
page_require_level(1);

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch the feedback ID from the request
if (isset($_GET['id'])) {
    $feedback_id = (int)$_GET['id'];

    // Fetch the feedback data
    $query = "SELECT * FROM feedback WHERE id = '{$feedback_id}' LIMIT 1";
    $feedback = find_by_sql($query);

    if ($feedback) {
        // Prepare the data for archiving
        $user_id = $feedback[0]['user_id'];
        $feedback_text = $feedback[0]['feedback_text'];
        $reaction = $feedback[0]['reaction'];
        $sentiment_score = $feedback[0]['sentiment_score'];

        // Insert into archived_feedback
        $archive_query = "INSERT INTO archived_feedback (user_id, feedback_text, reaction, sentiment_score) 
                          VALUES ('{$user_id}', '{$feedback_text}', '{$reaction}', '{$sentiment_score}')";
        $db->query($archive_query);

        // Delete from feedback
        $delete_query = "DELETE FROM feedback WHERE id = '{$feedback_id}'";
        $db->query($delete_query);

        // Redirect with a success message
        $_SESSION['msg'] = "Feedback archived successfully.";
        header('Location: userfeedback.php');
    } else {
        $_SESSION['msg'] = "Feedback not found.";
        header('Location: userfeedback.php');
    }
} else {
    $_SESSION['msg'] = "Invalid feedback ID.";
    header('Location: userfeedback.php');
}
?>
