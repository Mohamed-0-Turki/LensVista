<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Login extends Controller
{
    public mixed $auth;
    public function __construct(){
        $this->auth = $this->model('Auth');
    }

    public function __call($name, $arguments): void
    {
        $this->view();
    }


    public function index(): void
    {
        $errors = [];
        if ($this->auth->isLogIn()) {
            URLHelper::redirect(BASE_URL);
        }
        else {
            if (isset($_POST) && count($_POST) > 0) {
                $errors = $this->auth->login($_POST);
                if (count($errors) == 0) {
                    URLHelper::redirect(BASE_URL);
                } else {
                    $errors = [
                        'type' => 'warning',
                        'messages' => $errors
                    ];
                    $this->view('login', 'login', [],  $errors);
                }
            }
            else {
                $flashMessage = FlashMessage::getMessages();
                if (count($flashMessage) > 0) {
                    $errors = [
                        'type' => $flashMessage['type'],
                        'messages' => $flashMessage['message']
                    ];
                }
                $this->view('login', 'login', [], $errors);
            }
        }
    }
}