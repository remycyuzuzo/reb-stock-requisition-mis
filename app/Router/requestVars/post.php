<?php

namespace App\Router\RequestVars;

/**
 * a class for accessing the POST parameters
 */
class POST
{
    function __construct()
    {
        if (count($_POST) > 0) {
            foreach ($_POST as $key => $value) {
                $this->$key = $value;
            }
        }
        return $_POST;
    }
}
