<?php

namespace App\IoC;

class IoC
{
    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static;
        }
        return $instance;
    }

    private $services = [];

    public function register(String $name, \Closure $callback)
    {
        if (isset($this->services[$name])) {
            throw new IoCException("Service $name already exist.");
        }
        $this->services[$name] = $callback;
        return $this;
    }

    public function getService(String $name)
    {
        if (!isset($this->services[$name])) {
            throw new IoCException("Service $name does not exist.");
        }
        return $this->services[$name]();
    }
}
