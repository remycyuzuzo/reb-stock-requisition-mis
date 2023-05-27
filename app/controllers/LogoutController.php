<?php

namespace App\Controllers;

use App\Auth\User;

class LogoutController
{

    public function logout()
    {
        if (is_auth()) {
            $user = new User();
            $user->logout();
        }
    }
}
