<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion des fichiers nécessaires
require_once 'config/database.php';
require_once 'controllers/MessageController.php';
require_once 'controllers/BlogController.php';

try {
    // Initialisation de la connexion à la base de données
    $db = getDb(); // Connexion via la fonction getDb()
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Récupération de l'URL de la route
$route = isset($_GET['route']) ? $_GET['route'] : '';

// Instanciation des contrôleurs
$messageController = new MessageController($db);
$blogController = new BlogController($db);

// Gestion des routes
try {
    switch ($route) {
        // Routes pour les messages
        case 'message':
            $messageController->index();
            break;
        case 'message/sortByDate':
            $messageController->sortByDate();
            break;
            

        case 'message/create':
            $messageController->create();
            break;

        case 'message/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $messageController->store();
            } else {
                echo "Méthode de requête invalide.";
            }
            break;

        case 'message/edit':
            if (isset($_GET['id'])) {
                $messageController->edit((int)$_GET['id']);
            } else {
                echo "L'identifiant du message est manquant.";
            }
            break;

        case 'message/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
                $messageController->update((int)$_GET['id']);
            } else {
                echo "Requête invalide ou identifiant manquant.";
            }
            break;

        case 'message/delete':
            if (isset($_GET['id'])) {
                $messageController->delete((int)$_GET['id']);
            } else {
                echo "L'identifiant du message est manquant.";
            }
            break;

        // Routes pour les blogs
        case 'blog':
            $blogController->index();
            break;

        case 'blog/create':
            $blogController->create();
            break;

        case 'blog/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $blogController->store();
            } else {
                echo "Méthode de requête invalide.";
            }
            break;

        case 'blog/edit':
            if (isset($_GET['id'])) {
                $blogController->edit((int)$_GET['id']);
            } else {
                echo "L'identifiant du blog est manquant.";
            }
            break;

        case 'blog/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
                $blogController->update((int)$_GET['id']);
            } else {
                echo "Requête invalide ou identifiant manquant.";
            }
            break;

        case 'blog/delete':
            if (isset($_GET['id'])) {
                $blogController->delete((int)$_GET['id']);
            } else {
                echo "L'identifiant du blog est manquant.";
            }
            break;

        default:
            echo "Page non trouvée.";
    }
} catch (Exception $e) {
    echo "Une erreur est survenue : " . htmlspecialchars($e->getMessage());
}
