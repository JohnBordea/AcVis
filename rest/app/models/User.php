<?php
require_once BASE_PATH . "/app/models/Database.php";
class User extends DB {

    public function getUsers(): array | null {
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

    public function getUserById($id): array | null{
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

    public function getUserByToken($token): int | null{
        try {
            $sql = "SELECT id_user
                    FROM session
                    WHERE token = :token;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (isset($user["id_user"])) {
                return $user["id_user"];
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

    public function addUser($firstname, $lastname, $username, $email, $password) {
        try {
            $sql = "INSERT INTO users (firstname, lastname, username, email, password, role) VALUES (:firstname, :lastname, :username, :email, :password, :role)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $hash_pass = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hash_pass, PDO::PARAM_STR);
            $role = "user";
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
            return false;
        }
    }

    public function editUser($id, $firstname, $lastname, $username, $email): bool {
        try {
            $sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, username = :username, email = :email WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
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

    public function editUserPassword($id, $password): bool {
        try {
            $sql = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $hash_pass = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(':password', $hash_pass, PDO::PARAM_STR);
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

    public function editUserRole($id, $new_role): bool {
        try {
            $sql = "UPDATE users SET role = :role WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':role', $new_role, PDO::PARAM_STR);
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

    public function deleteUser($id): bool {
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

    public function checkUserByUsername($username): bool | null {
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

    public function checkUserByEmail($email): bool | null {
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

    public function getUserByName($name): array | null{
        try {
            $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $name, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

    public function checkUserIsAdmin($token): bool {
        try {
            $sql = "SELECT u.role FROM session s JOIN users u ON s.id_user = u.id WHERE s.token = :token";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                $roles = $stmt->fetch(PDO::FETCH_ASSOC);
                return $roles["role"] === "admin";
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return false;
        }
    }

    public function checkUserIsLoggedIn($token): bool {
        try {
            $sql = "SELECT * FROM session s WHERE token = :token";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return false;
        }
    }
}