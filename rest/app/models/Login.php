<?php
require_once BASE_PATH . "/app/models/Database.php";
class Login extends DB {

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

    public function getUserByUsername($username) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

    public function getUserByEmail($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

    public function getUserByUsernameOrEmail($data) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $data, PDO::PARAM_STR);
            $stmt->bindParam(':email', $data, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

    public function checkUserByPassword($id, $password): bool {
        try {
            $user = $this->getUserById($id);
            return password_verify($password, $user["password"]);
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return false;
        }
    }

    public function addUserSession($user_id): string {
        $token = $this->generateRandomString(16);

        //TODO
        //Check if session exists
        $this->deleteUserSession($user_id);

        $sql = "INSERT INTO session (id_user, token, creation_date) VALUES (:user, :token, DATE_FORMAT(NOW(),'%Y-%m-%d %h:%i:%s'))";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':token', $token, PDO::PARAM_STR);
        $stmt->execute();
        return $token;
    }

    public function deleteUserSession($user_id) {
        try {
            $sql = "DELETE FROM session WHERE id_user = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
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

    private function generateRandomString($length): string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function deleteSession($token): bool {
        try {
            $sql = "DELETE FROM session WHERE token = :token";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error deleting session: " . $e->getMessage();
            return false;
        }
    }
}