<?php


namespace application\models;


use application\core\Model;

class Account extends Model
{
    public $name;
    public $password;
    public $date_of_birth;
    public $gender;

    public function setName($name) {
        $this->name = $name;
    }
    public function setPassword($password) {
        $this->password = $password;
    }
    public function setDateOfBirth($date_of_birth) {
        $this->date_of_birth = $date_of_birth;
    }
    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setAllAttributesToDatabase() {
        $this->db->setRow("INSERT INTO users SET name='" . $this->name .
            "', password='" . $this->password .
            "', date_of_birth='" . $this->date_of_birth .
            "', gender='" . $this->gender .
            "'");
    }

    public function getAllAttributesFromDatabase($name) {
        $user = [];

        $user['name'] = $name;
        $user['date_of_birth'] = $this->db->getColumn("SELECT date_of_birth FROM users WHERE name='" . $name . "'");
        $user['gender'] = $this->db->getColumn("SELECT gender FROM users WHERE name='" . $name . "'");

        return $user;
    }

    public function isNameUnique($name) {
        $result = $this->db->getRow("SELECT name FROM users WHERE name='" . $name . "'");
        if (empty($result))
            return true;
        else
            return false;
    }

    public function isNameAndPasswordExist($name, $password) {
        $result = $this->db->getRow("SELECT name FROM users WHERE name='" . $name .
            "' AND password='" . $password . "'");
        if (empty($result))
            return false;
        else
            return true;
    }
}