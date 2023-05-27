<?php

namespace App\Router\RequestVars;

/**
 * a class for accessing the GET parameters
 */
class GET
{
    function __construct()
    {
        if (count($_GET) > 0) {
            foreach ($_GET as $key => $value) {
                $this->$key = $value;
            }
        }
        return $_GET;
    }
}
