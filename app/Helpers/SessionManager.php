<?php

namespace Helpers;

final class SessionManager
{
    private function __construct() { }

    public final static function startSession() : void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public final static function setSessionVariable(string $key, $value) : void {
        $_SESSION[$key] = $value;
    }

    public final static function getSessionVariable(string $key): mixed {
        return $_SESSION[$key] ?? null;
    }

    public final static function unsetSessionVariable(string $key) : void {
        unset($_SESSION[$key]);
    }

    public final static function destroySession() : void {
        if (session_status() !== PHP_SESSION_NONE) {
            session_unset();
            session_destroy();
        }
    }
}