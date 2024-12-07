<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "culture");

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer tous les blogs
$sql = "SELECT id, title, author, created_at, status, content, media FROM blog";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails des Blogs</title>
    <link rel="stylesheet" href="../../style/front.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-size: 1.8em;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .navbar {
            display: flex;
            gap: 15px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 1em;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .navbar a:hover {
            background-color: #34495e;
        }

        .icons {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .icons a {
            color: white;
            font-size: 1.5em;
            text-decoration: none;
        }

        /* Content Section */
        .content {
            margin-top: 100px; /* To avoid the header overlapping the content */
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            font-size: 3em; /* Augmenter la taille de la police */
            color: #2c3e50;
            margin-bottom: 40px; /* Ajouter plus d'espace sous le titre */
            text-align: center; /* Centrer le titre */
            font-weight: bold;
            letter-spacing: 2px; /* Espacement des lettres pour un effet moderne */
        }

        /* Blog Container */
        .blog-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); /* Responsive grid */
            gap: 20px;
            padding-top: 20px;
        }

        .blog-item {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .blog-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .blog-item h3 {
            font-size: 2em;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .blog-item p {
            font-size: 1.1em;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .media-container {
            margin-top: 20px;
        }

        img, video {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        /* Button */
        .btn {
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<!-- Header -->
<header>
    <div class="header-content">
        <a href="home.php" class="logo">CultureHub <i class="fa-solid fa-globe"></i></a>
        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="shop.php">Shop</a>
            <a href="orders.php">Orders</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
    </div>
</header>

<!-- Content Section -->
<div class="content">
    <h1>Tous les Blogs</h1>

    <div class="blog-container">
    <?php
    if ($blog['media']) {
        $mediaPath = realpath($blog['media']);
        echo "Chemin absolu de l'image: " . $mediaPath;
        if ($mediaPath && file_exists($mediaPath)) {
            $mediaType = pathinfo($mediaPath, PATHINFO_EXTENSION);
            if (in_array($mediaType, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "<img src='" . htmlspecialchars($blog['media']) . "' alt='Blog Media'>";
            } elseif (in_array($mediaType, ['mp4', 'avi', 'mov'])) {
                echo "<video controls><source src='" . htmlspecialchars($blog['media']) . "' type='video/" . $mediaType . "'></video>";
            }
        } else {
            echo "<p>L'image/vidéo n'est pas disponible.</p>";
        }
    }
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='blog-item'>";
            // Ajout du lien pour accéder aux détails du blog
            echo "<h3><a href='blog_details.php?id=" . $row['id'] . "'>" . htmlspecialchars($row['title']) . "</a></h3>";
            echo "<p><strong>Auteur:</strong> " . htmlspecialchars($row['author']) . "</p>";
            echo "<p><strong>Date de création:</strong> " . date("d/m/Y", strtotime($row['created_at'])) . "</p>";
            echo "<p><strong>Statut:</strong> " . ucfirst(htmlspecialchars($row['status'])) . "</p>";
            echo "<p><strong>Contenu:</strong> " . nl2br(htmlspecialchars($row['content'])) . "</p>";

            // Affichage de l'image directement dans la liste des blogs
            echo "<div class='media-container'>";
            if ($row['media']) {
                $mediaType = pathinfo($row['media'], PATHINFO_EXTENSION);
                if (in_array($mediaType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "<img src='" . htmlspecialchars($row['media']) . "' alt='Blog Media'>";
                } elseif (in_array($mediaType, ['mp4', 'avi', 'mov'])) {
                    echo "<video controls><source src='" . htmlspecialchars($row['media']) . "' type='video/" . $mediaType . "'></video>";
                }
            }
            echo "</div>"; // Close media-container
            echo "</div>"; // Close blog-item
        }
    } else {
        echo "<p>Aucun blog trouvé.</p>";
    }
        // Close database connection
        $conn->close();
        ?>
    </div>

    <a href="admin_page.php" class="btn">Retour à la liste</a>
</div>

</body>
</html>

