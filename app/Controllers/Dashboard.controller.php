<?php
namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Dashboard extends Controller
{
    private mixed $auth;
    private mixed $buyer;
    private mixed $frame;
    private mixed $order;

    public function __construct() {
        $this->auth = $this->model('Auth');
        $this->buyer = $this->model('buyer');
        $this->frame = $this->model('frame');
        $this->order = $this->model('order');
    }

    public function __call($name, $arguments): void
    {
        $this->view();
    }

    public function index(): void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                $data = [
                    'numberOfBuyer' => $this->buyer->fetchNumberOfBuyer(),
                    'numberOfProducts' => $this->frame->fetchNumberOfFrames(),
                    'numberOfOrders' => $this->order->fetchNumberOfOrders(),
                    'numberOfResentOrders' => $this->order->fetchNumberOfOrdersInLastDay(),
                    'resentOrders' => $this->order->fetchDetailsOfOrdersInLastDay(),
                ];
                $errors = [];
                $flashMessage = FlashMessage::getMessages();
                if (count($flashMessage) > 0) {
                    $errors = [
                        'type' => $flashMessage['type'],
                        'messages' => $flashMessage['message']
                    ];
                }
                $this->view('dashboard', 'dashboard', $data, $errors);
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

    public function feedbacks(string $callback = '', string $feedbackID = '') {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                if (! empty($callback)) {
                    if ($callback == 'manage-feedbacks') {
                        $this->invokeControllerMethod('feedback', 'manageFeedbacks');
                    }
                    elseif ($callback == 'delete-feedback') {
                        $this->invokeControllerMethod('feedback', 'deleteFeedbackByID', $feedbackID);
                    }
                    elseif ($callback == 'feedback-details') {
                        $this->invokeControllerMethod('feedback', 'feedbackInformation', $feedbackID);
                    }
                    elseif ($callback == 'notify-user') {
                        $this->invokeControllerMethod('feedback', 'notifyUser', $feedbackID);
                    }
                }
                else {
                    $this->invokeControllerMethod('feedback', 'manageFeedbacks');
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

    public function orders(string $callback = '', string $orderID = '') : void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                if (! empty($callback)) {
                    if ($callback == 'manage-orders') {
                        $this->invokeControllerMethod('orders', 'manageOrders');
                    }
                    elseif ($callback == 'order-details') {
                        $this->invokeControllerMethod('orders', 'orderDetails', $orderID);
                    }
                    elseif ($callback == 'update-order') {
                        $this->invokeControllerMethod('orders', 'updateOrderStatus', $orderID);
                    }
                }
                else {
                    $this->invokeControllerMethod('orders', 'manageOrders');
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

    public function categories(string $callback = '', string $categoryID = '') : void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                $data = [];
                $errors = [];
                if (! empty($callback)) {
                    if ($callback == 'manage-categories') {
                        $this->invokeControllerMethod('categories', 'manageCategories');
                    }
                    elseif ($callback == 'add-category') {
                        $this->invokeControllerMethod('categories', 'addCategory');
                    }
                    elseif ($callback == 'edit-category') {
                        $this->invokeControllerMethod('categories', 'editCategory', $categoryID);
                    }
                    elseif ($callback == 'delete-category') {
                        $this->invokeControllerMethod('categories', 'deleteCategory', $categoryID);
                    }
                }
                else {
                    $this->invokeControllerMethod('categories', 'manageCategories');
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
    public function users(string $callback = '', string $userID = '') : void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                $data = [];
                $errors = [];
                if (! empty($callback)) {
                    if ($callback == 'manage-users') {
                        $this->invokeControllerMethod('users', 'manageUsers');
                    }
                    elseif ($callback == 'add-user') {
                        $this->invokeControllerMethod('users', 'addUser');
                    }
                    elseif ($callback == 'edit-user') {
                        $userRole = (isset($_GET['userRole']) && in_array($_GET['userRole'], ['admin', 'buyer'])) ? $_GET['userRole']: '';
                        $this->invokeControllerMethod('users', 'editUser', $userID, $userRole);
                    }
                    elseif ($callback == 'delete-user') {
                        $this->invokeControllerMethod('users', 'deleteAccount', $userID);
                    }
                }
                else {
                    $this->invokeControllerMethod('users', 'manageUsers');
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
    public function products(string $callback = '', string $productID = '') : void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                $data = [];
                $errors = [];
                if (! empty($callback)) {
                    if ($callback == 'manage-products') {
                        $this->invokeControllerMethod('products', 'manageProducts');
                    }
                    elseif ($callback == 'add-product') {
                        $this->invokeControllerMethod('products', 'addProduct');
                    }
                    elseif ($callback == 'edit-product') {
                        $this->invokeControllerMethod('products', 'editProduct', $productID);
                    }
                    elseif ($callback == 'delete-product') {
                        $this->invokeControllerMethod('products', 'deleteProduct', $productID);
                    }
                }
                else {
                    $this->invokeControllerMethod('users', 'manageUsers');
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
}