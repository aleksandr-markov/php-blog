<?php

namespace PHPFramework;

use PHPFramework\Exceptions\CsrfTokenException;

class Router
{
    protected array $routes = [];
    protected array $routeParams = [];

    public function __construct(protected Request $request, protected Response $response)
    {
    }

    public function add(string $path, callable|array $callback, string|array $method): self
    {
        $path = trim($path, '/');
        if (is_array($method)) {
            $method = array_map('strtoupper', $method);
        } else {
            $method = [strtoupper($method)];
        }

        $this->routes[] = [
            'path' => "/$path",
            'callback' => $callback,
            'middleware' => [],
            'method' => $method,
            'needCsrfToken' => true,
        ];

        return $this;
    }

    public function get(string $path, callable|array $callback): self
    {
        return $this->add($path, $callback, 'GET');
    }

    public function post(string $path, callable|array $callback): self
    {
        return $this->add($path, $callback, 'POST');
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function dispatch(): mixed
    {
        $path = $this->request->getPath();
        try {
            $route = $this->matchRoute($path);
        } catch (CsrfTokenException) {
            $this->handleCsrfError();
        }

        if (!$route) {
            abort();
        }

        if (is_array($route['callback'])) {
            $route['callback'][0] = new $route['callback'][0];
        }

        return call_user_func($route['callback']);
    }

    private function handleCsrfError(): never
    {
        if ($this->request->isAjax()) {
            echo json_encode(['status' => 'error', 'data' => 'Security error']);
            die;
        }

        abort('Page expired', 419);
    }

    /**
     * @throws CsrfTokenException
     */
    protected function matchRoute($path): mixed
    {
        foreach ($this->routes as $route) {
            if (!$this->isRouteMatch($route, $path, $matches)) {
                continue;
            }

            $this->handleCsrf($route);
            $this->extractRouteParams($matches);
            $this->handleMiddleware($route);

            return $route;
        }

        return false;
    }

    private function isRouteMatch(array $route, string $path, ?array &$matches): bool
    {
        return preg_match("#^{$route['path']}$#", "/{$path}", $matches) && in_array($this->request->getMethod(),
                $route['method']);
    }

    private function extractRouteParams(array $matches): void
    {
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $this->routeParams[$key] = $value;
            }
        }
    }

    /**
     * @throws CsrfTokenException
     */
    private function handleCsrf(array $route): void
    {
        if ($this->request->isPost() && $route['needCsrfToken'] && !$this->checkCsrfToken()) {
            throw new CsrfTokenException();
        }
    }

    private function handleMiddleware(array $route): void
    {
        $registeredMiddlewares = MIDDLEWARE;
        $routeMiddlewares = $route['middleware'] ?? [];

        foreach ($routeMiddlewares as $middlewareName) {
            $isMiddlewareRegistered = isset($registeredMiddlewares[$middlewareName]);

            if (!$isMiddlewareRegistered) {
                continue;
            }

            $middlewareClass = $registeredMiddlewares[$middlewareName];
            (new $middlewareClass)->handle();
        }
    }

    public function checkCsrfToken(): bool
    {
        $csrfTokenFromPost = $this->request->post('csrf_token');

        return $csrfTokenFromPost && ($csrfTokenFromPost === session()->get('csrf_token'));
    }

    public function withoutCsrfToken(): self
    {
        $this->routes[array_key_last($this->routes)]['needCsrfToken'] = false;

        return $this;
    }

    public function middleware(array $middleware): self
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $middleware;

        return $this;
    }
}