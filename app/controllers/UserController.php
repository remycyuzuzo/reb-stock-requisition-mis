<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Database\DB;
use App\Helpers\Token;
use App\Helpers\Facade;
use App\Models\DepartmentModel;
use App\Models\UnitModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use App\Router\Request;

class UserController
{
    function __construct()
    {
        $auth = new Auth();
        $auth->must_be_auth();
        global $permissions;
        $auth->match_minimum_permissions([
            $permissions['CAN_MANAGE_USERS']
        ]);
    }

    public function renderUsersList()
    {
        $user = new UserModel();
        $users = $user->getAllUsers();

        Facade::renderView('/users/users_list.php', [
            'users' => $users,
        ]);
    }

    public function renderNewUserForm()
    {
        $role = new UserRoleModel();
        $departmentObj = new DepartmentModel();
        $unitObj = new UnitModel();

        $all_roles = $role->getAllRoles();
        $all_departments = $departmentObj->getAllDepartments();
        $all_units = $unitObj->getAllUnits();
        Facade::renderView('/users/new_user_form.php', [
            'all_roles' => $all_roles,
            'all_departments' => $all_departments,
            'all_units' => $all_units,
        ]);
    }

    public function createNewUser()
    {
        $request = new Request();
        $db = new DB();
        $roleObj = new UserRoleModel();
        // protect CSRF attacks    
        if (!isset($request->post->csrf_token) || !Token::verify($request->post->csrf_token)) {
            flash(["error" => "couldn't validate your request token"]);
            redirect_to(Facade::getRoute());
        }

        if (!isset($_POST['first_name']) || !isset($_POST['last_name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['role'])) {
            flash(['error' => 'Make sure you have filled all fields']);
            redirect_to(Facade::getRoute());
        }

        $fname = $request->post->first_name;
        $lname = $request->post->last_name;
        $email = $request->post->email;
        $password = hash_password($request->post->password);
        $tel_nber = $request->post->tel_number;
        $role_id = $request->post->role;
        $role_slug = $roleObj->getSingleRoleInfo($role_id)['user_role_slug'];
        $status = 'active';

        $insert = [
            'email_addr' => $email,
            'first_name' => $fname,
            'last_name' => $lname,
            'password' => $password,
            'tel_number' => $tel_nber,
            'role_id' => $role_id,
            'status' => $status
        ];
        $insert_id = $db->insert('users', $insert);
        global $_user_roles;

        if (isset($_POST['unit'])) {
            if ($role_slug === $_user_roles['dou']) {
                $db->insert('user_units', [
                    'unit_id' => $request->post->unit,
                    'user_id' => $insert_id
                ]);
                $db->update('units', [
                    'user_id' => $insert_id
                ], $request->post->unit);
            }
        }
        if (isset($_POST['department'])) {
            if ($role_slug === $_user_roles['hod']) {
                $db->update('departments', [
                    'user_id' => $insert_id
                ], $request->post->department);
            }
        }
        flash(['success' => 'a new user is created']);
        redirect_to(Facade::getRoute());
        return;
    }

    public function renderUserUpdateForm()
    {
    }

    public function updateUser()
    {
    }

    public function deleteUser()
    {
    }

    public function setUserSpecificPermissions()
    {
    }
}
