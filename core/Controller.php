<?php

namespace Core;
use Core\Container;

/**
 * Class Controller
 * @package Core
 */
abstract class Controller {

    /** @var Container */
    public $container;

    /**
     * Controller constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }


}
