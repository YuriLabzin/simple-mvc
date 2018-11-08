<?php

namespace Core;

use Twig_Environment;
use Twig_Loader_Filesystem;


/**
 * Class View
 * @package Core
 */
class View
{

    function generate($viewFile, $data = null)
    {
        $loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'] . '/app/views/');
        $twig = new Twig_Environment($loader, [
            'cache' => $_SERVER['DOCUMENT_ROOT'] . '/cache/views/'
        ]);

        $template = $twig->loadTemplate($viewFile);
        echo $template->render($data);
    }

}
