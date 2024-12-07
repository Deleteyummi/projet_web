<?php
// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "culture"); // Remplacez par vos informations de connexion

// Vérifiez la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupération des données du blog
$sql = "SELECT id, title, author, created_at, status, media FROM blog";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Blogs</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Réinitialisation des marges et du padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Styles pour la barre de navigation */
        .navbar {
            background-color: #2c3e50;
            padding: 15px;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar__container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar__logo {
            font-size: 1.5em;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
        }

        .navbar__menu {
            list-style-type: none;
            display: flex;
            padding: 0;
        }

        .navbar__item {
            margin-right: 20px;
        }

        .navbar__links {
            color: #fff;
            text-decoration: none;
            font-size: 1.1em;
        }

        .navbar__btn .button {
            background-color: #e74c3c;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .navbar__btn .button:hover {
            background-color: #c0392b;
        }

        /* Styles pour le corps de la page */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            padding: 20px;
        }

        header {
            text-align: center;
            margin-bottom: 40px;
        }

        header h1 {
            font-size: 2.5em;
            color: #333;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .table-container {
            max-width: 1200px;
            margin: 0 auto;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: #fff;
            font-size: 1.1em;
        }

        td {
            font-size: 1em;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Style des médias */
        img {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }

        video {
            max-width: 100px;
            max-height: 100px;
        }

        .no-data {
            text-align: center;
            color: #7f8c8d;
            font-size: 1.2em;
        }

        .btn {
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .no-data {
            text-align: center;
            color: #7f8c8d;
            font-size: 1.2em;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-buttons .btn-danger {
            background-color: #e74c3c;
        }

        .action-buttons .btn-danger:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<!-- Barre de navigation -->
<nav class="navbar">  
    <div class="navbar__container">
        <a href="admin_page.php" id="navbar__logo">Admin Panel</a>
        <ul class="navbar__menu">
            <li class="navbar__item"><a href="admin_page.php" class="navbar__links">Home</a></li>
            <li class="navbar__item"><a href="admin_products.php" class="navbar__links">Products</a></li>
            <li class="navbar__item"><a href="admin_users.php" class="navbar__links">Users</a></li>
            <li class="navbar__item"><a href="login_chart.php" class="navbar__links">Logins</a></li>
            <li class="navbar__item"><a href="admin_profile.php" class="navbar__links">Profile</a></li>
            <li class="navbar__btn"><a href="login.php" class="button">Logout</a></li>
        </ul>
    </div>
</nav>

<header>
    <h1>Liste des Blogs</h1>
    <p>Voici les blogs disponibles dans notre base de données</p>
</header>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Date de Création</th>
                <th>Statut</th>
                <th>Média</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Affichage des données dans le tableau
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["author"] . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row["created_at"])) . "</td>";
                    echo "<td>" . ucfirst($row["status"]) . "</td>";
                    if ($row["media"]) {
                        $mediaType = pathinfo($row["media"], PATHINFO_EXTENSION);
                        if (in_array($mediaType, ['jpg', 'jpeg', 'png', 'gif'])) {
                            echo "<td><img src='" . $row["media"] . "' alt='Blog Media'></td>";
                        } elseif (in_array($mediaType, ['mp4', 'avi', 'mov'])) {
                            echo "<td><video width='100' controls><source src='" . $row["media"] . "' type='video/" . $mediaType . "'></video></td>";
                        }
                    } else {
                        echo "<td>No media</td>";
                    }

                    echo "<td class='action-buttons'>
        <a href='/web1/frontOffice.php' class='btn'>Show</a>
        <a href='/web1/views/blog/edit_blog.php' class='btn'>Modifier</a>
        <a href='./' class='btn btn-danger' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce blog ?\");'>Supprimer</a>
      </td>";
echo "</tr>";

                }
            } else {
                echo "<tr><td colspan='7' class='no-data'>Aucun blog trouvé.</td></tr>";
            }

            // Fermeture de la connexion
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
