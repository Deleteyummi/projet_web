<?php

include '../config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      .heading {
         min-height: 30vh;
         display: flex;
         flex-flow: column;
         align-items: center;
         justify-content: center;
         gap: 1rem;
         background: url('images/header-priorities.jpg');
         background-size: cover;
         background-position: center;
         text-align: center;
      }
   </style>

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>
<br><br><br>
<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/international-diversity-earth-day-world-600nw-1913349307.webp" alt="">
      </div>

      <div class="content">
        <h3>why choose us?</h3>
        <p>Our world is rich with diverse cultures, each offering unique perspectives, traditions, and ways of life. Embracing this diversity fosters understanding, connection, and growth, enriching our collective experience. From language and art to customs and values, diversity shapes the fabric of our global community.</p>
        <p>Celebrating cultural differences encourages respect, equality, and inclusion, allowing individuals from all walks of life to come together in harmony. By learning from one another, we can create a world where everyone’s identity is valued and recognized, driving positive change for future generations.</p>

         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>
<br><br>
<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/pic-1.png" alt="">
         <p>"This platform has truly broadened my understanding of cultural diversity. The insights shared have been invaluable in helping me appreciate different perspectives."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john deo</h3>
      </div>

      <div class="box">
         <img src="images/pic-2.png" alt="">
         <p>"Being part of this platform has helped me connect with people from all over the world. It’s inspiring to see so many different cultures celebrated and shared."</p>

         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>alexandra botez</h3>
      </div>

      <div class="box">
         <img src="images/pic-3.png" alt="">
         <p>"They are attentive, hard-working, and truly care about customer satisfaction. I highly recommend them for their dedication and professionalism!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>James Anderson</h3>
      </div>

      <div class="box">
         <img src="images/pic-4.png" alt="">
         <p> "professionalism and dedication truly exceeded my expectations. His commitment to customer satisfaction is outstanding!"</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Jessica Carter</h3>
      </div>

      <div class="box">
         <img src="images/pic-5.png" alt="">
         <p>"Working with this platform has been a game-changer! Not only is it easy to find unique cultural products, but it also brings together a diverse community of like-minded individuals. 
            I’ve learned so much and am grateful for the connections I’ve made."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Ethan Carter</h3>
      </div>

      <div class="box">
         <img src="images/pic-6.png" alt="">
         <p>"This platform has been a delightful discovery! I love exploring the cultural treasures it offers, and the quality is always top-notch."</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Lena Thompson</h3>
      </div>

   </div>

</section>

<section class="authors">

   <h1 class="title">Created by</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/yassmine.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>yassmine fehri</h3>
      </div>

      <div class="box">
         <img src="images/salim.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Salim Sghaier</h3>
      </div>

      <div class="box">
         <img src="images/loussaif.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Loussaif Bhiri</h3>
      </div>
      
      <div class="box" >
         <img src="images/koussay.jpg" alt="">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <h3>Koussay Elkar</h3>
      </div>

   </div>

</section>







<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="../controllers/js/script.js"></script>

</body>
</html>