<?php

namespace phpTest\App;

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;

class App
{
    public function run(): void
    {
        $request = Request::createFromGlobals();
        $httpMethod = $request->getMethod();
        $uri = $request->getPathInfo();

        $dotenv = new Dotenv();
        $dotenv->loadEnv(__DIR__ . '/../.env');

        $router = new Routes();
        $router->dispatch($httpMethod, $uri, $request);
    }
}