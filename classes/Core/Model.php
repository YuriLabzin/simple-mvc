<?php

namespace Core;

/**
 * Class Model
 * @package Core
 */
abstract class Model
{
    protected $dbh;

    public function __construct()
    {
        $this->dbh = DBConnection::get();
    }

}
