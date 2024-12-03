<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | CultureHub</title>
    <link rel="stylesheet" href="../../style/style.css">
    <style>
        /* Style for error messages */
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }
        /* General Page Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        /* Container for the messages list */
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* List Title */
        .container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        /* Message List */
        .message-list {
            list-style: none;
            padding: 0;
        }

        .message-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
            padding: 15px 0;
        }

        .message-item:last-child {
            border-bottom: none;
        }

        .message-item span {
            font-weight: bold;
            color: #333;
        }

        .message-item .status {
            color: #007bff;
        }

        .btn-group {
            text-align: center;
            margin-top: 20px;
        }

        .btn-view {
            padding: 8px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-view:hover {
            background-color: #218838;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .btn-view {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-1">
            <div class="flex">
                <a href="home.php" class="logo">CultureHub <i class="fa-solid fa-globe"></i></a>
                <p>New? <a href="login.php">Login</a> | <a href="register.php">Register</a></p>
            </div>
        </div>
        <div class="header-2">
            <div class="flex">
                <nav class="navbar">
                    <a href="home.php">Home</a>
                    <a href="about.php">About</a>
                    <a href="shop.php">Shop</a>
                    <a href="orders.php">Orders</a>
                </nav>
                <div class="icons">
                    <div id="menu-btn" class="fas fa-bars"></div>
                    <a href="search_page.php" class="fas fa-search"></a>
                    <a href="cart.php" class="fas fa-shopping-cart"></a>
                    <div id="user-btn" class="fas fa-user"></div>
                </div>
            </div>
        </div>
    </header>

    <!-- Message List -->
    <div class="container">
        <h1 class="mb-4">Messages</h1>
        <ul class="message-list">
            <?php foreach ($messages as $message): ?>
                <li class="message-item">
                    <div>
                        <span><?= htmlspecialchars($message['author']) ?></span> - <span class="status"><?= htmlspecialchars($message['status']) ?></span>
                    </div>
                    <a href="edit_message.php?id=<?= $message['id'] ?>" class="btn-view">Edit</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Button to Create New Message -->
        <div class="btn-group">
            <a href="create_message.php" class="btn-view">Create New Message</a>
        </div>
    </div>

    <!-- Include JavaScript -->
    <script src="../../public/js/form-validation.js"></script>
</body>
</html>
