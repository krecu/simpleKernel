<?php

namespace Core;

use Symfony\Component\Yaml\Yaml as Yaml;

/**
 * Имплементация роутинга
 *
 * Class routing
 */
class Routing
{

    /** @var mixed  */
    private $_routes;

    /**
     * Routing constructor.
     * @throws \Exception
     */
    public function __construct ()
    {
        $conf = __DIR__ . '/../config/router.yml';

        /**
         * Load routing from yml
         */
        if (file_exists($conf)) {
            $this->_routes = Yaml::parse(file_get_contents($conf));
        }

        else {
            throw new \Exception("Route config not exists");
        }
    }

    /**
     * Get route config by uri
     *
     * @param $uri
     * @return null
     */
    public function getRoute($uri) {

        foreach ($this->_routes as $key => $route) {
            if (preg_match($route['pattern'], $uri)) {
                return $route;
            }
        }

        return null;
    }


}