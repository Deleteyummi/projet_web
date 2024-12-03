<?php
require_once 'models/Message.php';
require_once 'models/Blog.php';

class MessageController {
    private $messageModel;
    private $blogModel;

    public function __construct($db) {
        $this->messageModel = new Message($db); // Instance du modèle Message
        $this->blogModel = new Blog($db); // Instance du modèle Blog
    }

    // Liste des messages
    public function index() {
        $messages = $this->messageModel->getAll(); // Récupérer tous les messages
        include 'view/message/index.php'; // Afficher la liste des messages
    }
    
    // Afficher le formulaire de création d'un message
    public function create() {
        $blogs = $this->blogModel->getAll(); // Récupérer tous les blogs
        include 'view/message/create_message.php'; // Afficher le formulaire
    }

    // Sauvegarder un nouveau message
    public function store() {
        $errors = [];
        require_once 'config/database.php'; // Charger la configuration de la base de données
        
        // Validation des champs
        if (empty($_POST['blog_id']) || !is_numeric($_POST['blog_id'])) {
            $errors[] = "Valid Blog ID is required.";
        } else {
            // Vérification que le blog existe dans la base de données
            $blog_id = $_POST['blog_id'];
            $blogQuery = "SELECT * FROM blog WHERE id = ?";
            $stmt = $db->prepare($blogQuery);
            $stmt->execute([$blog_id]);
            if ($stmt->rowCount() == 0) {
                $errors[] = "Blog ID does not exist.";
            }
        }
        
        if (empty($_POST['author'])) {
            $errors[] = "Author is required.";
        }
        if (empty($_POST['message'])) {
            $errors[] = "Message cannot be empty.";
        }
        
        // Debugging: Affichage des données reçues
        echo '<pre>';
        var_dump($_POST);
        echo '</pre>';
        
        // Si des erreurs existent, afficher le formulaire avec les erreurs
        if (!empty($errors)) {
            include 'view/message/create_message.php'; // Afficher le formulaire avec les erreurs
        } else {
            // Utilisation de la méthode save() pour enregistrer le message
            $blog_id = $_POST['blog_id'];
            $author = $_POST['author'];
            $message = $_POST['message'];
            $created_at = date('Y-m-d H:i:s');
            $status = $_POST['status'];
    
            // Debugging: Vérifier si les données arrivent bien ici
            echo "Data received for insert: <br>";
            var_dump($blog_id, $author, $message, $status);
    
            if ($this->messageModel->save($blog_id, $author, $message, $created_at, $status)) {
                header('Location: index.php?route=message');
                exit();
            } else {
                die('Error: Failed to insert message');
            }
        }
    }
    
    
    // Modifier un message existant
    public function edit($id) {
        $message = $this->messageModel->getById($id); // Obtenir un message par ID
        $blogs = $this->blogModel->getAll(); // Obtenir tous les blogs
        include 'view/message/edit_message.php'; // Afficher le formulaire de modification
    }

    // Mettre à jour un message
    public function update($id) {
        $data = [
            'blog_id' => $_POST['blog_id'],
            'author' => $_POST['author'],
            'message' => $_POST['message'],
            'status' => $_POST['status']
        ];
        $this->messageModel->update($id, $data['blog_id'], $data['author'], $data['message'], date('Y-m-d H:i:s'), $data['status']);
        header('Location: /message'); // Redirection vers la liste des messages
    }

    // Supprimer un message
    public function delete($id) {
        $this->messageModel->delete($id); // Supprimer le message
        header('Location: /message'); // Redirection vers la liste des messages
    }
}
