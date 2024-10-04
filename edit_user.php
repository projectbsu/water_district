<?php
  $page_title = 'Edit User';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  $e_user = find_by_id('users',(int)$_GET['id']);
  $groups  = find_all('user_groups');
  if(!$e_user){
    $session->msg("d","Missing user id.");
    redirect('users.php');
  }
?>

<?php
//Update User basic info
  if(isset($_POST['update'])) {
    $req_fields = array('name','username','level');
    validate_fields($req_fields);
    if(empty($errors)){
             $id = (int)$e_user['id'];
           $name = remove_junk($db->escape($_POST['name']));
       $username = remove_junk($db->escape($_POST['username']));
       $email = remove_junk($db->escape($_POST['email']));
       $contact = remove_junk($db->escape($_POST['contact']));
       $sex = remove_junk($db->escape($_POST['sex']));
       $barangay = remove_junk($db->escape($_POST['barangay']));
       $age = (int)$db->escape($_POST['age']);
          $level = (int)$db->escape($_POST['level']);
       $status   = remove_junk($db->escape($_POST['status']));
       $sql = "UPDATE users SET name ='{$name}', username ='{$username}', user_level='{$level}', status='{$status}', email='{$email}', contact='{$contact}', sex='{$sex}', barangay='{$barangay}', age='{$age}' WHERE id='{$db->escape($id)}'";
         $result = $db->query($sql);
          if($result && $db->affected_rows() === 1){
            $session->msg('s',"Acount Updated ");
            redirect('edit_user.php?id='.(int)$e_user['id'], false);
          } else {
            $session->msg('d',' Sorry failed to updated!');
            redirect('edit_user.php?id='.(int)$e_user['id'], false);
          }
    } else {
      $session->msg("d", $errors);
      redirect('edit_user.php?id='.(int)$e_user['id'],false);
    }
  }
?>
<?php
// Update user password
if(isset($_POST['update-pass'])) {
  $req_fields = array('password');
  validate_fields($req_fields);
  if(empty($errors)){
           $id = (int)$e_user['id'];
     $password = remove_junk($db->escape($_POST['password']));
     $h_pass   = sha1($password);
          $sql = "UPDATE users SET password='{$h_pass}' WHERE id='{$db->escape($id)}'";
       $result = $db->query($sql);
        if($result && $db->affected_rows() === 1){
          $session->msg('s',"User password has been updated ");
          redirect('edit_user.php?id='.(int)$e_user['id'], false);
        } else {
          $session->msg('d',' Sorry failed to updated user password!');
          redirect('edit_user.php?id='.(int)$e_user['id'], false);
        }
  } else {
    $session->msg("d", $errors);
    redirect('edit_user.php?id='.(int)$e_user['id'],false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
 <div class="row">
   <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
  <div class="col-md-6">
     <div class="panel panel-default">
       <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Update <?php echo remove_junk(ucwords($e_user['name'])); ?> Account
        </strong>
       </div>
       <div class="panel-body">
          <form method="post" action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" class="clearfix">
            <div class="form-group">
                  <label for="name" class="control-label">Name</label>
                  <input type="name" class="form-control" name="name" value="<?php echo remove_junk(ucwords($e_user['name'])); ?>">
            </div>
            <div class="form-group">
                  <label for="username" class="control-label">Username</label>
                  <input type="text" class="form-control" name="username" value="<?php echo remove_junk(ucwords($e_user['username'])); ?>">
            </div>
            
                        <div class="form-group">
              <label for="email" class="control-label">Email</label>
              <input type="email" class="form-control" name="email" value="<?php echo remove_junk($e_user['email']); ?>">
            </div>
            <div class="form-group">
              <label for="contact" class="control-label">Contact</label>
              <input type="text" class="form-control" name="contact" value="<?php echo remove_junk($e_user['contact']); ?>">
            </div>
            <div class="form-group">
              <label for="sex">Sex</label>
              <select class="form-control" name="sex">
                  <option value="Male" <?php if($e_user['sex'] === 'Male') echo 'selected="selected"'; ?>>Male</option>
                  <option value="Female" <?php if($e_user['sex'] === 'Female') echo 'selected="selected"'; ?>>Female</option>
              </select>
            </div>
            <div class="form-group">
              <label for="barangay">Barangay</label>
              <select class="form-control" name="barangay">
                  <option value="Anilao Proper" <?php if($e_user['barangay'] === 'Anilao Proper') echo 'selected="selected"'; ?>>Anilao Proper</option>
                  <option value="Anilao East" <?php if($e_user['barangay'] === 'Anilao East') echo 'selected="selected"'; ?>>Anilao East</option>
                  <option value="Bagalangit" <?php if($e_user['barangay'] === 'Bagalangit') echo 'selected="selected"'; ?>>Bagalangit</option>
                  <option value="Bulacan" <?php if($e_user['barangay'] === 'Bulacan') echo 'selected="selected"'; ?>>Bulacan</option>
                  <option value="Calamias" <?php if($e_user['barangay'] === 'Calamias') echo 'selected="selected"'; ?>>Calamias</option>
                  <option value="Estrella" <?php if($e_user['barangay'] === 'Estrella') echo 'selected="selected"'; ?>>Estrella</option>
                  <option value="Gasang" <?php if($e_user['barangay'] === 'Gasang') echo 'selected="selected"'; ?>>Gasang</option>
                  <option value="Laurel" <?php if($e_user['barangay'] === 'Laurel') echo 'selected="selected"'; ?>>Laurel</option>
                  <option value="Ligaya" <?php if($e_user['barangay'] === 'Ligaya') echo 'selected="selected"'; ?>>Ligaya</option>
                  <option value="Mainaga" <?php if($e_user['barangay'] === 'Mainaga') echo 'selected="selected"'; ?>>Mainaga</option>
                  <option value="Mainit" <?php if($e_user['barangay'] === 'Mainit') echo 'selected="selected"'; ?>>Mainit</option>
                  <option value="Majuben" <?php if($e_user['barangay'] === 'Majuben') echo 'selected="selected"'; ?>>Majuben</option>
                  <option value="Malimatoc I" <?php if($e_user['barangay'] === 'Malimatoc I') echo 'selected="selected"'; ?>>Malimatoc I</option>
                  <option value="Malimatoc II" <?php if($e_user['barangay'] === 'Malimatoc II') echo 'selected="selected"'; ?>>Malimatoc II</option>
                  <option value="Nag-Iba" <?php if($e_user['barangay'] === 'Nag-Iba') echo 'selected="selected"'; ?>>Nag-Iba</option>
                  <option value="Pilahan" <?php if($e_user['barangay'] === 'Pilahan') echo 'selected="selected"'; ?>>Pilahan</option>
                  <option value="Poblacion" <?php if($e_user['barangay'] === 'Poblacion') echo 'selected="selected"'; ?>>Poblacion</option>
                  <option value="Pulang Lupa" <?php if($e_user['barangay'] === 'Pulang Lupa') echo 'selected="selected"'; ?>>Pulang Lupa</option>
                  <option value="Pulong Anahao" <?php if($e_user['barangay'] === 'Pulong Anahao') echo 'selected="selected"'; ?>>Pulong Anahao</option>
                  <option value="Pulong Balibaguhan" <?php if($e_user['barangay'] === 'Pulong Balibaguhan') echo 'selected="selected"'; ?>>Pulong Balibaguhan</option>
                  <option value="Pulong Niogan" <?php if($e_user['barangay'] === 'Pulong Niogan') echo 'selected="selected"'; ?>>Pulong Niogan</option>
                  <option value="Saguing" <?php if($e_user['barangay'] === 'Saguing') echo 'selected="selected"'; ?>>Saguing</option>
                  <option value="Sampaguita" <?php if($e_user['barangay'] === 'Sampaguita') echo 'selected="selected"'; ?>>Sampaguita</option>
                  <option value="San Francisco" <?php if($e_user['barangay'] === 'San Francisco') echo 'selected="selected"'; ?>>San Francisco</option>
                  <option value="San Jose" <?php if($e_user['barangay'] === 'San Jose') echo 'selected="selected"'; ?>>San Jose</option>
                  <option value="San Juan" <?php if($e_user['barangay'] === 'San Juan') echo 'selected="selected"'; ?>>San Juan</option>
                  <option value="San Teodoro" <?php if($e_user['barangay'] === 'San Teodoro') echo 'selected="selected"'; ?>>San Teodoro</option>
                  <option value="Santa Ana" <?php if($e_user['barangay'] === 'Santa Ana') echo 'selected="selected"'; ?>>Santa Ana</option>
                  <option value="Santa Mesa" <?php if($e_user['barangay'] === 'Santa Mesa') echo 'selected="selected"'; ?>>Santa Mesa</option>
                  <option value="Santo Niño" <?php if($e_user['barangay'] === 'Santo Niño') echo 'selected="selected"'; ?>>Santo Niño</option>
                  <option value="Santo Tomas" <?php if($e_user['barangay'] === 'Santo Tomas') echo 'selected="selected"'; ?>>Santo Tomas</option>
                  <option value="Solo" <?php if($e_user['barangay'] === 'Solo') echo 'selected="selected"'; ?>>Solo</option>
                  <option value="Talaga Proper" <?php if($e_user['barangay'] === 'Talaga Proper') echo 'selected="selected"'; ?>>Talaga Proper</option>
                  <option value="Talaga East" <?php if($e_user['barangay'] === 'Talaga East') echo 'selected="selected"'; ?>>Talaga East</option>
              </select>
            </div>
            <div class="form-group">
              <label for="age" class="control-label">Age</label>
              <input type="number" class="form-control" name="age" value="<?php echo (int)$e_user['age']; ?>">
            </div>


            <div class="form-group">
              <label for="level">User Role</label>
                <select class="form-control" name="level">
                  <?php foreach ($groups as $group ):?>
                   <option <?php if($group['group_level'] === $e_user['user_level']) echo 'selected="selected"';?> value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
              <label for="status">Status</label>
                <select class="form-control" name="status">
                  <option <?php if($e_user['status'] === '1') echo 'selected="selected"';?>value="1">Active</option>
                  <option <?php if($e_user['status'] === '0') echo 'selected="selected"';?> value="0">Deactive</option>
                </select>
            </div>
            <div class="form-group clearfix">
                    <button type="submit" name="update" class="btn btn-info">Update</button>
            </div>
        </form>
       </div>
     </div>
  </div>
  <!-- Change password form -->
  <div class="col-md-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          Change <?php echo remove_junk(ucwords($e_user['name'])); ?> password
        </strong>
      </div>
      <div class="panel-body">
        <form action="edit_user.php?id=<?php echo (int)$e_user['id'];?>" method="post" class="clearfix">
          <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Type user new password">
          </div>
          <div class="form-group clearfix">
                  <button type="submit" name="update-pass" class="btn btn-danger pull-right">Change</button>
          </div>
        </form>
      </div>
    </div>
  </div>

 </div>
<?php include_once('layouts/footer.php'); ?>
