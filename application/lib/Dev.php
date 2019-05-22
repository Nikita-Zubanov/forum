<?php

use application\core\View;

ini_set('display_errors', 1);
error_reporting(E_ALL);

function debug($string) {
    echo '<br>' . '<br>' . '<br>' . '<br>' . '<br>';
    echo '<pre>';
    var_dump($string);
    echo '</pre>';
}

function isArrayFull($array) {
    if (empty($array)) {
        View::errorPage(404);
        return false;
    } else
        return true;
}

function isPostFull($post) {
    if (empty($post))
        return false;
    else {
        foreach ($post as $key => $value)
            if (empty($value))
                return false;
    }

    return true;
}
function isPostFullAndIssetAttribute($post, $attribute) {
    if (empty($post) || empty($post[$attribute]))
        return false;
    else {
        foreach ($post as $key => $value)
            if (empty($value))
                return false;
    }

    return true;
}

function isClassExists($path) {
    if (!class_exists($path)) {
        View::errorPage(404);
        return false;
    } else
        return true;
}

function isMethodExists($path, $method) {
    if (!method_exists($path, $method)) {
        View::errorPage(404);
        return false;
    } else
        return true;
}

function isFileExists($path) {
    if (!file_exists($path)) {
        View::errorPage(404);
        return false;
    } else
        return true;
}
