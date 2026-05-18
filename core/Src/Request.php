<?php

namespace Src;

use Error;

class Request
{
    protected array $body;
    public string $method;
    public array $headers;

    public function __construct()
    {
        $this->body = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders() ?? [];
        // Добавляем URI
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    public function all(): array
    {
        return $this->body + $this->files();
    }

    public function set($field, $value):void
    {
        $this->body[$field] = $value;
    }

    public function get($field)
    {
        return $this->body[$field];
    }

    public function files(): array
    {
        return $_FILES;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->body)) {
            return $this->body[$key];
        }
        if ($key === 'uri') {
            return $this->uri;
        }
        throw new Error('Accessing a non-existent property');
    }

    // Новый метод для получения URI
    public function uri(): string
    {
        return $this->uri;
    }

    private string $uri;
}