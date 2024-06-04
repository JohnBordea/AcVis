<?php

$cookies = ["token", "username", "email", "firstname", "lastname", "role"];

foreach ($cookies as $cookie) {
    if (isset($_COOKIE[$cookie])) {
        unset($_COOKIE[$cookie]);
        setcookie($cookie, '', -1, '/');
    }
}

header("Location: index.php");
die();