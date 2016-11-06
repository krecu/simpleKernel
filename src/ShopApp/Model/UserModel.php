<?php

namespace ShopApp\Model;

/*
CREATE TABLE `users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `login` VARCHAR(120) NOT NULL,
  `pass` VARCHAR(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uniq_idx` (`login`)
) ENGINE=InnoDB CHARSET=UTF8;
*/

/**
 * Class UserModel
 * @package ShopApp\Model
 */
class UserModel {

    /** @var  integer */
    private $id;

    /** @var  string */
    private $login;

    /** @var  string */
    private $pass;

    /** @var  string */
    private $session;

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param $login
     * @return $this
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param $pass
     * @return $this
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param $session
     * @return $this
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

}