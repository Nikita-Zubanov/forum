<?php


namespace application\models;


use application\core\Model;

class Articles extends Model
{
    public $id;
    public $title;
    public $category;
    public $text;
    public $author;

    const NUMBER_WORDS_IN_ARTICLE = 250;
    const NUMBER_ARTICLES_ON_PAGE = 5;

    public function setId($id) {
        $this->id = $id;
    }
    public function setTitle($title) {
        $this->title = $title;
    }
    public function setCategory($category) {
        $this->category = $category;
    }
    public function setText($text) {
        $this->text = $text;
    }
    public function setAuthor($author) {
        $this->author = $author;
    }

    public function addViewToDatabase() {
        $currentViews = $this->db->getRow("SELECT views FROM articles WHERE id='" . $this->id . "'");
        $views = intval($currentViews['views']) + 1;

        $this->db->setRow("UPDATE articles SET views='" . $views .
            "' WHERE id='" . $this->id . "'");
    }
    public function setArticleToDatabase() {
        $this->db->setRow("INSERT INTO articles SET title='" . $this->title .
            "', category='" . $this->category .
            "', text='" . $this->text .
            "', author='" . $this->author .
            "'");
    }
    public function updateArticleToDatabase() {
        $this->db->updateRow("UPDATE articles SET title='" . $this->title .
            "', category='" . $this->category .
            "', text='" . $this->text .
            "', author='" . $this->author .
            "' WHERE id='" . $this->id . "'");
    }

    public function getArticles() {
        $articles = $this->db->getRows('SELECT id, title, category, text, author, views, date_publication FROM articles');

        return $articles;
    }
    public function getArticle() {
        $result = $this->db->getRow("SELECT title, category, text, author, views, date_publication FROM articles WHERE id='" . $this->id . "'");

        return $result;
    }

    public function getSortedAndTrimmedArticles($sortedByColumn) {
        $articles = $this->db->getRows('SELECT id, title, category, text, author, views, date_publication FROM articles');

        $articles = self::getSortedArticles($articles, $sortedByColumn);
        $articles = self::getTrimmedTextArticle($articles);

        return $articles;
    }
    public function getSortedAndTrimmedArticlesByColumn($sortedByColumn, $column, $columnValue) {
        $articles = $this->db->getRows('SELECT id, title, category, text, author, views, date_publication FROM articles');

        $articles = self::getArticlesByColumn($articles, $column, $columnValue);
        $articles = self::getSortedArticles($articles, $sortedByColumn);
        $articles = self::getTrimmedTextArticle($articles);

        return $articles;
    }
    private function getSortedArticles($articles, $sortedByColumn) {
        for ($i = 0; $i < count($articles); $i++)
            foreach ($articles as $keyArticle => $article)
                if (next($articles)) {
                    $currentColumn = $articles[$keyArticle][$sortedByColumn];
                    $nextColumn = $articles[$keyArticle + 1][$sortedByColumn];

                    if ($currentColumn < $nextColumn) {
                        $currentArticle = $articles[$keyArticle];
                        $articles[$keyArticle] = $articles[$keyArticle + 1];
                        $articles[$keyArticle + 1] = $currentArticle;
                    }
                }

        return $articles;
    }
    private function getTrimmedTextArticle($articles) {
        foreach ($articles as $key => $article) {
            $articles[$key]['text'] = self::getTrimmedText($articles[$key]['text']);
        }

        return $articles;
    }
    private function getTrimmedText($text) {
        $countSpaces = 0;
        $trimmedText = '';
        for ($i = 0; $i < strlen($text); $i++) {
            if ($text[$i] == ' ') {
                $countSpaces++;
                if ($countSpaces > self::NUMBER_WORDS_IN_ARTICLE) {
                    $trimmedText = rtrim($trimmedText, ',.!?:;(') . '...';
                    return $trimmedText;
                }
            }

            $trimmedText .= $text[$i];
        }

        return $trimmedText;
    }
    private function getArticlesByColumn($articles, $columnName, $columnValue) {
        $articlesByCategory = [];
        $couner = 0;

        foreach ($articles as $keyArticle => $article)
            if ($article[$columnName] == $columnValue) {
                $articlesByCategory[$couner] = array_merge($articlesByCategory, $article);
                $couner++;
            }

        return $articlesByCategory;
    }
}