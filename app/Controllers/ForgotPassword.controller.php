<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class ForgotPassword extends Controller
{
    private mixed $auth;
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
        } else {
            URLHelper::redirect(BASE_URL . 'forgotPassword/checkEmail');
        }
    }
    public function checkEmail(): void
    {
        if ($this->auth->isLogIn()) {
            URLHelper::redirect(BASE_URL);
        } else {
            if (isset($_POST) && count($_POST) > 0) {
                $errors = $this->auth->validateAndSendVerificationCode($_POST);
                if (count($errors) == 0) {
                    URLHelper::redirect(BASE_URL . 'forgotPassword/CheckVerificationCode?email=' . $_POST['email']);
                } else {
                    $errors = [
                        'type' => 'warning',
                        'messages' => $errors
                    ];
                    $this->view('checkEmail', 'check email', [], $errors);
                }
            }
            else {
                $this->view('checkEmail', 'check email');
            }
        }
    }

    public function CheckVerificationCode(): void
    {
        if ($this->auth->isLogIn()) {
            URLHelper::redirect(BASE_URL);
        } else {
            if (isset($_POST) && count($_POST) > 0) {
                $errors = $this->auth->verifyEmailAndCode($_POST);
                if (count($errors) == 0) {
                    URLHelper::redirect(BASE_URL . 'forgotPassword/resetPassword');
                } else {
                    $errors = [
                        'type' => 'warning',
                        'messages' => $errors
                    ];
                    $this->view('checkVerificationCode', 'Check Verification Code', [], $errors);
                }
            }
            else {
                if (isset($_GET['email'])) {
                    $this->view('checkVerificationCode', 'Check Verification Code');
                } else {
                    URLHelper::redirect(BASE_URL . 'forgotPassword/checkEmail');
                }
            }
        }
    }

    public function resetPassword(): void
    {
        if ($this->auth->isLogIn()) {
            URLHelper::redirect(BASE_URL);
        } else {
            if (isset($_POST) && count($_POST) > 0) {
                $errors = $this->auth->resetPassword($_POST);
                if (count($errors) == 0) {
                    FlashMessage::setMessages('successfully', ['Password Updated successfully.']);
                    URLHelper::redirect(BASE_URL . 'login');
                } else {
                    $errors = [
                        'type' => 'warning',
                        'messages' => $errors
                    ];
                    $this->view('resetPassword', 'reset password', [], $errors);
                }
            }
            else {
                if (isset($_SESSION['userID'])) {
                    $this->view('resetPassword', 'reset password');
                } else {
                    URLHelper::redirect(BASE_URL . 'forgotPassword/checkEmail');
                }
            }
        }
    }
}