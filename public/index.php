<?php
declare(strict_types=1);
ini_set('display_errors', "1");
define('PROJECT_ROOT', dirname(dirname(__FILE__)));
session_start();

require '../vendor/autoload.php';
require '../src/IoC/initIoC.php';
require '../config/routes/aggregator.php';

$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : "";
$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
$url = explode("?", $url)[0];

if (is_string($method) && !empty($method)) {
    try {
        initRoutes($url, $method);
    } catch (Exception $exception) {
        echo $exception->getMessage() . " " . $exception->getCode();
    }
}
