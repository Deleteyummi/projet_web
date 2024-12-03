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
        case 'message/create':
            $messageController->create();
            break;

        case 'message/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $messageController->store();
            } else {
                echo "Invalid request method.";
            }
            break;

        case 'message':
            $messageController->index();
            break;

        case (preg_match('/message\/update\/(\d+)/', $route, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $messageController->update($matches[1]);
            } else {
                echo "Invalid request method.";
            }
            break;

        // Routes pour les blogs
        case 'blog/create':
            $blogController->create();
            break;

        case 'blog/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $blogController->store();
            } else {
                echo "Invalid request method.";
            }
            break;

        case 'blog':
            $blogController->index();
            break;

        case 'blog/edit':
            if (isset($_GET['id'])) {
                $blogController->edit($_GET['id']);
            } else {
                echo "Blog ID missing.";
            }
            break;

        case (preg_match('/blog\/update\/(\d+)/', $route, $matches) ? true : false):
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $blogController->update($matches[1]);
            } else {
                echo "Invalid request method.";
            }
            break;

        case 'blog/delete':
            if (isset($_GET['id'])) {
                $blogController->delete($_GET['id']);
            } else {
                echo "Blog ID missing.";
            }
            break;

        default:
            echo "Page not found.";
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
