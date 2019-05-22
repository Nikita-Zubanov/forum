<?php

namespace application\models;

use application\core\Model;
use application\models\Articles;

class Main extends Model
{
    const NUMBER_MOST_POPULAR_ARTICLES_ON_PAGE = 3;

    public function getArticlesPage($articles) {
        $articles = array_slice($articles, 0,self::NUMBER_MOST_POPULAR_ARTICLES_ON_PAGE);

        return $articles;
    }

    public function getCurrentArticlesPage($arrayArticles, $numberPage) {
        $articles = array_slice(
            $arrayArticles,
            (Articles::NUMBER_ARTICLES_ON_PAGE * $numberPage) - Articles::NUMBER_ARTICLES_ON_PAGE,
            Articles::NUMBER_ARTICLES_ON_PAGE * $numberPage
        );

        return $articles;
    }

    public function getCurrentNumberPage($post, $key) {
        if (isset($post[$key]))
            $numberPage = $post[$key];
        else
            $numberPage = 1;

        return $numberPage;
    }

    public function getCountPages($arrayArticles) {
        $countPages = ceil(
            count($arrayArticles) / Articles::NUMBER_ARTICLES_ON_PAGE
        );

        return $countPages;
    }
}