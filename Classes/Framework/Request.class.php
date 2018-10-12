<?php

namespace Framework;

class Request
{
    /**
     * @return string
     */
    public static function getUrl() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
        $url = "$protocol://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        return $url;
    }

    /**
     * @return string
     */
    public static function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return bool
     */
    public static function isAjax() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            return strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        }

        return false;
    }
}