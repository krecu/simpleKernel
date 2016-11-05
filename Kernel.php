<?php

include_once 'vendor/autoload.php';

use \Symfony\Component\HttpFoundation\Request as Request;
use \Symfony\Component\HttpFoundation\Response as Response;

use \Core\View\View as View;
use \Core\Database\DB as DB;

use \Core\Routing as Routing;
use \Core\Container as Container;

/**
 * Simple micro kernel implementation
 *
 * Class Kernel
 */
class Kernel {

    /** @var Container */
    private $_container;

    /**
     * Init kernel
     */
    public function init(){

        /*
         * Init container and set services
         */
        $this->_container = (new Container())
            ->set('db', DB::init())
            ->set('routing', Routing::init());
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

        /** @var Routing $routing */
        $routing = $this->_container->get('routing');

        $route = $routing::getRoute($query);

        if (!empty($route)) {

            $controller = $route['controller'];
            $method     = $route['method'];

            /*
             * If controller and method exist then render template
             */
            if (class_exists($controller) && method_exists($controller, $method)) {

                /*
                 * get template path and init View Engine
                 */
                $reflector = new ReflectionClass($controller);
                $file = $reflector->getFileName();

                $view = View::init(new \Core\View\Engine\TwigEngine(dirname($file) .'/../Views'));

                $this->_container->set('view', $view);

                /*
                 * Init repo manager
                 */
                $manager = new \Core\Database\Manager($this->_container->get('db'));
                $this->_container->set('manager', $manager);

                /*
                 * create instance controller end return rendered Response
                 */
                $instance = (new $controller($this->_container));
                return $instance->$method($request);
            }
        }

        return new Response('Route not found', 404);
    }

}