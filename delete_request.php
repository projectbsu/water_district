<?php
$page_title = 'Delete Service Request';
require_once('includes/load.php');

// Check user level
page_require_level([1, 2]);

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $request_id = (int)$_GET['id'];

    // Check if the request ID exists and retrieve the associated user ID
    $sql = "SELECT * FROM service_requests WHERE id = '{$request_id}'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        // Proceed to delete the service request
        $delete_sql = "DELETE FROM service_requests WHERE id = '{$request_id}'";

        if ($db->query($delete_sql)) {
            $session->msg('s', "Service request deleted successfully.");
        } else {
            $session->msg('d', "Failed to delete service request.");
        }
    } else {
        $session->msg('d', "Service request not found.");
    }
} else {
    $session->msg('d', "No service request ID specified.");
}

// Redirect back to the service requests page
redirect('service_requests.php', false);
?>
