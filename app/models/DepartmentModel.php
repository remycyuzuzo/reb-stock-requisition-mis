<?php

namespace App\Models;

use App\Database\DB;

class DepartmentModel
{
    public function getAllDepartments()
    {
        $db = new DB();
        $deps = $db->table('departments')->get()->toArray();
        return $deps;
    }
}
