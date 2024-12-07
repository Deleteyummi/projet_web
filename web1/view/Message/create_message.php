<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Message | CultureHub</title>
    <link rel="stylesheet" href="../../style/style.css">
    <style>
        /* Style for error messages */
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        /* General Page Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #007bff;
            outline: none;
        }

        .btn-group {
            text-align: center;
        }

        .btn-submit,
        .btn-back {
            display: inline-block;
            padding: 12px 25px;
            font-size: 1rem;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit {
            background-color: #28a745;
            color: white;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            margin-left: 10px;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <?php if (isset($message)): ?>
        <?php foreach ($message as $msg): ?>
            <div class="message">
                <span><?php echo htmlspecialchars($msg); ?></span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

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

    <!-- Form Container -->
    <div class="container">
        <h1>Create a New Message</h1>
        <form action="/web1/index.php?route=message/store" method="POST">
            <!-- Blog ID -->
            <div class="form-group">
                <label for="blog_id">Blog ID:</label>
                <input type="number" id="blog_id" name="blog_id" required>
            </div>
            <!-- Author -->
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required>
                <span class="error-message" id="authorError"></span>
            </div>
            <!-- Message -->
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" required></textarea>
                <span class="error-message" id="messageError"></span>
            </div>
            <!-- Created At -->
            <div class="form-group">
                <label for="created_at">Created At:</label>
                <input type="datetime-local" id="created_at" name="created_at" required>
            </div>
            <!-- Status -->
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Draft">Draft</option>
                    <option value="Published">Published</option>
                </select>
                <span class="error-message" id="statusError"></span>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn-submit">Create Message</button>
                <a href="index.php?route=message" class="btn-back">Back</a>
            </div>
        </form>
    </div>
    <!-- Include JavaScript -->
    <script src="../../public/js/form-validation.js"></script><!-- Include JavaScript -->
</body>
</html>
