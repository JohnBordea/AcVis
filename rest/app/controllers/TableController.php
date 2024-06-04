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
                $year = $csv_data[0];
                $category = trim($csv_data[1]);
                $actor = trim($csv_data[2]);
                $show = trim($csv_data[3]);
                $category_id = -1;
                $actor_id = -1;
                $show_id = -1;

                if (!empty($category)) {
                    $category_id = $this->tableModel->getCategoryIdByName($category);
                    if($category_id == -2) {
                        $category_id = $this->tableModel->addCategory($category);
                    }
                }
                if (!empty($actor)) {
                    $actor_id = $this->tableModel->getActorIdByName($actor);
                    if($actor_id == -2) {
                        $actor_id = $this->tableModel->addActor($actor);
                    }
                }
                if (!empty($show)) {
                    $show_id = $this->tableModel->getShowIdByName($show);
                    if($show_id == -2) {
                        $show_id = $this->tableModel->addShow($show);
                    }
                }

                $result = $this->tableModel->addSAG($year, $category_id, $actor_id, $show_id, $csv_data[4] ? "yes" : 'no');
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

    public function addSAGEntry() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['token', 'year', 'category', 'actor', 'show'];
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $is_admin = $this->userModel->checkUserIsAdmin($data['token']);
        if($is_admin) {
            if($data['win']) {
                $this->tableModel->updateSAGEntryToLose($data['year'], $data['category']);
            }

            //Check if data already in place
            $in_place = $this->tableModel->isSAGInDB($data['year'], $data['category'], $data['actor'], $data['show']);

            if ($in_place) {
                $result = $this->tableModel->updateSAG($data['year'], $data['category'], $data['actor'], $data['show'], $data['win'] ? "yes" : 'no');
            } else {
                $result = $this->tableModel->addSAG($data['year'], $data['category'], $data['actor'], $data['show'], $data['win'] ? "yes" : 'no');
            }
            if($result == -1) {
                http_response_code(404);
                echo json_encode(['error' => "something went wrong"]);
                return;
            }

            http_response_code(200);
            echo json_encode(['message' => "entry added"]);
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
            echo json_encode([
                'sag' => $sag_by_page,
                'last_page' => count($sags) <= ($page * 20),
                'page_count' => ceil(count($sags) / 20)
            ]);
        } else {
            http_response_code(204);
            echo json_encode([
                'sag' => [],
                'last_page' => true,
                'page_count' => 0
            ]);
        }
    }

    public function getSAGFileCSV($user_token) {
        $is_admin = $this->userModel->checkUserIsAdmin($user_token);
        if ($is_admin) {
            $filename = BASE_PATH . "/../database/file.csv";
            $this->saveFileCSV($filename);
            if (file_exists($filename)) {
                // Set headers to initiate file download
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($filename));
                flush(); // Flush system output buffer
                readfile($filename);
                exit;
            } else {
                http_response_code(404);
                echo "File not found.";
            }
        } else {
            http_response_code(204);
        }
    }

    private function saveFileCSV($filename) {
        $sags = $this->tableModel->getSAGs();
        $file = fopen($filename, 'w');
        if ($file === false) {
            die('Error opening the file ' . $filename);
        }
        foreach ($sags as $sag) {
            fputcsv($file, array_slice($sag, 1));
        }
        fclose($file);
    }

    public function getSAGCreateData($user_token) {
        $is_admin = $this->userModel->checkUserIsAdmin($user_token);
        if ($is_admin) {
            $year_min = $this->tableModel->getYearMin();
            $year_current = $this->tableModel->getYearCurrent();
            $category = $this->tableModel->getCategory();
            $actor = $this->tableModel->getActor();
            $show = $this->tableModel->getShow();
            http_response_code(200);
            echo json_encode([
                "year_min"     => $year_min,
                "year_current" => $year_current,
                "category"     => $category,
                "actor"        => $actor,
                "show"         => $show,
            ]);
        } else {
            http_response_code(204);
            echo json_encode([]);
        }
    }

    public function deleteSAG() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
        $required_fields = ['token', 'sag_id', 'all'];
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

        if ($data['all']) {
            $success = $this->tableModel->deleteSAG();
        } else {
            $success = $this->tableModel->deleteSAGById($data['sag_id']);
        }

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'SAG deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'SAG not found']);
        }
    }

}
