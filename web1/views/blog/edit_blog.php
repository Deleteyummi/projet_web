<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog | CultureHub</title>
    <link rel="stylesheet" href="../../style/style.css">
    <style>
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
            background-color: #007bff;
            color: white;
        }

        .btn-submit:hover {
            background-color: #0056b3;
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

    <!-- Edit Blog Form -->
    <div class="container">
        <h1>Edit Blog</h1>
        <form action="index.php?route=blog/update/<?= $blog['id']; ?>" method="POST">
            <!-- Title -->
            <div class="form-group">
                <label for="title">Blog Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($blog['title'] ?? ''); ?>" 
                       placeholder="Enter the blog title" required>
            </div>

            <!-- Content -->
            <div class="form-group">
                <label for="content">Blog Content</label>
                <textarea id="content" name="content" rows="6" 
                          placeholder="Write the blog content here..." required><?= htmlspecialchars($blog['content'] ?? ''); ?></textarea>
            </div>

            <!-- Author -->
            <div class="form-group">
                <label for="author">Author Name</label>
                <input type="text" id="author" name="author" value="<?= htmlspecialchars($blog['author'] ?? ''); ?>" 
                       placeholder="Enter the author's name" required>
            </div>

            <!-- Created At -->
            <div class="form-group">
                <label for="created_at">Created Date</label>
                <input type="date" id="created_at" name="created_at" value="<?= htmlspecialchars($blog['created_at'] ?? ''); ?>" required>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">Blog Status</label>
                <select id="status" name="status" required>
                    <option value="published" <?= isset($blog['status']) && $blog['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                    <option value="draft" <?= isset($blog['status']) && $blog['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="btn-group">
                <button type="submit" class="btn-submit">Update Blog</button>
                <a href="index.php?route=blog" class="btn-back">Back to Blog List</a>
            </div>
        </form>
    </div>
     <!-- Include JavaScript -->
     <script src="../../public/js/form-validation.js"></script>
</body>
</html>
