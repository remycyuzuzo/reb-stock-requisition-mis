<?php

namespace App\Router\RequestVars;

/**
 * a class for accessing the SESSION parameters
 */
class SESSION
{
    function __construct()
    {
        if (count($_SESSION) > 0) {
            foreach ($_SESSION as $key => $value) {
                $this->$key = $value;
            }
        }
        return $_SESSION;
    }
}
