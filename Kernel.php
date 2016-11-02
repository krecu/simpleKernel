<?php

include_once 'vendor/autoload.php';

use \Symfony\Component\HttpFoundation\Request as Request;
use \Symfony\Component\HttpFoundation\Response as Response;
use \Core\Routing as Routing;
use \Core\View as View;

/**
 * Основной класс загрузчик
 *
 * Class Kernel
 */
class Kernel {

    /** @var Routing */
    private $_routing;

    /** @var View */
    private $_view;

    /**
     * Инициализируем наше микро ядро
     * - Инициализируем конфиг роутов
     * - Инициализируем подключение к БД
     */
    public function init(){
        $this->_routing = new Routing();
        $this->_view = new View();
    }


    /**
     * Как то гдето я встречал реализацию типа MVC подход организации роутов
     * так что не долго думая на нем и решил собрать
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request){

        /*
         * Берем наш query и считаем что он состоит из имени контролера и имени метода
         */
        $query = $request->server->get('REQUEST_URI');

        /*
         * Пробуем найти конфиг по текущему роуту
         */
        $route = $this->_routing->getRoute($query);

        if (!empty($route)) {

            $controller = $route['controller'];
            $method     = $route['method'];

            /*
             * проверяем есть ли в нашем приложении контроллер
             * и есть ли в контроллере наш метод
             * ну и собственно отдаем респонсе
             */
            if (class_exists($controller) && method_exists($controller, $method)) {

                /*
                 * Инициализируем движок шаблонизатора для текущего контролера
                 * нам нужен патч c шаблонами что бы их инициализировать
                 */
                $reflector = new ReflectionClass($controller);
                $file = $reflector->getFileName();
                $this->_view->init(dirname($file) .'/../');


                $instance = (new $controller($this->_view));
                return $instance->$method($request);
            }
        }

        return new Response('Route not found', 404);
    }

}