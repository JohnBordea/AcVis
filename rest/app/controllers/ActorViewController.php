<?php

class ActorViewController {
    private $userModel;
    private $actorModel;

    public function __construct() {
        $this->userModel = new User();
        $this->actorModel = new Actor();
    }

    public function getActorView($id, $token) {
        $is_fav = false;
        if (isset($token)) {
            $is_fav = $this->actorModel->checkIfActorFavourite($token, $id);
        }
        $actor_result = $this->actorModel->getActorView($id);
        $actor = $this->actorModel->getActorById($id);
        $data = array();
        if ($actor) {
            $actor_name = $actor["actor_name"];
            $data["text"] = array();
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.themoviedb.org/3/search/person?query=". str_replace(" ", "%20", $actor_name),
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
                $data["img"] = "./assets/imgs/actor-icon.png";
            } else {
                if ($response["page"] < 1) {
                    $data["img"] = "./assets/imgs/actor-icon.png";
                } else {
                    if (isset($response["results"][0]["profile_path"])) {
                        $data["img"] = "https://image.tmdb.org/t/p/w500" . $response["results"][0]["profile_path"];
                    } else {
                        $data["img"] = "./assets/imgs/actor-icon.png";
                    }
                    foreach ($response["results"][0]["known_for"] as $info) {
                        $text_entry = array();
                        if(isset($info["original_title"])) {
                            $text_entry["original_title"] = $info["original_title"];
                        }
                        if(isset($info["original_name"])) {
                            $text_entry["original_title"] = $info["original_name"];
                        }
                        $text_entry["overview"] = $info["overview"];
                        $data["text"][] = $text_entry;
                    }
                }
            }
        } else {
            $actor_name = "";
        }

        http_response_code(200);
        echo json_encode([
            'result' => $actor_result,
            'name' => $actor_name,
            'data' => $data,
            'fav' => $is_fav
        ]);
    }

    public function getActorImgById($id) {
        $actor = $this->actorModel->getActorById($id);

        if($actor) {
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

            http_response_code(200);
            echo json_encode(['actor' => $actor]);

        } else {
            http_response_code(404);
            echo json_encode(['error' => "no actor"]);
        }
    }
}
