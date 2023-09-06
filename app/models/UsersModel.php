<?php

namespace app\models;

use app\core\BaseModel;

class UsersModel extends BaseModel
{
    public function addNewUser($username, $login, $password)
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        return $this->insert(
            "INSERT INTO users (username, login, password) VALUES (:username, :login, :password)",
            [
                'username' => $username,
                'login' => $login,
                'password' => $password,
            ]
        );
    }

    public function authBylogin($login, $password)
    {
        $result = false;
        $error_message = '';
        if (empty($login)) {
            $error_message .= "Введите ваш логин!<br>";
        }
        if (empty($password)) {
            $error_message .= "Введите пароль!<br>";
        }
        if (empty($error_message)) {
            $users = $this->select('select * from users where login = :login', [
                'login' => $login
            ]);
            if (!empty($users[0])) {
                $passwordCorrect = password_verify($password, $users[0]['password']);
                if ($passwordCorrect) {
                    $_SESSION['user']['id'] = $users[0]['id'];
                    $_SESSION['user']['username'] = $users[0]['username'];
                    $_SESSION['user']['login'] = $users[0]['login'];
                    $_SESSION['user']['is_admin'] = ($users[0]['is_admin'] == '1');
                    $result = true;
                } else {
                    $error_message .= "Неверный логин или пароль! <br>";
                }
            } else {
                $error_message .= "Пользователь не найден! <br>";
            }
        }
        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }

    public function changePasswordByCurrentPassword($current_password, $new_password, $confirm_new_password)
    {
        $result = false;
        $error_message = '';

        if (empty($current_password)) {
            $error_message .= "Введите текущий пароль!<br>";
        }
        if (empty($new_password)) {
            $error_message .= "Введите новый пароль!<br>";
        }
        if (empty($confirm_new_password)) {
            $error_message .= "Повторите новый пароль!<br>";
        }
        if ($new_password != $confirm_new_password) {
            $error_message .= "Пароли не совпадают!<br>";
        }

        return [
            'result' => $result,
            'error_message' => $error_message
        ];
    }
}