<?php

namespace ShopApp\Repository;

use Core\Database\Repository;

class ProductRepository extends Repository {
    public static $table = 'products';
    public static $model = 'ShopApp\Model\ProductModel';
}