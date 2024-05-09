<?php

class LoginController {
    private $userModel;

    public function __construct() {
        $this->userModel = new Login();
    }

    public function checkIfCredentialsCorrect() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['username', 'password'];
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $user = $this->userModel->getUserByUsernameOrEmail($data["username"]);
        if($user) {
            if($this->userModel->checkUserByPassword($user["id"], $data["password"])) {
                $token = $this->userModel->addUserSession($user["id"]);
                $data_to_send = [
                    "username"  => $user["username"],
                    "firstname" => $user["firstname"],
                    "lastname"  => $user["lastname"],
                    "email"     => $user["email"],
                    "role"      => $user["role"],
                    "token"     => $token
                ];
                http_response_code(200);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($data_to_send);
                return;
            }
        }

        http_response_code(407);
        echo json_encode(['error' => 'User not found here']);
    }

    public function endSession() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        $required_fields = ['token'];
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $success = $this->userModel->deleteSession($data["token"]);

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'Session deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Session not found']);
        }
    }
}
