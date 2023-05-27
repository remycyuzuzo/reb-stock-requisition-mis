<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Helpers\Facade;


class DashboardController
{
    function __construct()
    {
        $auth = new Auth();
        $auth->must_be_auth();
    }

    public function renderHomepage()
    {
        Facade::renderView("/dashboard.php");
    }
}
