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
    $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.email,u.contact,u.sex,u.barangay,u.age,";
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
  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Function for cheaking which user level has access to page
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     //if user not login
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Please login...');
            redirect('index.php', false);
      //if Group status Deactive
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','This level user has been band!');
           redirect('home.php',false);
      //cheackin log in User level and Require level is Less than or equal to
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "Sorry! you dont have permission to view the page.");
            redirect('home.php', false);
        endif;

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







?>