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
            echo "Error fetching actors: " . $e->getMessage();
            return null;
        }
    }

    public function deleteActor($id): bool {
        $success = $this->deleteSAGByActor($id);
        if(!$success) {
            return false;
        }
        try {
            $sql = "DELETE FROM sag_actor WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error deleting actors: " . $e->getMessage();
            return false;
        }
    }

    private function deleteSAGByActor($actor_id): bool {
        try {
            $sql = "DELETE FROM sag WHERE actor_id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $actor_id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error deleting actors: " . $e->getMessage();
            return false;
        }
    }
}