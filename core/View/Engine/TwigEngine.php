<?php

namespace Core\View\Engine;

/**
 * Class TwigEngine
 */
class TwigEngine implements IEngine
{

    private $_path;

    public function __construct($path)
    {
        $this->_path = $path;
    }

    public function render($view, $data = []){

        $loader = new \Twig_Loader_Filesystem($this->_path);
        return (new \Twig_Environment($loader))
            ->loadTemplate($view)
            ->render($data);
    }

}