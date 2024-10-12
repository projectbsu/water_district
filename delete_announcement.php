<?php
require_once('includes/load.php');
// Check user permission
page_require_level(1);

if (isset($_GET['id'])) {
    $announcement_id = (int)$_GET['id'];
    $announcement = find_by_id('announcements', $announcement_id);
    if ($announcement) {
        $sql = "DELETE FROM announcements WHERE id = '{$announcement_id}'";
        if ($db->query($sql)) {
            $session->msg("s", "Announcement deleted successfully.");
            redirect('announcement.php', false);
        } else {
            $session->msg("d", "Failed to delete announcement.");
            redirect('announcement.php', false);
        }
    } else {
        $session->msg("d", "Announcement not found.");
        redirect('announcement.php', false);
    }
} else {
    $session->msg("d", "Invalid ID.");
    redirect('announcement.php', false);
}
