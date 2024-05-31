<?php
require_once BASE_PATH . "/app/models/Database.php";
class Actor extends DB {

    public function getActors(): array | null {
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

    public function getActorById($id): array | null {
        try {
            $sql = "SELECT * FROM sag_actor WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $actor = $stmt->fetch(PDO::FETCH_ASSOC);
            return $actor;
        } catch (PDOException $e) {
            echo "Error fetching actor: " . $e->getMessage();
            return null;
        }
    }

    public function getFavouriteActors($user_token): array | null {
        try {
            $sql = 'SELECT sag_actor.id AS actor_id, sag_actor.actor_name 
                FROM session 
                JOIN users ON session.id_user = users.id 
                JOIN user_fav_actor ON users.id = user_fav_actor.id_user 
                JOIN sag_actor ON user_fav_actor.id_actor = sag_actor.id 
                WHERE session.token = :session_token';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':session_token', $user_token, PDO::PARAM_STR);
        $stmt->execute();

        $sags = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sags;
        } catch (PDOException $e) {
            echo "Error fetching actors: " . $e->getMessage();
            return null;
        }
    }

    public function actorExists($actor): bool {
        try {
            $sql = "SELECT * FROM sag_actor WHERE LOWER(actor_name) = LOWER(:name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $actor, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function addActor($actor): bool {
        try {
            $sql = "INSERT INTO sag_actor (actor_name) VALUES (:name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $actor, PDO::PARAM_STR);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error adding actor: " . $e->getMessage();
            return false;
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
            return true;
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
            return true;
        } catch (PDOException $e) {
            echo "Error deleting actors: " . $e->getMessage();
            return false;
        }
    }
}