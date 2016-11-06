<?php

namespace ShopApp\Service;

use Core\Container;
use Core\Database\Manager;
use ShopApp\Model\ProductModel;
use ShopApp\Repository\ProductRepository;

/**
 * Class Cart
 * @package ShopApp\Service
 */
class Cart {

    /** @var  Container */
    private $_container;

    /**
     * Cart constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->_container = $container;
    }

    /**
     * Add product to cart
     *
     * @param $productId
     */
    public function addProduct($productId) {
        session_start();
        if (empty($_SESSION['cart'])) {
            $_SESSION['cart'][$productId] = 1;
        } else {
            $_SESSION['cart'][$productId] += 1;
        }
    }

    /**
     * Remove product from cart
     *
     * @param $productId
     */
    public function removeProduct($productId){
        session_start();
        if (!empty($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    /**
     * Summary info from cart
     *
     * @return array
     */
    public function summary(){

        $summ = 0;
        $count = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $p => $item) {
                /** @var Manager $em */
                $em = $this->_container->get('manager');
                /** @var ProductRepository $productRepo */
                $productRepo = $em->getRepository('ShopApp\\Repository\\ProductRepository');

                /** @var ProductModel $product */
                $product = $productRepo->find($p);
                $summ += (double)$product->getPrice();

                $count++;

            }
        }

        return [
            'summ' => $summ,
            'count' => $count
        ];
    }

    /**
     * Details info from cart
     *
     * @return array
     */
    public function details(){

        $products = [];

        session_start();

        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $p => $item) {
                /** @var Manager $em */
                $em = $this->_container->get('manager');
                /** @var ProductRepository $productRepo */
                $productRepo = $em->getRepository('ShopApp\\Repository\\ProductRepository');

                /** @var ProductModel $product */
                $product = $productRepo->find($p);

                /** @var ProductModel $product */
                $products[] = [
                    'title' => $product->getTitle(),
                    'count' => $item,
                    'price' => $item * $product->getPrice(),
                ];
            }
        }

        return $products;
    }
}