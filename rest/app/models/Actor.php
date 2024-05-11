<?php
require_once BASE_PATH . "/app/models/Database.php";
class Actor extends DB {

    public function getActors() {
        try {
            $sql = 'SELECT * FROM sag_actor WHERE id <> -1';
            $stmt = $this->pdo->query($sql);
            $sags = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $sags;
        } catch (PDOException $e) {
            echo "Error fetching users: " . $e->getMessage();
            return null;
        }
    }
}