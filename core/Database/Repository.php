<?php

namespace Core\Database;

/**
 * Class Repository
 */
abstract class Repository implements IRepository {

    private $_db;

    public static $table = 'stats';
    public static $model = 'ShopApp\Model\StatsModel';

    public function __construct(DB $db)
    {
        $this->_db = $db;
    }


    /**
     * Save entity
     *
     * @param $entity
     * @return mixed
     */
    public function save($entity)
    {

        $class = get_class($entity);

        /*
         * Get vars. NOTE all vars in private and id we get shes name from setter - i seenk is good validate...
         */
        $allMethods = array_filter(get_class_methods($class), function($m){
            return strpos($m, 'set') === 0 && $m !== 'setId';
        });


        $vars = array_map(function($m){
            $method = str_replace('set', '', $m);
            $matches = preg_split('/(?=[A-Z])/', $method, -1, PREG_SPLIT_NO_EMPTY);
            return [
                'name' => implode('_', array_map('strtolower', $matches)),
                'getter' => 'get' . $method
            ];
        }, $allMethods);

        $data = [];
        foreach ($vars as $var) {
            $value = $entity->{$var['getter']}();
            if (!empty($value)) {
                $data[$var['name']] = $value;
            }
        }

        $id = $this->_db->insert("INSERT INTO " . static::$table . " (" . implode(',', array_keys($data)) . ") VALUES(\"" . implode('","', array_values($data)) . "\")");

        $entity->setId($id);

        return $entity;
    }

    /**
     * Update entity
     *
     * @param $entity
     * @return mixed
     */
    public function update($entity)
    {

        $class = get_class($entity);

        /*
         * Get vars. NOTE all vars in private and id we get shes name from setter - i seenk is good validate...
         */
        $allMethods = array_filter(get_class_methods($class), function($m){
            return strpos($m, 'set') === 0 && $m !== 'setId';
        });

        $vars = array_map(function($m){
            $method = str_replace('set', '', $m);
            $matches = preg_split('/(?=[A-Z])/', $method, -1, PREG_SPLIT_NO_EMPTY);
            return [
                'name' => implode('_', array_map('strtolower', $matches)),
                'getter' => 'get' . $method
            ];
        }, $allMethods);

        $vals = [];
        foreach ($vars as $var) {
            $value = $entity->{$var['getter']}();
            $vals[] = $var['name'] . '= \'' . $value .'\'';
        }

        $this->_db->query("UPDATE " . static::$table . " SET " . implode(',', $vals));

        return $entity;
    }

    /**
     * Find bu ID
     *
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $obj = $this->_db->query("SELECT * FROM " . static::$table . " WHERE id = $id");

        return $this->_transform(reset($obj));
    }

    /**
     * Get all entity
     *
     * @param null $limit
     * @param null $orderBy
     * @return array
     */
    public function findAll($limit = null, $orderBy = null)
    {
        $rows = $this->_db->query("SELECT * FROM " . static::$table);

        $entities = [];

        foreach ($rows as $row) {
            $entities[] = $this->_transform($row);;
        }

        return $entities;
    }


    /**
     * Find entity by params
     *
     * @param $params
     * @return array
     */
    public function findBy($params)
    {
        $q = [];
        foreach ($params as $field => $value) {
            $q[] = $field . '=\'' . $value . '\'';
        }
        $rows = $this->_db->query("SELECT * FROM " . static::$table . ' WHERE ' . implode(' AND ', $q));

        $entities = [];

        foreach ($rows as $row) {
            $entities[] = $this->_transform($row);
        }

        return $entities;
    }

    /**
     * Find first entity by params
     *
     * @param $params
     * @return array
     */
    public function findOneBy($params)
    {
        $q = [];
        foreach ($params as $field => $value) {
            $q[] = $field . '=\'' . $value . '\'';
        }
        $row = $this->_db->query("SELECT * FROM " . static::$table . ' WHERE ' . implode(' AND ', $q) . ' LIMIT 1');

        return $this->_transform(reset($row));
    }


    public function remove($id)
    {
        $this->_db->query("DELETE FROM " . static::$table . " WHERE id = $id");
    }

    /**
     * Helper function to transform row to entity (Active record)
     *
     * @param $row
     * @return mixed
     */
    private function _transform($row){
        $entity = new static::$model();

        foreach ($row as $var => $value) {
            $var = str_replace(' ', '', ucwords(str_replace('_', ' ', $var)));
            $setter = 'set' . $var;
            $entity->{$setter}($value);
        }

        return $entity;
    }
}