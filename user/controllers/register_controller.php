<?php
// register_controller.php

include '../models/register_model.php';

// Initialize the message array for errors
$messages = [];

if (isset($_POST['submit'])) {
    // Sanitize user inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messages[] = 'Invalid email format!';
    }

    // Validate password length (at least 8 characters)
    if (strlen($pass) < 8) {
        $messages[] = 'Password must be at least 8 characters long!';
    }

    // Check if password and confirm password match
    if ($pass != $cpass) {
        $messages[] = 'Confirm password does not match!';
    }

    // Optional: Check for password complexity (at least one uppercase letter, one special character, etc.)
    if (!preg_match('/[A-Z]/', $pass)) {
        $messages[] = 'Password must contain at least one uppercase letter!';
    }
    if (!preg_match('/[a-z]/', $pass)) {
        $messages[] = 'Password must contain at least one lowercase letter!';
    }
    if (!preg_match('/[0-9]/', $pass)) {
        $messages[] = 'Password must contain at least one number!';
    }
    if (!preg_match('/[\W_]/', $pass)) {
        $messages[] = 'Password must contain at least one special character!';
    }

    // If there are any validation errors, display them
    if (!empty($messages)) {
        foreach ($messages as $msg) {
            echo '<div class="message"><span>' . $msg . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
        }
    } else {
        // Check if the user already exists
        if (userExists($email)) {
            $messages[] = 'User already exists!';
        } else {
            // Insert new user into the database
            insertUser($name, $email, $pass, $user_type);

            // Success message
            $messages[] = 'Registered successfully!';
            header('Location: login.php');
            exit;
        }

        // Display any messages
        if (!empty($messages)) {
            foreach ($messages as $msg) {
                echo '<div class="message"><span>' . $msg . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
            }
        }
    }
}
?>

