<?php

class ActorViewController {
    private $userModel;
    private $actorModel;

    public function __construct() {
        $this->userModel = new User();
        $this->actorModel = new Actor();
    }

    public function getActorByPage($page) {
        $actors = $this->actorModel->getActors();
        $split_from = ($page - 1) * 30;
        $actors_by_page = array_slice($actors, $split_from, 30);

        foreach($actors_by_page as &$actor) {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/search/person?query=". str_replace(" ", "%20", $actor["actor_name"]),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer " . file_get_contents(BASE_PATH . "/../database/read.access.token"),
                    "accept: application/json"
                ],
            ]);

            $response = json_decode(curl_exec($curl), true);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                $actor["img"] = "./assets/imgs/actor-icon.png";
            } else {
                if ($response["page"] < 1) {
                    $actor["img"] = "./assets/imgs/actor-icon.png";
                } else {
                    $actor["img"] = "https://image.tmdb.org/t/p/w500" . $response["results"][0]["profile_path"];
                }
            }
        }

        http_response_code(200);
        echo json_encode(['actor' => $actors_by_page, 'last_page' => count($actors) <= ($page * 30), 'page_count' => ceil(count($actors) / 30)]);
    }
}
