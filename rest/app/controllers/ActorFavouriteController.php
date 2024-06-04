<?php

class ActorFavouriteController {
    private $userModel;
    private $actorModel;

    public function __construct() {
        $this->userModel = new User();
        $this->actorModel = new Actor();
    }

    public function getActorByPage($page, $user_token) {
        $is_admin = $this->userModel->checkUserIsLoggedIn($user_token);
        if ($is_admin) {
            $actors = $this->actorModel->getFavouriteActors($user_token);
            $page_count = 10;
            $split_from = ($page - 1) * $page_count;
            $actors_by_page = array_slice($actors, $split_from, $page_count);
            http_response_code(200);
            echo json_encode([
                'actor' => $actors_by_page,
                'last_page' => count($actors) <= ($page * $page_count),
                'page_count' => ceil(count($actors) / $page_count)
            ]);
        } else {
            http_response_code(204);
            echo json_encode([
                'actor' => [],
                'last_page' => true,
                'page_count' => 0
            ]);
        }
    }

    public function addFavouriteActor() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['id', 'token'];
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }
        $is_logged = $this->userModel->checkUserIsLoggedIn($data['token']);
        if(!$is_logged) {
            http_response_code(204);
            echo json_encode(['error' => "bad credentials"]);
            return;
        }

        $user_id = $this->userModel->getUserByToken($data['token']);

        $success = $this->actorModel->addFavouriteActor($user_id, $data['id']);

        if ($success) {
            http_response_code(200);
            echo json_encode(['added' => '']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    public function removeFavouriteActor() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['id', 'token'];
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }
        $is_logged = $this->userModel->checkUserIsLoggedIn($data['token']);
        if(!$is_logged) {
            http_response_code(204);
            echo json_encode(['error' => "bad credentials"]);
            return;
        }

        $user_id = $this->userModel->getUserByToken($data['token']);

        $success = $this->actorModel->deleteFavouriteActor($user_id, $data['id']);

        if ($success) {
            http_response_code(200);
            echo json_encode(['removed' => '']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }
}
