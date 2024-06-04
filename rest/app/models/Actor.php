<?php
require_once BASE_PATH . "/app/models/Database.php";
class Actor extends DB {

    public function getActors(): array | null {
        try {
            $sql = 'SELECT * FROM sag_actor WHERE id <> -1 ORDER BY actor_name';
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

    public function addFavouriteActor($id_user, $id_actor) {
        try {
            $sql = "INSERT INTO user_fav_actor (id_user, id_actor) VALUES (:id_user, :id_actor)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_STR);
            $stmt->bindParam(':id_actor', $id_actor, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
            return false;
        }
    }

    public function deleteFavouriteActor($id_user, $id_actor) {
        try {
            $sql = "DELETE FROM user_fav_actor WHERE id_user = :id_user AND id_actor = :id_actor";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_STR);
            $stmt->bindParam(':id_actor', $id_actor, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
            return false;
        }
    }

    public function checkIfActorFavourite($user_token, $actor_id): bool {
        try {
            $sql = "SELECT
                        CASE
                            WHEN ufa.id_actor IS NOT NULL THEN 'Yes'
                            ELSE 'No'
                        END AS is_favorite
                    FROM
                        session s
                    LEFT JOIN
                        user_fav_actor ufa ON s.id_user = ufa.id_user AND ufa.id_actor = :actor_id
                    WHERE
                        s.token = :token";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':actor_id', $actor_id, PDO::PARAM_INT);
            $stmt->bindParam(':token', $user_token, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($result['is_favorite'])) {
                return $result['is_favorite'] === "Yes";
            }
            return false;
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return false;
        }
    }

    public function getFavouriteActors($user_token): array | null {
        try {
            $sql = 'SELECT
                        sag_actor.id AS actor_id, sag_actor.actor_name
                    FROM
                        session
                    JOIN
                        users ON session.id_user = users.id
                    JOIN
                        user_fav_actor ON users.id = user_fav_actor.id_user
                    JOIN
                        sag_actor ON user_fav_actor.id_actor = sag_actor.id
                    WHERE
                        session.token = :session_token';

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

    public function getActorStat($actor_id): array | null {
        try {
            $sql = 'SELECT
                        year_of_competition,
                        SUM(CASE WHEN result = "yes" THEN 1 ELSE 0 END) AS yes_count,
                        COUNT(*) AS total_count
                    FROM
                        sag
                    WHERE
                        actor_id = :actor_id
                    GROUP BY
                        year_of_competition
                    ORDER BY
                        year_of_competition';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':actor_id', $actor_id, PDO::PARAM_STR);
            $stmt->execute();

            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $e) {
            echo "Error fetching actors: " . $e->getMessage();
            return null;
        }
    }

    public function getActorView($actor_id): array | null {
        try {
            $sql = 'SELECT
                        s.year_of_competition,
                        c.category_name,
                        sh.show_name,
                        s.result
                    FROM
                        sag s
                    JOIN
                        sag_category c ON s.category_id = c.id
                    JOIN
                        sag_show sh ON s.show_id = sh.id
                    WHERE
                        s.actor_id = :actor_id
                    ORDER BY
                        s.year_of_competition ASC,
                        c.category_name ASC;';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':actor_id', $actor_id, PDO::PARAM_INT);
            $stmt->execute();

            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $e) {
            echo "Error fetching actors: " . $e->getMessage();
            return null;
        }
    }

    public function getActorYearStat($actor_id, $year): array | null {
        try {
            $sql = 'SELECT
                        sc.category_name,
                        ss.show_name,
                        s.result
                    FROM
                        sag s
                    JOIN
                        sag_category sc ON s.category_id = sc.id
                    JOIN
                        sag_show ss ON s.show_id = ss.id
                    WHERE
                        s.actor_id = :actor_id
                        AND s.year_of_competition = :year';

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':actor_id', $actor_id, PDO::PARAM_INT);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->execute();

            $stat = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stat;
        } catch (PDOException $e) {
            echo "Error fetching actors: " . $e->getMessage();
            return null;
        }
    }

    public function actorExists($actor): bool {
        try {
            $sql = "SELECT *
                        FROM sag_actor
                    WHERE
                        LOWER(actor_name) = LOWER(:name)";
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