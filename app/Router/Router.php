<?php

namespace App\Router;

/**
 * a simple php router
 * by @author @remycyuzuzo
 * @forked from an open-source github repository https://phprouter.com
 * customized it and added most features
 */
class Router
{

    private const METHOD_GET = "GET";

    private const METHOD_POST = "POST";


    public function get($route, $controller_path)
    {
        if ($_SERVER['REQUEST_METHOD'] == self::METHOD_GET) {
            $this->route($route, $controller_path);
        }
    }

    public function post($route, $controller_path)
    {
        if ($_SERVER['REQUEST_METHOD'] == self::METHOD_POST) {
            $this->route($route, $controller_path);
        }
    }

    public function put($route, $controller_path)
    {
        if ($_SERVER['REQUEST_METHOD'] == METHOD_PUT) {
            $this->route($route, $controller_path);
        }
    }

    /**
     * Handling the delete methods
     */
    public function delete($route, $controller_path)
    {
        if ($_SERVER['REQUEST_METHOD'] == METHOD_DELETE) {
            $this->route($route, $controller_path);
        }
    }

    /**
     * for handling the request which is not found
     */
    public function any($route, $controller_path)
    {
        $this->route($route, $controller_path);
    }

    private function route($route, $controller_path)
    {
        if (!is_callable($controller_path) && !is_array($controller_path)) {
            $controller_path = __DIR__ . "/../controllers/$controller_path";
        }

        if ($route == "/404") {
            // Callback function
            if (is_callable($controller_path)) {
                call_user_func($controller_path);
                exit();
            }
            include_once("$controller_path");
            exit();
        }

        $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $request_url = rtrim($request_url, '/');
        $request_url = strtok($request_url, '?');
        $route_parts = explode('/', $route);
        $request_url_parts = explode('/', $request_url);
        array_shift($route_parts);
        array_shift($request_url_parts);
        // if the route doesn't have a dynamic slug, just execute the controller
        if ($route_parts[0] == '' && count($request_url_parts) == 0) {
            if (is_callable($controller_path)) {
                call_user_func($controller_path);
                exit();
            }
            // if it is a class and a method passed in
            elseif (is_array($controller_path)) {
                if (count($controller_path) !== 2) {
                    return;
                }
                $str_phpcode = '$obj = new ' . $controller_path[0] . '();';
                $str_phpcode .= '$obj->' . $controller_path[1] . '();';
                eval($str_phpcode);
                exit();
            }
            include_once("$controller_path");
            exit();
        }
        if (count($route_parts) != count($request_url_parts)) {
            return;
        }
        $parameters = [];
        for ($__i__ = 0; $__i__ < count($route_parts); $__i__++) {
            $route_part = $route_parts[$__i__];
            if (preg_match("/^[$]/", $route_part)) {
                $route_part = ltrim($route_part, '$');
                $$route_part = $request_url_parts[$__i__];
                $parameters[$route_part] = $request_url_parts[$__i__];
                // array_push($parameters, $request_url_parts[$__i__]);
            } else if ($route_parts[$__i__] != $request_url_parts[$__i__]) {
                return;
            }
        }
        // Callback function
        if (is_callable($controller_path)) {
            call_user_func($controller_path);
            exit();
        }
        // if the handler param is array, means they passed in the class and the method to call
        if (is_array($controller_path)) {
            if (count($controller_path) !== 2) {
                return;
            }
            $str_phpcode = '$obj = new ' . $controller_path[0] . '();';
            $str_phpcode .= '$obj->' . $controller_path[1];
            if (count($parameters) > 0) {
                $str_phpcode .= '($parameters)';
            } else {
                $str_phpcode .= '()';
            }
            $str_phpcode .= ';';
            eval($str_phpcode);
            exit();
        }
        include_once("$controller_path");
        exit();
    }
    function out($text)
    {
        echo htmlspecialchars($text);
    }
    function set_csrf()
    {
        if (!isset($_SESSION["csrf"])) {
            $_SESSION["csrf"] = bin2hex(random_bytes(50));
        }
        echo '<input type="hidden" name="csrf" value="' . $_SESSION["csrf"] . '">';
    }
    function is_csrf_valid()
    {
        if (!isset($_SESSION['csrf']) || !isset($_POST['csrf'])) {
            return false;
        }
        if ($_SESSION['csrf'] != $_POST['csrf']) {
            return false;
        }
        return true;
    }
}
