<?php

namespace Core;


use PDO;


/**
 * Class DBConnection
 * @package Core
 */
class DBConnection
{
    private static $instance = null;

    public static function get()
    {
        if (self::$instance === null) {
            $arOptions = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            self::$instance = new PDO('mysql:host=localhost;dbname=simple-mvc', 'root', '', $arOptions);
        }

        return self::$instance;
    }
}
