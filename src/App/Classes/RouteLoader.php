<?php

namespace phpTest\src\App\Classes;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use phpTest\src\App\Attributes\Route;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\Request;

class RouteLoader
{
    private array $controllers;

    public function __construct(array $controllers)
    {
        $this->controllers = $controllers;
    }

    public function collectRoutes(RouteCollector $routeCollector): void
    {
        foreach ($this->controllers as $controller) {
            try {
                $reflection = new ReflectionClass($controller);
                foreach ($reflection->getMethods() as $method) {
                    foreach ($method->getAttributes(Route::class) as $attribute) {
                        $route = $attribute->newInstance();
                        $routeCollector->addRoute($route->httpMethod, $route->path, [$controller, $method->getName()]);
                    }
                }
            } catch (ReflectionException $e) {
                echo 'Controller Error: ' . $e->getMessage();
            }
        }
    }

    public function dispatch(Request $request, Dispatcher $dispatcher): void
    {
        $httpMethod = $request->getMethod();
        $uri = $request->getPathInfo();
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                echo '404 Not Found';
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                echo '405 Method Not Allowed';
                break;
            case Dispatcher::FOUND:
                [$controller, $method] = $routeInfo[1];
                $vars = $routeInfo[2];
                $controllerInstance = new $controller();
                try {
                    $methodReflection = new ReflectionMethod($controllerInstance, $method);
                    $methodParams = $methodReflection->getParameters();
                    foreach ($methodParams as $param) {
                        if ($param->getType() && $param->getType()->getName() === Request::class) {
                            $vars[$param->getName()] = $request;
                        }
                    }
                    call_user_func_array([$controllerInstance, $method], $vars);
                } catch (ReflectionException $e) {
                    echo 'Method Not Found: ' . $e->getMessage();
                }
                break;
        }
    }

}