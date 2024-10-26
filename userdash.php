<?php
$page_title = 'All User';
require_once('includes/load.php');

// Check permission level
page_require_level([3]);

include_once('layouts/header.php');
?>

<div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
</div>

<!-- First Row -->
<div class="row">
    <div class="col-md-3">
        <a href="services.php" style="color:black;">
            <div class="panel panel-box clearfix" style="height: 80px;">
                <div class="panel-icon pull-left bg-blue" style="height: 80px;">
                    <i class="glyphicon glyphicon-user"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"></h2>
                    <p class="text-muted">Services</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="billing_notice.php" style="color:black;">
            <div class="panel panel-box clearfix" style="height: 80px;">
                <div class="panel-icon pull-left bg-red" style="height: 80px;">
                    <i class="glyphicon glyphicon-th-large"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"></h2>
                    <p class="text-muted">Billing</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Second Row -->
<div class="row">
    <div class="col-md-3">
        <a href="add_request.php" style="color:black;">
            <div class="panel panel-box clearfix" style="height: 80px;">
                <div class="panel-icon pull-left bg-blue2" style="height: 80px;">
                    <i class="glyphicon glyphicon-list-alt"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"></h2>
                    <p class="text-muted">Service Request</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="transactions.php" style="color:black;">
            <div class="panel panel-box clearfix" style="height: 80px;">
                <div class="panel-icon pull-left bg-green" style="height: 80px;">
                    <i class="glyphicon glyphicon-tasks"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"></h2>
                    <p class="text-muted">Transaction</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Third Row -->
<div class="row">
    <div class="col-md-3">
        <a href="feedback.php" style="color:black;">
            <div class="panel panel-box clearfix" style="height: 80px;">
                <div class="panel-icon pull-left bg-blue2" style="height: 80px;">
                    <i class="glyphicon glyphicon-list-alt"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"></h2>
                    <p class="text-muted">Feedback</p>
                </div>
            </div>
        </a>
    </div>

    <div class="col-md-3">
        <a href="user_announcement.php" style="color:black;">
            <div class="panel panel-box clearfix" style="height: 80px;">
                <div class="panel-icon pull-left bg-green" style="height: 80px;">
                    <i class="glyphicon glyphicon-tasks"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"></h2>
                    <p class="text-muted">Announcement</p>
                </div>
            </div>
        </a>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
