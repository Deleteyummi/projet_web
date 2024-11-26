<?php
// Include configuration and session handling code
include '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$messages = [];
$message_types = []; // To classify messages as 'success' or 'error'

$stmt = $conn->prepare("SELECT * FROM `users` WHERE id = :id");
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
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

        if ($update_name != $user_data['name'] || $update_email != $user_data['email']) {
            $changes_made = true;
            if (!filter_var($update_email, FILTER_VALIDATE_EMAIL)) {
                $messages[] = 'Please enter a valid email address!';
                $message_types[] = 'error';
            } else {
                try {
                    $stmt = $conn->prepare("UPDATE `users` SET name = :name, email = :email WHERE id = :id");
                    $stmt->bindParam(':name', $update_name, PDO::PARAM_STR);
                    $stmt->bindParam(':email', $update_email, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $profile_updated = true;
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
                $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
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
                    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();

                    if (!move_uploaded_file($update_image_tmp_name, $update_image_folder)) {
                        $messages[] = 'Failed to upload image!';
                        $message_types[] = 'error';
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

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>
   <link rel="stylesheet" href="css/style_modif.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/style_header2.css">

   <style>
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
   </style>
   <script>
       // JavaScript function to check password confirmation
       function validateForm() {
           var newPass = document.getElementById('new_pass').value;
           var confirmPass = document.getElementById('confirm_pass').value;

           if (newPass !== "" && confirmPass === "") {
               alert("Please confirm your new password.");
               return false; // Prevent form submission
           }

           return true; // Proceed with form submission
       }
   </script>
</head>
<body>
   
<div class="update-profile">
   <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
      <?php
        $stmt = $conn->prepare("SELECT image FROM `users` WHERE id = :id");
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '<img src="' . ($fetch['image'] ? 'images/' . $fetch['image'] : 'images/default-avatar.png') . '" alt="Avatar">';
        } else {
            echo 'No user found!';
        }

         if (!empty($messages)) {
            foreach ($messages as $index => $message) {
               $type = $message_types[$index] ?? 'error'; // Default to 'error' if type is not set
               echo '<div class="alert-box ' . htmlspecialchars($type) . '">' . htmlspecialchars($message) . '</div>';
            }
         }
      ?>

      <div class="flex">
         <div class="inputBox">
            <span>Username:</span>
            <input type="text" name="update_name" value="<?php echo htmlspecialchars($user_data['name']); ?>" class="box" required>
            <span>Email:</span>
            <input type="email" name="update_email" value="<?php echo htmlspecialchars($user_data['email']); ?>" class="box" required>
            <span>Update Your Pic:</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <span>New Password:</span>
            <input type="password" id="new_pass" name="new_pass" placeholder="Enter new password" class="box" >
            <span>Confirm Password:</span>
            <input type="password" id="confirm_pass" name="confirm_pass" placeholder="Confirm password" class="box">
         </div>
      </div>

      <input type="submit" value="Update Profile" name="update_profile" class="btn">
   </form>
</div>

</body>
</html>