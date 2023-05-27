<?php

namespace App\Auth;

use App\Database\DB;

class User
{

    /** 
     * stores information of an authenticated user
     */
    public $user;

    /**
     * sets login sessions on the 
     * server memory to distinguish an authenticated user
     */
    public function login()
    {
        foreach ($this->user as $field => $value) {
            if ($field !== 'password') {
                $_SESSION['userdata'][$field] = $value;
            }
        }
    }

    /** 
     * Signs out a user by clearing out authentication 
     * session vars from the server memory
     */
    public function logout()
    {
        unset($_SESSION['userdata']);
        return;
    }

    /**
     * Checks whether the user entered the right credentials
     * @param string $email The user email address
     * @param string $password The hashed version of the user's password 
     * @return boolean
     */
    public function authenticate(string $email, string $password)
    {
        $db = new DB();
        $user = $db->table("users")->where([['email_addr', '=', $email], ['password', '=', $password]])->get()->toArray();

        if ($db->getCount() > 0) {
            $this->user = $user;
            return $user;
        } else {
            return false;
        }
    }
}
