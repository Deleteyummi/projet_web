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
        $blogs = $this->blogModel->getAllBlogs();
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

    // Gestion de l'upload de fichier
    $media = ''; // Variable pour stocker le chemin du fichier

    if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
        // Vérification du type de fichier (image/vidéo)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi', 'mov'];
        $fileExtension = pathinfo($_FILES['media']['name'], PATHINFO_EXTENSION);

        if (in_array(strtolower($fileExtension), $allowedExtensions)) {
            // Dossier de téléchargement
            $uploadDir = 'uploads/';
            $media = uniqid() . '.' . $fileExtension; // Générer un nom unique pour éviter les conflits
            $uploadPath = $uploadDir . $media;

            // Déplacement du fichier vers le dossier de téléchargement
            if (move_uploaded_file($_FILES['media']['tmp_name'], $uploadPath)) {
                // Succès du téléchargement
                error_log("File uploaded successfully.");
            } else {
                // Échec du téléchargement
                echo "Error uploading the file.";
                return;
            }
        } else {
            // Type de fichier non autorisé
            echo "Invalid file type.";
            return;
        }
    }

    // Insertion des données dans la base de données
    try {
        // Préparation de la requête SQL
        $stmt = $this->pdo->prepare("INSERT INTO blog (title, content, author, created_at, status, media) VALUES (:title, :content, :author, :created_at, :status, :media)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':created_at', $createdAt);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':media', $media); // Bind le chemin du fichier

        // Log de la tentative d'exécution de la requête
        error_log("Attempting to execute the query.");

        // Exécution de la requête
        if ($stmt->execute()) {
            // Redirection vers la liste des blogs après succès
            error_log("Blog created successfully.");
            header("Location: index.php?route=blog");
            exit;
        } else {
            // Échec de l'exécution de la requête
            error_log("Failed to execute the query.");
            echo "Failed to create the blog.";
        }
    } catch (PDOException $e) {
        // Log de l'erreur en cas de problème avec la base de données
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
