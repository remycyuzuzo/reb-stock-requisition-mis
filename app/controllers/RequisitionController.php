<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Database\DB;
use App\Helpers\Facade;
use App\Models\ItemModel;
use App\Models\RequisitionModel;
use App\Models\UserRoleModel;
use App\Router\Request;

class RequisitionController
{

    function __construct()
    {
        $this->auth = new Auth();
        $this->auth->must_be_auth();
    }

    public function renderCurrentUserRequisition()
    {
        global $permissions;
        $this->auth->match_minimum_permissions([$permissions['CAN_MAKE_REQUISITION']]);

        $requisitionObj = new RequisitionModel();
        $requisition_arr = $requisitionObj->getUserRequisitions(get_user()['id']);

        Facade::renderView('/requisitions/current_user_requisitions.php', [
            'requisition_arr' => $requisition_arr,
        ]);
    }

    public function renderNewRequisitionForm()
    {
        global $permissions;
        $this->auth->match_minimum_permissions([$permissions['CAN_MAKE_REQUISITION']]);

        $itemObj = new ItemModel();
        $item_list = $itemObj->getAllItems();
        $req_temp_list = [];
        if (isset($_SESSION['unsent_requisitions'])) {
            $req_temp_list = $_SESSION['unsent_requisitions'];
        }
        Facade::renderView('/requisitions/new_requisition_form.php', [
            'item_list' => $item_list,
            'req_temp_list' => $req_temp_list,
        ]);
    }

    public function createUnsentReqList()
    {
        $request = new Request();
        $itemObj = new ItemModel();
        if (!isset($_POST['item_id']) || !isset($_POST['quantity']) || !isset($_POST['comments'])) {
            flash("Please fill the form right");
            redirect_to('/requisitions/new');
            return;
        }
        $item_id = $request->post->item_id;
        $item_name = $itemObj->getItem($item_id)['item_name'];
        $quantity = $request->post->quantity;
        $comments = $request->post->comments;
        if (isset($_SESSION['unsent_requisitions'][$item_id])) {
            flash(["error" => "This item is already on the list"]);
            redirect_to('/requisitions/new');
            return;
        }

        $arr = [
            'id' => $item_id,
            'item_name' => $item_name,
            'quantity' => $quantity,
            'comments' => $comments,
        ];

        $_SESSION['unsent_requisitions'][$item_id] = $arr;
        redirect_to('/requisitions/new');
        return;
    }

    public function removeFromUnsentReqList($params)
    {
        if (!isset($params['requisition_id']) || !is_numeric($params['requisition_id'])) {
            redirect_to('/requisitions/new');
            return;
        }
        unset($_SESSION['unsent_requisitions'][$params['requisition_id']]);
        redirect_to('/requisitions/new');
        return;
    }

    public function clearUnsentReqList()
    {
        unset($_SESSION['unsent_requisitions']);
        redirect_to('/requisitions/new');
        return;
    }

    public function createNewRequisition()
    {
        global $permissions;
        $this->auth->match_minimum_permissions([$permissions['CAN_MAKE_REQUISITION']]);

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['token']) {
            flash(['error' => 'couldn\'t validate your anti CSRF token']);
            redirect_to('/requisitions/new');
            return;
        }
        $db = new DB();
        if (!isset($_SESSION['unsent_requisitions'])) {
            flash(['error' => 'required values not found']);
            redirect_to('/requisitions/new');
            return;
        }

        $data = [
            'user_id' => get_user()['id'],
            'req_reference_code' => generate_ref_number(uniqid('DEP_UNIT_')),
            'status' => 'pending'
        ];
        $req_insert_id = $db->insert('requisitions', $data);
        // then insert into an requisitions table extension "requisition items" requisition items
        foreach ($_SESSION['unsent_requisitions'] as $item) {
            $comments = (isset($item['comments'])) ? $item['comments'] : '';
            $data_items = [
                'requisition_id' => $req_insert_id,
                'item_id' => $item['id'],
                'comments' => $comments,
                'quantity' => $item['quantity'],
            ];
            $item_insert_id = $db->insert('requisition_items', $data_items);

            if (!$req_insert_id || !$item_insert_id) {
                flash(['error' => 'an error occured']);
                redirect_to('/requisitions/new');
                return;
            }
        }
        $this->clearUnsentReqList();
        flash(['success' => 'Your requisition has been sent! please wait for your approval']);
        redirect_to('/requisitions/new');
        return;
    }

    /**
     * show all pending requisitions waiting to be approved by the HOD of the director
     * 
     */
    public function renderPendingRequisitionList()
    {
        global $permissions;
        $this->auth->match_minimum_permissions([$permissions['CAN_APPROVE_REQUISITION']]);

        $requisitionObj = new RequisitionModel();
        $userRoleObj = new UserRoleModel();
        $currentUserId = get_user()['id'];
        // determine whether a user is a HOD or a Director of a unit
        $role_index = '';
        $unitOrDepID = null;
        $isDou = $userRoleObj->isUserDoU($currentUserId);
        if ($isDou !== false || is_array($isDou)) {
            $unitOrDepID = $isDou['id'];
            $role_index = 'unit_id';
        } else {
            $isHOD = $userRoleObj->isUserHOD($currentUserId);
            if ($isHOD) {
                $unitOrDepID = $isHOD['id'];
                $role_index = 'dep_id';
            }
        }
        $requisition_list = [];
        if ($unitOrDepID) {
            $requisition_list = $requisitionObj->getRequisitionsListToApprove([
                $role_index => $unitOrDepID,
                'user_id' => $currentUserId,
            ]);
        }


        Facade::renderView('/requisitions/requisition_list_to_approve.php', [
            'requisition_list' => $requisition_list,
        ]);
    }
}
