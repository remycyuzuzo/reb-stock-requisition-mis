<?php

/**
 * @author @remycyuzuzo for REB
 */

session_start();
// include all files required
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config.php';

// import the router class

use App\Controllers\DashboardController;
use App\Controllers\DepartmentController;
use App\Controllers\ItemController;
use App\Controllers\LoginController;
use App\Controllers\RequisitionController;
use App\Controllers\StockController;
use App\Controllers\Tests\TestingController;
use App\Controllers\UnitController;
use App\Controllers\UserController;
use App\Controllers\UserRoleController;
use App\Router\Router;
use App\Helpers\Facade;

// instantiate the Router class
$router = new Router();

// define your routes
/* 
    USE SINGLE QUOTES ON ROUTES WITH DYNAMIC SLUG, 
    OTHERWISE THE INTERPRETER MIGHT CONFUSE IT WITH AN UNDEFINED VARIABLE.

    on each route, the first argument is a route, don't add a trailing slash
        the second argument varies: can be a path to the controller file, 
        or an array with a class name and a method to call
        eg. [ControllerClass::class, 'methodName']
        or can be just an anonymous function
*/

// handling the dashboard page
$router->get('/', [DashboardController::class, 'renderHomepage']);

// login routers
$router->get('/login', [LoginController::class, 'renderLoginPage']);
$router->post('/login', [LoginController::class, 'login']);

// user-management-based routes
$router->get('/users', [UserController::class, 'renderUsersList']);
$router->get('/users/new-user', [UserController::class, 'renderNewUserForm']);
$router->post('/users/new-user', [UserController::class, 'createNewUser']);
$router->delete('/users/delete/$user_id', [UserController::class, 'deleteUser']);
$router->put('/users/update/$user_id', [UserController::class, 'updateUser']);
$router->get('/user/$user_id', [UserController::class, 'renderNewUserForm']);
// user-roles
$router->get('/users/roles', [UserRoleController::class, 'renderRolesList']);
$router->post('/users/roles/create-new-role', [UserRoleController::class, 'createNewRole']);
// $router->get('/users/roles/$role_id', 'users/get_single_role_controller.php');
$router->delete('/users/roles/delete/$role_id', 'users/get_single_role_controller.php');
$router->get('/users/roles/update/$role_id', [UserRoleController::class, 'renderRoleUpdateForm']);
$router->post('/users/roles/update/$role_id', [UserRoleController::class, 'updateRole']);

$router->get('/units', [UnitController::class, 'renderUnitsList']);
$router->post('/units/new-unit', [UnitController::class, 'createNewUnit']);

$router->get('/departments', [DepartmentController::class, 'renderDepartmentsList']);
$router->post('/departments/new', [DepartmentController::class, 'createNewDepartment']);

$router->get('/items', [ItemController::class, 'renderItemsList']);
$router->get('/items/new', [ItemController::class, 'renderNewItemForm']);
$router->post('/items/new', [ItemController::class, 'createNewItem']);

$router->post('/items/new/category', [ItemController::class, 'createNewCategory']);

// Stock management
$router->get('/stock', [StockController::class, 'showStockPage']);
$router->get('/stock/transactions', [StockController::class, 'showStockTransactions']);
$router->get('/stock/new-stock', [StockController::class, 'renderNewStockForm']);

$router->get('/requisitions/my-requisitions', [RequisitionController::class, 'renderCurrentUserRequisition']);
$router->get('/requisitions/new', [RequisitionController::class, 'renderNewRequisitionForm']);
$router->post('/requisitions/new', [RequisitionController::class, 'createNewRequisition']);
$router->post('/requisitions/add-to-list', [RequisitionController::class, 'createUnsentReqList']);
$router->get('/requisitions/new/form/remove/$requisition_id', [RequisitionController::class, 'removeFromUnsentReqList']);
$router->get('/requisitions/new/form/edit/$requisition_id', [RequisitionController::class, 'editFromUnsentReqList']);
$router->get('/requisitions/new/form/clear-list', [RequisitionController::class, 'clearUnsentReqList']);
// approve requisitions
$router->get('/requisitions/a/pending-requisitions', [RequisitionController::class, 'renderPendingRequisitionList']);
$router->get('/requisitions/auth/pending-requisitions', [RequisitionController::class, 'renderPendingRequisitionList']);
$router->get('/requisitions/', [RequisitionController::class, '']);

$router->get('/testing', [TestingController::class, 'sayIt']);
// error 404
$router->any('/404', function () {
    // send the error 404 code
    http_response_code(404);
    // render a custom error 404 page
    if (is_auth()) {
        Facade::renderView('/error404.php', ['route' => Facade::getRoute()]);
    } else {
        Facade::renderView('/general_error404.php');
    }
    return;
});
