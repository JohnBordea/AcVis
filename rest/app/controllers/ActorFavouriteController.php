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
            echo json_encode(['actor' => $actors_by_page, 'last_page' => count($actors) <= ($page * $page_count), 'page_count' => ceil(count($actors) / $page_count)]);
        } else {
            http_response_code(204);
            echo json_encode(['actor' => [], 'last_page' => true, 'page_count' => 0]);
        }
    }
}
