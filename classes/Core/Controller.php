<?php

namespace Core;

/**
 * Class Controller
 * @package Core
 */
abstract class Controller
{
    public $model;
    public $view;

    function __construct()
    {
        $this->view = new View();
    }

    /**
     * Метод-обёртка над View->generate()
     * @param string $view - название Twig шаблона
     * @param array $data - данные, передаваемые в шаблон
     */
    function view($view, $data = [])
    {
        $this->view->generate($view, $data);
    }
}
