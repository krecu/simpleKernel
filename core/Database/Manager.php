<?php

namespace Core\Database;

class Manager {

    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    /**
     * @param $class
     * @return Repository
     */
    public function getRepository($class) {
        return new $class($this->_db);
    }
}