<?php

namespace StatsApp\Controller;

use Core\Controller;
use StatsApp\Model\StatsModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package StatsApp\Controller
 */
class DefaultController extends Controller {

    /**
     * Home controller
     *
     * @param Request $request
     * @return Response
     */
    public function homeAction(Request $request){

        return new Response($this->_view->render('index.html.twig', [
            'data' => [
                    [
                        'time' => time(),
                        'os' => 'Mac OS',
                        'browser' => [
                            'name' => 'Chrome',
                            'version' => '54'
                        ],
                        'geo' => [
                            'latitude' => '55.7497002',
                            'longitude' => '37.8771951'
                        ],
                        'screen' => [
                            'height' => '1010',
                            'width' => '1920'
                        ],
                    ],
                [
                    'time' => time(),
                    'os' => 'Mac OS',
                    'browser' => [
                        'name' => 'Chrome',
                        'version' => '54'
                    ],
                    'geo' => [
                        'latitude' => '51.7497002',
                        'longitude' => '37.8771951'
                    ],
                    'screen' => [
                        'height' => '1010',
                        'width' => '1920'
                    ],
                ]
            ]
        ]));
    }

    /**
     * Save data controller
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function saveAction(Request $request){
        $data = json_decode($request->getContent(), 1);

        $stats = new StatsModel();
        $stats
            ->setBrowserName($data['browser']['name'])
            ->setBrowserVersion($data['browser']['version'])
            ->setScreenWidth($data['screen']['width'])
            ->setScreenWidth($data['screen']['height'])
            ->setLatitude($data['geo']['latitude'])
            ->setLongitude($data['geo']['longitude'])
            ->setOs($data['os'])
            ->setTime(time());

//        $this->_db->query();

        return new JsonResponse($data);
    }

}
