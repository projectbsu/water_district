<?php
require_once('includes/load.php');

if (isset($_GET['id'])) {
    $feedback_id = $_GET['id'];
    delete_feedback($feedback_id);
    $session->msg('s', "Feedback deleted successfully.");
    redirect('userfeedback.php');
} else {
    $session->msg('d', "Missing feedback ID.");
    redirect('userfeedback.php');
}
