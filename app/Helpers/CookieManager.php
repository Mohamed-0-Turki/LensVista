<?php

namespace Helpers;

final class CookieManager
{
    private function __construct() { }
    public final static function setCookie(
        string $name,
        string $value,
        int $expire = 0,
        string $path = "/",
        string $domain = "",
        bool $secure = false,
        bool $httpOnly = true
    ) : bool {
        return setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
    }
    public final static function getCookie(string $name) : ?string {
        return $_COOKIE[$name] ?? null;
    }
    public final static function isCookieSet(string $name) : bool {
        return isset($_COOKIE[$name]);
    }
    public final static function deleteCookie(
        string $name,
        string $path = "/",
        string $domain = "",
        bool $secure = false,
        bool $httpOnly = true
    ) : bool {
        if (self::isCookieSet($name)) {
            return setcookie($name, "", time() - 3600, $path, $domain, $secure, $httpOnly);
        }
        return false;
    }
}