<?php
require_once 'models/Message.php'; // Assurez-vous que ce chemin est correct

class MessageController {
    private $messageModel;

    public function __construct($db)
    {
        // Injectez la connexion à la base de données dans le modèle
        $this->messageModel = new Message($db);
    }

    public function index() {
        // Récupérer tous les messages
        $messages = $this->messageModel->getAll();
    
        // Inclure le fichier de vue
        $viewPath = __DIR__ . '/../view/Message/index.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            die("Vue introuvable : $viewPath");
        }
    }
    

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $author = $_POST['author'] ?? null;
            $message = $_POST['message'] ?? null;
            $blog_id = $_POST['blog_id'] ?? null;

            // Valider les données
            if ($author && $message && $blog_id) {
                $success = $this->messageModel->create([
                    'blog_id' => $blog_id,
                    'author' => $author,
                    'message' => $message,
                    'created_at' => date('Y-m-d H:i:s'),
                    'status' => 'draft', // Ou tout autre statut par défaut
                ]);

                if ($success) {
                    // Redirection après création réussie
                    header('Location: /web1/index.php?route=message');
                    exit;
                } else {
                    echo "Erreur lors de l'enregistrement du message.";
                }
            } else {
                echo "Tous les champs sont requis.";
            }
        }
    }

    public function edit($id) {
        $message = $this->messageModel->getById($id);
        if (!$message) {
            die('Message not found!');
        }
        include __DIR__ . '/../view/Message/edit_message.php'; // Corriger le chemin ici
    }
    public function sortByDate() {
        $order = isset($_GET['order']) && $_GET['order'] === 'ASC' ? 'ASC' : 'DESC'; // Vérifier l'ordre de tri
        $messages = $this->messageModel->getAllSortedByDate($order);
        include __DIR__ . '/../view/Message/index.php'; // Charger la vue
    }
    
    

    
    public function delete($id) {
        if ($this->messageModel->delete($id)) {
            // Redirection après suppression réussie
            header('Location: /web1/index.php?route=message');
            exit;
        } else {
            echo "Erreur lors de la suppression du message.";
        }
    }
}

