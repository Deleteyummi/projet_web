<?php

include '../models/login_model.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
   /* CAPTCHA Styles */
   .captcha {
      margin-top: 15px;
   }

   .captcha .preview {
      color: #555;
      width: 100%;
      text-align: center;
      height: 40px;
      line-height: 40px;
      letter-spacing: 8px;
      border: 1px dashed #888;
      font-family: monospace;
      margin-bottom: 10px;
      user-select: none;
   }

   .captcha .captcha-form {
      display: flex;
      align-items: center;
   }

   .captcha .captcha-form input {
      flex: 1;
      padding: 8px;
      border: 1px solid #888;
      border-radius: 4px;
   }

   .captcha .captcha-form .captcha-refresh {
      width: 40px;
      height: 40px;
      border: none;
      outline: none;
      background: #888;
      color: #fff;
      border-radius: 4px;
      cursor: pointer;
      text-align: center;
      display: flex;
      justify-content: center;
      align-items: center;
   }

   .captcha .captcha-form .captcha-refresh:hover {
      background: #555;
   }

   .error-message {
         color: red;
         font-size: 1.5rem;
         margin-top: 5px;
      }
</style>


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
         <h3>Login Now</h3>

         <!-- Email Input -->
         <input type="email" name="email" placeholder="Enter your email" required class="box">
         <?php if (!empty($emailError)) { ?>
            <div class="error-message"><?php echo $emailError; ?></div>
         <?php } ?>

         <!-- Password Input -->
         <input type="password" name="password" placeholder="Enter your password" required class="box">
         <?php if (!empty($passwordError)) { ?>
            <div class="error-message"><?php echo $passwordError; ?></div>
         <?php } ?>

         <!-- CAPTCHA -->
         <div class="captcha">
            <label for="captcha-input"></label>
            <div class="preview"></div>
            <div class="captcha-form">
               <input type="text" id="captcha-input" placeholder="Enter CAPTCHA text">
               <button class="captcha-refresh">&#x21bb;</button>
            </div>
         </div>

         <!-- Submit Button -->
         <input type="submit" name="submit" value="Login Now" class="btn">
         <p>Don't have an account? <a href="register.php">Register Now</a></p>
      </form>
   </div>
<script>
   document.addEventListener('DOMContentLoaded', () => {
      const fonts = ["cursive", "sans-serif", "serif", "monospace"];
      let captchaValue = "";

      // Function to generate random CAPTCHA
      function generateCaptcha() {
         let value = btoa(Math.random() * 1000000000).substring(0, 6);
         captchaValue = value.toUpperCase(); // Make it case insensitive
      }

      // Function to render the CAPTCHA
      function setCaptcha() {
         const preview = document.querySelector('.captcha .preview');
         let html = captchaValue
            .split("")
            .map((char) => {
               const rotate = -20 + Math.random() * 40; // Random rotation
               const font = fonts[Math.floor(Math.random() * fonts.length)];
               return `<span 
                           style="
                              transform: rotate(${rotate}deg);
                              font-family: ${font};
                           ">
                           ${char}
                        </span>`;
            })
            .join(""); // Combine characters into HTML
         preview.innerHTML = html;
      }

      // Initialize CAPTCHA
      function initCaptcha() {
         const refreshButton = document.querySelector('.captcha .captcha-refresh');
         refreshButton.addEventListener('click', (e) => {
            e.preventDefault(); // Prevent form submission on button click
            generateCaptcha();
            setCaptcha();
         });

         // Generate and set the initial CAPTCHA
         generateCaptcha();
         setCaptcha();
      }

      // Call the CAPTCHA initialization
      initCaptcha();

      // Form submission handler
      const form = document.querySelector('form');
      form.addEventListener('submit', (e) => {
         const userInput = document.querySelector('#captcha-input').value.toUpperCase();
         if (userInput !== captchaValue) {
            e.preventDefault(); // Stop form submission
            alert("Invalid CAPTCHA. Please try again.");
         }
      });
   });
</script>

  

</body>
</html>