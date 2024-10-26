<?php
  $page_title = 'All categories';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level([3]);
  
  $all_categories = find_all('categories')
?>
<?php
 if(isset($_POST['add_cat'])){
  $req_field = array('categorie-name');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['categorie-name']));
  $cat_details = remove_junk($db->escape($_POST['categorie-details']));
  
  if(empty($errors)){
    $sql  = "INSERT INTO categories (name, category_details)";
    $sql .= " VALUES ('{$cat_name}', '{$cat_details}')";
    if($db->query($sql)){
      $session->msg("s", "Successfully Added New Category");
      redirect('categorie.php', false);
    } else {
      $session->msg("d", "Sorry Failed to insert.");
      redirect('categorie.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('categorie.php', false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
  </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>All Service Categories</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
          <thead>
  <tr>
    <th class="text-center" style="width: 50px;">#</th>
    <th> Services Categories</th>
    <th>Details</th>
  </tr>
      </thead>
      <tbody>
        <?php foreach ($all_categories as $cat): ?>
        <tr>
          <td class="text-center"><?php echo count_id();?></td>
          <td><?php echo remove_junk(ucfirst($cat['name'])); ?></td>
          <td><?php echo remove_junk($cat['category_details']); ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>

          </table>
       </div>
    </div>
    </div>
   </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>