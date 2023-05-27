<?php

/**
 * @var string[] $permissions 
 * all preset user permissions 
 */

use App\Auth\Auth;
use App\Database\DB;

// stop executing this file if the user is not authenticated
if (!is_auth()) {
    return;
}
$permissions = [
    /**
     * defines whether a user can make requisitions
     */
    'CAN_MAKE_REQUISITION' => 'can_make_requisition',
    /**
     * This s given to the user who can approve the requisitions
     */
    'CAN_APPROVE_REQUISITION' => 'can_approve_requisition',
    /**
     * given to the user who can authorize the requisition
     */
    'CAN_AUTHORIZE_REQUISITION' => 'can_authorize_requisition',
    /**
     * given to the system administrators who can add or remove users from the system
     */
    'CAN_MANAGE_USERS' => 'can_manage_users',

    /**
     * a permission that is given to a user responsible for managing the stock
     */
    'CAN_MANAGE_STOCK' => 'can_manage_stock',

    'CAN_CHANGE_SYSTEM_PARAMS' => 'can_manage_system_parameters'
];

$_user_roles = [
    'admin' => 'admin',
    'hod' => 'hod',
    'staff' => 'staff',
    'dou' => 'dou',
    'logistics' => 'logistics',
    'storekeeper' => 'storekeeper',
];

/**
 * checks if a user have a specific permission
 * @param string $permission_name the name of the permission
 * @return boolean
 */
function check_permission($permission_name)
{

    $user_role_permissions = get_userrole_permissions();
    $user_specific_permissions = get_user_specific_permissions();
    // combined array without duplicates
    $user_permissions = array_merge($user_role_permissions, $user_specific_permissions);
    // die(print_r(get_user()['role_id']));
    // print_r($user_permissions);
    return in_array($permission_name, $user_permissions);
}

/**
 * returns all permissions preset to the current specific user-role in the system
 * @return array|false returns an array of permissions associated with a user-group/role or false if the query failed
 */
function get_userrole_permissions()
{
    $db = new DB();
    $user_role = get_user()['role_id'];
    $query = "SELECT perm_name, permissions.id from role_permissions left join permissions on (permissions.id = role_permissions.permission_id and role_permissions.role_id = ?);
    ";
    $res = $db->query($query, [$user_role]);
    $perms = [];
    $i = 0;
    foreach ($res->toArray() as $arrRow) {
        if ($arrRow['perm_name'] !== null) {
            $perms[$i++] = $arrRow['perm_name'];
        }
    }
    if ($res) {
        return $perms;
    }
    return false;
}

/**
 * returns an array of the current's user's specific permissions assigned to them
 */
function get_user_specific_permissions()
{
    return [];
}

function get_all_permissions()
{
    $db = new DB();
    $query = "SELECT perm_name, id from permissions";
    $res = $db->query($query);
    $perms = $res->toArray();
    if ($res) {
        return $perms;
    }
    return false;
}

function getRolePermissions($role_id)
{
    $db = new DB();
    $user_role = $role_id;
    $query = "SELECT perm_name from permissions inner join role_permissions on (permissions.id = role_permissions.permission_id and role_permissions.role_id = ?) ";
    $res = $db->query($query, [$user_role])->toArray();
    $perms = [];
    foreach ($res as $key => $value) {
        $perms[$key] = $value['perm_name'];
    }
    return $perms;
}
