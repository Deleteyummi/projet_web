<?php

include './models/config.php';

if (isset($_POST['submit'])) {
   try {
       // Sanitize user inputs
       $name = htmlspecialchars($_POST['name']);
       $email = htmlspecialchars($_POST['email']);
       $pass = md5($_POST['password']);
       $cpass = md5($_POST['cpassword']);
       $user_type = $_POST['user_type'];

       // Check if the user already exists
       $select_users = $conn->prepare("SELECT * FROM `users` WHERE email = :email");
       $select_users->bindParam(':email', $email);
       $select_users->execute();

       if ($select_users->rowCount() > 0) {
           $message[] = 'User already exists!';
       } else {
           if ($pass != $cpass) {
               $message[] = 'Confirm password does not match!';
           } else {
               // Insert new user into the database
               $insert_user = $conn->prepare("INSERT INTO `users` (name, email, password, user_type) VALUES (:name, :email, :password, :user_type)");
               $insert_user->bindParam(':name', $name);
               $insert_user->bindParam(':email', $email);
               $insert_user->bindParam(':password', $pass); // Use $pass (hashed password)
               $insert_user->bindParam(':user_type', $user_type);
               $insert_user->execute();

               $message[] = 'Registered successfully!';
               header('Location: login.php');
               exit;
           }
       }
   } catch (PDOException $e) {
       die('Query failed: ' . $e->getMessage());
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="views/css/style.css">

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
      <select name="user_type" class="box">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>