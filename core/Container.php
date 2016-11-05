<?php

namespace Core;

class Container {


    private static $services = [];


    public function get($service)
    {
        if (!isset(self::$services[$service])) {
            self::$services[$service] = new $service();
        }

        return self::$services[$service];
    }

    public function set($service, $instance)
    {
        self::$services[$service] = $instance;

        return $this;
    }
}