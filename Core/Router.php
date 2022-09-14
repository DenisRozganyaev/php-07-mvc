<?php

namespace Core;

class Router
{
    protected array $routes = [], $params = [];

    protected array $convertTypes = [
        'd' => 'int',
        'w' => 'string'
    ];

    public function add(string $route, array $params = [])
    {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        $route = "/^{$route}$/i";
        $this->routes[$route] = $params;
    }

    /**
     * @throws \Exception
     */
    public function dispatch(string $url)
    {
        $url = trim($url, '/');
        $url = $this->removeQuesryStringVariables($url);
        if ($this->match($url)) {
            if (array_key_exists('method', $this->params) && ($_SERVER['REQUEST_METHOD'] !== $this->params['method'])) {
                throw new \Exception("Method " . $_SERVER['REQUEST_METHOD'] . " doesn't supported by this route");
            }
            unset($this->params['method']);

            if (class_exists($this->params['controller'])) {
                $controller = $this->retrieveParam('controller');
                if (method_exists($controller, $this->params['action'])) {
                    $controller = new $controller;
                    $action = $this->retrieveParam('action');

                    if ($controller->before($action)) {
                        call_user_func_array([$controller, $action], $this->params);
                        $controller->after($action);
                    } else {
                        if (empty ($_SERVER['HTTP_REFERER'])) {
                            redirect();
                        }
                        redirectBack();
                    }
                } else {
                    throw new \Exception("Action {$this->params['action']} in class {$controller} not found");
                }
            } else {
                throw new \Exception("Controller class {$this->params['controller']} not found");
            }
        } else {
            throw new \Exception("Route not found", 404);
        }
    }

    protected function retrieveParam(string $name)
    {
        $value = $this->params[$name];
        unset($this->params[$name]);
        return $value;
    }

    protected function match(string $url)
    {
        foreach($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $this->setParams($route, $matches, $params);
                return true;
            }
        }
        return false;
    }

    protected function setParams(string $route, array $matches, array $params): array
    {
        preg_match_all('/\(\?P<[\w]+>\\\\(\w[\+])\)/', $route, $types);
        $matches = array_filter($matches, fn($key) => is_string($key), ARRAY_FILTER_USE_KEY);

        if (!empty($types)) {
            $step = 0;
            $lastKey = count($types) - 1;
            foreach($matches as $key => $match) {
                $types[$lastKey] = str_replace('+', '', $types[$lastKey]);
                settype($match, $this->convertTypes[$types[$lastKey][$step]]);
                $params[$key] = $match;
                $step++;
            }
        }

        return $params;
    }

    protected function removeQuesryStringVariables(string $url)
    {
        return preg_replace('/([\w\/]+)\?([\w\/=\d]+)/i', '$1', $url);
    }
}
