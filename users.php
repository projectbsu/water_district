<?php
$page_title = 'All Users';
require_once('includes/load.php');

// Check what level user has permission to view this page
page_require_level(1);

// Pull out all users from the database
$all_users = find_all_user();
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Users</span>
                </strong>
                <a href="add_user.php" class="btn btn-info pull-right">Add New User</a>
            </div>
            <div class="panel-body">
                <!-- Search Bar -->
                <div class="input-group" style="width: 250px; margin-bottom: 10px;">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search..." aria-label="Search">
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-search"></span>
                    </span>
                </div>

                <!-- Scrollable container -->
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto; overflow-x: auto;">
                    <table class="table table-bordered table-striped" id="userTable">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Account Number</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Sex</th>
                                <th>Barangay</th>
                                <th>Age</th>
                                <th class="text-center" style="width: 15%;">User Role</th>
                                <th class="text-center" style="width: 10%;">Status</th>
                                <th class="text-center" style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($all_users as $a_user): ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk(ucwords($a_user['name'])); ?></td>
                                <td><?php echo remove_junk(ucwords($a_user['username'])); ?></td>
                                <td><?php echo remove_junk($a_user['account_number']); ?></td>
                                <td><?php echo remove_junk($a_user['email']); ?></td>
                                <td><?php echo remove_junk($a_user['contact']); ?></td>
                                <td><?php echo remove_junk($a_user['sex']); ?></td>
                                <td><?php echo remove_junk($a_user['barangay']); ?></td>
                                <td><?php echo (int)$a_user['age']; ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_user['group_name'])); ?></td>
                                <td class="text-center">
                                    <?php if ($a_user['status'] === '1'): ?>
                                        <span class="label label-success"><?php echo "Active"; ?></span>
                                    <?php else: ?>
                                        <span class="label label-danger"><?php echo "Inactive"; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_user.php?id=<?php echo (int)$a_user['id']; ?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                                            <i class="glyphicon glyphicon-pencil"></i>
                                        </a>
                                        <a href="delete_user.php?id=<?php echo (int)$a_user['id']; ?>" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                                            <i class="glyphicon glyphicon-remove"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- Pagination controls -->
                    <div id="pagination" class="text-center"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<script>
// Search functionality
document.getElementById("searchInput").addEventListener("keyup", function() {
    var input = this.value.toLowerCase();
    var rows = document.querySelectorAll("#userTable tbody tr");

    rows.forEach(function(row) {
        row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
    });
});

// Pagination functionality
let currentPage = 1;
let rowsPerPage = 10;
const rows = document.querySelectorAll("#userTable tbody tr");

function paginateTable() {
    let paginationElement = document.getElementById('pagination');
    paginationElement.innerHTML = '';
    
    let totalPages = Math.ceil(rows.length / rowsPerPage);
    
    for (let i = 1; i <= totalPages; i++) {
        let pageButton = document.createElement('button');
        pageButton.innerHTML = i;
        pageButton.classList.add('btn', 'btn-primary', 'btn-sm', 'mx-1');
        pageButton.addEventListener('click', function() {
            currentPage = i;
            displayPage(currentPage);
        });
        paginationElement.appendChild(pageButton);
    }
    
    displayPage(currentPage);
}

function displayPage(page) {
    let start = (page - 1) * rowsPerPage;
    let end = start + rowsPerPage;
    
    rows.forEach((row, index) => {
        row.style.display = (index >= start && index < end) ? "" : "none";
    });
}

document.addEventListener("DOMContentLoaded", function() {
    paginateTable();
});
</script>
 