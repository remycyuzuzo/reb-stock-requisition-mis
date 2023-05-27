<?php

namespace App\Models;

use App\Database\DB;

class UnitModel
{
    public function getAllUnits()
    {
        $db = new DB();
        $arr_units = $db->table('units')->get()->toArray();
        return $arr_units;
    }

    public function getUsersInUnity($unit_id)
    {
        if (!$unit_id) {
            return false;
        }

        $db = new DB();

        $query = "SELECT
            users.*, from user_units
                LEFT JOIN users on (user_units.user_id = users.id)
                LEFT JOIN units on (user_units.unit_id = units.id)
            WHERE user_units.unit_id = ?
        ";

        $users_array = $db->query($query, [$unit_id])->toArray();

        return $users_array;
    }
}
