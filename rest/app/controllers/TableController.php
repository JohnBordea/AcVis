<?php

class TableController {
    private $userModel;
    private $tableModel;

    public function __construct() {
        $this->userModel = new User();
        $this->tableModel = new Table();
    }

    public function createSAGTable() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['token', 'csv_file'];
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $is_admin = $this->userModel->checkUserIsAdmin($data['token']);
        if($is_admin) {
            foreach($data['csv_file'] as $csv_data) {
                $category_id = -1;
                $actor_id = -1;
                $show_id = -1;

                if (!empty($csv_data[1])) {
                    $category_id = $this->tableModel->getCategoryIdByName($csv_data[1]);
                    if($category_id == -2) {
                        $category_id = $this->tableModel->addCategory($csv_data[1]);
                    }
                }
                if (!empty($csv_data[2])) {
                    $actor_id = $this->tableModel->getActorIdByName($csv_data[2]);
                    if($actor_id == -2) {
                        $actor_id = $this->tableModel->addActor($csv_data[2]);
                    }
                }
                if (!empty($csv_data[3])) {
                    $show_id = $this->tableModel->getShowIdByName($csv_data[3]);
                    if($show_id == -2) {
                        $show_id = $this->tableModel->addShow($csv_data[3]);
                    }
                }
                $result = $this->tableModel->addSAG($csv_data[0], $category_id, $actor_id, $show_id, $csv_data[4] ? "yes" : 'no');
                if($result == -1) {
                    http_response_code(404);
                    echo json_encode(['error' => "something went wrong"]);
                    return;
                }
            }

            http_response_code(200);
            echo json_encode(['message' => "table created"]);
        } else {
            http_response_code(204);
            echo json_encode(['error' => "bad credentials"]);
            return;
        }
    }

    public function getSAGByPage($page, $user_token) {
        $is_admin = $this->userModel->checkUserIsAdmin($user_token);
        if ($is_admin) {
            $sags = $this->tableModel->getSAGs();
            $split_from = ($page - 1) * 20;
            $sag_by_page = array_slice($sags, $split_from, 20);
            http_response_code(200);
            echo json_encode(['sag' => $sag_by_page, 'last_page' => count($sags) <= ($page * 20)]);
        } else {
            http_response_code(204);
            echo json_encode(['sag' => [], 'last_page' => true]);
        }
    }

}
