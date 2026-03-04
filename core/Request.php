<?php

namespace PHPFramework;

class Request
{
    public string $uri;

    public function __construct($uri)
    {
        $this->uri = trim(urldecode($uri), '/');
    }

    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }

    public function isGet(): bool
    {
        return $this->getMethod() == 'GET';
    }

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function get($name, $default = null): ?string
    {
        return $_GET[$name] ?? $default;
    }

    public function post($name, $default = null): ?string
    {
        return $_POST[$name] ?? $default;
    }

    public function getPath(): string
    {
        return $this->removeQueryString();
    }

    protected function removeQueryString(): string
    {
        if (!$this->uri) {
            return '';
        }

        $params = explode('?', $this->uri);

        return trim($params[0], '/');
    }

    public function getData(): array
    {
        $data = [];
        $requestData = $this->isPost() ? $_POST : $_GET;

        foreach ($requestData as $key => $value) {
            if (is_string($value)) {
                $value = trim($value);
            }

            $data[$key] = $value;
        }

        return $data;
    }
}