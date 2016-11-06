<?php

namespace ShopApp\Model;

/*
CREATE TABLE `products` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(254) NOT NULL,
  `price` DOUBLE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=UTF8;
*/

/**
 * Class UserModel
 * @package ShopApp\Model
 */
class ProductModel {

    /** @var  integer */
    private $id;

    /** @var  string */
    private $title;

    /** @var  string */
    private $price;

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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }


}