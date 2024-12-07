<?php
class Message {
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM message");
        return $stmt->fetchAll();
    }

    public function create($data)
    {
        $query = "INSERT INTO message (blog_id, author, message, created_at, status) 
                  VALUES (:blog_id, :author, :message, :created_at, :status)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':blog_id' => $data['blog_id'],
            ':author' => $data['author'],
            ':message' => $data['message'],
            ':created_at' => $data['created_at'],
            ':status' => $data['status'],
        ]);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM message WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function update($id, $blog_id, $author, $message, $status)
    {
        $query = "UPDATE message SET blog_id = :blog_id, author = :author, 
                  message = :message, status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':blog_id' => $blog_id,
            ':author' => $author,
            ':message' => $message,
            ':status' => $status,
            ':id' => $id,
        ]);
    }
    public function getAllSortedByDate($order = 'DESC') {
        $sql = "SELECT * FROM message ORDER BY created_at $order";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM message WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
