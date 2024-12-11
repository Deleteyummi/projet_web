<?php
$db = "mysql:host=localhost;dbname=event";
$user = "root";
$password = "";

try {
    $connect = new PDO($db, $user, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Collect form data
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_place = $_POST['event_place'];

    // Handle the file upload
    if (isset($_FILES['event_photo']) && $_FILES['event_photo']['error'] == 0) {
        $photo_name = $_FILES['event_photo']['name'];
        $photo_tmp = $_FILES['event_photo']['tmp_name'];
        $photo_path = 'uploads/' . $photo_name;

        // Move the uploaded file to the uploads directory
        move_uploaded_file($photo_tmp, $photo_path);

        // Insert event data into the database
        $query = "INSERT INTO event (nom, date, lieu, photo) VALUES (?, ?, ?, ?)";
        $stmt = $connect->prepare($query);
        $stmt->execute([$event_name, $event_date, $event_place, $photo_path]);
        header("Location:../view/dash/addevent.php"); 
        exit(); 
    } else {
        echo "Error uploading photo.";
    }
} catch (PDOException $e) {
    echo "Problem: " . $e->getMessage();
}
?>
