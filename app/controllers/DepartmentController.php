<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Database\DB;
use App\Router\Request;
use App\Helpers\Facade;
use App\Models\DepartmentModel;

class DepartmentController
{
    public function __construct()
    {
        $auth = new Auth();
        $auth->must_be_auth();
        $auth->match_minimum_permissions([
            'can_manage_system_parameters'
        ]);
    }

    public function renderDepartmentsList()
    {
        $department = new DepartmentModel();
        $department_list = $department->getAllDepartments();

        Facade::renderView('/departments/department_list.php', [
            'department_list' => $department_list,
        ]);

        return;
    }


    public function createNewDepartment()
    {

        if (!isset($_POST['dep_name'])) {
            flash(['error', 'Make sure you filled your form correctly']);
            redirect_to('/departments');
            return false;
        }

        $req = new Request();
        $db = new DB();
        $dep_name = $req->post->dep_name;

        // insert method usually returns the lastInsertID
        $new_dep_id = $db->insert('departments', [
            'dep_name' => $dep_name,
        ]);

        if (!$new_dep_id) {
            flash(['error', 'there was an error while trying to create the new department']);
            redirect_to('/departments');
            return false;
        }

        flash(['success' => 'The new department was created']);
        redirect_to('/departments');
        return true;
    }

    public function renderRoleUpdateForm()
    {
    }

    public function updateRole()
    {
    }

    public function deleteRole()
    {
    }
}
