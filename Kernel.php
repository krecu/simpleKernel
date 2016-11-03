<?php

include_once 'vendor/autoload.php';

use \Symfony\Component\HttpFoundation\Request as Request;
use \Symfony\Component\HttpFoundation\Response as Response;
use \Core\Routing as Routing;
use \Core\View as View;
use \Core\DB as DB;

/**
 * Simple micro kernel implementation
 *
 * Class Kernel
 */
class Kernel {

    /** @var Routing */
    private $_routing;

    /** @var View */
    private $_view;

    /** @var DB */
    private $_db;

    /**
     * Init kernel
     */
    public function init(){
        $this->_routing = new Routing();
        $this->_view = new View();
        $this->_db = DB::conn();
    }


    /**
     * Execute request
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request){

        /*
         * Get request string
         */
        $query = $request->server->get('REQUEST_URI');

        /*
         * load route config
         */
        $route = $this->_routing->getRoute($query);

        if (!empty($route)) {

            $controller = $route['controller'];
            $method     = $route['method'];

            /*
             * If controller and method exist then render template
             */
            if (class_exists($controller) && method_exists($controller, $method)) {

                /*
                 * get template path and init Twig
                 */
                $reflector = new ReflectionClass($controller);
                $file = $reflector->getFileName();
                $this->_view->init(dirname($file) .'/../');

                /*
                 * create instance controller end return rendered Response
                 */
                $instance = (new $controller($this->_view, $this->_db));
                return $instance->$method($request);
            }
        }

        return new Response('Route not found', 404);
    }

}