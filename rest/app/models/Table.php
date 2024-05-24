<?php
require_once BASE_PATH . "/app/models/Database.php";
class Table extends DB {

    public function getSAGs() {
        try {
            $sql = 'SELECT s.id, s.year_of_competition as "year", sc.category_name as "category", sa.actor_name as "actor", sh.show_name as "show", s.result FROM sag s JOIN sag_category sc ON s.category_id = sc.id JOIN sag_actor sa ON s.actor_id = sa.id JOIN sag_show sh ON s.show_id = sh.id ORDER BY s.year_of_competition DESC, sc.category_name ASC';
            $stmt = $this->pdo->query($sql);
            $sags = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $sags;
        } catch (PDOException $e) {
            echo "Error fetching users: " . $e->getMessage();
            return null;
        }
    }

    public function getCategoryIdByName($name): int {
        try {
            $sql = "SELECT * FROM sag_category WHERE category_name = :category_name";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':category_name', $name, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data["id"];
            } else {
                return -2;
            }
        } catch (PDOException $e) {
            echo "Error fetching category: " . $e->getMessage();
            return -2;
        }
    }

    public function addCategory($name): int {
        try {
            $sql = "INSERT INTO sag_category (category_name) VALUES (:category_name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':category_name', $name, PDO::PARAM_STR);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error adding category: " . $e->getMessage();
            return -2;
        }
    }

    public function getActorIdByName($name): int {
        try {
            $sql = "SELECT * FROM sag_actor WHERE actor_name = :actor_name";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':actor_name', $name, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data["id"];
            } else {
                return -2;
            }
        } catch (PDOException $e) {
            echo "Error fetching actor: " . $e->getMessage();
            return -2;
        }
    }

    public function addActor($name) {
        try {
            $sql = "INSERT INTO sag_actor (actor_name) VALUES (:actor_name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':actor_name', $name, PDO::PARAM_STR);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error adding actor: " . $e->getMessage();
            return -2;
        }
    }

    public function getShowIdByName($name): int {
        try {
            $sql = "SELECT * FROM sag_show WHERE show_name = :show_name";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':show_name', $name, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data["id"];
            } else {
                return -2;
            }
        } catch (PDOException $e) {
            echo "Error fetching show: " . $e->getMessage();
            return -2;
        }
    }

    public function addShow($name): int {
        try {
            $sql = "INSERT INTO sag_show (show_name) VALUES (:show_name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':show_name', $name, PDO::PARAM_STR);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error adding show: " . $e->getMessage();
            return -2;
        }
    }

    public function addSAG($year, $category_id, $actor_id, $show_id, $result): int {
        try {
            $sql = "INSERT INTO sag (year_of_competition, category_id, actor_id, show_id, result) VALUES (:year_of_competition, :category_id, :actor_id, :show_id, :result)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':year_of_competition', $year, PDO::PARAM_INT);
            $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt->bindParam(':actor_id', $actor_id, PDO::PARAM_INT);
            $stmt->bindParam(':show_id', $show_id, PDO::PARAM_INT);
            $stmt->bindParam(':result', $result, PDO::PARAM_STR);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error adding SAG entry: " . $e->getMessage();
            return -1;
        }
    }

    public function deleteSAGById($id): bool {
        try {
            $sql = "DELETE FROM sag WHERE id = :id";
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

    public function deleteSAG(): bool {
        try {
            $sql = file_get_contents(BASE_PATH . "/sql_scripts/sag.sql");
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error deleting actors: " . $e->getMessage();
            return false;
        }
    }
}