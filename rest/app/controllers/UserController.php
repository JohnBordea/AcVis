<?php

class UsersController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function getUsers() {
        http_response_code(200);
        echo json_encode($this->userModel->getUsers());
    }

    public function getUser($id) {
        $user = $this->userModel->getUserById($id);
            if ($user) {
                http_response_code(200);
                echo json_encode($user);
                return;
            }
        http_response_code(404);
        echo '404 Not Found';
    }

    public function updateUser($id) {
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);
            if ($data === null) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid JSON data']);
                return;
            }
            $required_fields = ['name', 'email', 'age'];
            foreach ($required_fields as $field) {
                if (!array_key_exists($field, $data)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Missing required field: ' . $field]);
                    return;

                }
        }

        $result = $this->userModel->editUser($id, $data['firstname'], $data['lastname'], $data['username'], $data['email'], $data['password']);
        if($result) {
            http_response_code(200);
            echo json_encode(['message' => 'User updated succesfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    public function createUser() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        $required_fields = ['name', 'email', 'age'];
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }
        $newUserId = $this->userModel->addUser($data['firstname'], $data['lastname'], $data['username'], $data['email'], $data['password']);
        http_response_code(201);
        header('Location: http://' .$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $newUserId);
        echo json_encode(['message' => 'User created successfully']);
    }

    public function deleteUser($id) {
        $success = $this->userModel->deleteUser($id);

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }
}
