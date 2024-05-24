<?php

require_once "./assets/php/database.php";

function is_admin($token): bool {
    $model = new DB();

    $result = $model->checkIfUserAdmin($token);

    return $result;
}

function is_logged_in($token): bool {
    $model = new DB();

    $result = $model->checkIfUserLoggedIn($token);

    return $result;
}