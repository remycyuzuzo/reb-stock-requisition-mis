<?php
// toggle the environment to dev or prod mode
$env_dev = "development";
$env_prod = "production";
define("ENV", $env_dev); // change to $env_prod during production

/** change this during production */
define('ROOT_URL', "http://" . $_SERVER["SERVER_NAME"] . ":" . $_SERVER['SERVER_PORT']);

/** Project title system-wide */
define('APP_TITLE', 'REB Stock Management System');

/** Public folder, contains the entry point of the application */
define('PUBLIC_FOLDER_URL', ROOT_URL . "/public");

/** URI to the static folder */
define('STATIC_FOLDER_URL', PUBLIC_FOLDER_URL . "/static");

define('LOGIN_URL', ROOT_URL . '/login');

include_once __DIR__ . "/constants.php";
include_once __DIR__ . "/app/helpers/helpers.php";
include_once __DIR__ . "/permissions.php";
