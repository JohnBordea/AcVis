<?php

class ActorController {
    private $userModel;
    private $actorModel;

    public function __construct() {
        $this->userModel = new User();
        $this->actorModel = new Actor();
    }

    public function getActorByPage($page, $user_token) {
        $is_admin = $this->userModel->checkUserIsAdmin($user_token);
        if ($is_admin) {
            $actors = $this->actorModel->getActors();
            $split_from = ($page - 1) * 20;
            $actors_by_page = array_slice($actors, $split_from, 20);
            http_response_code(200);
            echo json_encode(['actor' => $actors_by_page, 'last_page' => count($actors) <= ($page * 20), 'page_count' => ceil(count($actors) / 20)]);
        } else {
            http_response_code(204);
            echo json_encode(['actor' => [], 'last_page' => true, 'page_count' => 0]);
        }
    }

    public function deleteActor() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['token', 'actor_id'];
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

        $success = $this->actorModel->deleteActor($data['actor_id']);

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

}
