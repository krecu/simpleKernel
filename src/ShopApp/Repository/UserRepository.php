<?php

namespace ShopApp\Repository;

use Core\Database\Repository;

class UserRepository extends Repository {
    public static $table = 'users';
    public static $model = 'ShopApp\Model\UserModel';
}