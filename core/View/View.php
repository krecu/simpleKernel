<?php

namespace Core\View;
use Core\View\Engine\IEngine;

/**
 * Class View
 */
class View
{

    /** @var IEngine */
    private static $_engine;

    /** @var null */
    private static $_instance = null;


    /**
     * Render template
     *
     * @param $view
     * @param array $data
     * @return string
     */
    public static function render($view, $data = [])
    {
        return self::$_engine->render($view, $data);
    }

    /**
     * @param IEngine $engine
     * @return View|null
     */
    public static function init(IEngine $engine){

        if (self::$_instance === null) {

            self::$_engine = $engine;

            self::$_instance = new self;
        }
        
        return self::$_instance;
    }

}