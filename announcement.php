<?php
$page_title = 'Manage Announcements';
require_once('includes/load.php');
// Check user permission
page_require_level(1);

$all_announcements = find_all('announcements');

if (isset($_POST['add_announcement'])) {
    $req_field = array('announcement-title', 'announcement-schedule', 'announcement-context');
    validate_fields($req_field);
    $title = remove_junk($db->escape($_POST['announcement-title']));
    $schedule = remove_junk($db->escape($_POST['announcement-schedule']));
    $context = remove_junk($db->escape($_POST['announcement-context']));

    if (empty($errors)) {
        $sql  = "INSERT INTO announcements (title, schedule, context)";
        $sql .= " VALUES ('{$title}', '{$schedule}', '{$context}')";
        if ($db->query($sql)) {
            $session->msg("s", "Successfully Added New Announcement");
            redirect('announcement.php', false);
        } else {
            $session->msg("d", "Sorry Failed to insert.");
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
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-bullhorn"></span>
                    <span>Add New Announcement</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="announcement.php">
                    <div class="form-group">
                        <input type="text" class="form-control" name="announcement-title" placeholder="Announcement Title" required>
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" name="announcement-schedule" placeholder="Schedule Date" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="announcement-context" placeholder="Announcement Details" required></textarea>
                    </div>
                    <button type="submit" name="add_announcement" class="btn btn-primary">Add Announcement</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-list-alt"></span>
                    <span>All Announcements</span>
                </strong>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Title</th>
                            <th>Schedule</th>
                            <th>Details</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_announcements as $announcement): ?>
                        <tr>
                            <td class="text-center"><?php echo count_id(); ?></td>
                            <td><?php echo remove_junk(ucfirst($announcement['title'])); ?></td>
                            <td><?php echo remove_junk($announcement['schedule']); ?></td>
                            <td><?php echo remove_junk($announcement['context']); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_announcement.php?id=<?php echo (int)$announcement['id']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <a href="delete_announcement.php?id=<?php echo (int)$announcement['id']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
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
