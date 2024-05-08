<?php
require_once BASE_PATH . "/app/models/Database.php";
class User extends DB {

    public function getUsers() {
        try {
            $sql = "SELECT * FROM users";
            $stmt = $this->pdo->query($sql);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            echo "Error fetching users: " . $e->getMessage();
            return null;
        }
    }

    public function getUserById($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

    public function addUser($firstname, $lastname, $username, $email, $password) {
        try {
            $sql = "INSERT INTO users (firstname, lastname, username, email, password) VALUES (:firstname, :lastname, :username, :email, :password)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $hash_pass = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hash_pass, PDO::PARAM_STR);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
            return false;
        }
    }

    public function editUser($id, $firstname, $lastname, $username, $email, $password) {
        try {
            $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, username = :username, email = :email, password = :password WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error editing user: " . $e->getMessage();
            return false;
        }
    }

    public function deleteUser($id) {
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
            return false;
        }
    }

    public function checkUserByUsername($username) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

    public function checkUserByEmail($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }
}