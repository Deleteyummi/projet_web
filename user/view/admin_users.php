<?php
include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
   exit();
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    // Use PDO for DELETE operation
    $delete_query = $conn->prepare("DELETE FROM `users` WHERE id = :delete_id");
    $delete_query->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    $delete_query->execute();
    header('location:admin_users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Users</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link -->
   <link rel="stylesheet" href="css/admin_styles.css">
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/admin_detail.css">
   <link rel="stylesheet" href="css/style_search.css">
   
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=search" />
   <style>
            .search {
         --padding: 14px;

         width: max-content;
         display: flex;
         align-items: center;
         padding: var(--padding);
         border-radius: 28px;
         background: #333333; /* Dark grey background */
         transition: background 0.25s;
         position: absolute; /* Positioning for centering */
         left: 50%; /* Center horizontally */
         transform: translate(-50%, -50%); /* Adjust for the element's size */
      }

      .search:focus-within {
         background: #444444; /* Slightly lighter dark grey on focus */
      }

      .search-input {
         font-size: 16px;
         font-family: 'Lexend', sans-serif;
         color: #ffffff; /* White text for contrast */
         margin-left: var(--padding);
         outline: none;
         border: none;
         background: transparent;
         width: 300px;
      }

      .search-input::placeholder {
         color: rgba(255, 255, 255, 0.6); /* Light grey placeholder text */
      }

      .search-icon {
         color: rgba(255, 255, 255, 0.6); /* Light grey icon color */
      }

      /* Optional: Add a slightly darker background for the entire page */
      body {
         background-color: #f0f0f0; /* Light grey page background */
         margin: 0;
         height: 100vh;
      }

    </style>
</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title"> User Accounts </h1>
   <br><br>
   <form >
        <div class="search">
            <span class="search-icon material-symbols-outlined">search</span>
            <input class="search-input" type="search" placeholder="search">
        </div>
    </form>
    <br><br><br><br><br>
   <div class="box-container">
   <?php
    // Fetch all users from the database
    $select_users = $conn->prepare("SELECT * FROM `users`");
    $select_users->execute();
    $fetch_users = $select_users->fetchAll(PDO::FETCH_ASSOC);

    foreach ($fetch_users as $user) {
    ?>

    <div class="box">
         <p> Username : <span><?php echo $user['name']; ?></span> </p>
         <p> Email : <span><?php echo $user['email']; ?></span> </p>



         <!-- Details button -->
         <form action="details.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
            <button type="submit" class="btn">View Details</button>
         </form>
      </div>
      <?php
    };
    ?>
   </div>

</section>

<!-- custom admin js file link -->
<script src="../controllers/js/admin_script.js"></script>

</body>
</html>
