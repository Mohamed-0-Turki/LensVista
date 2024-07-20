<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Orders extends Controller
{
    private mixed $auth;
    private mixed $admin;
    private mixed $user;
    private mixed $order;

    public function __construct() {
        $this->auth = $this->model('Auth');
        $this->order = $this->model('Order');
        $this->admin = $this->model('Admin');
        $this->user = $this->model('user');
    }

    public function __call($name, $arguments): void
    {
        $this->view();
    }

    public function index(string $userID = ''): void {
        if ($this->auth->isLogIn()) {
            if (empty($userID) || $userID != $_SESSION['USER']['userID']) {
                FlashMessage::setMessages('warning', ['There Is An Error occurred Please Try Again.']);
                URLHelper::redirect(URLHelper::appendToBaseURL('home'));
            }
            else {
                $data = $this->order->fetchBuyerOrders($userID);
                $errors = [];
                $flashMessage = FlashMessage::getMessages();
                if (count($flashMessage) > 0) {
                    $errors = [
                        'type' => $flashMessage['type'],
                        'messages' => $flashMessage['message']
                    ];
                }
                if ($userID == $_SESSION['USER']['userID']) {
                    $this->view('orders', 'orders', $data, $errors);
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

    private function manageOrders() : void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                $data = [
                    'numberOfOrders' => $this->order->fetchNumberOfOrders(),
                    'numberOfResentOrders' => $this->order->fetchNumberOfOrdersInLastDay(),
                    'orders' => (isset($_GET['duration']) && $_GET['duration'] == 'resentOrders') ? $this->order->fetchDetailsOfOrdersInLastDay() : $this->order->fetchDetailsOfOrders(), 
                ];
                $errors = [];
                $flashMessage = FlashMessage::getMessages();
                if (count($flashMessage) > 0) {
                    $errors = [
                        'type' => $flashMessage['type'],
                        'messages' => $flashMessage['message']
                    ];
                }
                $this->view('orderManagement', 'orders', $data, $errors);
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

    public function orderDetails(string $orderID = ''): void {
        if ($this->auth->isLogIn()) {
            if (! empty($orderID)) {
                $data = $this->order->fetchOrderDetails($orderID);
                $errors = [];
                $flashMessage = FlashMessage::getMessages();
                if (count($flashMessage) > 0) {
                    $errors = [
                        'type' => $flashMessage['type'],
                        'messages' => $flashMessage['message']
                    ];
                }
                if ($data['order']['user_ID'] == $_SESSION['USER']['userID'] || $_SESSION['USER']['role'] == 'admin') {
                    $this->view('orderDetails', 'order Details', $data, $errors);
                }
                else {
                    FlashMessage::setMessages('warning', ['There Is An Error occurred Please Try Again.']);
                    URLHelper::redirect(URLHelper::appendToBaseURL('home'));
                }
            }
            else {
                FlashMessage::setMessages('warning', ['There Is An Error occurred Please Try Again.']);
                URLHelper::redirect(URLHelper::appendToBaseURL('home'));
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    public function cancelOrder(string $userID = '', string $orderID = ''): void {
        if ($this->auth->isLogIn()) {
            if (! empty($orderID)) {
                if ($userID == $_SESSION['USER']['userID'] || $_SESSION['USER']['role'] == 'admin') {
                    if ($this->user->cancelOrder($orderID)) {
                        FlashMessage::setMessages('successfully', ['order canceled successfully.']);
                    }
                    else {
                        FlashMessage::setMessages('warning', ['order can not cancel.']);
                    }
                }
                URLHelper::redirect(URLHelper::appendToBaseURL('Orders/orderDetails/' . $orderID));
            }
            else {
                FlashMessage::setMessages('warning', ['There Is An Error occurred Please Try Again.']);
                URLHelper::redirect(URLHelper::appendToBaseURL('home'));
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    private function UpdateOrderStatus(string $orderID = ''): void
    {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                $data = [];
                $errors = [];
                if (! empty($orderID)) {
                    if(isset($_POST) && count($_POST) > 0) {
                        $errors = $this->admin->UpdateOrderStatus($orderID, $_POST);
                        if (count($errors) != 0) {
                            $errors = [
                                'type' => 'warning',
                                'messages' => $errors
                            ];
                        }
                        else {
                            $errors = [
                                'type' => 'successfully',
                                'messages' => ['Update order status successfully.']
                            ];
                        }
                    }
                    $data = $this->order->fetchOrderAndBuyerDetails($orderID);
                    $flashMessage = FlashMessage::getMessages();
                    if (count($flashMessage) > 0) {
                        $errors = [
                            'type' => $flashMessage['type'],
                            'messages' => $flashMessage['message']
                        ];
                    }
                    $this->view('updateOrderStatus', 'update Order Status', $data, $errors);
                }
                else {
                    FlashMessage::setMessages('warning', ['There Is An Error occurred Please Try Again.']);
                    URLHelper::redirect(URLHelper::appendToBaseURL('dashboard'));
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