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
            display: block;
        }
        /* General Page Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        /* Container for the form */
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Form Title */
        .container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        /* Form Groups */
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

        /* Buttons */
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .btn-submit,
            .btn-back {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
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
    <div class="container mt-5">
        <h1 class="mb-4">Create a New Message</h1>
        <form id="createMessageForm" action="index.php?route=message/store" method="POST" class="shadow p-4 rounded bg-light">
            <!-- Blog ID -->
            <div class="form-group">
                <label for="blog_id">Blog ID:</label>
                <input type="text" id="blog_id" name="blog_id" class="form-control" required>
                <span id="blogIdError" class="error-message"></span>
            </div>

            <!-- Author -->
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" id="author" name="author" class="form-control" required>
                <span id="authorError" class="error-message"></span>
            </div>

            <!-- Message -->
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" class="form-control" required></textarea>
                <span id="messageError" class="error-message"></span>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="Draft">Draft</option>
                    <option value="Published">Published</option>
                </select>
                <span id="statusError" class="error-message"></span>
            </div>

            <!-- Submit Button -->
            <div class="btn-group">
                <button type="submit" class="btn-submit">Submit</button>
                <a href="index.php" class="btn-back">Back</a>
            </div>
        </form>
    </div>

    <!-- JavaScript Validation -->
    <script>
        document.getElementById('createMessageForm').addEventListener('submit', function(event) {
            let isValid = true;
            // Reset error messages
            document.querySelectorAll('.error-message').forEach(function(el) {
                el.textContent = '';
            });

            // Blog ID Validation
            const blogId = document.getElementById('blog_id').value;
            if (!blogId || isNaN(blogId) || blogId <= 0) {
                document.getElementById('blogIdError').textContent = 'Please enter a valid Blog ID.';
                isValid = false;
            }

            // Author Validation
            const author = document.getElementById('author').value;
            if (author.length < 3) {
                document.getElementById('authorError').textContent = 'Author name must be at least 3 characters long.';
                isValid = false;
            }

            // Message Validation
            const message = document.getElementById('message').value;
            if (message.trim().length < 10) {
                document.getElementById('messageError').textContent = 'Message must be at least 10 characters long.';
                isValid = false;
            }

            // Status Validation
            const status = document.getElementById('status').value;
            if (!status) {
                document.getElementById('statusError').textContent = 'Please select a status.';
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
