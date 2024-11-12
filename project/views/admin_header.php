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


<nav class="navbar"> 
        <div class="navbar__container">
         
            <a href="admin_page.php" id="navbar__logo">Admin Panel</a>
            <div class="navbar__toggle" id="mobile_menu">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
            <ul class="navbar__menu">
               
                <li class="navbar__item">
                    <a href="admin_page.php" class="navbar__links">Home</a>
                </li>
                <li class="navbar__item">
                    <a href="admin_products.php" class="navbar__links">products</a>
                </li>
                <li class="navbar__item">
                    <a href="admin_users.php" class="navbar__links">Users</a>
                </li>
                <li class="navbar__item">
                    <a href="admin_contacts.php" class="navbar__links">messages</a>
                </li>
                <li class="navbar__btn">
                    <a href="login.php" class="button">login </a>
                </li>
                <li class="navbar__btn">
                    <a href="register.php" class="button">register</a>
                </li>
            </ul>
      </div>
      
</nav>


   
