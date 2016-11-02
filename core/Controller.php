<?php

namespace Core;

/**
 * Class Controller
 * @package Core
 */
abstract class Controller {

    /** @var  View */
    public $_view;

    /**
     * Controller constructor.
     * @param $_view
     */
    public function __construct($_view)
    {
        $this->_view = $_view;
    }


}
