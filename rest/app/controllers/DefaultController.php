<?php

class DefaultController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

}
