<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "culture");

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer l'ID du blog depuis l'URL
$blog_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Vérifier si un ID est passé et récupérer les détails du blog
if ($blog_id > 0) {
    $sql = "SELECT * FROM blog WHERE id = $blog_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $blog = $result->fetch_assoc();
    } else {
        echo "<p>Blog non trouvé.</p>";
    }
} else {
    echo "<p>ID invalide.</p>";
}

// Fermer la connexion
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Blog</title>
    <link rel="stylesheet" href="../../style/front.css">
    <style>
        /* Style pour la page des détails du blog */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .content {
            margin-top: 100px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        h2 {
            font-size: 2.5em;
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
        }
        .blog-details {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .blog-details img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .blog-details video {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .back-btn {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<!-- Content -->
<div class="content">
    <?php if (isset($blog)): ?>
        <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
        <div class="blog-details">
            <p><strong>Auteur:</strong> <?php echo htmlspecialchars($blog['author']); ?></p>
            <p><strong>Date de création:</strong> <?php echo date("d/m/Y", strtotime($blog['created_at'])); ?></p>
            <p><strong>Statut:</strong> <?php echo ucfirst(htmlspecialchars($blog['status'])); ?></p>
            <p><strong>Contenu:</strong> <?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>

            <!-- Affichage du média -->
            <?php if (!empty($blog['media'])): ?>
    <?php
    // Définir le chemin complet du média
    $mediaPath = '/web1/public/uploads/' . htmlspecialchars($blog['media']);
    $mediaType = pathinfo($mediaPath, PATHINFO_EXTENSION);

    // Vérification si le fichier existe
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $mediaPath)) {
        if (in_array($mediaType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<img src='$mediaPath' alt='Blog Media'>";
        } elseif (in_array($mediaType, ['mp4', 'avi', 'mov'])) {
            echo "<video controls><source src='$mediaPath' type='video/" . $mediaType . "'></video>";
        } else {
            echo "<p>Type de média non pris en charge.</p>";
        }
    } else {
        echo "<p>Le fichier média n'existe pas.</p>";
    }
    ?>
<?php else: ?>
    <p>Aucun média associé.</p>
<?php endif; ?>

        </div>
    <?php endif; ?>

    <a href="home.php" class="back-btn">Retour à la liste</a>
</div>

</body>
</html>
