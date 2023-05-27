<?php

namespace App\Router;

use App\Helpers\Facade;
use App\Router\RequestVars\FILES;
use App\Router\RequestVars\GET;
use App\Router\RequestVars\POST;
use App\Router\RequestVars\SESSION;

class Request
{
    public POST $post;
    public GET $get;
    public SESSION $session;
    // public Request $cookie;
    public FILES $files;

    function __construct()
    {
        $this->post = new POST();
        $this->get = new GET();
        $this->session = new SESSION();
        // $this->cookie = new Request();
        $this->files = new FILES();
    }

    public function has(string $field_name)
    {
        return isset($field_name);
    }

    /**
     * will validate incoming data and rejects all if one condition is not met
     */
    public function validate(array $fields)
    {
        if (!is_array($fields)) {
            return;
        }
        foreach ($fields as $field => $rules) {
            foreach ($rules as $rule => $value) {
                if (strtolower($rule) === 'email') {
                    $email = filter_var($this->post->$field, FILTER_SANITIZE_EMAIL);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        return false;
                    }
                } elseif (strtolower($rule) === 'required') {
                    if (empty($this->post->$field)) {
                        return false;
                    }
                } elseif (strtolower($rule) === 'max') {
                    if (strlen($this->post->$field) > $value) {
                        return false;
                    }
                }
            }
        }
    }
}
