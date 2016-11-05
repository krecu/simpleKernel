<?php

namespace StatsApp\Controller;

use Core\Controller;
use Core\Database\Manager;
use StatsApp\Model\StatsModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package StatsApp\Controller
 */
class DefaultController extends Controller {


    public function indexAction(Request $request){
        return new Response($this->container->get('view')->render('index.html.twig'));
    }

    /**
     * Home controller
     *
     * @param Request $request
     * @return Response
     */
    public function homeAction(Request $request){

        /** @var Manager $em */
        $em = $this->container->get('manager');
        $statsRepo = $em->getRepository('StatsApp\\Repository\\StatsRepository');

        $data = [];
        /** @var StatsModel[] $items */
        $items = $statsRepo->findAll();
        foreach ($items as $item) {
            $data[] = [
                'time' => $item->getCreated(),
                'os' => $item->getOs(),
                'browser' => [
                    'name' => $item->getBrowserName(),
                    'version' => $item->getBrowserVersion()
                ],
                'geo' => [
                    'latitude' => $item->getLatitude(),
                    'longitude' => $item->getLongitude()
                ],
                'screen' => [
                    'height' => $item->getScreenHeight(),
                    'width' => $item->getScreenWidth()
                ],
            ];
        }

        return new Response($this->container->get('view')->render('stats.html.twig', ['data' => $data]));
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
            ->setScreenHeight($data['screen']['height'])
            ->setLatitude($data['geo']['latitude'])
            ->setLongitude($data['geo']['longitude'])
            ->setOs($data['os'])
            ->setCreated(time());

        /** @var Manager $em */
        $em = $this->container->get('manager');
        $statsRepo = $em->getRepository('StatsApp\\Repository\\StatsRepository');

        // save
        $statsRepo->save($stats);

        return new JsonResponse($data);
    }

}
