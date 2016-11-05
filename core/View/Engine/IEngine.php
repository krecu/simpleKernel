<?php

namespace Core\View\Engine;

/**
 * Class View
 */
interface IEngine
{

    public function render($view, $data = []);

}