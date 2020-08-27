<?php

use App\IoC\IoC;
use App\Service\Router\Router;
use App\Service\Db\Connection;
use App\Repository\Factory;
use App\Service\View;

require_once PROJECT_ROOT.'/config/db.php';

IoC::getInstance()
    ->register("router", function () {
        static $router;
        if ($router instanceof Router) {
            return $router;
        }
        $router = new Router();
        return $router
            ->once(Router::ROUTER_ROUTE_NOT_FOUND_EVENT, function (Router $router) {
                echo "Oups! Route not found";
                header('HTTP/1.1 404 Oups! Route not found', true, 404);
                die;
            })
            ->once(Router::ROUTER_RESPONSE_ERROR_EVENT, function (Router $router) {
                echo "Server error";
                header('HTTP/1.1 500 Server error', true, 500);
                die;
            })
            ->once(Router::ROUTER_RESPONSE_EVENT, function (Router $router) {
                $response = $router->getResponse();
                echo $response;
            });
    })
    ->register("db", function () use ($db_dsn, $db_user, $db_password) {
        static $connection;
        if ($connection instanceof Connection) {
            return $connection;
        }
        $connection = new Connection();
        $connection->init($db_dsn, $db_user, $db_password);
        return $connection;
    })
    ->register("view", function () {
        static $view;
        if ($view instanceof View) {
            return $view;
        }
        $view = new View();

        return $view;
    })
    ->register("repository", function () {
        static $repo;
        if ($repo instanceof Factory) {
            return $repo;
        }
        $repo = new Factory(IoC::getInstance()->getService("db")->getConnection());
        return $repo;
    });
