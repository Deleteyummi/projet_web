<?php
class Blog {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function save($title, $content, $author, $createdAt, $status) {
        try {
            $sql = "INSERT INTO blog (title, content, author, created_at, status) 
                    VALUES (:title, :content, :author, :created_at, :status)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':created_at', $createdAt);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function getAll() {
        $sql = "SELECT * FROM blog ORDER BY created_at DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM blog WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $title, $content, $author, $status) {
        try {
            $sql = "UPDATE blog SET title = :title, content = :content, author = :author, status = :status WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':status', $status);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            return false;
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM blog WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . htmlspecialchars($e->getMessage());
            return false;
        }
    }
}
?>
