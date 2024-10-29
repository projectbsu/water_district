<?php
  $page_title = 'All User';
  require_once('includes/load.php');

  // Check permission level
  page_require_level([1]);

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
  $total_categories = count_all_categories();
  $total_service_requests = count_all_service_requests();
  $total_feedback = count_all_feedback();


    // Fetch data for feedback charts
  $feedback_reaction_distribution = get_feedback_reaction_distribution(); // Reaction distribution
  $feedback_sentiment_distribution = get_feedback_sentiment_distribution(); // Sentiment score distribution
  $feedback_rating_over_time = get_feedback_rating_over_time(); // Average rating over time
  $feedback_per_user = get_feedback_per_user(); // Number of feedback per user
  $feedback_per_date = get_feedback_per_date(); // Number of feedback per date

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

  <a href="userfeedback.php" style="color:black;">
    <div class="col-md-3">
       <div class="panel panel-box clearfix" style="height: 120px;">
         <div class="panel-icon pull-left bg-blue2" style="height: 120px;">
         <i class="glyphicon glyphicon-comment"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?php echo $total_feedback; ?></h2> <!-- Display feedback count here -->
          <p class="text-muted">Feedback</p>
        </div>
       </div>
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
          <span> Feedback Dashboard</span>
        </strong>
      </div>
      <div class="panel-body">
            <div class="row">
          <div class="col-md-4">
              <canvas id="feedbackReactionChart"></canvas>
          </div>
          <div class="col-md-4">
              <canvas id="feedbackSentimentChart"></canvas>
          </div>
          <div class="col-md-4">
              <canvas id="feedbackRatingOverTimeChart"></canvas>
          </div>
          <div class="col-md-4">
              <canvas id="feedbackPerUserChart"></canvas>
          </div>
          <div class="col-md-4">
              <canvas id="feedbackPerDateChart"></canvas>
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


<script>
    // Feedback Reaction Distribution Chart
    var ctx1 = document.getElementById('feedbackReactionChart').getContext('2d');
    var feedbackReactionChart = new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_column($feedback_reaction_distribution, 'reaction')); ?>,
            datasets: [{
                label: 'Reactions',
                data: <?php echo json_encode(array_column($feedback_reaction_distribution, 'count')); ?>,
                backgroundColor: bluePalette
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Feedback Reaction Distribution',
                fontSize: 18
            },
            legend: {
                position: 'bottom'
            }
        }
    });

    // Feedback Sentiment Score Distribution Chart
    var ctx2 = document.getElementById('feedbackSentimentChart').getContext('2d');
    var feedbackSentimentChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($feedback_sentiment_distribution, 'sentiment_score')); ?>,
            datasets: [{
                label: 'Sentiment Scores',
                data: <?php echo json_encode(array_column($feedback_sentiment_distribution, 'count')); ?>,
                backgroundColor: bluePalette[1]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Feedback Sentiment Score Distribution',
                fontSize: 18
            },
            scales: {
                yAxes: [{ ticks: { beginAtZero: true } }]
            },
            legend: { display: false }
        }
    });

    // Average Rating Over Time Chart
    var ctx3 = document.getElementById('feedbackRatingOverTimeChart').getContext('2d');
    var feedbackRatingOverTimeChart = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: <?php echo json_encode(array_column($feedback_rating_over_time, 'date')); ?>,
            datasets: [{
                label: 'Average Rating',
                data: <?php echo json_encode(array_column($feedback_rating_over_time, 'avg_rating')); ?>,
                borderColor: bluePalette[0],
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Average Rating Over Time',
                fontSize: 18
            },
            scales: {
                yAxes: [{ ticks: { beginAtZero: true } }]
            }
        }
    });

    // Feedback Per User Chart
    var ctx4 = document.getElementById('feedbackPerUserChart').getContext('2d');
    var feedbackPerUserChart = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($feedback_per_user, 'name')); ?>,
            datasets: [{
                label: 'Feedback Count',
                data: <?php echo json_encode(array_column($feedback_per_user, 'feedback_count')); ?>,
                backgroundColor: bluePalette[2]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Feedback Per User',
                fontSize: 18
            },
            scales: {
                yAxes: [{ ticks: { beginAtZero: true } }]
            },
            legend: { display: false }
        }
    });

    // Feedback Per Date Chart
    var ctx5 = document.getElementById('feedbackPerDateChart').getContext('2d');
    var feedbackPerDateChart = new Chart(ctx5, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_column($feedback_per_date, 'date')); ?>,
            datasets: [{
                label: 'Feedback Count',
                data: <?php echo json_encode(array_column($feedback_per_date, 'feedback_count')); ?>,
                backgroundColor: bluePalette[3]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Feedback Per Date',
                fontSize: 18
            },
            scales: {
                yAxes: [{ ticks: { beginAtZero: true } }]
            },
            legend: { display: false }
        }
    });
</script>