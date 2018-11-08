<?php

/**
 * Class App <br/>
 * Входня точка, необхадимая для запуска приложения
 */
class App
{

    /**
     * Автозагрузчик классов
     */
    private function autoload()
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

        spl_autoload_register(function ($className) {
            $foldersWithClasses = ['/app', '/classes'];

            foreach ($foldersWithClasses as $folder) {
                $filePath = $_SERVER['DOCUMENT_ROOT'] . $folder . '/' . str_replace('\\', '/', $className) . '.php';

                if (file_exists($filePath)) {
                    require_once $filePath;
                }
            }
        });
    }

    /**
     * Запускает приложение. <br/>
     * Инициализирует автозагрузчик классов и роутер
     */
    public function init()
    {
        $this->autoload();
        Core\Route::start();
    }
}



