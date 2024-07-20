<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Comments extends Controller
{
    private mixed $auth;
    private mixed $buyer;
    private mixed $admin;

    public function __construct() {
        $this->auth = $this->model('Auth');
        $this->buyer = $this->model('Buyer');
        $this->admin = $this->model('admin');
    }

    public function __call($name, $arguments): void
    {
        $this->view();
    }

    public function index(): void
    {
    }

    public function deleteComment(string $commentID = ''): void
    {
        if ($this->auth->isLogIn()) {
          if (! empty($commentID)) {
            $result = false;
            if ($_SESSION['USER']['role'] == 'buyer') {
              $result = $this->buyer->deleteComment($commentID, $_SESSION['USER']['userID']);
            }
            if ($_SESSION['USER']['role'] == 'admin') {
              $result = $this->buyer->deleteComment($commentID);
            }
              if ($result) {
                  FlashMessage::setMessages('successfully', ['comment deleted successfully.']);
              }
              else {
                  FlashMessage::setMessages('warning', ['There is an error occurred while deleting the comment.']);
              }
          }
        }
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != null) {
          URLHelper::redirect($_SERVER['HTTP_REFERER']);
        }
        else {
            URLHelper::redirect(BASE_URL);
        }
    }

}