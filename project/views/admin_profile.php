<?php
// Include configuration and session handling code
include '../config.php';
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

// Get the admin's ID from the session
$admin_id = $_SESSION['admin_id'];
$messages = [];
$message_types = []; // To classify messages as 'success' or 'error'

// Fetch the logged-in admin's data from the 'users' table
$stmt = $conn->prepare("SELECT * FROM `users` WHERE id = :id");
$stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $admin_data = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "No user found.";
    exit();
}

// Handle profile update logic
if (isset($_POST['update_profile'])) {
    $profile_updated = false;
    $changes_made = false;

    // Check if the name or email is being updated
    if (!empty($_POST['update_name']) && !empty($_POST['update_email'])) {
        $update_name = $_POST['update_name'];
        $update_email = $_POST['update_email'];

        if ($update_name != $admin_data['name'] || $update_email != $admin_data['email']) {
            $changes_made = true;
            if (!filter_var($update_email, FILTER_VALIDATE_EMAIL)) {
                $messages[] = 'Please enter a valid email address!';
                $message_types[] = 'error';
            } else {
                try {
                    $stmt = $conn->prepare("UPDATE `users` SET name = :name, email = :email WHERE id = :id");
                    $stmt->bindParam(':name', $update_name, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $update_email, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $profile_updated = true;

                    // Update the admin data array to reflect the new values
                    $admin_data['name'] = $update_name;
                    $admin_data['email'] = $update_email;
                } catch (PDOException $e) {
                    $messages[] = 'Error: ' . $e->getMessage();
                    $message_types[] = 'error';
                }
            }
        }
    }

    // Check if the password is being updated
    if (!empty($_POST['new_pass']) && !empty($_POST['confirm_pass'])) {
        $new_pass = $_POST['new_pass'];
        $confirm_pass = $_POST['confirm_pass'];

        if ($new_pass != $confirm_pass) {
            $messages[] = 'Confirm password does not match!';
            $message_types[] = 'error';
        } elseif (strlen($new_pass) < 6) {
            $messages[] = 'New password must be at least 6 characters!';
            $message_types[] = 'error';
        } else {
            $changes_made = true;
            try {
                $stmt = $conn->prepare("UPDATE `users` SET password = :password WHERE id = :id");
                $stmt->bindParam(':password', $new_pass, PDO::PARAM_STR);
                $stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $e) {
                $messages[] = 'Error: ' . $e->getMessage();
                $message_types[] = 'error';
            }
        }
    }

    // Check if the image is being updated
    if (isset($_FILES['update_image']) && !empty($_FILES['update_image']['name'])) {
        $update_image = $_FILES['update_image']['name'];
        $update_image_size = $_FILES['update_image']['size'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'images/' . $update_image;

        $changes_made = true;
        if ($update_image_size > 2000000) {
            $messages[] = 'Image is too large! Max size is 2MB.';
            $message_types[] = 'error';
        } else {
            $image_file_type = mime_content_type($update_image_tmp_name);
            if (!in_array($image_file_type, ['image/jpeg', 'image/png', 'image/jpg'])) {
                $messages[] = 'Please upload a valid image (JPG, JPEG, PNG only).';
                $message_types[] = 'error';
            } else {
                try {
                    $stmt = $conn->prepare("UPDATE `users` SET image = :image WHERE id = :id");
                    $stmt->bindParam(':image', $update_image, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
                    $stmt->execute();

                    if (!move_uploaded_file($update_image_tmp_name, $update_image_folder)) {
                        $messages[] = 'Failed to upload image!';
                        $message_types[] = 'error';
                    } else {
                        // Update the admin data array to reflect the new image
                        $admin_data['image'] = $update_image;
                    }
                } catch (PDOException $e) {
                    $messages[] = 'Error: ' . $e->getMessage();
                    $message_types[] = 'error';
                }
            }
        }
    }

    // Only display success message if changes were made
    if ($changes_made && empty($messages)) {
        $messages[] = 'Profile updated successfully!';
        $message_types[] = 'success';
    }
}
?>

<?php include 'admin_header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Profile</title>
   <link rel="stylesheet" href="css/style_admin.css">
   <link rel="stylesheet" href="css/style_header_admin.css">
   <link rel="stylesheet" href="css/admin_styles.css">
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/admin_detail.css">
   <style>
       body {
           background-color: #f1f1f1;
           font-family: Arial, sans-serif;
           justify-content: center;
           align-items: center; 
           color: #333;
       }

       .alert-box {
           padding: 10px;
           margin: 10px 0;
           border-radius: 5px;
           font-size: 14px;
           text-align: center;
           border: 1px solid;
       }
       .alert-box.success {
           background-color: #d4edda;
           color: #155724;
           border-color: #c3e6cb;
       }
       .alert-box.error {
           background-color: #f8d7da;
           color: #721c24;
           border-color: #f5c6cb;
       }

       .admin-profile-wrapper {
           display: flex;
           justify-content: space-between;
           justify-content: center;
            align-items: center;
           padding: 20px;
           max-width: 1200px;
           margin: 0 auto;
       }

       .admin-sidebar {
           width: 250px;
           background-color: #333;
           padding: 20px;
           color: #fff;
           border-radius: 8px;
       }

       .admin-sidebar a {
           color: #fff;
           text-decoration: none;
           display: block;
           padding: 10px;
           margin: 10px 0;
           background-color: #444;
           border-radius: 5px;
       }

       .admin-sidebar a:hover {
           background-color: #555;
       }

       .profile-form {
           width: 70%;
           padding: 20px;
           background-color: #fff;
           border-radius: 8px;
           box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
       }

       .profile-image-container {
           text-align: center;
           margin-bottom: 20px;
       }

       .profile-image-container img {
           max-width: 150px;
           border-radius: 50%;
       }

       .inputBox {
           margin-bottom: 20px;
       }

       .inputBox span {
           font-weight: bold;
           display: block;
           margin-bottom: 5px;
       }

       .inputBox input[type="text"], 
       .inputBox input[type="email"], 
       .inputBox input[type="password"], 
       .inputBox input[type="file"] {
           width: 100%;
           padding: 10px;
           border: 1px solid #ddd;
           border-radius: 5px;
           font-size: 14px;
       }

       .btn {
           background-color: #4CAF50;
           color: white;
           padding: 10px 20px;
           border: none;
           border-radius: 5px;
           cursor: pointer;
       }

       .btn:hover {
           background-color: #45a049;
       }
   </style>
</head>
<body>

<div class="admin-profile-wrapper">

   <div class="profile-form">
       <h2>Update Profile</h2>

       <?php
       // Display messages if there are any
       for ($i = 0; $i < count($messages); $i++) {
           echo '<div class="alert-box ' . $message_types[$i] . '">' . $messages[$i] . '</div>';
       }
       ?>

       <form method="post" enctype="multipart/form-data">
           <!-- Profile Image at the top -->
           <div class="profile-image-container">
               <img src="images/<?php echo $admin_data['image'] ?? 'default.jpg'; ?>" alt="Profile Image">
           </div>

           <div class="inputBox">
               <span>Name:</span>
               <input type="text" name="update_name" value="<?php echo htmlspecialchars($admin_data['name']); ?>" required>
           </div>

           <div class="inputBox">
               <span>Email:</span>
               <input type="email" name="update_email" value="<?php echo htmlspecialchars($admin_data['email']); ?>" required>
           </div>

           <div class="inputBox">
               <span>Profile Image:</span>
               <input type="file" name="update_image">
           </div>

           <div class="inputBox">
               <span>New Password:</span>
               <input type="password" name="new_pass" placeholder="Enter new password (if any)">
           </div>

           <div class="inputBox">
               <span>Confirm Password:</span>
               <input type="password" name="confirm_pass" placeholder="Confirm new password">
           </div>

           <button type="submit" class="btn" name="update_profile">Update Profile</button>
       </form>
   </div>

</div>

</body>
</html>
