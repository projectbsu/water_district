<?php
  $page_title = 'All User';
  require_once('includes/load.php');

  // Check permission level
  page_require_level(1);

  // Fetch all users from the database
  $all_users = find_all_user();

  // Fetch data for charts
  $user_roles_raw = get_user_roles_distribution(); // User roles and counts
  
  // Map user levels to labels
  $user_roles = [
    'Admin' => isset($user_roles_raw[1]) ? $user_roles_raw[1] : 0,
    'Staff' => isset($user_roles_raw[2]) ? $user_roles_raw[2] : 0,
    'Customer' => isset($user_roles_raw[3]) ? $user_roles_raw[3] : 0
  ];

  $total_users = count_all_users(); // Total users count
  $active_users = count_active_users(); // Active users count
  $inactive_users = $total_users - $active_users; // Inactive users count
  $age_distribution = get_age_distribution(); // Age distribution of users
  $sex_distribution = get_sex_distribution(); // Fetch sex distribution data
  $barangay_distribution = get_barangay_distribution();
  $total_transactions = count_all_transactions();
  $total_categories = count_all_categories();
  $total_service_requests = count_all_service_requests();

  include_once('layouts/header.php');
?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-6">
     <?php echo display_msg($msg); ?>
   </div>
</div>
  <div class="row">
  
	<a href="users.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix" style="height: 120px;">
         <div class="panel-icon pull-left bg-blue" style="height: 120px;">
         <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo  $total_users;?></h2>
          <p class="text-muted">Users</p>
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
</div>

<?php include_once('layouts/header.php'); ?>
<div class="row">
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span> User Dashboard</span>
        </strong>
      </div>
      <div class="panel-body">
           
            <div class="row">
              <div class="col-md-4">
                <canvas id="userRolesChart"></canvas>
              </div>
              <div class="col-md-4">
                <canvas id="activeUsersChart"></canvas>
              </div>
              <div class="col-md-4">
                <canvas id="ageDistributionChart"></canvas>
              </div>
              <div class="col-md-4">
                <canvas id="sexDistributionChart"></canvas>
              </div>
              <div class="col-md-4">
                <canvas id="barangayDistributionChart"></canvas>
              </div>

            </div>
          </div>
      </div>
    </div>
  </div>

  <div class="row">
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span> Service Dashboard</span>
        </strong>
      </div>
      <div class="panel-body">
      
          </div>
      </div>
    </div>
  </div>

  <div class="row">
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span> Feedback Dashboard</span>
        </strong>
      </div>
      <div class="panel-body">
      
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

  // User Roles Distribution Chart
  var ctx1 = document.getElementById('userRolesChart').getContext('2d');
  var userRolesChart = new Chart(ctx1, {
    type: 'pie',
    data: {
      labels: <?php echo json_encode(array_keys($user_roles)); ?>, // User role names
      datasets: [{
        label: 'User Roles',
        data: <?php echo json_encode(array_values($user_roles)); ?>, // User role counts
        backgroundColor: bluePalette // Blue color palette
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'User Roles Distribution',
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

  // Active vs Inactive Users Chart
  var ctx2 = document.getElementById('activeUsersChart').getContext('2d');
  var activeUsersChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
      labels: ['Active Users', 'Inactive Users'],
      datasets: [{
        label: 'User Status',
        data: [<?php echo $active_users; ?>, <?php echo $inactive_users; ?>],
        backgroundColor: [bluePalette[0], '#f44336'] // Blue for active, red for inactive
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'Active vs Inactive Users',
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

  // Age Distribution Chart
  var ctx3 = document.getElementById('ageDistributionChart').getContext('2d');
  var ageDistributionChart = new Chart(ctx3, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode(array_keys($age_distribution)); ?>, // Age groups
      datasets: [{
        label: 'Users',
        data: <?php echo json_encode(array_values($age_distribution)); ?>, // Age group counts
        backgroundColor: bluePalette[0] // Single blue color
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'Age Distribution of Users',
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

  // Sex Distribution Chart
  var ctx4 = document.getElementById('sexDistributionChart').getContext('2d');
  var sexDistributionChart = new Chart(ctx4, {
    type: 'bar',
    data: {
      labels: ['Male', 'Female'], // Assuming only male and female are considered
      datasets: [{
        label: 'Users',
        data: [
          <?php echo isset($sex_distribution['Male']) ? $sex_distribution['Male'] : 0; ?>,
          <?php echo isset($sex_distribution['Female']) ? $sex_distribution['Female'] : 0; ?>
        ],
        backgroundColor: [bluePalette[0], bluePalette[1]] // Different colors for each gender
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'Sex Distribution of Users',
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

  // Barangay Distribution Chart
  var ctx5 = document.getElementById('barangayDistributionChart').getContext('2d');
  var barangayDistributionChart = new Chart(ctx5, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode(array_keys($barangay_distribution)); ?>, // Barangay names
      datasets: [{
        label: 'Users',
        data: <?php echo json_encode(array_values($barangay_distribution)); ?>, // User counts per barangay
        backgroundColor: bluePalette[2] // Single blue color for all barangays
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'Barangay Distribution of Users',
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
  
</script>
