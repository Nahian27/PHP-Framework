<?php

namespace phpTest\App;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use phpTest\App\Controllers\HomeController;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\Request;

use function FastRoute\simpleDispatcher;

class Routes
{
    private Dispatcher $dispatcher;

    public function __construct()
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $r->get('/', [HomeController::class, 'list']);
            $r->get('/{id}', [HomeController::class, 'single']);
        });
    }

    public function dispatch(string $httpMethod, string $uri, Request $request): void
    {
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                echo '404 Not Found';
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                echo '405 Method Not Allowed';
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                [$controller, $method] = $handler;
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