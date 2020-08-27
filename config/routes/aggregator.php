<?php

use App\IOC\IoC;
use App\Service\Router\Router;

function initRoutes(String $url, String $method)
{
    /** @var IoC $container */
    $container = IoC::getInstance();
    /** @var Router $router */
    $router = $container->getService("router");

    foreach (scandir(dirname(__FILE__)) as $filename) {
        $path = dirname(__FILE__) . '/' . $filename;
        preg_match("#Routes.php$#", $filename, $matches);
        if (is_file($path) && count($matches) > 0) {
            require $path;
        }
    }

    $router->run($url, $method);
}
