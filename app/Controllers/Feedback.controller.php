<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;
use Helpers\URLHelper;

class Feedback extends Controller {

  private mixed $auth;
  private mixed $user;
  private mixed $admin;
  private mixed $feedback;

  public function __construct() {
      $this->auth = $this->model('Auth');
      $this->admin = $this->model('Admin');
      $this->user = $this->model('User');
      $this->feedback = $this->model('feedback');
  }

  public function __call($name, $arguments): void
  {
    $this->view();
  }


  private function manageFeedbacks() :void
  {
    if ($this->auth->isLogIn()) {
      if ($_SESSION['USER']['role'] == 'admin') {
        $sort = (isset($_GET['sort']) && $_GET['sort'] == 'DESC') ? 'DESC': 'ASC';
        $data = [
          'numberOfFeedbacks' => $this->feedback->fetchNumberOfFeedbacks(),
          'feedbacks' => $this->feedback->fetchFeedbacks($sort),
        ];
        $errors = [];
        $flashMessage = FlashMessage::getMessages();
        if (count($flashMessage) > 0) {
            $errors = [
                'type' => $flashMessage['type'],
                'messages' => $flashMessage['message']
            ];
        }
        $this->view('feedbacksManagement', 'feedbacks', $data, $errors);
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

  private function deleteFeedbackByID(string $feedbackID = '') :void
  {
    if ($this->auth->isLogIn()) {
      if ($_SESSION['USER']['role'] == 'admin') {
        if (empty($feedbackID)) {
          FlashMessage::setMessages('warning', ['There Is An Error Please Try Again.']);
        }
        else {
          if($this->admin->deleteFeedback($feedbackID)) {
            FlashMessage::setMessages('successfully', ['Feedback Deleted successfully.']);
          } else {
            FlashMessage::setMessages('warning', ['This feedback can not be deleted.']);
          }
        }
        URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/feedbacks/manage-feedbacks'));
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

  private function feedbackInformation(string $feedbackID = '') :void 
  {
    if ($this->auth->isLogIn()) {
      if ($_SESSION['USER']['role'] == 'admin') {
        if (empty($feedbackID)) {
          FlashMessage::setMessages('warning', ['There Is An Error Please Try Again.']);
          URLHelper::redirect(URLHelper::appendToBaseURL('dashboard/feedbacks/manage-feedbacks'));
        }
        else {
          $data = $this->feedback->fetchFeedbackDetails($feedbackID);
          $errors = [];
          $flashMessage = FlashMessage::getMessages();
          if (count($flashMessage) > 0) {
              $errors = [
                  'type' => $flashMessage['type'],
                  'messages' => $flashMessage['message']
              ];
          }
          $this->view('feedbackDetails', 'feedbacks', $data, $errors);
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

  private function notifyUser(string $feedbackID = '') : void {
    if ($this->auth->isLogIn()) {
      if ($_SESSION['USER']['role'] == 'admin') {
        $errors =  $this->admin->sendEmail($_POST, $feedbackID);
        if (count($errors) > 0) {
          FlashMessage::setMessages('warning',$errors);
        }
        else {
          FlashMessage::setMessages('successfully', ['successfully.']);
        }
        URLHelper::redirect(BASE_URL . 'dashboard/feedbacks/feedback-details/' . $feedbackID);
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

  public function sendFeedback() :void
  {
    if (isset($_POST) && count($_POST) > 0) {
      $errors = $this->user->sendFeedback($_POST);
      if (count($errors) == 0) {
        FlashMessage::setMessages('successfully', ['Your request has been sent successfully. We will contact you as soon as possible.']);
      }
      else {
        FlashMessage::setMessages('warning', $errors);
      }
    }
    URLHelper::redirect(BASE_URL . 'home#contactUs');
  }
}