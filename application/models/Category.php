<?php


namespace application\models;


use application\core\Model;

class Category extends Model
{
    public $id;
    public $name;

    public function setId($id) {
        $this->id = $id;
    }
    public function setName($name) {
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }
    public function getName() {
        return $this->name;
    }

    public function getCategories() {
        $categories = $this->db->getRows('SELECT id, name FROM category');

        return $categories;
    }

    public function getCategoryNameById($id) {
        $category = $this->db->getRow("SELECT name FROM category WHERE id='" . $id . "'");

        return $category['name'];
    }
}