<?php

namespace phpTest\src\App;

use FastRoute\RouteCollector;
use phpTest\src\App\Classes\ControllerFactory;
use phpTest\src\App\Classes\RouteLoader;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Dotenv\Exception\FormatException;
use Symfony\Component\Dotenv\Exception\PathException;
use Symfony\Component\HttpFoundation\Request;

use function FastRoute\simpleDispatcher;

class App
{
    public function run(): void
    {
        $request = Request::createFromGlobals();

        $dotenv = new Dotenv();
        try {
            $dotenv->loadEnv(__DIR__ . '/../../.env');
        } catch (FormatException|PathException $e) {
            echo 'Env Error: ' . $e->getMessage();
        }

        $factory = new ControllerFactory('phpTest\\src\\Controllers', __DIR__ . '/../Controllers');
        $controllers = $factory->createControllers();
        $router = new RouteLoader($controllers);
        $dispatcher = simpleDispatcher(function (RouteCollector $r) use ($router) {
            $router->collectRoutes($r);
        });
        $router->dispatch($request, $dispatcher);
    }
}