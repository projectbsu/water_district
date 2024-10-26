<?php
  require_once('includes/load.php');

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql) {
    global $db;
    $result = $db->query($sql);
    // Check if $result is valid and return as an array
    if ($result && $db->num_rows($result) > 0) {
        return $result->fetch_all(MYSQLI_ASSOC); // Make sure this returns an associative array
    } else {
        return []; // Return an empty array if no results
    }
}

/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return $user['id'];
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Login with the data provided in $_POST,
  /* coming from the login_v2.php form.
  /* If you used this method then remove authenticate function.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $sql  = sprintf("SELECT id,username,password,user_level FROM users WHERE username ='%s' LIMIT 1", $username);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
         return $user;
       }
     }
    return false;
   }


  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
    global $db;
    $sql = "SELECT u.id,u.name,u.username,u.account_number,u.user_level,u.status,u.email,u.contact,u.sex,u.barangay,u.age,";
    $sql .= "g.group_name ";
    $sql .= "FROM users u ";
    $sql .= "LEFT JOIN user_groups g ON g.group_level=u.user_level ORDER BY u.name ASC";
    return find_by_sql($sql);
 }
 
  /*--------------------------------------------------------------*/
  /* Find all Group name
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  //*--------------------------------------------------------------*/
/* Find group level and status                                   */
/*--------------------------------------------------------------*/
function find_by_groupLevel($level)
{
    global $db;
    $sql = "SELECT group_level, group_status FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1";
    $result = $db->query($sql);

    // Ensure the query was successful and data exists
    if ($db->num_rows($result) > 0) {
        return $db->fetch_assoc($result); // Return the result as an associative array
    } else {
        return false; // Group level not found
    }
}

/*--------------------------------------------------------------*/
/* Function to check which user level has access to the page     */
/*--------------------------------------------------------------*/
function page_require_level($require_levels) {
  global $session;

  $current_user = current_user();

  // Check if the user is logged in
  if (!$session->isUserLoggedIn(true)) {
      $session->msg('d', 'Please login...');
      redirect('index.php', false);
  }

  // Retrieve the user's group level and status
  $login_level = find_by_groupLevel($current_user['user_level']);

  // Check if the group level exists and the status is active
  if (!$login_level || $login_level['group_status'] === '0') {
      $session->msg('d', 'This level user has been banned!');
      redirect('home.php', false);
  }

  // Check if the current user's level is one of the required levels
  if (in_array($current_user['user_level'], $require_levels)) {
      return true; // Access granted
  } else {
      $session->msg('d', 'Sorry! You don\'t have permission to view this page.');
      redirect('home.php', false);
  }
}



// In includes/functions.php or a similar file
function find_all_feedback() {
  global $db;
  return find_by_sql("SELECT f.*, u.username FROM feedback f LEFT JOIN users u ON f.user_id = u.id ORDER BY f.created_at DESC");
}


// Function to delete feedback by ID
function delete_feedback($id) {
    global $db;
    $id = (int)$id;
    $sql = "DELETE FROM feedback WHERE id={$db->escape($id)} LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
}

// Count all users
function count_all_users() {
  global $db;
  $query = "SELECT COUNT(*) as total FROM users";
  $result = $db->query($query);
  return $result->fetch_assoc()['total'];
}

// Count active users
function count_active_users() {
  global $db;
  $query = "SELECT COUNT(*) as total FROM users WHERE status = '1'";
  $result = $db->query($query);
  return $result->fetch_assoc()['total'];
}

// Get user roles distribution
function get_user_roles_distribution() {
  global $db;
  $query = "SELECT user_level, COUNT(*) as count FROM users GROUP BY user_level";
  $result = $db->query($query);
  $roles = [];
  while ($row = $result->fetch_assoc()) {
    $roles[$row['user_level']] = $row['count'];
  }
  return $roles;
}

// Get age distribution
function get_age_distribution() {
  global $db;
  $query = "SELECT 
              CASE 
                WHEN age BETWEEN 18 AND 25 THEN '18-25'
                WHEN age BETWEEN 26 AND 35 THEN '26-35'
                WHEN age BETWEEN 36 AND 45 THEN '36-45'
                ELSE '46+' 
              END as age_group, COUNT(*) as count
            FROM users
            GROUP BY age_group";
  $result = $db->query($query);
  $ages = [];
  while ($row = $result->fetch_assoc()) {
    $ages[$row['age_group']] = $row['count'];
  }
  return $ages;
}

// Count all transactions
function count_all_transactions() {
  global $db;
  $query = "SELECT COUNT(*) as total FROM transactions"; // Adjust the table name if it's different
  $result = $db->query($query);
  return $result->fetch_assoc()['total'];
}

// Count all categories
function count_all_categories() {
  global $db;
  $query = "SELECT COUNT(*) as total FROM categories"; // Adjust the table name if it's different
  $result = $db->query($query);
  return $result->fetch_assoc()['total'];
}

// Count all service requests
function count_all_service_requests() {
  global $db;
  $query = "SELECT COUNT(*) as total FROM service_requests"; // Adjust the table name if it's different
  $result = $db->query($query);
  return $result->fetch_assoc()['total'];
}


function get_sex_distribution() {
  global $db; // Assume you have a global database connection

  $sql = "SELECT sex, COUNT(*) as count FROM users GROUP BY sex"; // Change 'users' to your actual users table name
  $result = $db->query($sql);

  $sex_distribution = [];
  while ($row = $result->fetch_assoc()) {
      $sex_distribution[$row['sex']] = (int)$row['count']; // Cast to int to ensure it's a number
  }

  return $sex_distribution;
}

function get_barangay_distribution() {
  global $db; // Assume you have a global database connection

  $sql = "SELECT barangay, COUNT(*) as count FROM users GROUP BY barangay"; // Change 'users' to your actual users table name
  $result = $db->query($sql);

  $barangay_distribution = [];
  while ($row = $result->fetch_assoc()) {
      $barangay_distribution[$row['barangay']] = (int)$row['count']; // Cast to int to ensure it's a number
  }

  return $barangay_distribution;
}

// STAFF DASHBOARD

function count_all_customers() {
  global $db;
  $sql = "SELECT COUNT(*) AS total FROM users WHERE user_level = 3"; // Update to user_level
  $result = $db->query($sql);
  
  if (!$result) {
      die("Error on this Query: " . $db->error);
  }
  
  return $result->fetch_assoc()['total'];
}

function count_active_customers() {
  global $db;
  $sql = "SELECT COUNT(*) AS total FROM users WHERE user_level = 3 AND status = 'active'"; // Update to user_level
  $result = $db->query($sql);
  
  if (!$result) {
      die("Error on this Query: " . $db->error);
  }
  
  return $result->fetch_assoc()['total'];
}

function get_customer_age_distribution() {
  global $db;
  $sql = "SELECT age, COUNT(*) AS total FROM users WHERE user_level = 3 GROUP BY age"; // Updated query
  $result = $db->query($sql);
  
  if (!$result) {
      die("Error on this Query: " . $db->error);
  }
  
  $age_distribution = [];
  while ($row = $result->fetch_assoc()) {
      $age_distribution[$row['age']] = $row['total']; // Using 'age' as the key
  }
  
  return $age_distribution;
}


function get_customer_sex_distribution() {
  global $db;
  $sql = "SELECT sex, COUNT(*) AS total FROM users WHERE user_level = 3 GROUP BY sex"; // Update to user_level
  $result = $db->query($sql);
  
  if (!$result) {
      die("Error on this Query: " . $db->error);
  }
  
  $sex_distribution = [];
  while ($row = $result->fetch_assoc()) {
      $sex_distribution[$row['sex']] = $row['total'];
  }
  
  return $sex_distribution;
}

function get_customer_barangay_distribution() {
  global $db;
  $sql = "SELECT barangay, COUNT(*) AS total FROM users WHERE user_level = 3 GROUP BY barangay"; // Update to user_level
  $result = $db->query($sql);
  
  if (!$result) {
      die("Error on this Query: " . $db->error);
  }
  
  $barangay_distribution = [];
  while ($row = $result->fetch_assoc()) {
      $barangay_distribution[$row['barangay']] = $row['total'];
  }
  
  return $barangay_distribution;
}
 

// Get reaction distribution
function get_feedback_reaction_distribution() {
  global $db;
  $sql = "SELECT reaction, COUNT(*) as count FROM feedback GROUP BY reaction";
  return find_by_sql($sql);
}

// Get sentiment score distribution
function get_feedback_sentiment_distribution() {
  global $db;
  $sql = "SELECT sentiment_score, COUNT(*) as count FROM feedback GROUP BY sentiment_score";
  return find_by_sql($sql);
}

// Get average rating over time
function get_feedback_rating_over_time() {
  global $db;
  $sql = "SELECT DATE(created_at) as date, AVG(reaction) as avg_reaction FROM feedback GROUP BY DATE(created_at)";
  return find_by_sql($sql);
}

// Get number of feedback per user
function get_feedback_per_user() {
  global $db;
  $sql = "SELECT u.name, COUNT(f.id) as feedback_count FROM feedback f LEFT JOIN users u ON f.user_id = u.id GROUP BY f.user_id";
  return find_by_sql($sql);
}

// Get number of feedback per date
function get_feedback_per_date() {
  global $db;
  $sql = "SELECT DATE(created_at) as date, COUNT(*) as feedback_count FROM feedback GROUP BY DATE(created_at)";
  return find_by_sql($sql);
}
 
function find_users_by_role($role_id) {
  global $db;
  $sql = "SELECT * FROM users WHERE user_level = '{$db->escape($role_id)}'";
  return find_by_sql($sql);
}

function find_all_billing(){
  global $db;
  $sql = "SELECT * FROM Billing_list";
  return find_by_sql($sql);
}

function find_billing_by_id($id){
  global $db;
  $id = (int)$id;
  $sql = "SELECT * FROM Billing_list WHERE id='{$db->escape($id)}'";
  return find_by_sql($sql);
}

function delete_billing_by_id($id){
  global $db;
  $sql = "DELETE FROM Billing_list WHERE id='{$db->escape($id)}'";
  return ($db->query($sql)) ? true : false;
}

function update_billing($id, $data){
  global $db;
  $sql = "UPDATE Billing_list SET 
          name='{$db->escape($data['name'])}', 
          account_number='{$db->escape($data['account_number'])}',
          reading_date='{$db->escape($data['reading_date'])}',
          bill_number='{$db->escape($data['bill_number'])}',
          meter_number='{$db->escape($data['meter_number'])}',
          due_date='{$db->escape($data['due_date'])}',
          present_reading='{$db->escape($data['present_reading'])}',
          previous='{$db->escape($data['previous'])}',
          total='{$db->escape($data['total'])}',
          penalty='{$db->escape($data['penalty'])}',
          total_after_due='{$db->escape($data['total_after_due'])}',
          status='{$db->escape($data['status'])}',
          paymentMethod='{$db->escape($data['paymentMethod'])}',
          maintenance='{$db->escape($data['maintenance'])}',
          date_updated=NOW()
          WHERE id='{$db->escape($id)}'";
  return ($db->query($sql)) ? true : false;
}

function add_announcement($title, $schedule, $context) {
  global $db;
  $sql = "INSERT INTO announcements (title, schedule, context) VALUES (?, ?, ?)";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("sss", $title, $schedule, $context);
  return $stmt->execute();
}

 
function find_latest_announcement() {
  global $db;
  $sql = "SELECT * FROM announcements ORDER BY schedule DESC LIMIT 1";
  return $db->query($sql)->fetch_assoc();
}

function find_previous_announcements() {
  global $db;

  // Get the latest announcement ID
  $latest_sql = "SELECT id FROM announcements ORDER BY schedule DESC LIMIT 1";
  $latest_result = $db->query($latest_sql);

  // Check if there are any announcements
  if ($latest_result->num_rows > 0) {
      $latest_announcement_id = $latest_result->fetch_assoc();
      
      // Fetch previous announcements excluding the latest one
      $sql = "SELECT * FROM announcements WHERE id != {$latest_announcement_id['id']} ORDER BY schedule DESC LIMIT 0, 25";
      return $db->query($sql)->fetch_all(MYSQLI_ASSOC);
  } else {
      return []; // No announcements available
  }
}

function edit_announcement($id, $title, $schedule, $context) {
  global $db;
  $sql = "UPDATE announcements SET title = ?, schedule = ?, context = ? WHERE id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("sssi", $title, $schedule, $context, $id);
  return $stmt->execute();
}



function delete_announcement($id) {
  global $db;
  $sql = "DELETE FROM announcements WHERE id = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("i", $id);
  return $stmt->execute();
}


?>
