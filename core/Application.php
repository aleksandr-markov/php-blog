<?php

namespace PHPFramework;

class Application
{
    public Request $request;
    public Response $response;
    protected string $uri;
    public static Application $app;
    public Router $router;
    public View $view;
    public Session $session;
    public Database $db;

    public function __construct()
    {
        self::$app = $this;

        $this->uri = $_SERVER['REQUEST_URI'];
        $this->request = new Request($this->uri);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View(LAYOUT);
        $this->session = new Session();
        $this->db = new Database();

        $this->generateCsrfToken();
    }

    public function run(): void
    {
        echo $this->router->dispatch();
    }

    public function generateCsrfToken(): void
    {
        if (!session()->has('csrf_token')) {
            session()->set('csrf_token', md5(uniqid(mt_rand(), true)));
        }
    }
}