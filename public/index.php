<?php
ob_start();
session_start();
$config = require __DIR__ . '/../config/config.php';
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/Controllers/',
        __DIR__ . '/../app/Controllers/association/',
         __DIR__ . '/../app/Models/',
        __DIR__ . '/../app/Core/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});


$router = new Router();

/* AUTH */
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);

$router->get('/register', [AuthController::class, 'registerForm']);
$router->post('/register', [AuthController::class, 'register']);

$router->get('/verify-otp', [AuthController::class, 'verifyOtpForm']);
$router->post('/verify-otp', [AuthController::class, 'verifyOtp']);

$router->get('/set-password', [AuthController::class, 'setPasswordForm']);
$router->post('/set-password', [AuthController::class, 'setPassword']);

$router->get('/forgot-password', [AuthController::class, 'forgotPasswordForm']);
$router->post('/forgot-password', [AuthController::class, 'sendForgotOtp']);

$router->get('/forgot-verify-otp', [AuthController::class, 'forgotVerifyOtpForm']);
$router->post('/forgot-verify-otp', [AuthController::class, 'forgotVerifyOtp']);

$router->get('/forgot-set-password', [AuthController::class, 'forgotSetPasswordForm']);
$router->post('/forgot-set-password', [AuthController::class, 'forgotSetPassword']);


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
$router->get('/association/dashboard',[AssociationDashboardController::class, 'index']);
$router->get('/association/members',[MembersController::class, 'index']);
$router->get('/association/members/create',[MembersController::class, 'create']);
$router->post('/association/members/store',[MembersController::class, 'store']);
$router->get('/association/members/edit', [MembersController::class, 'edit']);
$router->post('/association/members/update', [MembersController::class, 'update']);
$router->post('/association/members/deactivate', [MembersController::class, 'deactivate']);
$router->get('/association/settings/member-categories',[MemberCategoriesController::class, 'index']);
$router->get('/association/settings/member-categories/create',[MemberCategoriesController::class, 'create']);
$router->post('/association/settings/member-categories/store',[MemberCategoriesController::class, 'store']);
$router->post('/association/settings/member-categories',[MemberCategoriesController::class, 'toggleAjax']);
$router->get('/association/settings/fee-heads',[FeeHeadsController::class, 'index']);
$router->get('/association/settings/fee-heads/create',[FeeHeadsController::class, 'create']);
$router->post('/association/settings/fee-heads/store',[FeeHeadsController::class, 'store']);
$router->get('/association/settings/fee-heads/toggle/(\d+)', [FeeHeadsController::class, 'toggleStatus']);
$router->get('/association/settings/category-fee-mapping',[CategoryFeeHeadsController::class, 'index']);
$router->post('/association/settings/category-fee-mapping/store',[CategoryFeeHeadsController::class, 'store']);
$router->post('/association/settings/category-fee-mapping/save',[CategoryFeeHeadsController::class, 'save']);
$router->get('/association/settings/category-fee-heads/edit/(\d+)',[CategoryFeeHeadsController::class, 'edit']);
$router->post('/association/settings/category-fee-heads/update',[CategoryFeeHeadsController::class, 'update']);
$router->get('/association/bills', [BillsController::class, 'index']);
$router->get('/association/bills/generate', [BillsController::class, 'generate']);
$router->post('/association/bills/generate', [BillsController::class, 'generate']);
$router->get('/association/bills/view', [BillsController::class, 'show']);

$router->dispatch();