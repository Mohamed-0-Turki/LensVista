<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Products extends Controller
{
    private mixed $auth;
    private mixed $buyer;
    private mixed $admin;
    private mixed $category;
    private mixed $frame;
    public function __construct() {
        $this->buyer = $this->model('Buyer');
        $this->auth = $this->model('Auth');
        $this->frame = $this->model('frame');
        $this->admin = $this->model('Admin');
        $this->category = $this->model('Category');
    }

    public function __call($name, $arguments): void
    {
        $this->view();
    }

    public function index(string $productID = ''): void
    {
        $data = [];
        $errors = [];
        if (empty($productID)) {
            if (isset($_GET['search'])) {
                $data = $this->frame->fetchFrames($_GET['search']);
            }
            else {
                $data = $this->frame->fetchFrames();
            }
            $this->view('products', 'products', $data, $errors);
        }
        else {
            if (isset($_POST) && count($_POST) > 0) {
                if ($this->auth->isLogIn()) {
                    $errors = $this->buyer->handleFrameCartInsertion($_SESSION['USER']['userID'] , $_POST);
                    if (count($errors) > 0) {
                        $errors = [
                            'type' => 'warning',
                            'messages' => $errors
                        ];
                    }
                    else {
                        $errors = [
                            'type' => 'successfully',
                            'messages' => ['Product added to cart']
                        ];
                    }
                }
                else {
                    $errors = [
                        'type' => 'warning',
                        'messages' => ['Please login to add product']
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
            if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'buyer') {
                $data = $this->frame->fetchFrameByID($productID, $_SESSION['USER']['userID']);
                $data['rate'] = $this->buyer->fetchUserRatingForTheFrame($_SESSION['USER']['userID'], $productID);
            }
            else {
                $data = $this->frame->fetchFrameByID($productID);
            }
            $data['comments'] = $this->buyer->fetchAllComments($productID);
            $data['averageRate'] = $this->frame->fetchAverageRate($productID);
            if (isset($_GET['frameColor'])) {
                $color = '#' . $_GET['frameColor'];
                $data = $this->frame->fetchFrameOptionsByColor($productID, $color, $data);
            }
            $this->view('product', 'product', $data, $errors);
        }
    }

    public function getProductsByModel(string $model = ''): void
    {
        $data = $this->frame->fetchProductsByModel($model);
        echo json_encode($data);
    }

    private function manageProducts() : void {
        if ($this->auth->isLogIn()) {
            if ($_SESSION['USER']['role'] == 'admin') {
                $sort = (isset($_GET['sort']) && $_GET['sort'] == 'DESC') ? 'DESC': 'ASC';
                $data = [
                    'numberOfFrames' => $this->frame->fetchNumberOfFrames(),
                    'frames' => $this->frame->fetchFrameDetails($sort),
                ];
                $errors = [];
                $flashMessage = FlashMessage::getMessages();
                if (count($flashMessage) > 0) {
                    $errors = [
                        'type' => $flashMessage['type'],
                        'messages' => $flashMessage['message']
                    ];
                }
                $this->view('productsManagement', 'products', $data, $errors);
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

    private function addProduct(): void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'admin') {
            $errors = [];
            $data = [
                'categoriesName' => $this->category->fetchCategoriesName(),
                'frameStyleOptions' => $this->frame->fetchFrameStyles(),
                'frameShapeOptions' => $this->frame->fetchFrameShapes(),
                'frameMaterialOptions' => $this->frame->fetchFrameMaterials(),
                'frameNosePadsOptions' => $this->frame->fetchFrameNosePads(),
            ];
            if (isset($_POST) && count($_POST) > 0) {
                $errors = $this->admin->addFrame($_SESSION['USER']['userID'], $_POST, $_FILES);
                if (count($errors) == 0) {
                    $errors = [
                        'type' => 'successfully',
                        'messages' => ['Add frame Successfully']
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
            $this->view('addProduct', 'addProduct', $data, $errors);
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }
    private function editProduct(string $productID = ''): void
    {
        
        if (empty($productID)) {
            FlashMessage::setMessages('warning', ['There Is An Error occurred Please Try Again.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/users/manage-products'));
        }
        else {
            if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'admin') {
                $errors = [];
                if (isset($_POST) && count($_POST) > 0) {
                    $errors = $this->admin->updateFrame($productID, $_SESSION['USER']['userID'], $_POST, $_FILES);
                    if (count($errors) == 0) {
                        $errors = [
                            'type' => 'successfully',
                            'messages' => ['Add frame Successfully']
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
                $data = [
                    'categoriesName' => $this->category->fetchCategoriesName(),
                    'frameStyleOptions' => $this->frame->fetchFrameStyles(),
                    'frameShapeOptions' => $this->frame->fetchFrameShapes(),
                    'frameMaterialOptions' => $this->frame->fetchFrameMaterials(),
                    'frameNosePadsOptions' => $this->frame->fetchFrameNosePads(),
                    'frame' => $this->frame->fetchAllDetailsAboutFrame($productID)
                ];
                $this->view('addProduct', 'addProduct', $data, $errors);
            }
            else {
                FlashMessage::setMessages('warning', ['Please Log in to continue.']);
                URLHelper::redirect(URLHelper::appendToBaseURL('login'));
            }
        }
    }
    private function deleteProduct(string $productID = ''): void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'admin') {
            if (! empty($productID)) {
                if ($this->admin->deleteFrame($productID)) {
                    FlashMessage::setMessages('successfully', ['frame deleted successfully.']);
                }
                else {
                    FlashMessage::setMessages('warning', ['This frame Can Not Be Deleted.']);
                }
                URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/products/manage-products'));
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }
    public function deleteProductOption(string $productID = '', string $productOptionID = ''): void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'admin') {
            if (! empty($productOptionID) && ! empty($productID)) {
                if ($this->admin->deleteFrameOption($productID, $productOptionID)) {
                    FlashMessage::setMessages('successfully', ['frame option deleted successfully.']);
                }
                else {
                    FlashMessage::setMessages('warning', ['This frame option Can Not Be Deleted.']);
                }
                URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/products/edit-product/' . $productID));
            }
            else {
                URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/products/manage-products'));
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    public function rateProduct(string $productID = '', string $rate = ''): void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'buyer') {
            $errors = [];
            if (! empty($productID) && ! empty($rate)) {
                $this->buyer->EvaluateFrame($_SESSION['USER']['userID'], $productID, $rate);
            }
            else {
                FlashMessage::setMessages('warning', ['Please try again.']);
            }
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != null) {
                URLHelper::redirect($_SERVER['HTTP_REFERER']);
            }
            else {
                URLHelper::redirect(BASE_URL);
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    public function sendComment(string $productID = '') : void {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'buyer') {
            $errors = [];
            if (! empty($productID)) {
                if (isset($_POST) && count($_POST) > 0) {
                    $errors = $this->buyer->sendComment($_SESSION['USER']['userID'], $productID, $_POST);
                    if (count($errors) > 0) {
                        FlashMessage::setMessages('warning', $errors);
                    }
                    else {
                        FlashMessage::setMessages('successfully', ['comment send successfully.']);
                    }
                }
                else {
                    FlashMessage::setMessages('warning', ['Please try again.']);
                }
            }
            else {
                FlashMessage::setMessages('warning', ['Please try again.']);
            }
            if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != null) {
                URLHelper::redirect($_SERVER['HTTP_REFERER']);
            }
            else {
                URLHelper::redirect(BASE_URL);
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }
}