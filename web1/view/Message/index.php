<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Messages</title>
    <link rel="stylesheet" href="/web1/style/style.css">
    <style>
        /* Styling de la page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            color: #333;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-buttons a {
            text-decoration: none;
            padding: 5px 10px;
            margin: 0 5px;
            border-radius: 4px;
            color: white;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .action-buttons a.edit {
            background-color: #007BFF;
        }

        .action-buttons a.edit:hover {
            background-color: #0056b3;
        }

        .action-buttons a.delete {
            background-color: #DC3545;
        }

        .action-buttons a.delete:hover {
            background-color: #b21f2d;
        }

        /* Bouton pour ajouter un message */
        .btn-add {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .btn-add:hover {
            background-color: #45a049;
        }

        /* Boutons pour le tri */
        .sort-buttons {
            margin-bottom: 20px;
            text-align: center;
        }

        .sort-buttons a {
            text-decoration: none;
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            margin: 0 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .sort-buttons a:hover {
            background-color: #45a049;
        }

        /* Pagination */
        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            text-decoration: none;
            padding: 8px 15px;
            margin: 0 5px;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            font-size: 14px;
        }

        .pagination a:hover {
            background-color: #45a049;
        }

        .pagination a.disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h1>Liste des Messages</h1>

    <!-- Boutons pour trier les messages -->
    <div class="sort-buttons">
        <a href="/web1/index.php?route=message/sortByDate&order=ASC">Trier par date (croissant)</a>
        <a href="/web1/index.php?route=message/sortByDate&order=DESC">Trier par date (décroissant)</a>
    </div>

    <!-- Bouton pour ajouter un message -->
    <a href="/web1/index.php?route=message/create" class="btn-add">Ajouter un Message</a>

    <!-- Table des messages -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Blog ID</th>
                <th>Auteur</th>
                <th>Message</th>
                <th>Date de Création</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($messages)) : ?>
                <?php foreach ($messages as $message) : ?>
                    <tr>
                        <td><?= htmlspecialchars($message['id']) ?></td>
                        <td><?= htmlspecialchars($message['blog_id']) ?></td>
                        <td><?= htmlspecialchars($message['author']) ?></td>
                        <td><?= htmlspecialchars($message['message']) ?></td>
                        <td><?= htmlspecialchars($message['created_at']) ?></td>
                        <td><?= htmlspecialchars($message['status']) ?></td>
                        <td class="action-buttons">
                            <a href="/web1/index.php?route=message/edit&id=<?= $message['id'] ?>" class="edit">Modifier</a>
                            <a href="/web1/index.php?route=message/delete&id=<?= $message['id'] ?>" class="delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7" style="text-align: center; color: #888;">Aucun message trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Pagination (si applicable) -->
    <div class="pagination">
        <?php if (isset($pagination)) : ?>
            <a href="?route=message&page=<?= $pagination['previous'] ?>" class="<?= $pagination['previous'] ? '' : 'disabled' ?>">Précédent</a>
            <a href="?route=message&page=<?= $pagination['next'] ?>" class="<?= $pagination['next'] ? '' : 'disabled' ?>">Suivant</a>
        <?php endif; ?>
    </div>
</body>
</html>
