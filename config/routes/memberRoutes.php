<?php

use App\Service\Router\Router;

/** @var Router $router */
$router->get("/members", "Member#members");

$router->addProxy('/members', function ($url, &$matches) {
    if (!isset($_SESSION['connected_member'])) {
        header('HTTP/1.1 401 Unauthorized', true, 401);
        die;
    }
});