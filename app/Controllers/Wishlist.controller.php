<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Wishlist extends Controller
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
            $data = $this->buyer->fetchWishlistItems($_SESSION['USER']['userID']);
            $errors = [];
            $flashMessage = FlashMessage::getMessages();
            if (count($flashMessage) > 0) {
                $errors = [
                    'type' => $flashMessage['type'],
                    'messages' => $flashMessage['message']
                ];
            }
            $this->view('wishlist', 'wishlist', $data, $errors);
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in as buyer to continue.']);
            UrlHelper::redirect(URLHelper::appendToBaseURL());
        }
    }

    public function addToWishlist(string $productID = ''): void
    {
        if ($this->auth->isLogIn() && $_SESSION['USER']['role'] === 'buyer') {
            if (! empty($productID)) {
                if ($this->buyer->toggleWishlistItem($_SESSION['USER']['userID'], $productID)) {
                    FlashMessage::setMessages('successfully', ['The product has been added to your wishlist successfully.']);
                }
                else {
                    FlashMessage::setMessages('successfully', ['The product has been removed from your wishlist.']);
                }
                if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != null) {
                    URLHelper::redirect($_SERVER['HTTP_REFERER']);
                }
                else {
                    URLHelper::redirect(BASE_URL);
                }
            }
        }
        else {
            FlashMessage::setMessages('warning', ['Please Log in as buyer to continue.']);
            UrlHelper::redirect(URLHelper::appendToBaseURL());
        }
    }
}