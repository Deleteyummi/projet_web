<?php
// register_model.php

include '../config.php';

function userExists($email) {
    global $conn;
    $select_users = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $select_users->bindParam(':email', $email);
    $select_users->execute();
    return $select_users->rowCount() > 0;
}

function insertUser($name, $email, $password, $user_type) {
    global $conn;
    $hashed_pass = md5($password);
    $insert_user = $conn->prepare("INSERT INTO users (name, email, password, user_type) VALUES (:name, :email, :password, :user_type)");
    $insert_user->bindParam(':name', $name);
    $insert_user->bindParam(':email', $email);
    $insert_user->bindParam(':password', $hashed_pass);
    $insert_user->bindParam(':user_type', $user_type);
    $insert_user->execute();
}
?>
