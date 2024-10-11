<?php
require_once('includes/load.php');

// Check user permission
page_require_level(1);

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
    $archived_feedback_id = (int)$_GET['id'];

    // Fetch the archived feedback data
    $query = "SELECT * FROM archived_feedback WHERE id = '{$archived_feedback_id}' LIMIT 1";
    $archived_feedback = find_by_sql($query);

    if ($archived_feedback) {
        // Prepare the data for restoring
        $user_id = $archived_feedback[0]['user_id'];
        $feedback_text = $archived_feedback[0]['feedback_text'];
        $reaction = $archived_feedback[0]['reaction'];
        $sentiment_score = $archived_feedback[0]['sentiment_score'];

        // Insert into feedback
        $insert_query = "INSERT INTO feedback (user_id, feedback_text, reaction, sentiment_score) 
                         VALUES ('{$user_id}', '{$feedback_text}', '{$reaction}', '{$sentiment_score}')";
        $db->query($insert_query);

        // Delete from archived_feedback
        $delete_query = "DELETE FROM archived_feedback WHERE id = '{$archived_feedback_id}'";
        $db->query($delete_query);

        // Redirect with a success message
        $_SESSION['msg'] = "Feedback unarchived successfully.";
        header('Location: archived_feedback.php');
    } else {
        $_SESSION['msg'] = "Archived feedback not found.";
        header('Location: archived_feedback.php');
    }
} else {
    $_SESSION['msg'] = "Invalid archived feedback ID.";
    header('Location: archived_feedback.php');
}
?>
