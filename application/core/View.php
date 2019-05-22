<?php


namespace application\core;

class View
{
    public $path;
    public $layout = 'default';

    public function __construct($route) {
        $this->path = $route['controller'] . '/' . $route['action'];
    }

    public function render($title, $vars = []) {
        $viewPath = 'application/views/' . $this->path . '.php';
        if (isFileExists($viewPath)) {
            $content = self::getContent($viewPath, $vars);
            require 'application/views/layouts/' . $this->layout . '.php';
        }
    }

    public static function errorPage($code) {
        $errorPath = 'application/views/errors/' . $code . '.php';
        if (isFileExists($errorPath)) {
            $title = 'Ошибка ' . $code;
            $content = self::getContent($errorPath, null);
            require 'application/views/layouts/default.php';
            exit;
        }
    }

    private static function getContent($viewPath, $vars) {
        if (!empty($vars))
            extract($vars);
        ob_start();
        require $viewPath;

        return ob_get_clean();
    }

    public function redirect($url) {
        header('location: ' . $url);
        exit;
    }

    public static function message($message) {
        echo "<script>alert(\"$message\");</script>";
    }
}