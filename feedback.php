<?php
require_once('includes/load.php');

// Check user permission
page_require_level([3]);

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to get sentiment score based on reaction
function get_sentiment_score($reaction) {
    switch ($reaction) {
        case "Very Happy":
            return 1;
        case "Happy":
            return 0.5;
        case "Neutral":
            return 0;
        case "Sad":
            return -0.5;
        case "Angry":
            return -1;
        default:
            return 0; // Default case if needed
    }
}

$msg = ''; // Initialize message variable

if (isset($_POST['submit_feedback'])) {
    // Assuming you've validated and sanitized the input data
    $user_name = remove_junk($_POST['user_name']);
    $account_number = remove_junk($_POST['account_number']);
    $feedback_text = remove_junk($_POST['feedback_text']);

    // Insert feedback into the database
    $feedback_inserted = insert_feedback($user_name, $account_number, $feedback_text); // Implement this function

    // Check if feedback was successfully inserted
    if ($feedback_inserted) {
        log_transaction($user_name, $account_number, "$user_name has sent feedback.");
        // Optionally, redirect or display success message
    } else {
        // Handle the error
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure reaction is set and feedback text is not empty
    if (isset($_POST['reaction']) && !empty($_POST['feedback_text'])) {
        $reaction = $_POST['reaction'];
        $feedback_text = remove_junk($_POST['feedback_text']);
        $user_id = current_user()['id']; // Get the current user ID
        $user_name = remove_junk(current_user()['name']); // Get the user's name

        // Get sentiment score based on reaction
        $sentiment_score = get_sentiment_score($reaction);

        // Save feedback to the database with sentiment score
        $sql = "INSERT INTO feedback (user_id, user_name, reaction, feedback_text, sentiment_score) 
                VALUES ('$user_id', '$user_name', '$reaction', '$feedback_text', '$sentiment_score')";
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
    <div class="col-md-7">
        <?php echo display_msg($msg); ?>
        <div id="warning-message" style="color: red; display: none;">Please select a reaction before submitting your feedback.</div>
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
                <form method="POST" action="" onsubmit="return validateForm();">
                    <p>How do you rate this app?</p>
                    <div class="emoji">
                        <div class="emoji-option" data-reaction="Angry" style="text-align: center;">
                            <i class="bi bi-emoji-angry" style="color: red;"></i>
                            <p style="font-size: 14px; margin: 0;">Very Unsatisfied</p>
                        </div>
                        <div class="emoji-option" data-reaction="Sad" style="text-align: center;">
                            <i class="bi bi-emoji-frown" style="color: orange;"></i>
                            <p style="font-size: 14px; margin: 0;">Unsatisfied</p>
                        </div>
                        <div class="emoji-option" data-reaction="Neutral" style="text-align: center;">
                            <i class="bi bi-emoji-neutral" style="color: yellow;"></i>
                            <p style="font-size: 14px; margin: 0;">Neutral</p>
                        </div>
                        <div class="emoji-option" data-reaction="Happy" style="text-align: center;">
                            <i class="bi bi-emoji-smile" style="color: lightgreen;"></i>
                            <p style="font-size: 14px; margin: 0;">Satisfied</p>
                        </div>
                        <div class="emoji-option" data-reaction="Very Happy" style="text-align: center;">
                            <i class="bi bi-emoji-laughing" style="color: green;"></i>
                            <p style="font-size: 14px; margin: 0;">Very Satisfied</p>
                        </div>
                    </div>

                    <div class="suggestions" style="display: none;">
                        <div id="bubble-container" style="margin-bottom: 10px;"></div>
                    </div>

                    <input type="hidden" name="reaction" value="">
                    <textarea name="feedback_text" placeholder="What makes you feel this way?" style="display: none; width: 100%; height: 50px;" readonly></textarea>
                    <button type="submit" class="btn" style="display: none; margin-top: 10px;">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Suggested phrases for each reaction
const suggestions = {
    "Angry": [
        "Consistent issues with water quality.",
        "Long response times for service requests.",
        "Billing errors and lack of transparency.",
        "Inadequate communication during outages.",
        "Frequent water service disruptions."
    ],
    "Sad": [
        "Occasional delays in service restoration.",
        "Difficulty reaching customer support.",
        "Water pressure problems in my area.",
        "Limited information on conservation programs.",
        "High rates compared to neighboring districts."
    ],
    "Neutral": [
        "Service is adequate but not exceptional.",
        "Water quality varies at times.",
        "Communication is sometimes unclear.",
        "No major complaints, but also no standout features.",
        "Standard billing process with no surprises."
    ],
    "Happy": [
        "Prompt responses to service inquiries.",
        "Reliable water supply with minimal issues.",
        "Helpful staff when contacted.",
        "Clear information on water usage.",
        "Positive experience with community outreach efforts."
    ],
    "Very Happy": [
        "Consistently high water quality and reliability.",
        "Excellent customer service every time.",
        "Proactive communication about projects and updates.",
        "Great programs for water conservation and education.",
        "Fair pricing and transparent billing practices."
    ]
};

const emojis = document.querySelectorAll('.emoji-option');
const bubbleContainer = document.getElementById('bubble-container');
const feedbackText = document.querySelector('textarea[name="feedback_text"]');
let selectedReaction = '';

// Function to validate form submission
function validateForm() {
    if (!selectedReaction) {
        document.getElementById('warning-message').style.display = 'block'; // Show warning message
        return false; // Prevent form submission
    }
    document.getElementById('warning-message').style.display = 'none'; // Hide warning if valid
    return true; // Allow form submission
}

emojis.forEach((emoji) => {
    emoji.addEventListener('click', () => {
        selectedReaction = emoji.getAttribute('data-reaction'); // Store selected reaction
        document.querySelector('input[name="reaction"]').value = selectedReaction;
        feedbackText.style.display = 'block';
        document.querySelector('button[type="submit"]').style.display = 'block';
        document.querySelector('.suggestions').style.display = 'block';

        // Clear existing suggestion bubbles
        bubbleContainer.innerHTML = '';

        // Populate suggestion bubbles based on the selected reaction
        suggestions[selectedReaction].forEach((suggestion) => {
            const bubble = document.createElement('span');
            bubble.textContent = suggestion;
            bubble.style.padding = '5px 10px';
            bubble.style.margin = '5px';
            bubble.style.borderRadius = '20px';
            bubble.style.border = '1px solid #ccc';
            bubble.style.background = '#f0f0f0';
            bubble.style.cursor = 'pointer';
            bubble.style.display = 'inline-block';
            bubble.style.transition = 'background 0.2s';
            
            bubble.addEventListener('mouseenter', () => {
                bubble.style.background = '#e0e0e0'; // Highlight on hover
            });
            
            bubble.addEventListener('mouseleave', () => {
                bubble.style.background = '#f0f0f0'; // Reset on mouse leave
            });

            bubble.addEventListener('click', () => {
                feedbackText.value = suggestion;
                feedbackText.style.color = 'black'; // Reset text color to black after selection
            });

            bubbleContainer.appendChild(bubble);
        });
    });
});
</script>

<?php include_once('layouts/footer.php'); ?>
