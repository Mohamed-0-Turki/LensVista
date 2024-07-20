<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Categories extends Controller
{
    private mixed $category;
    private mixed $frame;
    private mixed $auth;
    private mixed $admin;

    public function __construct() {
        $this->category = $this->model('Category');
        $this->frame = $this->model('Frame');
        $this->auth = $this->model('Auth');
        $this->admin = $this->model('Admin');
        $this->frame = $this->model('Frame');
    }

    public function __call($name, $arguments): void
    {
        $this->view();
    }

    public function index(string $categoryID = ''): void
    {
        if (empty($categoryID)) {
            $data = $this->category->fetchCategories();
            $this->view('categories', 'categories', $data);
        }
        else {
            $data = $this->frame->fetchFramesByCategory($categoryID);
            $this->view('products', 'products', $data);
        }
    }


    private function manageCategories() : void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                $sort = (isset($_GET['sort']) && $_GET['sort'] == 'DESC') ? 'DESC': 'ASC';
                $data = [
                    'numberOfCategories' => $this->category->fetchNumberOfCategories(),
                    'categories' => $this->category->fetchCategories($sort),
                ];
                $errors = [];
                $flashMessage = FlashMessage::getMessages();
                if (count($flashMessage) > 0) {
                    $errors = [
                        'type' => $flashMessage['type'],
                        'messages' => $flashMessage['message']
                    ];
                }
                $this->view('categoriesManagement', 'categories', $data, $errors);
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

    private function addCategory() : void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                $data = [];
                $errors = [];
                if (isset($_POST) && count($_POST) > 0) {
                    $errors = $this->admin->addCategory($_POST, $_FILES);
                    if (count($errors) > 0) {
                        $errors = [
                            'type' => 'warning',
                            'messages' => $errors
                        ];
                    }
                    else {
                        $errors = [
                            'type' => 'successfully',
                            'messages' => ['Category Added successfully.']
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
                $this->view('categoryManagement', 'add category', $data, $errors);
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

    private function editCategory(string $categoryID = '') : void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                if (empty($categoryID)) {
                    FlashMessage::setMessages('warning', ['There Is An Error.']);
                    URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/categories/manage-categories'));
                }
                else {
                    $errors = [];
                    if ((isset($_POST) && count($_POST) > 0) || (isset($_FILES) && count($_FILES) > 0)) {
                        $errors = $this->admin->updateCategory($_POST, $_FILES);
                        if (count($errors) > 0) {
                            $errors = [
                                'type' => 'warning',
                                'messages' => $errors
                            ];
                        }
                        else {
                            $errors = [
                                'type' => 'successfully',
                                'messages' => ['Category updated successfully.']
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
                    $data = $this->category->fetchCategoryDetails($categoryID);
                    $this->view('categoryManagement', 'add category', $data, $errors);
                }
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

    private function deleteCategory(string $categoryID = '') : void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                if (empty($categoryID)) {
                    FlashMessage::setMessages('warning', ['There Is An Error.']);
                }
                else {
                    if ($this->admin->deleteCategory($categoryID)) {
                        FlashMessage::setMessages('successfully', ['Category Added successfully.']);
                    }
                    else {
                        FlashMessage::setMessages('warning', ['can not delete this category.']);
                    }
                }
                URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/categories/manage-categories'));
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
}