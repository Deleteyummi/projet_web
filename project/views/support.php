<?php
session_start();
require '../config.php';

$messages = []; // Initialize messages array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Basic validations
    if (empty($name) || empty($email) || empty($message)) {
        $messages[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messages[] = "Invalid email format.";
    } else {
        // Check if the user exists in the users table
        $stmt = $conn->prepare("SELECT * FROM users WHERE name = ? AND email = ?");
        $stmt->execute([$name, $email]);
        $user = $stmt->fetch();

        if ($user) {
            // Insert the support message into the database
            $stmt = $conn->prepare("INSERT INTO support_messages (name, email, message, created_at) VALUES (?, ?, ?, NOW())");
            if ($stmt->execute([$name, $email, $message])) {
                $messages[] = "Your message has been sent. We will check it and email you.";
            } else {
                $messages[] = "An error occurred. Please try again later.";
            }
        } else {
            $messages[] = "No user found with the provided name and email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Support</title>

   <!-- Font Awesome CDN Link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- Custom CSS -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="message-container">
    <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $msg): ?>
            <div class="message">
                <span><?php echo htmlspecialchars($msg); ?></span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="form-container">
    <form method="post">
        <h3>Contact Support</h3>
        <input type="text" name="name" placeholder="Your Name" class="box">
        <input type="email" name="email" placeholder="Your Email"  class="box">
        <textarea name="message" placeholder="Describe your issue or question" class="box"></textarea>
        <input type="submit" name="submit" value="Send Message" class="btn">
        <p>Don't have an account? <a href="register.php">Register Now</a></p>
    </form>
</div>

</body>
</html>
