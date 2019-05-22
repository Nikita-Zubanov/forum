<?php


namespace application\models;


use application\core\Model;

class Comment extends Model
{
    public $author;
    public $article_id;
    public $comment;

    public function setAuthor($author) {
        $this->author = $author;
    }
    public function setArticleId($article_id) {
        $this->article_id = $article_id;
    }
    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setCommentToDatabase() {
        $this->db->setRow("INSERT INTO comments SET author='" . $this->author .
            "', article_id='" . $this->article_id .
            "', comment='" . $this->comment .
            "'");
    }

    public function getCommentsFromDatabase() {
        $comment = $this->db->getRows("SELECT author, article_id, comment FROM comments WHERE article_id='" . $this->article_id . "'");

        return $comment;
    }
}