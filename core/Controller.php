<?php

namespace Core;

/**
 * Class Controller
 * @package Core
 */
abstract class Controller {

    /** @var View */
    public $_view;

    /** @var DB */
    public $_db;

    /**
     * Controller constructor.
     * @param $_view
     * @param $_db
     */
    public function __construct($_view, $_db)
    {
        $this->_view = $_view;
        $this->_db = $_db;
    }


}
