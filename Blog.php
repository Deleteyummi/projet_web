<?php
class Blog {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $sql = "SELECT * FROM blog ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save($title, $content, $author, $createdAt, $status) {
        $sql = "INSERT INTO blog (title, content, author, created_at, status) 
                VALUES (:title, :content, :author, :created_at, :status)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':created_at', $createdAt);
        $stmt->bindParam(':status', $status);

        $stmt->execute();
    }


}
?>
