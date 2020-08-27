<?php

namespace App\Service\Router;

class Route
{
    private $callback;
    private $path;
    private $matches = [];
    private $params = [];

    public function __construct(String $path, $callback)
    {
        $this->path = trim($path, '/');
        $this->callback = $callback;
    }

    public function match(String $url)
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "%^$path$%i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        } else {
            array_shift($matches);
            $this->matches = $matches;
            return true;
        }
    }

    public function call()
    {
        if (is_string($this->callback)) {
            $params = explode('#', $this->callback);
            $controller = "App\\Controller\\" . $params[0];
            $controller = new $controller();
            $action = $params[1];
            return $controller->$action(...$this->matches);
        }
        return call_user_func_array($this->callback, $this->matches);
    }

    public function constraint(String $param, String $regex)
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    private function paramMatch(array $match)
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    public function getUrl(array $params = []): string
    {
        $path = $this->path;
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

    public function getMatches()
    {
        return $this->matches;
    }

    public function setMatches(array $matches)
    {
        $this->matches = $matches;
        return $this;
    }
}
