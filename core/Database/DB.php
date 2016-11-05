<?php

namespace Core\Database;
use Symfony\Component\Yaml\Yaml;

/**
 * Simple singleton db connection
 * @package Core
 */
class DB
{
    /** @var null|\PDO  */
    private static $_conn = null;

    /** @var null */
    private static $_instance = null;

    /**
     * DB constructor.
     * @throws \Exception
     */
    private function __construct() {
        $conf = __DIR__ . '/../../config/db.yml';

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
    public static function init() {

        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * @param $sql
     * @return array
     */
    public static function query($sql) {

        $pdo =  self::$_conn;
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = [];
        while($row = $stmt->fetch($pdo::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public static function insert($sql) {

        $pdo =  self::$_conn;
        $pdo->setAttribute( $pdo::ATTR_ERRMODE, $pdo::ERRMODE_WARNING );
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $pdo->lastInsertId();
    }


    private function __clone() {}

}