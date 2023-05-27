<?php

/**
 * @author @remycyuzuzo
 */

namespace App\Helpers;

/**
 * class facade contains all important methods which wraps some basic 
 * PHP functions to simplify tasks and for code readability
 */
class Facade
{

    public static function getRoute()
    {
        $url = parse_url($_SERVER["REQUEST_URI"]);
        return $url['path'];
    }

    /**
     * returns the HTTP request method (GET, POST)
     * @return string
     */
    public static function getRequestMethod()
    {
        $method = $_SERVER["REQUEST_METHOD"];
        return $method;
    }

    /**
     * @method renderView
     * Includes the view into the HTML DOM
     * @param string $path the path of the view, you must start this with a slash '/'
     * @param array|mixed $data passes data into the view being rendered
     */
    public static function renderView(string $path, $data = null)
    {
        if ($data !== null && is_array($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
            unset($data);
        }
        include(VIEWS_FOLDER . $path);
    }
}
