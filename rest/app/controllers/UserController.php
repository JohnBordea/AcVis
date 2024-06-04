<?php
class UserController {
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

    public function getUsersByPage($page, $user_token) {
        $is_admin = $this->userModel->checkUserIsAdmin($user_token);
        if ($is_admin) {
            $users = $this->userModel->getUsers();
            $split_from = ($page - 1) * 20;
            $user_by_page = array_slice($users, $split_from, 20);
            http_response_code(200);
            echo json_encode(['users' => $user_by_page, 'last_page' => count($users) <= ($page * 20), 'page_count' => ceil(count($users) / 20)]);
        } else {
            http_response_code(204);
            echo json_encode(['users' => [], 'last_page' => true, 'page_count' => 0]);
        }
    }

    public function updateUser() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        if (array_key_exists('role', $data)) {
            $required_fields = ['token'];
            foreach ($required_fields as $field) {
                if (!array_key_exists($field, $data)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Missing required field: ' . $field]);
                    return;
                }
            }

            $is_admin = $this->userModel->checkUserIsAdmin($data['token']);
            if ($is_admin) {
                $result = $this->userModel->editUserRole($data["user_id"], $data["role"]);
            } else {
                http_response_code(204);
                echo json_encode(['error' => "bad credentials"]);
                return;
            }
        } else if (array_key_exists('password', $data)) {
            //TODO
            //Email/username + password
            // CHeck Email
            $required_fields = ['username'];
            foreach ($required_fields as $field) {
                if (!array_key_exists($field, $data)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Missing required field: ' . $field]);
                    return;
                }
            }

            if ($this->userModel->checkUserByEmail($data["username"]) || $this->userModel->checkUserByUsername($data["username"])) {
                $user = $this->userModel->getUserByName($data["username"]);
                if ($user) {
                    $result = $this->userModel->editUserPassword(
                        $user["id"],
                        $data["password"]
                    );
                } else {
                    http_response_code(400);
                    echo json_encode(['error' => 'Something went wrong']);
                    return;
                }
            } else {
                http_response_code(204);
                echo json_encode(['missing' => 'Username or Email written wrong']);
                return;
            }

        } else {
            $required_fields = ['firstname', 'lastname', 'username', 'email', 'token'];
            foreach ($required_fields as $field) {
                if (!array_key_exists($field, $data)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Missing required field: ' . $field]);
                    return;
                }
            }

            $user_id = $this->userModel->getUserByToken($data["token"]);
            $result = $this->userModel->editUser($user_id, $data['firstname'], $data['lastname'], $data['username'], $data['email']);
            $result = $this->userModel->getUserById($user_id);
        }

        if($result) {
            http_response_code(200);
            echo json_encode([
                'message' => 'User updated succesfully',
                'result' => $result
            ]);
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

    public function deleteUser() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['token', 'user_id'];
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $is_admin = $this->userModel->checkUserIsAdmin($data['token']);

        if(!$is_admin) {
            http_response_code(204);
            echo json_encode(['error' => "bad credentials"]);
            return;
        }

        $success = $this->userModel->deleteUser($data['user_id']);

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }
}
