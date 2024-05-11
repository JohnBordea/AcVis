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
            echo json_encode(['actor' => $actors_by_page, 'last_page' => count($actors) <= ($page * 20)]);
        } else {
            http_response_code(204);
            echo json_encode(['actor' => [], 'last_page' => true]);
        }
    }

}
