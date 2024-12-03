<?php
include_once 'models/Blog.php';

class BlogController {
    private $blogModel;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->blogModel = new Blog($pdo);
    }

    public function index() {
        $blogs = $this->blogModel->getAll();
        include 'views/blog/show.php';
    }

    public function create() {
        include 'views/blog/create_blog.php';
    }

    public function store()
    {
        // Vérification que toutes les données nécessaires sont fournies
        if (!isset($_POST['title'], $_POST['content'], $_POST['author'], $_POST['created_at'], $_POST['status'])) {
            echo "All fields are required.";
            return;
        }
    
        // Récupération des données du formulaire
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_POST['author'];
        $createdAt = $_POST['created_at'];
        $status = $_POST['status'];
    
        // Validation de base
        if (empty($title) || empty($content) || empty($author) || empty($createdAt) || empty($status)) {
            echo "Please fill all the fields.";
            return;
        }
    
        try {
            // Préparation de la requête SQL
            $stmt = $this->pdo->prepare("INSERT INTO blog (title, content, author, created_at, status) VALUES (:title, :content, :author, :created_at, :status)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':created_at', $createdAt);
            $stmt->bindParam(':status', $status);
    
            // Ajout de journal pour vérifier la requête
            error_log("Attempting to execute the query.");
    
            // Exécution de la requête
            if ($stmt->execute()) {
                // Redirection vers la liste des blogs
                error_log("Blog created successfully.");
                header("Location: index.php?route=blog");
                exit;
            } else {
                error_log("Failed to execute the query.");
                echo "Failed to create the blog.";
            }
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            echo "Error: " . $e->getMessage();
        }
    }
    
    

    public function edit($id) {
        $blog = $this->blogModel->getById($id);
        if (!$blog) {
            die('Blog not found!');
        }
        include 'views/blog/edit_blog.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $author = trim($_POST['author']);
            $status = $_POST['status'];

            $updated = $this->blogModel->update($id, $title, $content, $author, $status);
            if ($updated) {
                header('Location: index.php?route=blog');
                exit();
            } else {
                echo "Failed to update blog.";
            }
        }
    }

    public function delete($id) {
        $deleted = $this->blogModel->delete($id);
        if ($deleted) {
            header('Location: index.php?route=blog');
            exit();
        } else {
            echo "Failed to delete blog.";
        }
    }
}
?>
