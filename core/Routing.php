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

    /**
     * Простой массив из YAML ../config/routing.yml
     *
     * @var array
     */
    private $_routes;

    /**
     * Routing constructor.
     * @throws \Exception
     */
    public function __construct ()
    {
        $conf = __DIR__ . '/../config/router.yml';

        /**
         * Загружаем настройки роутинга
         */
        if (file_exists($conf)) {
            $this->_routes = Yaml::parse(file_get_contents($conf));
        }

        else {
            throw new \Exception("Файл настроек роутинга не найден");
        }
    }

    /**
     * По текущему URI получаем настройку роута
     *
     * @param $uri
     * @return null
     */
    public function getRoute($uri) {

        foreach ($this->_routes as $key => $route) {

            /*
             * Наш роутинг основан на регулярках, так быстро и удобно
             */
            if (preg_match($route['pattern'], $uri)) {
                return $route;
            }
        }

        return null;
    }


}