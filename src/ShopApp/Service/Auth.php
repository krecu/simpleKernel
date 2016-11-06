<?php

namespace ShopApp\Service;

use Core\Container;
use Core\Database\Manager;
use ShopApp\Model\UserModel;
use ShopApp\Repository\UserRepository;


/**
 * Very simple auth service
 *
 * Class Auth
 * @package ShopApp\Service
 */
class Auth {

    const SALT = 'abracadabra';

    /** @var  Container */
    private $_container;

    /** @var null|string  */
    private $_sessionId = null;

    /**
     * Auth constructor.
     * @param $container
     */
    public function __construct($container)
    {
        if (empty($_SESSION['user'])) {
            session_start();
            $_SESSION['user'] = empty($_SESSION['user']) ? 'anonymous' : $_SESSION['user'];
            $_SESSION['time'] = time();
        }

        /*
         * store session ID for anonymous user
         * maybe he want to be login
         */
        $this->_sessionId = session_id();
        $this->_container = $container;
    }

    /**
     * Simple generate hash
     *
     * @param $string
     * @return string
     */
    public function hash($string) {
        return sha1(self::SALT . $string);
    }

    /**
     * Helper function generate user
     *
     * @param $login
     * @param $pass
     * @return mixed
     */
    public function generate($login, $pass) {
        $user = new UserModel();
        $user
            ->setLogin($login)
            ->setPass($this->hash($pass));

        /** @var Manager $em */
        $em = $this->_container->get('manager');
        $userRepo = $em->getRepository('ShopApp\\Repository\\UserRepository');

        return $userRepo->save($user);
    }

    /**
     * Check user login
     *
     * @return bool|mixed
     */
    public function check(){
        /** @var Manager $em */
        $em = $this->_container->get('manager');

        if (!empty($_SESSION['user']) && $_SESSION['user'] !== 'anonymous') {
            return $em->getRepository('ShopApp\\Repository\\UserRepository')->find($_SESSION['user']);
        } else {
            $this->logout();
            return false;
        }
    }


    /**
     * Login callback
     *
     * @param $login
     * @param $pass
     * @return bool
     */
    public function login($login, $pass){

        /** @var Manager $em */
        $em = $this->_container->get('manager');

        /** @var UserRepository $userRepo */
        $userRepo = $em->getRepository('ShopApp\\Repository\\UserRepository');

        /** @var UserModel $user */
        $user = $userRepo->findOneBy(['login' => $login]);


        if ($user->getPass() === sha1(self::SALT . $pass)) {

            $user->setSession($this->_sessionId);
            $user = $userRepo->update($user);

            $_SESSION['user'] = $user->getId();
        } else {
            return false;
        }
    }

    /**
     * Logout user
     */
    public function logout(){
        unset($_SESSION['user']);
        session_destroy();
    }

}