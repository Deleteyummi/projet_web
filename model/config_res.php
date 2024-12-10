<?php
try {
    // Establish connection to the database
    $db = "mysql:host=localhost;dbname=event";
    $user = "root";
    $password = "";
    $connect = new PDO($db, $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the form data and trim whitespace
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $age = isset($_POST['age']) ? trim($_POST['age']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Check if any field is empty
    if (empty($nom) || empty($age) || empty($email)) {
        echo "Please fill in all fields.";
    } else {
        // Prepare the insert query for the reservation table
        $query = "INSERT INTO reservation (nom, age, email) VALUES (:nom, :age, :email)";
        $stmt = $connect->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        header("Location:../view/front/event_seat/index.html"); 
        exit(); 
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
