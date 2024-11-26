<?php

/**
 * Logs the user's login time in the database.
 *
 * @param PDO $conn Database connection object
 * @param int $userId The ID of the logged-in user
 */
function logUserLogin($conn, $userId) {
    $currentDateTime = date('Y-m-d H:i:s');

    // Insert the login time into the database
    $stmt = $conn->prepare("INSERT INTO user_logins (user_id, login_time) VALUES (:user_id, :login_time)");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':login_time', $currentDateTime);
    $stmt->execute();
}
?>
