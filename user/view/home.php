<?php

include '../models/home_model.php';

?>




<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
   integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
   crossorigin="anonymous" referrerpolicy="no-referrer" />
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

<style>
  .custom-line {
    border: 0;
    border-top: 2px solid #000; /* Black line with 2px thickness */
    margin: 20px 0; /* Space around the line */
  }
</style>

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
   <h3>Explorez l'Univers des Livres et des Trésors Culturels</h3>
   <p>Plongez dans un univers fascinant où chaque livre et objet culturel est sélectionné pour enrichir votre esprit. Offrez-vous une expérience qui mêle savoir, histoire et inspiration, tout en découvrant des trésors uniques et mémorables.</p>

      <a href="about.php" class="white-btn">discover more</a>
   </div>

</section>

<br><br><br><br>
<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">
      <?php
       echo '<p class="empty">no products added yet!</p>';
       ?>

   </div>

   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>

<br><br><br><br>

   <section class="about">

      <div class="flex">

         <div class="image">
            <img src="images/about.jpg" alt="">
         </div>

         <div class="content">
            <h3>about us</h3>
            <p>CultureHub is your gateway to discovering global culture through curated books and unique cultural items. 
               We celebrate diversity and heritage</p>
            <a href="about.php" class="btn">read more</a>
         </div>

      
      </div> 
   </div>

</section>
<hr class="custom-line">

<br><br>

<section class="about">

   <div class="flex">

   <div class="content" >
   <h3>Cultural Diversity</h3>
   <p> Embrace different cultures and see how they shape our world.</p>

   <a href="about.php" class="btn">learn more</a>
   </div>
   <div class="image">
            <img src="images/culture.jpeg" alt="">
         </div>
      </div> 
</div>

</section>
<hr class="custom-line">
<br><br>


<section class="about">
      <div class="flex">
         <div class="content" align="center">
         <h3>Cultural Quiz</h3>
         <p>Test your knowledge of global cultures and explore fascinating facts and traditions from around the world. Challenge yourself today!</p>
            <a href="controller/quizz.php" class="btn">Play</a>
         </div>
      </div>
      <br>
      <div class="image" align="center">
               <img src="images/quizz.jpg" alt="">
            </div>
</section>

<br><br>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>We're here to help! Feel free to reach out if you need assistance with your order, product information, or just want to know more about CultureHub.</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>



<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="../controllers/js/script.js"></script>


</body>
</html>