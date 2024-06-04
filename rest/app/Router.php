<?php

class Router {
    public function dispatch($api_call = "") {

        $method = $_SERVER['REQUEST_METHOD'];

        $segments = [$api_call];
        $controllerName = !empty($segments[0]) ? ucfirst($segments[0]) . 'Controller' : 'DefaultController';
        $controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        } else {
            http_response_code(404);
            echo '404 Not Found';
            exit;
        }

        $controller = new $controllerName();
        switch ($method) {
            case 'GET':
                if ($controllerName === 'UserController') {
                    if (isset($_GET['page']) && isset($_GET['token'])) {
                        $controller->getUsersByPage($_GET['page'], $_GET['token']);
                    } else {
                        http_response_code(405);
                        echo '405 Method Not Allowed';
                        exit;
                    }
                } else if ($controllerName === 'TableController') {
                    if (isset($_GET['token'])) {
                        if (isset($_GET['page'])) {
                            $controller->getSAGByPage($_GET['page'], $_GET['token']);
                        } else if (isset($_GET['create'])) {
                            $controller->getSAGCreateData($_GET['token']);
                        } else if (isset($_GET['filecsv'])) {
                            $controller->getSAGFileCSV($_GET['token']);
                        }
                    } else {
                        http_response_code(405);
                        echo '405 Method Not Allowed';
                        exit;
                    }
                } else if ($controllerName === 'ActorController') {
                    if (isset($_GET['token']) && isset($_GET['page'])) {
                        $controller->getActorByPage($_GET['page'], $_GET['token']);
                    } else {
                        $controller->getActors();
                    }
                } else if ($controllerName === 'ActorViewController') {
                    if (isset($_GET['id'])) {
                        if (isset($_GET['token'])) {
                            $controller->getActorView($_GET['id'], $_GET['token']);
                        } else {
                            $controller->getActorView($_GET['id'], null);
                        }
                    } else {
                        http_response_code(405);
                        echo '405 Method Not Allowed';
                        exit;
                    }
                } else if ($controllerName === 'ActorStatController') {
                    if (isset($_GET['id'])) {
                        if (isset($_GET['year'])) {
                            $controller->getActorYearStat($_GET['id'], $_GET['year']);
                        } else {
                            $controller->getActorStat($_GET['id']);
                        }
                    } else {
                        http_response_code(405);
                        echo '405 Method Not Allowed';
                        exit;
                    }
                } else if ($controllerName === 'ActorFavouriteController') {
                    if (isset($_GET['page']) && isset($_GET['token'])) {
                        $controller->getActorByPage($_GET['page'], $_GET['token']);
                    } else {
                        http_response_code(405);
                        echo '405 Method Not Allowed';
                        exit;
                    }
                } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'PUT':
                if ($controllerName === 'UserController') {
                    $controller->updateUser();
                } else if ($controllerName === 'TableController') {
                    $controller->addSAGEntry();
                } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'POST':
                if ($controllerName === 'LoginController') {
                    $controller->checkIfCredentialsCorrect();
                } else if ($controllerName === 'RegisterController') {
                    $controller->registerUser();
                } else if ($controllerName === 'TableController') {
                    $controller->createSAGTable();
                } else if ($controllerName === 'ActorController') {
                    $controller->addActor();
                } else if ($controllerName === 'ActorFavouriteController') {
                    $controller->addFavouriteActor();
                } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'DELETE':
                if ($controllerName === 'UserController') {
                    $controller->deleteUser();
                } else if ($controllerName === 'ActorController') {
                    $controller->deleteActor();
                } else if ($controllerName === 'TableController') {
                    $controller->deleteSAG();
                } else if ($controllerName === 'ActorFavouriteController') {
                    $controller->removeFavouriteActor();
                } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            default:
                http_response_code(405);
                echo '405 Method Not Allowed';
                exit;
        }
    }
}