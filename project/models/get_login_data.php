<?php
include '../config.php';

header('Content-Type: application/json');

$query = $conn->prepare("SELECT HOUR(login_time) AS hour, COUNT(*) AS count FROM user_logins GROUP BY HOUR(login_time)");
$query->execute();

$data = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
?>
