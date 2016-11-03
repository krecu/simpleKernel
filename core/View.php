<?php

namespace Core;

/**
 * Class View
 */
class View
{

    /** @var  \Twig_Environment */
    public $_engine;

    /**
     * Render template
     *
     * @param $view
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function render($view, $data = [])
    {
        $template = $this->_engine->loadTemplate($view);

        return $template->render($data);

    }

    /**
     * Init engine for module
     * @param $path
     */
    public function init($path){
        $loader = new \Twig_Loader_Filesystem($path . '/Views');
        $this->_engine = new \Twig_Environment($loader);
    }

}