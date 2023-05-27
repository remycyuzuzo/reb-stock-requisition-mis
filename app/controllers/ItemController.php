<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Database\DB;
use App\Helpers\Facade;
use App\Router\Request;
use App\Models\ItemModel;

class ItemController
{
    function __construct()
    {
        $auth = new Auth();
        $auth->must_be_auth();
        global $permissions;
        $auth->match_minimum_permissions([
            $permissions['CAN_MANAGE_STOCK'],
        ]);
        return;
    }

    public function renderItemsList()
    {
        $itemObj = new ItemModel();
        $item_categories = $itemObj->getAllItemCategories();
        $item_list = $itemObj->getAllItems();
        Facade::renderView('/items/items_list.php', [
            'item_list' => $item_list,
            'item_categories' => $item_categories,
        ]);
    }

    public function createNewItem()
    {

        if (!isset($_POST['item_name']) || !isset($_POST['item_category'])) {
            flash(['error', 'Make sure you filled your form correctly']);
            redirect_to('/items');
            return false;
        }

        $req = new Request();
        $db = new DB();
        $item_name = $req->post->item_name;
        $item_category_id = $req->post->item_category;

        // insert method usually returns the lastInsertID
        $new_insert_id = $db->insert('items', [
            'item_name' => $item_name,
            'item_category_id' => $item_category_id,
        ]);

        if (!$new_insert_id) {
            flash(['error', 'there was an error while trying to create the new department']);
            redirect_to('/items');
            return false;
        }

        flash(['success' => 'a new item created']);
        redirect_to('/items');
        return true;
    }

    public function createNewCategory()
    {
        $response = [];
        $req = new Request();
        $db = new DB();
        if (!isset($_POST['cat_name'])) {
            $response = ['result' => false, 'message' => 'make sure all fields are filled'];
            echo json_encode($response);
            return false;
        }
        if (!isset($_POST['csrf_token']) || $req->post->csrf_token !== $_SESSION['token']) {
            $response = ['result' => false, 'message' => 'cannot validate your anti-CSRF token'];
            echo json_encode($response);
            return false;
        }

        $category_name = $req->post->cat_name;

        // insert method usually returns the lastInsertID
        $new_insert_id = $db->insert('item_categories', [
            'category_name' => $category_name,
        ]);

        if (!$new_insert_id) {
            $response = ['result' => false, 'message' => 'there was an error while trying to create the new department'];
            echo $response;
            return false;
        }
        $response = ['result' => true, 'newID' => $new_insert_id, 'message' => 'new category registered'];
        echo json_encode($response);
        return true;
    }
}
