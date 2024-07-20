<?php

namespace Controllers;

use Core\Controller;
use Helpers\FlashMessage;

// Done
class Home extends Controller
{
    public function __construct()
    {
    }

    public function __call($name, $arguments): void
    {
        $this->view();
    }


    public function index() :void
    {
        $data = [];
        $errors = [];
        $flashMessage = FlashMessage::getMessages();
        if (count($flashMessage) > 0) {
            $errors = [
                'type' => $flashMessage['type'],
                'messages' => $flashMessage['message']
            ];
        }
        $this->view('home', 'home', $data, $errors);
    }

}