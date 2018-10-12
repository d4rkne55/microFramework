<?php

namespace Framework;

class Response
{
    /**
     * Sets the HTTP status code
     *
     * @param int $code
     */
    public static function setCode($code) {
        http_response_code($code);
    }

    /**
     * Triggers a redirect to the given path.
     * The path is relative to ROOT, the project base path, like in the config.
     *
     * @param string $path
     */
    public static function redirect($path) {
        header('Location: ' . ROOT . $path);
    }

    /**
     * Creates a JSON response for the given data
     *
     * @param mixed $data
     */
    public static function json($data) {
        header('Content-Type: application/json');

        die(json_encode($data));
    }
}