<?php

return [
    '' => [
        'controller' => 'main',
        'action' => 'index',
        ],
    'articles/article' => [
        'controller' => 'articles',
        'action' => 'article',
    ],
    'articles/articles' => [
        'controller' => 'articles',
        'action' => 'articles',
    ],
    'articles/allArticles' => [
        'controller' => 'articles',
        'action' => 'allArticles',
    ],
    'articles/categoryArticles' => [
        'controller' => 'articles',
        'action' => 'categoryArticles',
    ],
    'articles/addArticle' => [
        'controller' => 'articles',
        'action' => 'addArticle',
    ],
    'articles/editArticle' => [
        'controller' => 'articles',
        'action' => 'editArticle',
    ],
    'articles/myArticles' => [
        'controller' => 'articles',
        'action' => 'myArticles',
    ],
    'account/profile' => [
        'controller' => 'account',
        'action' => 'profile',
    ],
    'account/login' => [
        'controller' => 'account',
        'action' => 'login',
        ],
    'account/register' => [
        'controller' => 'account',
        'action' => 'register',
        ],
];