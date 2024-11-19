<?php

namespace phpTest\src\App\Classes;

class ControllerFactory
{
    private string $namespace;
    private string $path;

    public function __construct(string $namespace, string $path)
    {
        $this->namespace = $namespace;
        $this->path = $path;
    }

    /**
     * Scans and creates controller instances.
     *
     * @return object[] List of controller instances
     */
    public function createControllers(): array
    {
        $controllers = [];
        $files = glob($this->path . '/*.php');

        foreach ($files as $file) {
            $className = $this->namespace . '\\' . basename($file, '.php');

            if (class_exists($className)) {
                $controllers[] = new $className();
            }
        }

        return $controllers;
    }
}