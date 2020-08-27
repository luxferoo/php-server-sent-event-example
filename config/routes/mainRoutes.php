<?php

use App\Service\Router\Router;

/** @var Router $router */
$router->get("/home", "Main#index","home");

$router->addProxy('/home',function ($url, &$matches){
    if(!isset($_SESSION['connected_member'])){
        header('location: /login');
    }
});