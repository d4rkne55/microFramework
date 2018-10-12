<?php

namespace Framework;

/**
 * Class for providing so called 'Services'
 */
class DI
{
    private static $services = array();


    /**
     * @param string $name
     * @return object
     * @throws \LogicException
     */
    public static function getService($name) {
        if (!isset(self::$services[$name])) {
            throw new \LogicException("Service isn't registered.");
        }

        return self::$services[$name];
    }

    /**
     * @param string $name
     * @param object $service
     */
    public static function registerService($name, $service) {
        self::$services[$name] = $service;
    }
}