<?php
  $page_title = 'Add User';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  $groups = find_all('user_groups');
?>
<?php
  if(isset($_POST['add_user'])){

   $req_fields = array('full-name','username','password','level' );
   validate_fields($req_fields);

   if(empty($errors)){
           $name   = remove_junk($db->escape($_POST['full-name']));
       $username   = remove_junk($db->escape($_POST['username']));
       $account_number = remove_junk($db->escape($_POST['account_number'])); // Make sure this is added
       $email = remove_junk($db->escape($_POST['email']));
        $contact = remove_junk($db->escape($_POST['contact']));
        $sex = remove_junk($db->escape($_POST['sex']));
        $barangay = remove_junk($db->escape($_POST['barangay']));
        $age = (int)$db->escape($_POST['age']);
       $password   = remove_junk($db->escape($_POST['password']));
       $user_level = (int)$db->escape($_POST['level']);
       $password = sha1($password);
       $query = "INSERT INTO users (";
       $query .= "name,username,password,user_level,status,email,contact,sex,barangay,age";
       $query .= ") VALUES (";
       $query .= " '{$name}', '{$username}', '{$password}', '{$user_level}','1','{$email}','{$contact}','{$sex}','{$barangay}','{$age}'";
       $query .= ")";
        if($db->query($query)){
          //sucess
          $session->msg('s',"User account has been creted! ");
          redirect('add_user.php', false);
        } else {
          //failed
          $session->msg('d',' Sorry failed to create account!');
          redirect('add_user.php', false);
        }
   } else {
     $session->msg("d", $errors);
      redirect('add_user.php',false);
   }
 }
?>
<?php include_once('layouts/header.php'); ?>
  <?php echo display_msg($msg); ?>
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Add New User</span>
       </strong>
      </div>
      <div class="panel-body">
        <div class="col-md-6">
          <form method="post" action="add_user.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="full-name" placeholder="Full Name">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Username">
            </div>
            <div class="form-group">
              <label for="account_number" class="control-label">Account Number</label>
              <input type="text" class="form-control" name="account_number" required>
          </div>
            <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="form-group">
            <label for="contact">Contact</label>
            <input type="text" class="form-control" name="contact" placeholder="Contact">
            </div>
            <div class="form-group">
            <label for="sex">Sex</label>
            <select class="form-control" name="sex">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            </div>
            <div class="form-group">
            <label for="barangay">Barangay</label>
            <select class="form-control" name="barangay">
              <option value="Anilao Proper">Anilao Proper</option>
              <option value="Anilao East">Anilao East</option>
              <option value="Bagalangit">Bagalangit</option>
              <option value="Bulacan">Bulacan</option>
              <option value="Calamias">Calamias</option>
              <option value="Estrella">Estrella</option>
              <option value="Gasang">Gasang</option>
              <option value="Laurel">Laurel</option>
              <option value="Ligaya">Ligaya</option>
              <option value="Mainaga">Mainaga</option>
              <option value="Mainit">Mainit</option>
              <option value="Majuben">Majuben</option>
              <option value="Malimatoc I">Malimatoc I</option>
              <option value="Malimatoc II">Malimatoc II</option>
              <option value="Nag-Iba">Nag-Iba</option>
              <option value="Pilahan">Pilahan</option>
              <option value="Poblacion">Poblacion</option>
              <option value="Pulang Lupa">Pulang Lupa</option>
              <option value="Pulong Anahao">Pulong Anahao</option>
              <option value="Pulong Balibaguhan">Pulong Balibaguhan</option>
              <option value="Pulong Niogan">Pulong Niogan</option>
              <option value="Saguing">Saguing</option>
              <option value="Sampaguita">Sampaguita</option>
              <option value="San Francisco">San Francisco</option>
              <option value="San Jose">San Jose</option>
              <option value="San Juan">San Juan</option>
              <option value="San Teodoro">San Teodoro</option>
              <option value="Santa Ana">Santa Ana</option>
              <option value="Santa Mesa">Santa Mesa</option>
              <option value="Santo Niño">Santo Niño</option>
              <option value="Santo Tomas">Santo Tomas</option>
              <option value="Solo">Solo</option>
              <option value="Talaga Proper">Talaga Proper</option>
              <option value="Talaga East">Talaga East</option>
            </select>
            </div>
            <div class="form-group">
            <label for="age">Age</label>
            <input type="number" class="form-control" name="age" placeholder="Age">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name ="password"  placeholder="Password">
            </div>
            <div class="form-group">
              <label for="level">User Role</label>
                <select class="form-control" name="level">
                  <?php foreach ($groups as $group ):?>
                   <option value="<?php echo $group['group_level'];?>"><?php echo ucwords($group['group_name']);?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div class="form-group clearfix">
              <button type="submit" name="add_user" class="btn btn-primary">Add User</button>
            </div>
        </form>
        </div>

      </div>

    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
