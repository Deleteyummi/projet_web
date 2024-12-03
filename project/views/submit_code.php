<?php
session_start();
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $code = $_POST['code'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND reset_code = ? AND code_expiry > NOW()");
    $stmt->execute([$email, $code]);
    $user = $stmt->fetch();

    if ($user) {
        // Clear the reset code
        $stmt = $conn->prepare("UPDATE users SET reset_code = NULL, code_expiry = NULL WHERE email = ?");
        $stmt->execute([$email]);

        // Redirect to reset password page
        header("Location: reset_password.php?email=" . urlencode($email));
        exit();
    } else {
        $error = "Invalid code. Please try again.";
    }
} else if (isset($_GET['email'])) {
    $email = $_GET['email'];
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Code</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
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
    <form method="post">
        <h3>Submit Code</h3>
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email ?? '', ENT_QUOTES); ?>">
        <input type="text" name="code" placeholder="Enter your code"  class="box">
        <input type="button" value="Go Back" class="btn" onclick="window.location.href='login.php';">
        <input type="submit" value="Submit" class="btn">
    </form>
</div>
</body>
</html>
