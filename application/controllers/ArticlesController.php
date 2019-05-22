<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\models\Comment;
use application\models\Main;
use application\models\Category;

class ArticlesController extends Controller
{
    public function articleAction() {
        $comment = new Comment();

        $this->model->setId($_SESSION['article']['id']);
        $this->model->addViewToDatabase();

        if (isPostFullAndIssetAttribute($_POST, 'edit'))
            $this->view->redirect('\articles\editArticle');

        if (isPostFullAndIssetAttribute($_POST, 'comment')) {
            if ($this->isUserAuthorized($_SESSION)) {
                $comment->setAuthor($_SESSION['authorize']['name']);
                $comment->setArticleId($_SESSION['article']['id']);
                $comment->setComment($_POST['commentText']);

                $comment->setCommentToDatabase();

                header("Refresh:0");
            } else
                $this->view->message('Войдите в свой аккаунт или зарегестрируйтесь!');
        }

        $this->model->setId($_SESSION['article']['id']);
        $article = $this->model->getArticle();

        $comment->setArticleId($_SESSION['article']['id']);
        $comments = $comment->getCommentsFromDatabase();

        $user = $_SESSION['authorize']['name'];

        $vars = [
            'article' => $article,
            'comments' => $comments,
            'user' => $user,
        ];

        $this->view->render($vars['article']['title'], $vars);
    }

    public function categoryArticlesAction() {
        $main = new Main();
        $category = new Category();

        $this->redirectBySelect($_POST);

        $articlesByCategory = $this->model->getSortedAndTrimmedArticlesByColumn('date_publication', 'category', $_SESSION['article']['category_name']);
        $numberPage = $main->getCurrentNumberPage($_POST, 'page');

        $currentArticlesPage = $main->getCurrentArticlesPage($articlesByCategory, $numberPage);
        $countPages = $main->getCountPages($articlesByCategory);
        $categories = $category->getCategories();
        $categoryName = $_SESSION['article']['category_name'];

        $vars = [
            'articles' => $currentArticlesPage,
            'countPages' => $countPages,
            'categories' => $categories,
            'categoryName' => $categoryName,
        ];

        $this->view->render($_SESSION['article']['category_name'], $vars);
    }

    public function allArticlesAction() {
        $main = new Main();
        $category = new Category();

        $this->redirectBySelect($_POST);

        $articlesByDatePublication = $this->model->getSortedAndTrimmedArticles('date_publication');
        $numberPage = $main->getCurrentNumberPage($_POST, 'page');

        $currentArticlesPage = $main->getCurrentArticlesPage($articlesByDatePublication, $numberPage);
        $countPages = $main->getCountPages($articlesByDatePublication);
        $categories = $category->getCategories();

        $vars = [
            'articles' => $currentArticlesPage,
            'countPages' => $countPages,
            'categories' => $categories,
        ];

        $this->view->render('Все статьи', $vars);
    }

    public function addArticleAction() {
        $category = new Category();

        if (!empty($_POST) ) {
            if (isPostFull($_POST)) {
                $this->model->setTitle($_POST['title']);
                $this->model->setCategory($_POST['category']);
                $this->model->setText($_POST['text']);
                $this->model->setAuthor($_SESSION['authorize']['name']);

                $this->model->setArticleToDatabase();

                $this->view->redirect('\\');
            } else
                View::message('Заполните все данные.');
        }

        $categories = $category->getCategories();

        $vars = [
            'categories' => $categories,
        ];

        $this->view->render('Добавить статью', $vars);
    }

    public function editArticleAction() {
        $category = new Category();

        if (!empty($_POST) ) {
            if (isPostFull($_POST)) {
                $this->model->setId($_SESSION['article']['id']);
                $this->model->setTitle($_POST['title']);
                $this->model->setCategory($_POST['category']);
                $this->model->setText($_POST['text']);
                $this->model->setAuthor($_SESSION['authorize']['name']);

                $this->model->updateArticleToDatabase();

                $this->view->redirect('\\');
            } else
                View::message('Заполните все данные.');
        }

        $this->model->setId($_SESSION['article']['id']);
        $article = $this->model->getArticle();

        $categories = $category->getCategories();

        $vars = [
            'article' => $article,
            'categories' => $categories,
        ];

        $this->view->render('Изменить статью', $vars);
    }

    public function myArticlesAction() {
        $main = new Main();
        $category = new Category();

        $this->redirectBySelect($_POST);

        $myArticles = $this->model->getSortedAndTrimmedArticlesByColumn('date_publication', 'author', $_SESSION['authorize']['name']);
        $numberPage = $main->getCurrentNumberPage($_POST, 'page');

        $currentMyArticlesPage = $main->getCurrentArticlesPage($myArticles, $numberPage);
        $countPages = $main->getCountPages($myArticles);
        $categories = $category->getCategories();

        $vars = [
            'articles' => $currentMyArticlesPage,
            'countPages' => $countPages,
            'categories' => $categories,
        ];

        $this->view->render('Мои статьи', $vars);
    }
}