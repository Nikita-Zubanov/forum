<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\models\Account;

class AccountController extends Controller
{
    public function loginAction() {
        if (isPostFull($_POST) || isset($_POST['path'])) {
            if ($this->view->path != $_POST['path']) {
                $this->view->redirect('\\' . $_POST['path']);
            } elseif ($this->view->path == $_POST['path']) {
                $account = new Account;
                if ($account->isNameAndPasswordExist($_POST['name'], $_POST['password'])) {
                    $user = $account->getAllAttributesFromDatabase($_POST['name']);
                    $this->setSessionAuthorize($user);

                    $this->view->redirect('\account\profile\\');
                } else
                    View::message('Неправильно введен логин или пароль.');
            } else
                View::message('Заполните все данные.');
        }

        $this->view->render('Авторизация');
    }

    public function registerAction() {
        if (isPostFull($_POST)) {
            $account = new Account;
            if ($account->isNameUnique($_POST['name'])) {
                $account->setName($_POST['name']);
                $account->setPassword($_POST['password']);
                $account->setDateOfBirth($_POST['date_of_birth']);
                $account->setGender($_POST['gender']);

                $account->setAllAttributesToDatabase();

                $user = $account->getAllAttributesFromDatabase($_POST['name']);
                $this->setSessionAuthorize($user);

                $this->view->redirect('profile\\');
            } else
                View::message('Пользователь с таким логином уже существует.');
        } elseif (isset($_POST['register']))
            View::message('Заполните все данные.');

        $this->view->render('Регистрация');
    }

    public function profileAction() {
        $vars = [];
        if ($this->isUserAuthorized($_SESSION)) {
            if(isset($_POST['exit'])) {
                $this->sessionDestroy();

                $this->view->redirect('\account\login\\');
            }

            $vars = [
                'name' => $_SESSION['authorize']['name'],
                'date_of_birth' => $_SESSION['authorize']['date_of_birth'],
                'gender' => $_SESSION['authorize']['gender'],
            ];
        } else
            $this->view->redirect('\account\login\\');

        $this->view->render('Профиль', $vars);
    }
}