<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Cart extends Controller
{
    private mixed $auth;
    private mixed $buyer;

    public function __construct() {
        $this->auth = $this->model('Auth');
        $this->buyer = $this->model('Buyer');
    }

    public function __call($name, $arguments): void
    {
        $this->view();
    }

    public function index(): void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'buyer') {
            $errors = [];
            if (isset($_POST['checkout'])) {
                $result = $this->buyer->processCheckout($_SESSION['USER']['userID']);
                if ($result == 0) {
                    $errors = [
                        'type' => 'warning',
                        'messages' => ['Please go to your profile and enter your location data and phone number.']
                    ];
                }
                else if ($result == -1) {
                    $errors = [
                        'type' => 'error',
                        'messages' => ['Failed to complete checkout. Please try again later.']
                    ];
                }
                else {
                    $errors = [
                        'type' => 'successfully',
                        'messages' => ['Checkout completed successfully.']
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
            $data = $this->buyer->fetchBuyerCartDetails($_SESSION['USER']['userID']);
            $this->view('cart', 'cart', $data, $errors);
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in to continue.']);
            URLHelper::redirect(URLHelper::appendToBaseURL('login'));
        }
    }

    public function deleteItem(string $cartID = ''): void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'buyer') {
            if (! empty($cartID)) {
                if ($this->buyer->deleteItemFromCart($cartID)) {
                    FlashMessage::setMessages('successfully', ['frame deleted successfully from cart.']);
                }
                else {
                    FlashMessage::setMessages('warning', ['There is an error occurred while deleting the item from cart.']);
                }
            }
        }
        UrlHelper::redirect(URLHelper::appendToBaseURL('cart'));
    }

    public function updateCartItemQuantity(string $updateType = '', string $cartID = '', string $frameOptionID = ''): void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'buyer') {
            if (!empty($cartID) && !empty($frameOptionID)) {
                $updateResult = 0;
                if ($updateType == 'increase') {
                    $updateResult = ($this->buyer->increaseCartItemQuantity($cartID, $frameOptionID)) ? 1 : 0;
                }
                elseif ($updateType == 'decrease') {
                    $updateResult = ($this->buyer->decreaseCartItemQuantity($cartID, $frameOptionID)) ? 1 : 0;
                }
                else {
                    $updateResult = -1;
                }
                if ($updateResult == 1) {
                    FlashMessage::setMessages('successfully', ['frame updated quantity successfully.']);
                }
                elseif ($updateResult == 0) {
                    FlashMessage::setMessages('warning', ['You have exceeded the minimum quantity for this product.']);
                }
                else {
                    FlashMessage::setMessages('error', ['Failed to update the quantity.']);
                }
            }
        }
        UrlHelper::redirect(URLHelper::appendToBaseURL('cart'));
    }

    public function getTotalCartQuantity(): void
    {
        if (isset($_SESSION['USER']) && $_SESSION['USER']['role'] === 'buyer') {
            $userID = $_SESSION['USER']['userID'];
            $totalQuantity = $this->buyer->fetchBuyerCartItemCount($userID);
            echo json_encode(['total_quantity' => $totalQuantity]);
        } else {
            echo json_encode(['total_quantity' => 0]);
        }
    }

}