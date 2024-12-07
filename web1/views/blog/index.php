<?php foreach ($blogs as $blog): ?>
    <div>
        <h2><?= htmlspecialchars($blog['title']) ?></h2>
        <p><?= htmlspecialchars($blog['content']) ?></p>
        <p><strong>Author:</strong> <?= htmlspecialchars($blog['author']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($blog['status']) ?></p>
        <a href="index.php?action=edit&id=<?= $blog['id'] ?>">Edit</a>
        <a href="index.php?action=delete&id=<?= $blog['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </div>
<?php endforeach; ?>