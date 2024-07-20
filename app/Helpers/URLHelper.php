<?php

namespace Helpers;

final class URLHelper
{
    private function __construct() { }
    public final static function appendToBaseURL(string $url = '') : string {

        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $baseUrl = $protocol . '://' . $host . dirname($_SERVER['PHP_SELF']) . '/';
        return $baseUrl . $url;
    }
    public final static function isValidURL(string $url) : bool {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }
        $parsedUrl = parse_url($url);
        if (!$parsedUrl || !isset($parsedUrl['scheme']) || !in_array($parsedUrl['scheme'], array('http', 'https', 'ftp'))) {
            return false;
        }
        return true;
    }

    public final static function appendQueryParams(string $url, array $params) : string {
        $query = http_build_query($params);
        return $url . (parse_url($url, PHP_URL_QUERY) ? '&' : '?') . $query;
    }

    public final static function redirect(string $url) : void {
        header("Location: $url");
        exit();
    }
}