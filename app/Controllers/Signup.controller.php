<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Signup extends Controller
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
        if ($this->auth->isLogIn()) {
            URLHelper::redirect(BASE_URL);
        }
        else {
            $errors = [];
            if (isset($_POST) && count($_POST) > 0) {
                $errors = $this->auth->signup($_POST);
                if (count($errors) == 0) {
                    FlashMessage::setMessages('successfully', ['Congratulations! Your account has been successfully created. You can now log in with your credentials.']);
                    URLHelper::redirect(BASE_URL . 'login');
                } else {
                    $errors = [
                        'type' => 'warning',
                        'messages' => $errors
                    ];
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
            }
            $this->view('addUser', 'signup', [], $errors);
        }
    }
}