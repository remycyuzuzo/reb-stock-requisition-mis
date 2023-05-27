<?php


/** Project Base Directory */
define('BASE_DIR', __DIR__);

/** Public folder, contains the entry point of the application */
define('PUBLIC_FOLDER', BASE_DIR . "/public");

/** static folder, folder to keep all files */
define('STATIC_FOLDER', PUBLIC_FOLDER . "/static");

/** folder that contains templates to render pages */
define('VIEWS_FOLDER', BASE_DIR . "/views");

/** REQUEST GET */
define('METHOD_GET', 'GET');

/** REQUEST POST */
define('METHOD_POST', 'POST');

/** REQUEST PUT */
define('METHOD_PUT', 'PUT');

/** REQUEST DELETE */
define('METHOD_DELETE', 'DELETE');
