<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Database\DB;
use App\Router\Request;
use App\Helpers\Facade;
use App\Models\DepartmentModel;
use App\Models\UnitModel;

class UnitController
{
    public function __construct()
    {
        $auth = new Auth();
        $auth->must_be_auth();
        $auth->match_minimum_permissions([
            'can_manage_system_parameters'
        ]);
    }

    public function renderUnitsList()
    {
        $unitObj = new UnitModel();
        $department = new DepartmentModel();
        $department_list = $department->getAllDepartments();
        $units = $unitObj->getAllUnits();

        Facade::renderView('/units/units_list.php', [
            'units' => $units,
            'department_list' => $department_list,
        ]);

        return;
    }


    public function createNewUnit()
    {

        if (!isset($_POST['unit_name']) || !isset($_POST['department'])) {
            flash(['error', 'Make sure you filled your form correctly']);
            redirect_to('/units');
            return false;
        }

        $req = new Request();
        $db = new DB();
        $dep_id = $req->post->department;
        $unit_name = $req->post->unit_name;

        // insert method usually returns the lastInsertID
        $new_dep_id = $db->insert('units', [
            'unit_name' => $unit_name,
            'department_id' => $dep_id,
        ]);

        if (!$new_dep_id) {
            flash(['error', 'there was an error while trying to create the new department']);
            redirect_to('/units');
            return false;
        }

        flash(['success' => 'The new unit was created']);
        redirect_to('/units');
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
