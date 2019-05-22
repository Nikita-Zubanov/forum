<?php


namespace application\core;

use application\core\View;
use application\models\Account;

abstract class Controller
{
    public $route = [];
    public $acl = [];

    public $view;
    public $model;

    public function __construct($route) {
        $this->route = $route;

        if (self::isAllowedAcl()) {
            $this->view = new View($route);
            $this->model = self::loadModel($route['controller']);
        }
        else
            View::errorPage(403);
    }
    public function loadModel($nameModel) {
        $path = 'application\models\\' . ucfirst($nameModel);

        return new $path;
    }
    protected function isAllowedAcl() {
        $this->acl = require 'application/acl/' . $this->route['controller'] . '.php';

        if (self::isHaveAcl('authorize') and isset($_SESSION['authorize']['name']))
            return true;
        elseif (self::isHaveAcl('guest'))
            return true;

        return false;
    }
    protected function isHaveAcl($key) {
        if (in_array($this->route['action'], $this->acl[$key]))
            return true;

        return false;
    }

    protected function setSessionArticle($attributes) {
        if (isset($attributes['articleId']))
            $_SESSION['article']['id'] = $attributes['articleId'];
        if (isset($attributes['categoryName']))
            $_SESSION['article']['category_name'] = $attributes['categoryName'];
    }
    protected function setSessionAuthorize($user) {
        $_SESSION['authorize']['name'] = $user['name'];
        $_SESSION['authorize']['date_of_birth'] = date_format(date_create($user['date_of_birth']), 'd/m/Y');
        $_SESSION['authorize']['gender'] = $user['gender'];
    }
    protected function sessionDestroy() {
        session_destroy();
    }

    protected function isUserAuthorized($session) {
        if (isset($session['authorize']))
            return true;
        else
            return false;
    }

    protected function redirectBySelect($post) {
        if ($this->isTransitionToArticle($post) ) {
            $this->setSessionArticle($post);

            $this->view->redirect('\articles\article');
        } elseif ($this->isTransitionToCategoryArticles($post) ) {
            $this->setSessionArticle($post);

            $this->view->redirect('\articles\categoryArticles');
        } elseif ($this->isTransitionToAllArticles($post) ) {
            $this->view->redirect('\articles\allArticles');
        } elseif ($this->isTransitionToMyArticles($post) ) {
            $this->view->redirect('\articles\myArticles');
        } elseif ($this->isTransitionToAddArticle($post) ) {
            $this->view->redirect('\articles\addArticle');
        }
    }

    private function isTransitionToArticle($post) {
        if (isset($post['articleId']))
            return true;
        else
            return false;
    }
    private function isTransitionToCategoryArticles($post) {
        if (isset($post['categoryName']))
            return true;
        else
            return false;
    }
    private function isTransitionToAllArticles($post) {
        if (isset($post['allArticles']))
            return true;
        else
            return false;
    }
    private function isTransitionToMyArticles($post) {
        if (isset($post['myArticles']))
            return true;
        else
            return false;
    }
    private function isTransitionToAddArticle($post) {
        if (isset($post['addArticle']))
            return true;
        else
            return false;
    }
}