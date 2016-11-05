<?php

namespace Core;

use Symfony\Component\Yaml\Yaml as Yaml;

/**
 * Implementation simple routing
 *
 * Class routing
 */
class Routing
{

    /** @var array  */
    private static $_config = [];

    /** @var null */
    private static $_instance = null;


    /**
     * Routing constructor.
     * @throws \Exception
     */
    private function __construct() {
        $conf = __DIR__ . '/../config/router.yml';

        /**
         * Load routing from yml
         */
        if (file_exists($conf)) {
            self::$_config = Yaml::parse(file_get_contents($conf));
        }

        else {
            throw new \Exception("Route config not exists");
        }
    }


    /**
     * Init routing config
     *
     * @throws \Exception
     */
    public static function init(){
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * Get route config by uri
     *
     * @param $uri
     * @return null
     */
    public static function getRoute($uri) {

        foreach (self::$_config as $key => $route) {
            if (preg_match($route['pattern'], $uri)) {
                return $route;
            }
        }

        return null;
    }


}