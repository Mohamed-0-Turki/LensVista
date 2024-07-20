<?php

namespace Core;

use ReflectionException;
use ReflectionMethod;

class Controller {

    public final function model($model)
    {
        $model = ucfirst($model);
        $modelClass = "Models\\$model";
        return new $modelClass;
    }

    public final function invokeControllerMethod(string $controller = '', string $method = '', mixed ...$params) : void
    {
        $controller = ucfirst($controller);
        $method = lcfirst($method);
        $controllerPath = CONTROLLERS . $controller . '.controller.php';
        $controllerClass = "Controllers\\$controller";
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            if (class_exists($controllerClass)) {
                $controllerObj = new $controllerClass;
                if (method_exists($controllerObj, $method)) {
                    try {
                        $reflectionMethod = new ReflectionMethod($controllerClass, $method);
                        if (!$reflectionMethod->isPublic()) {
                            $reflectionMethod->setAccessible(true);
                        }
                        $reflectionMethod->invoke($controllerObj, ...$params);
                    } catch (ReflectionException $e) {
                        $this->view();
                    }
                }
                else {
                    $this->view();
                }
            }
            else {
                $this->view();
            }
        }
        else {
            $this->view();
        }
    }

    public final function view(string $template = '404', string $title = '404 - Page Not Found', array $data = [], array $errors = []) : View
    {
        $data = [
            'title' => ucfirst($title),
            'data' => $data,
            'errors' => $errors
        ];
        // dump($_GET);
        // dump($_POST);
        // dump($_FILES);
        // dump($_SESSION);
        // dump($_COOKIE);
        // dump($data);
        return new View($template, $data);
    }
}