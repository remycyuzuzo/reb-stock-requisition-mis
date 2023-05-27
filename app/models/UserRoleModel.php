<?php

namespace App\Models;

use App\Database\DB;

class UserRoleModel
{

    public function getAllRoles()
    {
        $db = new DB();
        $res = $db->table('user_roles')->get()->toArray();
        return $res;
    }

    /**
     * Returns the info about a role whose ID is specified in the parameter's list
     */
    public static function getSingleRoleInfo($id)
    {
        $db = new DB();
        $res = $db->table('user_roles')->where([['id', '=', $id]])->limit(1)->get()->toArray();
        if (count($res) > 0) {
            return $res[0];
        } else {
            return [];
        }
    }

    public function getRolePermissions($role_id)
    {
        $db = new DB();
        $user_role = $role_id;
        $query =
            "SELECT perm_name, role_permissions.id as role_permissions_id 
                from permissions
                inner join role_permissions on (permissions.id = role_permissions.permission_id and role_id = ?) 
        ";
        $res = $db->query($query, [$user_role])->toArray();

        return $res;
    }

    public function getUserRole()
    {
        return [];
    }

    public function getUsersInDepartment($department_id)
    {
        $db = new DB();
        $query = "SELECT users.first_name, users.last_name, users.id as userid, units.id as unitid, departments.id as depid, units.unit_name, departments.dep_name FROM users
            INNER JOIN user_units ON (users.id = user_units.user_id) 
            INNER JOIN units on (units.id = user_units.unit_id) 
            INNER JOIN departments ON (departments.id = units.department_id)
        WHERE departments.id = ?
        ";

        $res = $db->query($query, [$department_id])->toArray();
        return $res;
    }

    public function isUserHOD($user_id)
    {
        $db = new DB();
        $res = $db->table('departments')->where('user_id', '=', $user_id)->get()->toArray();
        if (count($res) <= 0) {
            return false;
        }
        return $res[0];
    }

    public function isUserDoU($user_id)
    {
        $db = new DB();
        $res = $db->table('units')->where('user_id', '=', $user_id)->get()->toArray();
        if (count($res) <= 0) {
            return false;
        }
        return $res[0];
    }
}
