<?php

use App\Service\Router\Router;

/** @var Router $router */
$router->get('/login', "Security#login","login");
$router->post('/login', "Security#login","post_login");
$router->get('/logout', "Security#logout","logout");

$router->addProxy('/login', function ($url, &$matches) {
    if (isset($_SESSION['connected_member'])) {
        header('location: /home');
    }
});
