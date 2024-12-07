<?php
$host = 'localhost';
$dbname = 'culture';
$username = 'root';
$password = '';

function getDb() {
    global $host, $dbname, $username, $password;
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db; // Retourne l'objet PDO
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
