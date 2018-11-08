<?php

namespace Core;


/**
 * Class Route <br/>
 * Роутер приложения
 * @package Core
 */
class Route
{
    /**
     * Запускает роутификацию в приложении
     */
    static public function start()
    {
        $controllerName = 'Main';
        $actionName = 'index';
        $actionParam = '';

        $routes = preg_replace('/(\?.*)?$/', '', $_SERVER["REQUEST_URI"]);
        $routes = explode('/', $routes);

        // Контроллер
        if (!empty($routes[1])) {
            $controllerName = ucfirst($routes[1]);
        }

        // Метод контроллера
        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }

        // Параметр метода контроллера
        if (!empty($routes[3])) {
            $actionParam = $routes[3];
        }

        $controllerFile = $controllerName . 'Controller.php';
        $controllerPath = 'app/Controllers/' . $controllerFile;

        if (!file_exists($controllerPath)) {
            Route::Error404();
        }

        $controllerClass = 'Controllers\\' . $controllerName . 'Controller';
        $controller = new $controllerClass;
        $action = $actionName;

        if (method_exists($controller, $action)) {
            if ($actionParam) {
                $controller->$action($actionParam);
            } else {
                $controller->$action();
            }
        } else {
            Route::Error404();
        }
    }

    /**
     * Обработка отсутсвующих страниц
     */
    static public function Error404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        header('Location:' . $host . 'errors/error404');
    }
}
