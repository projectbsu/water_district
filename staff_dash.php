<?php

$page_title = 'Customer Dashboard';
require_once('includes/load.php');

// Check permission level for staff
page_require_level(2); // Assuming level 2 is for Staff

// Fetch all customers from the database
$total_customers = count_all_customers();
$active_customers = count_active_customers();
$customer_age_distribution = get_customer_age_distribution();
$customer_sex_distribution = get_customer_sex_distribution();
$customer_barangay_distribution = get_customer_barangay_distribution();
$total_transactions = count_all_transactions();
$total_categories = count_all_categories();
$total_service_requests = count_all_service_requests();

include_once('layouts/header.php');
?>

<div class="row">
    <a href="customers.php" style="color:black;">
        <div class="col-md-3">
            <div class="panel panel-box clearfix" style="height: 120px;">
                <div class="panel-icon pull-left bg-secondary1" style="height: 120px;">
                    <i class="glyphicon glyphicon-user"></i>
                </div>
                <div class="panel-value pull-right">
                    <h2 class="margin-top"><?php echo $total_customers; ?></h2> <!-- Display total customer count -->
                    <p class="text-muted">Customers</p>
                </div>
            </div>
        </div>
    </a>

    <a href="categorie.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix" style="height: 120px;">
         <div class="panel-icon pull-left bg-red" style="height: 120px;">
          <i class="glyphicon glyphicon-th-large" ></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo $total_categories?></h2>
          <p class="text-muted">Categories</p>
        </div>
       </div>
    </div>
	</a>

	
	<a href="service_requests.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix" style="height: 120px;">
         <div class="panel-icon pull-left bg-blue2" style="height: 120px;">
          <i class="glyphicon glyphicon-list-alt"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo $total_service_requests ?></h2>
          <p class="text-muted">Service Request</p>
        </div>
      </div>
    </div>
	</a>
	
	<a href="transactions.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix" style="height: 120px;">
         <div class="panel-icon pull-left bg-green" style="height: 120px;">
          <i class="glyphicon glyphicon-tasks"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"><?php echo $total_transactions ?></h2>
          <p class="text-muted">Transaction</p>
        </div>
       </div>
    </div>
	</a>


    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span> Customer Dashboard</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <canvas id="customerRolesChart"></canvas>
                    </div>
                    <div class="col-md-4">
                        <canvas id="activeCustomersChart"></canvas>
                    </div>
                    <div class="col-md-4">
                        <canvas id="customerAgeDistributionChart"></canvas>
                    </div>
                    <div class="col-md-4">
                        <canvas id="customerSexDistributionChart"></canvas>
                    </div>
                    <div class="col-md-4">
                        <canvas id="customerBarangayDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<!-- Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Blue color palette
  const bluePalette = ['#007bff', '#0056b3', '#003d80', '#3399ff', '#80bfff'];

  // Customer Roles Distribution Chart
  var ctx1 = document.getElementById('customerRolesChart').getContext('2d');
  var customerRolesChart = new Chart(ctx1, {
    type: 'pie',
    data: {
      labels: ['Customer'],
      datasets: [{
        label: 'Customers',
        data: [<?php echo $total_customers; ?>],
        backgroundColor: bluePalette
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'Customer Roles Distribution',
        fontSize: 18
      },
      legend: {
        position: 'bottom',
        labels: {
          fontColor: '#333'
        }
      }
    }
  });

  // Active vs Inactive Customers Chart
  var ctx2 = document.getElementById('activeCustomersChart').getContext('2d');
  var activeCustomersChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: ['Active Customers', 'Inactive Customers'],
      datasets: [{
        label: 'Customer Status',
        data: [<?php echo $active_customers; ?>, <?php echo $total_customers - $active_customers; ?>],
        backgroundColor: [bluePalette[0], '#f44336']
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'Active vs Inactive Customers',
        fontSize: 18
      },
      legend: {
        position: 'bottom',
        labels: {
          fontColor: '#333'
        }
      }
    }
  });

  // Customer Age Distribution Chart
  var ctx3 = document.getElementById('customerAgeDistributionChart').getContext('2d');
  var customerAgeDistributionChart = new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode(array_keys($customer_age_distribution)); ?>,
      datasets: [{
        label: 'Customers',
        data: <?php echo json_encode(array_values($customer_age_distribution)); ?>,
        backgroundColor: bluePalette[0]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'Age Distribution of Customers',
        fontSize: 18
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            fontColor: '#333'
          }
        }],
        xAxes: [{
          ticks: {
            fontColor: '#333'
          }
        }]
      },
      legend: {
        display: false
      }
    }
  });

  // Customer Sex Distribution Chart
  var ctx4 = document.getElementById('customerSexDistributionChart').getContext('2d');
  var customerSexDistributionChart = new Chart(ctx4, {
    type: 'bar',
    data: {
      labels: ['Male', 'Female'],
      datasets: [{
        label: 'Customers',
        data: [
          <?php echo isset($customer_sex_distribution['Male']) ? $customer_sex_distribution['Male'] : 0; ?>,
          <?php echo isset($customer_sex_distribution['Female']) ? $customer_sex_distribution['Female'] : 0; ?>
        ],
        backgroundColor: [bluePalette[0], bluePalette[1]]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'Sex Distribution of Customers',
        fontSize: 18
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            fontColor: '#333'
          }
        }],
        xAxes: [{
          ticks: {
            fontColor: '#333'
          }
        }]
      },
      legend: {
        display: false
      }
    }
  });

  // Customer Barangay Distribution Chart
  var ctx5 = document.getElementById('customerBarangayDistributionChart').getContext('2d');
  var customerBarangayDistributionChart = new Chart(ctx5, {
    type: 'horizontalBar',
    data: {
      labels: <?php echo json_encode(array_keys($customer_barangay_distribution)); ?>,
      datasets: [{
        label: 'Customers',
        data: <?php echo json_encode(array_values($customer_barangay_distribution)); ?>,
        backgroundColor: bluePalette[0]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'Customer Distribution by Barangay',
        fontSize: 18
      },
      scales: {
        xAxes: [{
          ticks: {
            beginAtZero: true,
            fontColor: '#333'
          }
        }],
        yAxes: [{
          ticks: {
            fontColor: '#333'
          }
        }]
      },
      legend: {
        display: false
      }
    }
  });
</script>
