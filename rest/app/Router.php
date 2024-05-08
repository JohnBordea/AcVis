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
                if ($controllerName === 'UsersController') {
                    if (!empty($segments[1]) && is_numeric($segments[1])) {
                        $controller->getUser($segments[1]);
                    } else {
                        $controller->getUsers();
                    }
                } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'PUT':
                if ($controllerName === 'UsersController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    $controller->updateUser($segments[1]);
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
                } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'DELETE':
                if ($controllerName === 'LoginController') {
                    $controller->checkIfCredentialsCorrect();
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