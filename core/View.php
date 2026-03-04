<?php

namespace PHPFramework;

class View
{

    public string $content = '';

    public function __construct(public string $layout)
    {
    }

    public function render(string $view, array $data = [], string|bool $layout = ''): string
    {
        extract($data);

        $viewFile = VIEWS . "/{$view}.php";
        if (is_file($viewFile)) {
            ob_start();
            require $viewFile;
            $this->content = ob_get_clean();
        } else {
            abort("Not found view {$viewFile}", 500);
        }

        if (false === $layout) {
            return $this->content;
        }

        $layoutFileName = $layout ?: $this->layout;
        $layoutFile = VIEWS . "/layouts/{$layoutFileName}.php";
        if (is_file($layoutFile)) {
            ob_start();
            require_once $layoutFile;
            return ob_get_clean();
        } else {
            abort("Not found layout {$layoutFile}", 500);
        }

        return '';
    }

    public function renderPartial($view, $data = []): string
    {
        extract($data);

        $viewFile = VIEWS . "/{$view}.php";
        if (is_file($viewFile)) {
            ob_start();
            require $viewFile;

            return ob_get_clean();
        } else {
            return "File view {$viewFile} not found";
        }
    }
}