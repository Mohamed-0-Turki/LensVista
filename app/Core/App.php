<?php

namespace Core;

use ReflectionException;
use ReflectionMethod;

final class App
{
    private object | string $controller = 'home';
    private string $method = 'index';
    private array $params = [];
    public function __construct()
    {
        $this->handleRequests();
    }

    public function setController(object|string $controller): void
    {
        $this->controller = $controller;
    }
    public function getController(): object|string
    {
        return $this->controller;
    }

    public function setMethod(string $method): void
    {
        $this->method = $method;
    }
    public function getMethod(): string
    {
        return $this->method;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }
    public function getParams(): array
    {
        return $this->params;
    }

    private function handleRequests() :void
    {
        $url = $this->getUrlSegments();
        if (!$this->render($url)) {
            http_response_code(404);
            new view('');
        }
    }

    private function getUrlSegments() :array
    {
        $url = (!empty($_GET['url'])) ? $_GET['url'] : $this->controller;
        unset($_GET['url']);
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = str_replace('\\', '/', $url);
        $url = trim($url, '/');
        return explode('/', $url);
    }

    private function render(array $url) :bool
    {
        $class = ucfirst($url[0]);
        $controllerClass = "Controllers\\$class";
        $controllerPath = CONTROLLERS . $class . '.controller.php';

        if (file_exists($controllerPath)) {
            require_once $controllerPath;

            if (class_exists($controllerClass)) {
                $this->controller = new $controllerClass();
                unset($url[0]);

                if (isset($url[1])) {
                    $method = lcfirst($url[1]);

                    if (method_exists($this->controller, $method)) {
                        try {
                            $reflectionMethod = new ReflectionMethod($this->controller, $method);
                            if ($reflectionMethod->isPublic()) {
                                $this->method = $method;
                                unset($url[1]);
                                $url = array_values($url);
                            } else {
                                return false;
                            }
                        } catch (ReflectionException $e) {
                            return false;
                        }
                    }
                    else {
                        return false;
                    }
                }
                $this->params = $url;

                if (!$this->methodHasParameters($this->controller, $this->method) && count($this->params) > 0) {
                    return false;
                } else {
                    call_user_func_array([$this->controller, $this->method], $this->params);
                    return true;
                }
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }

    private function methodHasParameters(string | object $className, string $methodName) :bool
    {
        try {
            $reflectionMethod = new ReflectionMethod($className, $methodName);
            $parameters = $reflectionMethod->getParameters();
            return count($parameters) > 0;
        } catch (ReflectionException $e) {
            return false;
        }
    }
}