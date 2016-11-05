<?php

namespace Core\Database;


/**
 * Interface IRepository
 */
interface IRepository {

    /**
     * Find record by ID
     *
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Save entity
     *
     * @param $entity
     * @return mixed
     */
    public function save($entity);

    /**
     * Remove entity by id
     *
     * @param $id
     * @return mixed
     */
    public function remove($id);

    /**
     * Find entity by params
     *
     * @param $params
     * @return mixed
     */
    public function findBy($params);

    /**
     * Find all entity by params
     *
     * @return mixed
     */
    public function findAll();
}