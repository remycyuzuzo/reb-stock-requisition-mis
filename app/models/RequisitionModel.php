<?php


namespace App\Models;

use App\Database\DB;

class RequisitionModel
{
    public function getUserRequisitions($user_id)
    {
        $db = new DB();
        $requisitions = $db->table('requisitions')->where('user_id', '=', $user_id)->get()->toArray();
        return $requisitions;
    }

    /**
     * Fetch requisition list from a given department id or unit id
     * @param array $depIdOrUnitId an array to specify whether the id is for a unit or a department,
     * if you're looking for a list of requisitions in a department simply pass (['dep_id' => 1]) and (['unit_id' => 1]) for a unit
     */
    public function getRequisitionsListToApprove(array $depIdOrUnitId)
    {
        if (!is_array($depIdOrUnitId) && (!isset($depIdOrUnitId['dep_id']) || !isset($depIdOrUnitId['unit_id']))) {
            return false;
        }
        $db = new DB();
        $group_id_index_name = '';
        $group = '';
        $query = '';
        if (isset($depIdOrUnitId['dep_id'])) {
            $query = "SELECT 
                    requisitions.req_reference_code, requisitions.datetime_created, users.first_name, users.last_name, users.id as userid, units.id as unitid, departments.id as depid, units.unit_name, departments.dep_name 
                FROM requisitions 
                    INNER JOIN users ON (users.id = requisitions.user_id) 
                    INNER JOIN user_units ON (users.id = user_units.user_id) 
                    LEFT JOIN units on (units.id = user_units.unit_id AND user_units.user_id = users.id) 
                    INNER JOIN departments ON (departments.id = units.department_id AND departments.id = ?)
                WHERE requisitions.status = 'pending'
                    ";
            $group_id_index_name = 'dep_id';
            $group = 'departments';
        }
        // if a unit ID was passed in instead
        elseif (isset($depIdOrUnitId['unit_id'])) {
            $query = "SELECT
                users.first_name, users.last_name, 
            ";

            $group_id_index_name = 'unit_id';
            $group = 'units';
        }

        $query_arguments = [$depIdOrUnitId[$group_id_index_name]];
        if (isset($depIdOrUnitId['user_id'])) {
            $query .= " AND $group.user_id = ? ";
            array_push($query_arguments, $depIdOrUnitId['user_id']);

            $res = $db->query($query, $query_arguments)->toArray();
        }
        return $res;
    }
}
