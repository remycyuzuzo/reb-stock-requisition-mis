<?php

// namespace App\Router;

class Router
{

    // an array to store handlers
    private array $handlers;
    // Request method constants
    private const METHOD_POST = "POST";
    private const METHOD_GET = "GET";

    // for handling every get request
    public function get($path, $handler)
    {
        $this->addHandler($this->METHOD_POST, $path, $handler);
    }

    // for handling every POST request
    public function post($path, $handler)
    {
        $this->addHandler($this->METHOD_POST, $path, $handler);
    }

    // Add a handler to the local property
    private function addHandler(string $method, string $path, $handler)
    {
        $this->handlers[$method . $path] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    // execute handlers
    public function execute()
    {
        $callback = null;
        foreach ($this->handlers as $key => $handler) {
            $callback = $handler["handler"];
        }
    }
}
