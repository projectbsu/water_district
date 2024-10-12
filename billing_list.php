<?php
$page_title = 'Billing List';
require_once('includes/load.php');
page_require_level(1); // Admin-level access

// Query to retrieve all billing records
$all_bills = find_all('Billing_list');
?>

<?php include_once('layouts/header.php'); ?>

<style>
    .btn-status-paid {
        background-color: green;
        color: white;
    }
    .btn-status-overdue {
        background-color: yellow;
        color: black;
    }
    .btn-status-unpaid {
        background-color: red;
        color: white;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Billing List</span>
                </strong>
                <a href="billing_notice.php" class="btn btn-info pull-right">Add Billing Notice</a>
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
                    <table class="table table-bordered table-striped" id="billingTable">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Account Number</th>
                                <th class="text-center">Reading Date</th>
                                <th class="text-center">Bill Number</th>
                                <th class="text-center">Meter Number</th>
                                <th class="text-center">Due Date</th>
                                <th class="text-center">Present Reading</th>
                                <th class="text-center">Previous Reading</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Penalty</th>
                                <th class="text-center">Total After Due</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Payment Method</th>
                                <th class="text-center">Maintenance Fee</th>
                                <th class="text-center">Date Created</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_bills as $bill): ?>
                                <tr>
                                    <td class="text-center"><?php echo count_id(); ?></td>
                                    <td class="text-center"><?php echo remove_junk(ucwords($bill['name'])); ?></td>
                                    <td class="text-center"><?php echo remove_junk($bill['account_number']); ?></td>
                                    <td class="text-center"><?php echo date('Y-m-d', strtotime($bill['reading_date'])); ?></td>
                                    <td class="text-center"><?php echo remove_junk($bill['bill_number']); ?></td>
                                    <td class="text-center"><?php echo remove_junk($bill['meter_number']); ?></td>
                                    <td class="text-center"><?php echo date('Y-m-d', strtotime($bill['due_date'])); ?></td>
                                    <td class="text-center"><?php echo number_format($bill['present_reading'], 2); ?></td>
                                    <td class="text-center"><?php echo number_format($bill['previous'], 2); ?></td>
                                    <td class="text-center"><?php echo number_format($bill['total'], 2); ?></td>
                                    <td class="text-center"><?php echo number_format($bill['penalty'], 2); ?></td>
                                    <td class="text-center"><?php echo number_format($bill['total_after_due'], 2); ?></td>
                                    <td class="text-center">
                                        <?php 
                                        if ($bill['status'] == 1) {
                                            echo '<button class="btn btn-status-paid">Paid</button>';
                                        } elseif ($bill['status'] == 2) {
                                            echo '<button class="btn btn-status-overdue">Overdue</button>';
                                        } else {
                                            echo '<button class="btn btn-status-unpaid">Unpaid</button>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?php echo remove_junk($bill['paymentMethod']); ?></td>
                                    <td class="text-center"><?php echo number_format($bill['maintenance'], 2); ?></td>
                                    <td class="text-center"><?php echo date('Y-m-d H:i:s', strtotime($bill['date_created'])); ?></td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_billing.php?id=<?php echo (int)$bill['id'];?>" class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <a href="delete_billing.php?id=<?php echo (int)$bill['id'];?>" class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip" onclick="return confirm('Are you sure you want to delete this bill?');">
                                                <span class="glyphicon glyphicon-trash"></span>
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
    var rows = document.querySelectorAll("#billingTable tbody tr");

    rows.forEach(function(row) {
        row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
    });
});

// Pagination functionality
let currentPage = 1;
let rowsPerPage = 10;
const rows = document.querySelectorAll("#billingTable tbody tr");

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
