<?php

use App\Service\Router\Router;

/** @var Router $router */
$router->get("/messages/:id", "Message#messages");
$router->post("/messages/:id", "Message#sendMessage");