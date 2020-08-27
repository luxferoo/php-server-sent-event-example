<?php

namespace App\Controller;

use App\IoC\IoC;
use App\Model\Member;
use App\Service\Router\Router;

abstract class Controller
{
    private $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function redirect(String $pathname, Array $params = [])
    {
        /** @var Router $router */
        $router = IoC::getInstance()->getService('router');
        $url = $router->getUrl($pathname, $params);
        header("location: ${url}");
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    protected function getService(String $service): Object
    {
        return IoC::getInstance()->getService($service);
    }

    protected function json($data): String
    {
        header("Content-type: application/json");
        return json_encode($data);
    }

    protected function getConnectedMember(): ?Member
    {
        if (!isset($_SESSION['connected_member'])) {
            return null;
        }
        return Member::fromArray(json_decode($_SESSION['connected_member'], true));
    }

    protected function setConnectedMember(Member $member)
    {
        $_SESSION['connected_member'] = json_encode($member);
    }
}

class Request
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function get(String $input)
    {
        return isset($_POST[$input]) ? $_POST[$input] : null;
    }
}