<?php

namespace App\Auth;

use App\Helpers\Facade;

class Auth
{
    public function must_be_auth()
    {
        if (!isset($_SESSION['userdata'])) {
            $redirect_url = LOGIN_URL;
            if (Facade::getRoute() !== '/') {
                flash(['warn' => '<b>Access denied</b>: you must be signed in to access this page']);
                $redirect_url .= '?redirect_to=';
            }
            redirect_to($redirect_url . Facade::getRoute());
        }
        return;
    }

    public static function must_be_guest()
    {
        if (isset($_SESSION['userdata'])) {
            redirect_to('/');
        }
    }

    public static function is_signed_in()
    {
        if (isset($_SESSION['userdata'])) {
            return true;
        }
        return false;
    }

    /**
     * will halt the execution if the user is not authorized for a specific action
     * @param array $permission_list an array containing the minimum permissions that a user must have
     */
    public static function match_minimum_permissions($permission_list)
    {
        if (is_array($permission_list)) {
            foreach ($permission_list as $permission) {
                if (!check_permission($permission)) {
                    return false;
                    http_response_code(403);
                    exit('access denied');
                }
            }
        } else {
            exit();
        }
    }
}
