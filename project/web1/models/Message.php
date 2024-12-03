<?php
class Message {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Obtenir tous les messages
    public function getAll() {
        $query = 'SELECT * FROM message ORDER BY created_at DESC';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtenir un message par ID
    public function getById($id) {
        $query = 'SELECT * FROM message WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Sauvegarder un nouveau message
    public function save($blog_id, $author, $message, $created_at, $status) {
        try {
            $query = 'INSERT INTO message (blog_id, author, message, created_at, status) 
                      VALUES (:blog_id, :author, :message, :created_at, :status)';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':blog_id', $blog_id);
            $stmt->bindParam(':author', $author);
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':created_at', $created_at);
            $stmt->bindParam(':status', $status);
    
            // Debugging: Vérification avant d'exécuter la requête
            echo "Query: $query <br>";
            echo "Executing statement...<br>";
            
            $result = $stmt->execute();
    
            // Debugging: Vérifier si l'exécution a réussi
            if ($result) {
                echo "Data inserted successfully!";
            } else {
                echo "Failed to insert data.";
            }
            return $result;
        } catch (PDOException $e) {
            // Catch exception and output error message
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    // Mettre à jour un message
    public function update($id, $blog_id, $author, $message, $created_at, $status) {
        $query = 'UPDATE message SET blog_id = :blog_id, author = :author, message = :message, created_at = :created_at, status = :status WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':blog_id', $blog_id);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    // Supprimer un message
    public function delete($id) {
        $query = 'DELETE FROM message WHERE id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
