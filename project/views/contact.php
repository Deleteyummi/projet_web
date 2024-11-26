<?php

include '../config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
   exit();
}

if(isset($_POST['send'])){
   // Get the user input
   $name = $_POST['name'];
   $email = $_POST['email'];
   $number = $_POST['number'];
   $msg = $_POST['message'];

   // Check if email exists in the users table
   $select_user_query = "SELECT * FROM `users` WHERE email = :email";
   $select_user_stmt = $conn->prepare($select_user_query);
   $select_user_stmt->bindParam(':email', $email);
   $select_user_stmt->execute();

   if($select_user_stmt->rowCount() === 0) {
      $message[] = 'Email does not exist in our records!';
   } else {
      // Using PDO to prepare and execute the SELECT query for message
      $select_message_query = "SELECT * FROM `message` WHERE name = :name AND email = :email AND number = :number AND message = :message";
      $select_message_stmt = $conn->prepare($select_message_query);
      $select_message_stmt->bindParam(':name', $name);
      $select_message_stmt->bindParam(':email', $email);
      $select_message_stmt->bindParam(':number', $number);
      $select_message_stmt->bindParam(':message', $msg);
      $select_message_stmt->execute();

      if($select_message_stmt->rowCount() > 0){
         $message[] = 'Message sent already!';
      }else{
         // Prepare the INSERT query
         $insert_message_query = "INSERT INTO `message`(user_id, name, email, number, message) VALUES(:user_id, :name, :email, :number, :message)";
         $insert_message_stmt = $conn->prepare($insert_message_query);
         $insert_message_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
         $insert_message_stmt->bindParam(':name', $name);
         $insert_message_stmt->bindParam(':email', $email);
         $insert_message_stmt->bindParam(':number', $number);
         $insert_message_stmt->bindParam(':message', $msg);
         $insert_message_stmt->execute();

         $message[] = 'Message sent successfully!';
      }
   }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/style_modif.css">
   <link rel="stylesheet" href="css/style_header2.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading" aling>
    <div align="center"><h3>contact us</h3>
   
   <p> <a href="home.php">home</a> / contact </p>
   </div>
</div>

<section class="contact">

   <form action="" method="post">
      <h3>say something!</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box">
      <input type="email" name="email" required placeholder="enter your email" class="box">
      <input type="number" name="number" required placeholder="enter your number" class="box">
      <textarea name="message" class="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn">
   </form>

</section>




<script>
   // Client-side validation
   document.querySelector('form').addEventListener('submit', function(event) {
      var name = document.querySelector('input[name="name"]').value;
      var email = document.querySelector('input[name="email"]').value;
      var number = document.querySelector('input[name="number"]').value;
      var message = document.querySelector('textarea[name="message"]').value;

      // Validate name (should not be empty)
      if(name.trim() === '') {
         alert('Name cannot be empty!');
         event.preventDefault();  // Prevent form submission
         return;
      }

      // Validate email format
      var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if(!emailPattern.test(email)) {
         alert('Please enter a valid email address!');
         event.preventDefault();
         return;
      }

      // Check if email exists in the database
      <?php
         if (isset($message) && in_array('Email does not exist in our records!', $message)) {
            echo 'alert("Email does not exist in our records!");';
            echo 'event.preventDefault();';  // Prevent form submission
         }
      ?>

      // Validate number (should be exactly 8 digits)
      var numberPattern = /^\d{8}$/;  // Ensures only 8 digits
      if(!numberPattern.test(number)) {
         alert('Please enter a valid phone number with exactly 8 digits!');
         event.preventDefault();
         return;
      }

      // Validate message (should not be empty)
      if(message.trim() === '') {
         alert('Message cannot be empty!');
         event.preventDefault();
         return;
      }
   });
</script>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
