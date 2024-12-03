<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog List</title>
    <link rel="stylesheet" href="public/css/style.css">
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

    <style>
        
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        .btn-create {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn-create:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table thead {
            background-color: #007bff;
            color: white;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .btn-action {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
        }
        .btn-action:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Blog List</h1>
    <a href="index.php?route=blog/create" class="btn-create">Create Blog</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blogs as $blog): ?>
                <tr>
                    <td><?= $blog['id']; ?></td>
                    <td><?= htmlspecialchars($blog['title']); ?></td>
                    <td><?= htmlspecialchars($blog['author']); ?></td>
                    <td><?= htmlspecialchars($blog['status']); ?></td>
                    <td><?= htmlspecialchars($blog['created_at']); ?></td>
                    <td>
                        <a href="index.php?route=blog/edit&id=<?= $blog['id']; ?>" class="btn-action">Edit</a>
                        <a href="index.php?route=blog/delete&id=<?= $blog['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Delete this blog?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
