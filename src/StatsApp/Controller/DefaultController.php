<?php

namespace StatsApp\Controller;

use Core\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    public function indexAction(Request $request){

        return new Response($this->_view->render('index.html.twig', []));
    }

}
