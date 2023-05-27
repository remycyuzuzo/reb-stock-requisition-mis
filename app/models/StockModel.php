<?php

namespace App\Models;

use App\Database\DB;

class StockModel
{
    public function getCurrentStock(array $filters = null)
    {
        $db = new DB();
        $query = "SELECT items.item_name, items.quantity, item_categories.category_name from items 
                LEFT JOIN item_categories on (items.item_category_id = item_categories.id)                
            ";
        // if no filters are set, then return all rows
        if ($filters !== null) {
            $query .= " WHERE ";
        }

        $rows = $db->query($query)->toArray();
        return $rows;
    }
}
