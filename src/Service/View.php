<?php


namespace App\Service;

class View
{
    public function __construct()
    {
    }

    public function render(String $view, Array $params = [])
    {
        ob_start();
        include PROJECT_ROOT . '/src/Views/' . $view . '.php';
        return ob_get_clean();
    }
}

