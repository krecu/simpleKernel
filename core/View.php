<?php

namespace Core;

/**
 * Class View
 */
class View
{

    /*
     * На самом деле что бы было уж сосвем хорошо
     * можно сдедать некий интерфейс TemplateEngine
     * и некую фабрику что бы можно было выбирать на каком движке рендерить шаблоны
     */
    /** @var  \Twig_Environment */
    public $_engine;

    /**
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
     * Инициализация движка темплейта
     * @param $path
     */
    public function init($path){
        $loader = new \Twig_Loader_Filesystem($path . '/Views');
        $this->_engine = new \Twig_Environment($loader);
    }

}