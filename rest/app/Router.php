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
                    if (isset($_GET['page']) && isset($_GET['token'])) {
                        $controller->getSAGByPage($_GET['page'], $_GET['token']);
                    } else {
                        http_response_code(405);
                        echo '405 Method Not Allowed';
                        exit;
                    }
                } else if ($controllerName === 'ActorController') {
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
                } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'DELETE':
                if ($controllerName === 'UserController') {
                    $controller->deleteUser();
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