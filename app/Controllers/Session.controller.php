<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Session extends Controller
{
    private mixed $auth;
    private mixed $user;
    private mixed $buyer;
    public function __construct() {
        $this->auth = $this->model('Auth');
        $this->user = $this->model('User');
        $this->buyer = $this->model('Buyer');
    }

    public function __call($name, $arguments): void
    {
        $this->view();
    }

    public function profile(string $userID = ''): void
    {
        if ($this->auth->isLogIn()) {
            if (empty($userID)) {
                FlashMessage::setMessages('warning', ['There Is An Error occurred Please Try Again.']);
                URLHelper::redirect(URLHelper::appendToBaseURL('home'));
            }
            else {
                if (($_SESSION['USER']['role'] === 'buyer' && $userID == $_SESSION['USER']['userID']) || ($_SESSION['USER']['role'] === 'admin')) {
                    $errors = [];
                    if ((isset($_POST) && count($_POST) > 0) || (isset($_FILES) && count($_FILES) > 0)) {
                        $errors = $this->buyer->updateProfile($userID, $_POST, $_FILES);
                        if (count($errors) > 0) {
                            $errors = [
                                'type' => 'warning',
                                'messages' => $errors
                            ];
                        }
                        else {
                            $errors = [
                                'type' => 'successfully',
                                'messages' => ['Your active data has been updated.']
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
                    $data = [
                        'personalData' => $this->buyer->fetchProfile($userID)[0],
                        'orders' => $this->buyer->fetchBuyerOrders($userID)
                    ];
                    $this->view('profile', 'profile', $data, $errors);
                }
                else {
                    FlashMessage::setMessages('warning', ['There Is An Error occurred Please Try Again.']);
                    URLHelper::redirect(URLHelper::appendToBaseURL('home'));
                }
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    public function logout(): void
    {
        $this->auth->logout();
        URLHelper::redirect(BASE_URL . 'login');
    }

    public function deleteAccount(string $userID = ''): void
    {
        if ($this->auth->isLogIn() && ($_SESSION['USER']['role'] === 'buyer' || $_SESSION['USER']['role'] === 'admin')) {
            if (! empty($userID)) {
                if ($this->buyer->deleteUserAccount($_SESSION['USER']['userID'])) {
                    FlashMessage::setMessages('successfully', ['Account deleted successfully.']);
                    $this->logout();
                }
                else {
                    FlashMessage::setMessages('warning', ['Your profile can not be deleted.']);
                    URLHelper::redirect(URLHelper::appendToBaseURL('session/profile/' . $_SESSION['USER']['userID']));
                }
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    public function deleteProfileImage(string $userID = ''): void
    {
        if ($this->auth->isLogIn()) {
            if (! empty($userID)) {
                if (($_SESSION['USER']['role'] === 'buyer' && $userID == $_SESSION['USER']['userID']) || ($_SESSION['USER']['role'] === 'admin')) {
                    if ($this->user->deleteProfileImage($userID)) {
                        FlashMessage::setMessages('successfully', ['Your profile image has been deleted successfully.']);
                    }
                    else {
                        FlashMessage::setMessages('warning', ['Your profile image could not be deleted.']);
                    }
                    if ($_SESSION['USER']['role'] === 'buyer') {
                        URLHelper::redirect(URLHelper::appendToBaseURL('session/profile/' . $userID));
                    }
                    elseif ($_SESSION['USER']['role'] === 'admin') {
                        URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/users/edit-user/' . $userID));
                    }
                }
                else {
                    FlashMessage::setMessages('warning', ['There Is An Error occurred Please Try Again.']);
                    URLHelper::redirect(URLHelper::appendToBaseURL('home'));
                }
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }
}