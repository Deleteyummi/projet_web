<?php
session_start();
require '../config.php';

$messages = []; // Initialize messages array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messages[] = "Invalid email format.";
    } else {
        // Secure query to check if email exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Check if the account is deactivated
            if ($user['status'] === 'deactivated') {
                $messages[] = "This account is deactivated. Please contact support.";
            } else {
                // Generate a random reset code
                $code = random_int(100000, 999999);
                $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

                // Update reset code and expiry in the database
                $stmt = $conn->prepare("UPDATE users SET reset_code = ?, code_expiry = ? WHERE email = ?");
                $stmt->execute([$code, $expiry, $email]);

                // Redirect to QR code display page
                header("Location: display_qr.php?email=" . urlencode($email));
                exit();
            }
        } else {
            $messages[] = "Email not found.";
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
   <title>Forgot Password</title>

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

<div class="form-container">
    <form method="post">
        <h3>Forgot Password</h3>
        <input type="email" name="email" placeholder="Enter your email"  class="box">
        
        
        <!-- Message Container -->
        <input type="button" value="Go Back" class="btn" onclick="window.location.href='login.php';">

            <input type="submit" name="submit" value="Submit" class="btn">
            <p>Contact Our Support? <a href="support.php">Contact</a></p>
            
            
            
        </div>
    </form>
</div>

</body>
</html>
