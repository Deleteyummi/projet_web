<?php
// Database connection settings
$host = 'localhost';
$dbname = 'event'; // Replace with your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    // Create a PDO instance and set the error mode to exception
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the ID is provided in the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Prepare and execute the delete query
        $sql = "DELETE FROM reservation WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirect to the reservations list page after deletion
        header("Location: table_messages.php");
        exit;
    } else {
        echo "No ID provided.";
    }

} catch (PDOException $e) {
    // Handle database errors
    echo "Error: " . $e->getMessage();
}
?>
