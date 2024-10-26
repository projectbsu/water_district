<?php
  $page_title = 'Feedback Analytics';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level([1]);
?>

<?php include_once('layouts/header.php'); ?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row">
  <div class="col-md-12">
    <h3>Feedback Analysis Dashboard</h3>
  </div>
</div>

<!-- Row 1: Pie Chart, Bar Chart, Line Chart -->
<div class="row">
  <div class="col-md-4">
    <canvas id="pieChart"></canvas>
  </div>
  <div class="col-md-4">
    <canvas id="barChart"></canvas>
  </div>
  <div class="col-md-4">
    <canvas id="lineChart"></canvas>
  </div>
</div>

<!-- Row 2: Stacked Bar Chart, Heat Map -->
<div class="row">
  <div class="col-md-6">
    <canvas id="stackedBarChart"></canvas>
  </div>
  <div class="col-md-6">
    <canvas id="heatMapChart"></canvas>
  </div>
</div>

<script>
  // Data for the charts (replace this with dynamic data from your database)
  const pieData = [10, 20, 30, 25, 15]; // Sentiment distribution
  const barData = [12, 19, 3, 5, 2]; // Sentiment frequency
  const lineData = [5, 10, 15, 10, 5]; // Sentiment trend over time
  const stackedBarData = [ // Sentiment by category
    { category: 'Feature A', happy: 10, neutral: 5, sad: 2 },
    { category: 'Feature B', happy: 8, neutral: 3, sad: 4 },
    { category: 'Feature C', happy: 15, neutral: 2, sad: 1 }
  ];
  const heatMapData = [ // Sentiment intensity over time
    { time: 'Day 1', happy: 3, neutral: 2, sad: 1 },
    { time: 'Day 2', happy: 4, neutral: 3, sad: 2 },
    { time: 'Day 3', happy: 2, neutral: 4, sad: 3 }
  ];

  // Pie Chart
  const pieChart = new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
      labels: ['Angry', 'Sad', 'Neutral', 'Happy', 'Very Happy'],
      datasets: [{
        data: pieData,
        backgroundColor: ['#003f5c', '#005f73', '#0a9396', '#94d2bd', '#0dcaf0'], // Shades of blue
      }]
    },
    options: {
      responsive: true,
    }
  });

  // Bar Chart
  const barChart = new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
      labels: ['Angry', 'Sad', 'Neutral', 'Happy', 'Very Happy'],
      datasets: [{
        label: 'Sentiment Frequency',
        data: barData,
        backgroundColor: ['#003f5c', '#005f73', '#0a9396', '#94d2bd', '#0dcaf0'], // Shades of blue
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });

  // Line Chart
  const lineChart = new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
      labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5'],
      datasets: [{
        label: 'Sentiment Over Time',
        data: lineData,
        fill: false,
        borderColor: '#003f5c', // Dark blue
        tension: 0.1
      }]
    },
    options: {
      responsive: true,
    }
  });

  // Stacked Bar Chart
  const stackedBarChart = new Chart(document.getElementById('stackedBarChart'), {
    type: 'bar',
    data: {
      labels: stackedBarData.map(item => item.category),
      datasets: [
        {
          label: 'Happy',
          data: stackedBarData.map(item => item.happy),
          backgroundColor: '#0a9396' // Light blue
        },
        {
          label: 'Neutral',
          data: stackedBarData.map(item => item.neutral),
          backgroundColor: '#94d2bd' // Lighter blue
        },
        {
          label: 'Sad',
          data: stackedBarData.map(item => item.sad),
          backgroundColor: '#003f5c' // Dark blue
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        x: { stacked: true },
        y: { stacked: true, beginAtZero: true }
      }
    }
  });

  // Heat Map (simulated with bar chart for simplicity)
  const heatMapChart = new Chart(document.getElementById('heatMapChart'), {
    type: 'bar',
    data: {
      labels: heatMapData.map(item => item.time),
      datasets: [
        {
          label: 'Happy',
          data: heatMapData.map(item => item.happy),
          backgroundColor: '#005f73' // Medium blue
        },
        {
          label: 'Neutral',
          data: heatMapData.map(item => item.neutral),
          backgroundColor: '#0a9396' // Light blue
        },
        {
          label: 'Sad',
          data: heatMapData.map(item => item.sad),
          backgroundColor: '#003f5c' // Dark blue
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>

<?php include_once('layouts/footer.php'); ?>
