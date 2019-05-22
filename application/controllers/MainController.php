<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Articles;
use application\models\Category;

class MainController extends Controller
{
    public function indexAction() {
        $article = new Articles();
        $category = new Category();

        $this->redirectBySelect($_POST);

        $myArticles = [];
        if ($this->isUserAuthorized($_SESSION) ) {
            $myArticles = $article->getSortedAndTrimmedArticlesByColumn('date_publication', 'author', $_SESSION['authorize']['name']);
            $myArticles = $this->model->getArticlesPage($myArticles);
        }

        $articlesByViews = $article->getSortedAndTrimmedArticles('views');
        $mostPopularArticles = $this->model->getArticlesPage($articlesByViews);

        $categories = $category->getCategories();

        $user = $_SESSION['authorize']['name'];

        $vars = [
            'mostPopularArticles' => $mostPopularArticles,
            'categories' => $categories,
            'user' => $user,
            'myArticles' => $myArticles,
        ];

        $this->view->render('Главная страница', $vars);
    }
}