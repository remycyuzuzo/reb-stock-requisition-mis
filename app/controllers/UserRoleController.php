<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Database\DB;
use App\Helpers\Facade;
use App\Models\UserRoleModel;
use App\Router\Request;

class UserRoleController
{
    function __construct()
    {
        global $permissions;
        $auth = new Auth();
        $auth->must_be_auth();
        $auth->match_minimum_permissions([
            $permissions['CAN_MANAGE_USERS']
        ]);
    }

    public function renderRolesList()
    {
        $usrRoles = new UserRoleModel();
        $all_permissions = get_all_permissions();
        $roles = $usrRoles->getAllRoles();

        Facade::renderView('/users/user_roles_list.php', [
            'all_permissions' => $all_permissions,
            'roles' => $roles,
        ]);
    }


    public function createNewRole()
    {

        if (!isset($_POST['role_name']) || !isset($_POST['permissions'])) {
            flash(['error', 'Make sure you filled your form correctly']);
            redirect_to('/users/roles');
            return false;
        }

        $req = new Request();
        $db = new DB();
        $role_title = $req->post->role_name;
        $permissions = $req->post->permissions;

        $slug = str_replace([' ', '-', '/', '@', '&', ':'], '_', strtolower($role_title));

        // insert method usually returns the lastInsertID
        $new_role_id = $db->insert('user_roles', [
            'role_name' => $role_title,
            'user_role_slug' => $slug
        ]);

        if (!$new_role_id) {
            flash(['error', 'there was an error while trying to create the new role']);
            redirect_to('/users/roles');
            return false;
        }

        if ($permissions && is_array($permissions)) {
            foreach ($permissions as $permission) {
                if (!$db->insert('role_permissions', [
                    'permission_id' => $permission,
                    'role_id' => $new_role_id,
                ])) {
                    flash(['error' => 'There was an error']);
                    redirect_to('/users/roles');
                    return false;
                }
            }
        }

        flash(['success' => 'The new role was registered']);
        redirect_to('/users/roles');
        return true;
    }

    public function renderRoleUpdateForm($params)
    {
        $roleObj = new UserRoleModel();
        $role_info = $roleObj->getSingleRoleInfo($params['role_id']);
        $all_permissions = get_all_permissions();
        Facade::renderView('/users/update_user_role_form.php', [
            'all_permissions' => $all_permissions,
            'role_info' => $role_info,
        ]);
    }

    public function updateRole()
    {

        if (!isset($_POST['role_name']) || !isset($_POST['permissions']) || !isset($_POST['role_id'])) {
            flash(['error', 'Make sure you filled your form correctly']);
            // redirect_to(Facade::getRoute());
            return false;
        }

        $req = new Request();
        $db = new DB();
        $roleObj = new UserRoleModel();
        $role_title = $req->post->role_name;
        /**list of permissions submitted by the user */
        $permissions = $req->post->permissions;
        $role_id = $req->post->role_id;
        $role_perms = $roleObj->getRolePermissions($role_id);
        // $allPermissions = get_all_permissions();

        $update = $db->update('user_roles', [
            'role_name' => $role_title,
        ])->where([['id', '=', $role_id]])->exec();
        print_r($db->getSQL());
        if ($update === false) {
            echo "Hello 1  err";
            flash(['error', 'there was an error while trying to update this role']);
            redirect_to(Facade::getRoute());
            return false;
        }

        if ($permissions && is_array($permissions)) {
            foreach ($permissions as $permission) {
                if (!in_array($permission, $role_perms)) {
                    if (!$db->insert('role_permissions', [
                        'permission_id' => $permission,
                        'role_id' => $role_id,
                    ])) {
                        flash(['error' => 'There was an error']);
                        redirect_to(Facade::getRoute());
                        return false;
                    }
                }
            }
            foreach ($role_perms as $role_perm) {
                if (!in_array($role_perm['role_permissions_id'], $permissions)) {
                    if (!$db->delete('role_permissions', $role_id)) {
                        flash(['error', 'removed role permissions can not be deleted']);
                    }
                }
            }
        }

        flash(['success' => 'Changes were saved']);
        redirect_to('/users/roles');
        return true;
    }

    public function deleteRole()
    {
    }

    public function setRoleSpecificPermissions()
    {
    }
}
