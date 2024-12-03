<?php
require '../config.php';

$email = $_GET['email'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match. Please try again.";
    } else {
        // Check if the password meets the required policy
        if (!preg_match('/^(?=.*\d).{4,}$/', $new_password)) {
            $error = "Password must be at least 4 characters long and contain at least one number.";
        } else {
            // Directly store the password without hashing (consider using hashing in real applications)
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->execute([$new_password, $email]);

            header("Location: login.php");
            exit();
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
    <title>Reset Password</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <script>
        // JavaScript validation to ensure password meets the policy
        function validateForm() {
            var newPassword = document.forms["resetForm"]["new_password"].value;
            var confirmPassword = document.forms["resetForm"]["confirm_password"].value;

            // Check if both password fields are filled
            if (newPassword == "" || confirmPassword == "") {
                alert("Both password fields must be filled out.");
                return false;
            }

            // Check if password is at least 4 characters long and contains at least one number
            var passwordPattern = /^(?=.*\d).{4,}$/;
            if (!passwordPattern.test(newPassword)) {
                alert("Password must be at least 4 characters long and contain at least one number.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
<div class="message-container">
    <?php if (isset($error)): ?>
        <div class="message">
            <span><?php echo htmlspecialchars($error, ENT_QUOTES); ?></span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
    <?php endif; ?>
</div>

<div class="form-container">
    <form method="post" name="resetForm" onsubmit="return validateForm()">
        <h3>Reset Password</h3>
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES); ?>">

        <label>New Password:</label>
        <input type="password" name="new_password" class="box">

        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" class="box">

        
        <input type="submit" value="Reset Your Password" class="btn">
    </form>
</div>
</body>
</html>
