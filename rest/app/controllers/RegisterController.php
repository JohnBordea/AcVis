<?php

class RegisterController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function registerUser() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        $required_fields = ['firstname', 'lastname', 'username', 'email', 'password'];
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        if ($this->userModel->checkUserByUsername($data["username"])) {
            http_response_code(202);
            echo json_encode(['exist' => 'username']);
        } else if ($this->userModel->checkUserByEmail($data["email"])) {
            http_response_code(202);
            echo json_encode(['exist' => 'email']);
        } else {
            $newUserId = $this->userModel->addUser($data['firstname'], $data['lastname'], $data['username'], $data['email'], $data['password']);
            http_response_code(201);
            echo json_encode(['message' => 'created']);
        }
    }
}
