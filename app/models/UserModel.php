<?php

namespace App\Models;

use App\Database\DB;

class UserModel
{
    public function getAllUsers()
    {
        $db = new DB();
        $res = $db->query('SELECT users.*, role_name, user_role_slug from users inner join user_roles on (users.role_id = user_roles.id)')->toArray();
        return $res;
    }
}
