<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Users extends Controller
{
    private mixed $auth;
    private mixed $user;
    private mixed $admin;
    private mixed $buyer;

    public function __construct() {
        $this->auth = $this->model('Auth');
        $this->user = $this->model('user');
        $this->buyer = $this->model('Buyer');
        $this->admin = $this->model('Admin');

    }

    public function __call($name, $arguments): void
    {
        $this->view();
    }

    private function manageUsers() : void {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                $sort = (isset($_GET['sort']) && $_GET['sort'] == 'DESC') ? 'DESC': 'ASC';
                $data = [
                    'numberOfUsers' => $this->user->fetchNumberOfUsers(),
                    'numberOfBuyer' => $this->buyer->fetchNumberOfBuyer(),
                    'numberOfAdmins' => $this->admin->fetchNumberOfAdmins(),
                    'users' => $this->user->fetchUserDetails($sort),
                ];
                $errors = [];
                $flashMessage = FlashMessage::getMessages();
                if (count($flashMessage) > 0) {
                    $errors = [
                        'type' => $flashMessage['type'],
                        'messages' => $flashMessage['message']
                    ];
                }
                $this->view('usersManagement', 'users', $data, $errors);
            }
            else {
                FlashMessage::setMessages('warning', ['You Can Not Access This Page.']);
                URLHelper::redirect(URLHelper::appendToBaseURL('home'));
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    public function getRecentUserRegistrations() : void {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                echo json_encode(['numberOfRecentUserRegistrations' => $this->user->fetchRecentUserRegistrations()]);
            }
            else {
                FlashMessage::setMessages('warning', ['You Can Not Access This Page.']);
                URLHelper::redirect(URLHelper::appendToBaseURL('home'));
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    private function deleteAccount(string $userID = ''): void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'admin') {
            if (! empty($userID)) {
                if ($this->user->deleteUserAccount($userID)) {
                    FlashMessage::setMessages('successfully', ['Account deleted successfully.']);
                }
                else {
                    FlashMessage::setMessages('warning', ['This Account Can Not Be Deleted.']);
                }
                URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/users/manage-users'));
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    public function changeAccountStatus(string $userID = '') : void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'admin') {
            if (! empty($userID)) {
                if ($this->admin->toggleAccountStatus($userID)) {
                    FlashMessage::setMessages('successfully', ['Account change status successfully.']);
                }
                else {
                    FlashMessage::setMessages('warning', ['This Account Can Not Be change status.']);
                }
                $userRole = (isset($_GET['userRole'])) ? $_GET['userRole'] : '';
                URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/users/edit-user/' . $userID . '?userRole=' . $userRole));
            }
            else {
                URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/users/manage-users/'));
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    private function addUser(): void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'admin') {
            $errors = [];
            if (isset($_POST) && count($_POST) > 0) {
                $errors = $this->admin->addUser($_POST);
                if (count($errors) == 0) {
                    $errors = [
                        'type' => 'successfully',
                        'messages' => ['Add User Successfully']
                    ];
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
            $this->view('addUser', 'addUser', [], $errors);
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    private function editUser(string $userID = '', string $userRole = ''): void
    {
        if ($this->auth->isLogIn()) {
            if (empty($userID) || empty($userRole)) {
                FlashMessage::setMessages('warning', ['There Is An Error occurred Please Try Again.']);
                URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/users/manage-users'));
            }
            else {
                if ($_SESSION['USER']['role'] === 'admin') {
                    $errors = [];
                    if ((isset($_POST) && count($_POST) > 0) || (isset($_FILES) && count($_FILES) > 0)) {
                        if ($userRole == 'admin') {
                            $errors = $this->admin->updateProfile($userID, $_POST, $_FILES);
                        }
                        elseif ($userRole == 'buyer') {
                            $errors = $this->buyer->updateProfile($userID, $_POST, $_FILES);
                        }
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
                    if ($userRole == 'admin') {
                        $data = [
                            'personalData' => $this->admin->fetchProfile($userID)[0],
                        ];
                        $this->view('addUser', 'profile', $data, $errors);
                    }
                    elseif ($userRole == 'buyer') {
                        $data = [
                            'personalData' => $this->buyer->fetchProfile($userID)[0],
                            'orders' => $this->buyer->fetchBuyerOrders($userID)
                        ];
                        $this->view('profile', 'profile', $data, $errors);
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