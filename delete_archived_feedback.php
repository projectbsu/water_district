<?php
require_once('includes/load.php');

// Check user permission
page_require_level([1, 2]);

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id'])) {
    $archived_feedback_id = (int)$_GET['id'];

    // Delete from archived_feedback
    $delete_query = "DELETE FROM archived_feedback WHERE id = '{$archived_feedback_id}'";
    $db->query($delete_query);

    // Redirect with a success message
    $_SESSION['msg'] = "Customer feedback deleted permanently.";
    header('Location: archived_feedback.php');
} else {
    $_SESSION['msg'] = "Invalid archived feedback ID.";
    header('Location: archived_feedback.php');
}
?>
