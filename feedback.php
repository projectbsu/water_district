<?php
require_once('includes/load.php');

// Check user permission
page_require_level(3);

$msg = ''; // Initialize $msg for displaying messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Ensure reaction is set and feedback text is not empty
  if (isset($_POST['reaction']) && !empty($_POST['feedback_text'])) {
      $reaction = $_POST['reaction'];
      $feedback_text = remove_junk($_POST['feedback_text']);
      $user_id = current_user()['id']; // Get the current user ID
      $user_name = remove_junk(current_user()['name']); // Get the user's name

      // Save feedback to database
      $sql = "INSERT INTO feedback (user_id, user_name, reaction, feedback_text) VALUES ('$user_id', '$user_name', '$reaction', '$feedback_text')";
      if ($db->query($sql)) {
          $msg = "Thank you for your feedback! We appreciate your input and will use it to improve our app.";
      } else {
          $msg = "Oops! Something went wrong. Please try again later.";
      }
  } else {
      $msg = "Please select a reaction and provide your feedback before submitting.";
  }
}

?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
</div>
<div class="row">
  <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span>Feedback</span>
        </strong>
      </div>
      <div class="panel-body">
        <form method="POST" action=""> <!-- Add form tags -->
          <p>How do you rate this app?</p>
          <div class="emoji">
              <div class="emoji-option" data-reaction="Angry">
                  <i class="bi bi-emoji-angry"></i><p>Angry</p>
              </div>
              <div class="emoji-option" data-reaction="Sad">
                  <i class="bi bi-emoji-frown"></i><p>Sad</p>
              </div>
              <div class="emoji-option" data-reaction="Neutral">
                  <i class="bi bi-emoji-neutral"></i><p>Neutral</p>
              </div>
              <div class="emoji-option" data-reaction="Happy">
                  <i class="bi bi-emoji-smile"></i><p>Happy</p>
              </div>
              <div class="emoji-option" data-reaction="Very Happy">
                  <i class="bi bi-emoji-laughing"></i><p>Very Happy</p>
              </div>

              <input type="hidden" name="reaction" value=""> <!-- Hidden input for reaction -->
              <textarea name="feedback_text" placeholder="Write your feedback" style="display: none;"></textarea>
              <button type="submit" class="btn" style="display: none;">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
const emojis = document.querySelectorAll('.emoji-option');

emojis.forEach((emoji) => {
    emoji.addEventListener('click', () => {
        const reaction = emoji.getAttribute('data-reaction');
        document.querySelector('input[name="reaction"]').value = reaction; // Store selected reaction
        document.querySelector('textarea[name="feedback_text"]').style.display = 'block';
        document.querySelector('button[type="submit"]').style.display = 'block';
    });
});
</script>

<?php include_once('layouts/footer.php'); ?>
