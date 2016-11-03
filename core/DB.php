<?php

namespace Core;
use Symfony\Component\Yaml\Yaml;

/**
 * Simple singleton db connection
 * @package Core
 */
class DB
{
    /** @var null|\PDO  */
    private static $_conn = null;

    /**
     * DB constructor.
     * @throws \Exception
     */
    private function __construct() {
        $conf = __DIR__ . '/../config/db.yml';

        /**
         * Load config and connect
         */
        if (file_exists($conf)) {
            $_config = Yaml::parse(file_get_contents($conf));

            $conn = $_config['type'].':host='.$_config['host'].';dbname='.$_config['dbname'];
            self::$_conn = new \PDO($conn, $_config['user'], $_config['pass']);
        }

        else {
            throw new \Exception("DB config not exists");
        }
    }

    /**
     * Connect to DB
     *
     * @return DB|\PDO
     */
    public static function conn() {
        if (self::$_conn === null) {
            self::$_conn = new self;
        }
        return self::$_conn;
    }

    /**
     * Execute query
     *
     * @param $sql
     * @return \PDOStatement
     * @throws \Exception
     */
    public static function query($sql) {
        if (self::$_conn !== null) {
            return self::$_conn->query($sql);
        } else {
            throw new \Exception("DB die");
        }
    }


    private function __clone() {}

}