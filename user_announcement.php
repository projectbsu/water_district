<?php
$page_title = 'Announcements';
require_once('includes/load.php');
// Check user permission
page_require_level([3]);

$latest_announcement = find_latest_announcement(); // Function to fetch the latest announcement
$previous_announcements = find_previous_announcements(); // Function to fetch previous announcements

include_once('layouts/header.php'); 
?>

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-bullhorn"></span>
                    <span>Latest Announcement</span>
                </strong>
            </div>
            <div class="panel-body">
                <?php if ($latest_announcement): ?>
                    <h4><?php echo remove_junk(ucfirst($latest_announcement['title'])); ?></h4>
                    <p><strong>Scheduled on:</strong> <?php echo remove_junk($latest_announcement['schedule']); ?></p>
                    <p><?php echo remove_junk($latest_announcement['context']); ?></p>
                <?php else: ?>
                    <p>No announcements available.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Panel for Previous Announcements -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-list-alt"></span>
                    <span>Previous Announcements</span>
                </strong>
            </div>
            <div class="panel-body">
                <?php if (!empty($previous_announcements)): ?>
                    <ul class="list-group">
                        <?php foreach ($previous_announcements as $announcement): ?>
                            <li class="list-group-item">
                                <h5><?php echo remove_junk(ucfirst($announcement['title'])); ?></h5>
                                <p><strong>Scheduled on:</strong> <?php echo remove_junk($announcement['schedule']); ?></p>
                                <p><?php echo remove_junk($announcement['context']); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No previous announcements available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
