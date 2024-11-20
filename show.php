<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #4CAF50;
        }

        ul {
            list-style-type: none;
            padding: 0;
            max-width: 900px;
            margin: 20px auto;
        }

        li {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 24px;
            margin: 0;
            color: #333;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin-top: 10px;
            color: #555;
        }

        em {
            font-style: italic;
            color: #888;
        }

        .no-blogs {
            text-align: center;
            font-size: 18px;
            color: #777;
            padding: 20px;
        }

        /* Button Styles */
        .create-blog-btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
            margin: 20px auto;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .create-blog-btn:hover {
            background-color: #45a049;
        }

        /* Add hover effect on list items */
        li:hover {
            background-color: #f1f1f1;
            border-color: #ccc;
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body>
    <h1>All Blogs</h1>

    <!-- Create Blog Button -->
    <div style="text-align: center;">
        <a href="views/blog/create_blog.php" class="create-blog-btn">Create Blog</a>
    </div>

    <?php if (count($blogs) > 0): ?>
        <ul>
            <?php foreach ($blogs as $blog): ?>
                <li>
                    <h2><a href="show.php?id=<?php echo $blog['id']; ?>"><?php echo htmlspecialchars($blog['title']); ?></a></h2>
                    <p><?php echo htmlspecialchars($blog['content']); ?></p>
                    <p><em>Posted on <?php echo $blog['created_at']; ?></em></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="no-blogs">No blogs available.</p>
    <?php endif; ?>
</body>
</html>
