<?php

namespace application\lib;

use PDO;

class Database
{
    protected $db;

    public function __construct() {
        $config = require 'application/config/database.php';
        $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbName'], $config['user'], $config['password']);
    }

    public function setRow($sql) {
        $result = self::getQuery($sql);
    }

    public function updateRow($sql) {
        $result = self::getQuery($sql);
    }

    public function getColumn($sql) {
        $result = self::getQuery($sql);
        $result = $result->fetchColumn();

        return $result;
    }

    public function getRow($sql) {
        $result = self::getQuery($sql);
        $result = $result->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getRows($sql) {
        $result = self::getQuery($sql);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getQuery($sql) {
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query;
    }
}