<?php

require_once "./database/config.php";

class DB {
    protected $pdo;

    public function __construct() {

        try {
            $dsn = "mysql:host=".DB_SERVER.";dbname=".DB_NAME;
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
            exit();
        }
    }

    public function checkIfUserAdmin($token): bool {
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
            return false;
        }
    }

    public function checkIfUserLoggedIn($token): bool {
        try {
            $sql = "SELECT * FROM session WHERE token = :token";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function __destruct() {
        $this->pdo = null;
    }
}