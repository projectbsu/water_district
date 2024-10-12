<?php
$page_title = 'Edit Announcement';
require_once('includes/load.php');
// Check user permission
page_require_level(1);

if (isset($_GET['id'])) {
    $announcement_id = (int)$_GET['id'];
    $announcement = find_by_id('announcements', $announcement_id);
    if (!$announcement) {
        $session->msg("d", "Announcement not found.");
        redirect('announcement.php', false);
    }
} else {
    $session->msg("d", "Invalid ID.");
    redirect('announcement.php', false);
}

if (isset($_POST['edit_announcement'])) {
    $req_field = array('announcement-title', 'announcement-schedule', 'announcement-context');
    validate_fields($req_field);
    $title = remove_junk($db->escape($_POST['announcement-title']));
    $schedule = remove_junk($db->escape($_POST['announcement-schedule']));
    $context = remove_junk($db->escape($_POST['announcement-context']));

    if (empty($errors)) {
        $sql = "UPDATE announcements SET title = '{$title}', schedule = '{$schedule}', context = '{$context}' WHERE id = '{$announcement_id}'";
        if ($db->query($sql)) {
            $session->msg("s", "Announcement updated successfully.");
            redirect('announcement.php', false);
        } else {
            $session->msg("d", "Failed to update announcement.");
            redirect('announcement.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('announcement.php', false);
    }
}

include_once('layouts/header.php'); 
?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-edit"></span>
                    <span>Edit Announcement</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_announcement.php?id=<?php echo (int)$announcement['id']; ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="announcement-title" value="<?php echo remove_junk(ucfirst($announcement['title'])); ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" name="announcement-schedule" value="<?php echo remove_junk($announcement['schedule']); ?>" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="announcement-context" required><?php echo remove_junk($announcement['context']); ?></textarea>
                    </div>
                    <button type="submit" name="edit_announcement" class="btn btn-primary">Update Announcement</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
