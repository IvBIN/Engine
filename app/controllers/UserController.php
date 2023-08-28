<?php
namespace app\controllers;
use app\core\InitController;

class UserController extends InitController
{
    public function actionProfile(){
        echo 'Страница профиля';
        var_dump($this->route);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'rules' =>[
                    [
                        'actions' => ['login'],
                        'roles' => ['quest'],
                        'matchCallback' => function () {
                            $this->redirect('/user/profile');
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionRegistration()
    {
        $this->view->title = 'Регистрация';
        $error_message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['btn_registration_form'])) {
            $username = !empty($_POST['username']) ? $_POST['username'] : null;
            $login = !empty($_POST['login']) ? $_POST['login'] : null;
            $password = !empty($_POST['password']) ? $_POST['password'] : null;
            $confirm_password = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : null;
        }
        $this->render('registration', [
            'error_message' =>$error_message
        ]);
    }
}



