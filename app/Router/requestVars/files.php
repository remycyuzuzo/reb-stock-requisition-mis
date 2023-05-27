<?php

namespace App\Router\RequestVars;

/**
 * a class for accessing the FILES parameters
 */
class FILES
{
    function __construct()
    {
        if (count($_FILES) > 0) {
            foreach ($_FILES as $key => $value) {
                $this->$key = $value;
            }
        }
        return $_FILES;
    }
}
