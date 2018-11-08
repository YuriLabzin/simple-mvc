<?php


namespace Controllers;


use Core\Controller;

class MainController extends Controller
{
    function index()
    {
        $this->view('main.twig');
    }

}
