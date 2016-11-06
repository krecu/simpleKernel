<?php

namespace ShopApp\Controller;

use Core\Controller;
use Core\Database\Manager;
use ShopApp\Model\ProductModel;
use ShopApp\Model\UserModel;
use ShopApp\Service\Auth;
use ShopApp\Service\Cart;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package StatsApp\Controller
 */
class DefaultController extends Controller {


    public function cartAction(Request $request){

        $cart = new Cart($this->container);

        switch ($request->getMethod()) {
            case 'POST' :
                $cart->addProduct($request->request->get('product'));

                header("Location: " . $request->server->get('HTTP_REFERER'));
                break;

            case 'PATCH' :
                break;

            case 'DELETE' :
                $cart->removeProduct($request->request->get('product'));

                header("Location: " . $request->server->get('HTTP_REFERER'));
                break;
            case 'GET' :

                return new Response($this->container->get('view')->render('cart.html.twig', $this->_getVariable(['cart' => ['details' => $cart->details()]])));
                break;
        }

    }

    /**
     * List products
     *
     * @param Request $request
     * @return Response
     */
    public function catalogAction(Request $request){

        /** @var Manager $em */
        $em = $this->container->get('manager');
        $productRepo = $em->getRepository('ShopApp\\Repository\\ProductRepository');

        /** @var ProductModel[] $productsEntity */
        $productsEntity = $productRepo->findAll();

        $products = [];
        foreach ($productsEntity as $item) {
            $products[] = [
                'id' => $item->getId(),
                'title' => $item->getTitle(),
                'price' => $item->getPrice()
            ];
        }

        return new Response($this->container->get('view')->render('catalog.html.twig', $this->_getVariable(['products' => $products])));
    }

    /**
     * Logout page
     *
     * @param Request $request
     */
    public function logoutAction(Request $request){
        $auth = new Auth($this->container);
        $auth->logout();

        header("Location: /login");
    }

    /**
     * Profile page
     *
     * @param Request $request
     * @return Response
     */
    public function profileAction(Request $request){
        $auth = new Auth($this->container);
        if ($user = $auth->check()) {
            return new Response($this->container->get('view')->render('profile.html.twig', $this->_getVariable()));
        } else {
            header("Location: /login");
        }
    }

    /**
     * Login page
     *
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request){

        $auth = new Auth($this->container);

        if ($request->getMethod() == "POST") {
            $auth->login($request->request->get('login'), $request->request->get('pass'));
        }

        if ($user = $auth->check()) {
            header("Location: /profile");
        } else {
            $alert = [];
            $alert[] = 'Check login and password';
            return new Response($this->container->get('view')->render('login.html.twig', ['alert' => $alert]));
        }

    }

    /**
     * Default shop variables
     *
     * @param $vars
     * @return array
     */
    private function _getVariable($vars = []){

        $variables = [];
        $auth = new Auth($this->container);
        if ($user = $auth->check()) {
            $variables['user'] = [
                'login' => $user->getLogin()
            ];
        }

        $cart = new Cart($this->container);
        $variables['cart']['summary'] = $cart->summary();

        return array_merge_recursive($variables, $vars);
    }

}
