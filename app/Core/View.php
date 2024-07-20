<?php

namespace Core;

final class View {
    private array $data;
    private string $template;
    public function __construct(string $template = '404', array $data = [])
    {
        $this->data = $data;
        $this->template = $template;
        $this->renderView();
    }

    public final function renderView() : void
    {
        $viewPath = VIEWS . $this->template . '.view.php';

        $data = $this->data;

        if (file_exists($viewPath)) {
            require_once $viewPath;
        }
        else {
            require_once VIEWS . '404' . '.view.php';
        }
    }
}