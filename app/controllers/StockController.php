<?php

namespace App\Controllers;

use App\Auth\Auth;
use App\Helpers\Facade;
use App\Models\StockModel;

class StockController
{
    function __construct()
    {
        $auth = new Auth();
        $auth->must_be_auth();
    }

    public function showStockTransactions()
    {
        $transactions = [];
        Facade::renderView('/stock/stock_transactions.php', [
            'transactions' => $transactions,
        ]);
    }

    public function renderNewStockForm()
    {
        Facade::renderView('/stock/new_stock.php');
    }

    public function showStockPage()
    {
        $stockObj = new StockModel();
        $stock = $stockObj->getCurrentStock();
        Facade::renderView('/stock/stock_brief.php', [
            'stock' => $stock,
        ]);
    }
}
