<?php
session_start();

spl_autoload_register(function ($class) {
    foreach (['Controllers', 'Models', 'Core'] as $dir) {
        $path = __DIR__ . "/../app/$dir/$class.php";
        if (file_exists($path)) require $path;
    }
});

$router = new Router();

// AUTH
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

// SUPER ADMIN
$router->get('/super-admin/dashboard', [SuperAdminController::class, 'dashboard']);
// ASSOCIATIONS (Super Admin)
$router->get('/super-admin/associations', [SuperAdminAssociationController::class, 'index']);
$router->get('/super-admin/associations/create', [SuperAdminAssociationController::class, 'create']);
$router->post('/super-admin/associations/store', [SuperAdminAssociationController::class, 'store']);
$router->get('/super-admin/associations/edit', [SuperAdminAssociationController::class, 'edit']);
$router->post('/super-admin/associations/update', [SuperAdminAssociationController::class, 'update']);
$router->post('/super-admin/associations/deactivate', [SuperAdminAssociationController::class, 'deactivate']);
$router->post('/super-admin/associations/suspend',    [SuperAdminAssociationController::class, 'suspend']);
$router->post('/super-admin/associations/activate',   [SuperAdminAssociationController::class, 'activate']);
$router->get('/super-admin/districts/by-state', [SuperAdminAssociationController::class, 'districtsByState']);
$router->get('/super-admin/association-admins', [SuperAdminAssociationAdminController::class, 'index']);
$router->post('/super-admin/association-admins/store', [SuperAdminAssociationAdminController::class, 'store']);
$router->post('/super-admin/association-admins/toggle',[SuperAdminAssociationAdminController::class, 'toggle']);
$router->get('/super-admin/association-admins',[SuperAdminAssociationAdminController::class, 'index']);

$router->dispatch();