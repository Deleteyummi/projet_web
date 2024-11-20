<?php

include '../config.php';
session_start(); // Make sure you have this at the beginning of your script

if (isset($_POST['submit'])) {

    // Use PDO to prepare and execute queries safely
    $email = $_POST['email'];
    $pass = md5($_POST['password']); // Hash the password

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE email = :email AND password = :password");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $pass);
    $stmt->execute();

    // Check if any user matches the criteria
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the user data

        if ($row['user_type'] == 'admin') {
            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
            exit(); // Ensure no further code is executed after redirection

        } elseif ($row['user_type'] == 'user') {
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
            exit(); // Ensure no further code is executed after redirection
        }

    } else {
        $message[] = 'Incorrect email or password!';
    }
}

?>