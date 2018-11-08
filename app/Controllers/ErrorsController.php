<?php


namespace Controllers;


use Core\Controller;

/**
 * Class ErrorsController
 * @package Controllers
 */
class ErrorsController extends Controller
{
    /**
     * Выводит страницу ошибки
     */
    public function error404()
    {
        $this->view('404.twig');
    }

}
