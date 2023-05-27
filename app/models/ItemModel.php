<?php

namespace App\Models;

use App\Database\DB;

class ItemModel
{
    public function getAllItems()
    {
        $db = new DB();
        $query = "SELECT items.*, category_name, item_categories.id as cat_id from items left join item_categories on (items.`item_category_id` = item_categories.id);
        ";
        $items = $db->query($query)->toArray();
        return $items;
    }

    /**
     * Fetches the specific details about an particular item
     * @param integer $item_id the ID of the item being fetched from the database
     */
    public function getItem($item_id)
    {
        $db = new DB();
        $query = "SELECT items.*, category_name, item_categories.id as cat_id from items left join item_categories on (items.`item_category_id` = item_categories.id) where items.id = $item_id;
        ";
        $items = $db->query($query)->toArray();
        return $items[0];
    }

    // item categories
    public function getAllItemCategories()
    {
        $db = new DB();
        $item_cats = $db->table('item_categories')->get()->toArray();
        return $item_cats;
    }
}
