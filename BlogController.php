<?php
include_once 'models/Blog.php';

class BlogController {
    private $blogModel;

    public function __construct($pdo) {
        $this->blogModel = new Blog($pdo);
    }

    public function index() {
        $blogs = $this->blogModel->getAll();
        include 'views/blog/show.php';
    }

    public function store() {
        // Check if form data is submitted via POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and get form input values
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $author = trim($_POST['author']);
            $createdAt = $_POST['created_at'];
            $status = $_POST['status'];

            // Call the model method to save the blog
            $this->blogModel->save($title, $content, $author, $createdAt, $status);

            // Redirect or show a success message (optional)
            header('Location: index.php'); // Redirect back to blog list
            exit();
        }
    }



}
?>
