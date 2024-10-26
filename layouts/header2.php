
<?php $user = current_user(); ?>
<!DOCTYPE html>
  <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (!empty($page_title))
           echo remove_junk($page_title);
            elseif(!empty($user))
           echo ucfirst($user['name']);
            else echo "Mabini Water District System";?>
    </title>
  </head>
  <body>
  <?php  if ($session->isUserLoggedIn(true)): ?>
      
     </div>
    </header>
      <?php elseif($user['user_level'] === '3'): ?>
        <!-- User menu -->
      <?php include_once('user_menu.php');?>

      <?php endif;?>
<div class="page">
  <div class="container-fluid">

  