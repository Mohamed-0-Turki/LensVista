<?php

namespace Helpers;

final class FlashMessage
{
    private function __construct() {}
    public static function setMessages($type, $message): void
    {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public static function getMessages(): array
    {
        if (isset($_SESSION['flash_message'])) {
            $flashMessage = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $flashMessage;
        }
        return [];
    }
}