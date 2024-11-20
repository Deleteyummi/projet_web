<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        h1, h2 {
            text-align: center;
            margin-top: 30px;
            color: #4CAF50;
        }

        .form-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        form label {
            font-size: 16px;
            margin-top: 10px;
            color: #333;
            display: block;
        }

        form input, form textarea, form select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #e74c3c;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

    <h1>Create a New Blog</h1>
    <div class="form-container">
        <form action="../../index.php?action=store" method="POST">
            <label for="title">Blog Title</label>
            <input type="text" name="title" id="title" required>

            <label for="content">Content</label>
            <textarea name="content" id="content" rows="6" required></textarea>

            <label for="author">Author</label>
            <input type="text" name="author" id="author" required>

            <label for="created_at">Created At</label>
            <input type="date" name="created_at" id="created_at" required>

            <label for="status">Status</label>
            <select name="status" id="status">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>

            <button type="submit">Submit</button>
        </form>
    </div>

    <h2>Update Blog</h2>
    <div class="form-container">
        <form action="../../index.php?action=update" method="POST">
            <!-- Assume 'id' will be provided as a hidden input -->
            <input type="hidden" name="id" value="<!-- Blog ID here -->">

            <label for="update_title">Blog Title</label>
            <input type="text" name="title" id="update_title" value="<!-- Existing title -->" required>

            <label for="update_content">Content</label>
            <textarea name="content" id="update_content" rows="6" required><!-- Existing content --></textarea>

            <label for="update_author">Author</label>
            <input type="text" name="author" id="update_author" value="<!-- Existing author -->" required>

            <label for="update_created_at">Created At</label>
            <input type="date" name="created_at" id="update_created_at" value="<!-- Existing date -->" required>

            <label for="update_status">Status</label>
            <select name="status" id="update_status">
                <option value="draft" <!-- Add "selected" if draft --> >Draft</option>
                <option value="published" <!-- Add "selected" if published --> >Published</option>
            </select>

            <button type="submit">Update</button>
        </form>
    </div>

    <h2>Delete Blog</h2>
    <div class="form-container">
        <form action="../../index.php?action=delete" method="POST">
            <!-- Assume 'id' will be provided as a hidden input -->
            <input type="hidden" name="id" value="<!-- Blog ID here -->">

            <p>Are you sure you want to delete this blog?</p>
            <button type="submit" class="delete-btn">Delete</button>
        </form>
    </div>

</body>
</html>
