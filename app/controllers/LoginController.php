<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Helpers\Facade;
use App\Auth\User;
use App\Helpers\Token;
use App\Router\Request;

class LoginController
{

    // !! Don't add parameters on these controllers methods, otherwise the code will break!!

    function __construct()
    {
        $auth = new Auth();
        $auth->must_be_guest();
    }

    public function renderLoginPage()
    {
        Facade::renderView("/login.php");
    }

    public function login()
    {
        $request = new Request();

        if (!isset($request->post->csrf_token) || !Token::verify($request->post->csrf_token)) {
            flash(["error" => "couldn't validate your request token"]);
            redirect_to('/login');
        }

        $email = $request->post->email_addr;
        $password = $request->post->password;

        $user = new User();

        if ($user->authenticate($email, hash_password($password))) {
            $user->login();
            if (isset($_POST['redirect_to'])) {
                redirect_to($request->post->redirect_to);
            }
            redirect_to('/');
        } else {
            flash(["error" => "invalid email address or password"]);
            redirect_to('/login');
        }
    }
}
