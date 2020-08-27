<?php

namespace App\Service\Router;

use App\Helper\EventEmitter;

class Router extends EventEmitter
{
    private $routes = [];
    private $namedRoutes = [];
    private $proxies = [];
    private $response;
    private $url;
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    const DELETE = "DELETE";
    const ROUTER_REQUEST_EVENT = "router.request";
    const ROUTER_ROUTE_NOT_FOUND_EVENT = "router.route.not.found";
    const ROUTER_RESPONSE_EVENT = "router.response";
    const ROUTER_RESPONSE_ERROR_EVENT = "router.response.error";

    public function run(String $url, String $method)
    {
        $this->url = $url;
        $this->response = null;
        $this->emit(self::ROUTER_REQUEST_EVENT, $this);
        if (isset($this->routes[$method])) {
            /** @var Route $route */
            foreach ($this->routes[$method] as $route) {
                if ($route->match($url)) {
                    $matches = $route->getMatches();
                    foreach ($this->proxies as $regex => $proxy) {
                        preg_match("#$regex#", $url, $m);
                        if (count($m) > 0) {
                            if($res = $proxy($url, $matches)){
                                return $res;
                            }
                        }
                    }
                    $route->setMatches($matches);
                    try {
                        $this->response = $route->call();
                        $this->emit(self::ROUTER_RESPONSE_EVENT, $this);
                        return;
                    } catch (\Exception $exception) {
                        $this->emit(self::ROUTER_RESPONSE_ERROR_EVENT, $this);
                        return;
                    }
                }
            }
        }
        $this->emit(self::ROUTER_ROUTE_NOT_FOUND_EVENT, $this);
    }

    public function get(String $path, $callback, String $name = null): Route
    {
        return $this->add($path, $callback, self::GET, $name);
    }

    public function post(String $path, $callback, String $name = null): Route
    {
        return $this->add($path, $callback, self::POST, $name);
    }

    public function put(String $path, $callback, String $name = null): Route
    {
        return $this->add($path, $callback, self::PUT, $name);
    }

    public function delete(String $path, $callback, String $name = null): Route
    {
        return $this->add($path, $callback, self::DELETE, $name);
    }

    private function add(String $path, $callback, String $method, String $name = null): Route
    {
        $route = new Route($path, $callback);
        $this->routes[$method][] = $route;
        if (is_string($callback) && $name == null) {
            /*if (array_key_exists($callback, $this->namedRoutes)) {
                throw new RouterException("Route name already taken $callback");
            }*/
            $this->namedRoutes[$callback] = $callback;
        }
        if ($name) {
            /*
             if (array_key_exists($name, $this->namedRoutes)) {
                    throw new RouterException("Route name already taken $name");
                }*/
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    public function getUrl(String $name, array $params = [])
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException('No route matches this name');
        }

        var_dump($this->namedRoutes[$name]);
        return $this->namedRoutes[$name]->getUrl($params);
    }

    public function addProxy(String $regex, \Closure $callback)
    {
        $this->proxies[$regex] = $callback;
        return $this;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getRequestedUrl()
    {
        return $this->url;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
