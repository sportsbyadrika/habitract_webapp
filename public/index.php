<?php

use App\Controllers\AssociationAdminController;
use App\Controllers\AuthController;
use App\Controllers\MemberController;
use App\Controllers\SuperAdminController;
use App\Core\Auth;
use App\Core\Database;
use App\Core\Router;
use App\Core\Security;
use App\Models\Association;
use App\Models\Member;
use App\Models\User;

require_once __DIR__ . '/../app/autoload.php';

$config = require __DIR__ . '/../config/config.php';

Security::startSession($config['security']['session_name']);

$database = new Database($config['db']);
$connection = $database->getConnection();

$userModel = new User($connection);
$associationModel = new Association($connection);
$memberModel = new Member($connection);

$auth = new Auth($userModel, $memberModel, $associationModel, $config);

$router = new Router();

$authController = new AuthController($auth, $userModel, $config);
$superAdminController = new SuperAdminController($auth, $associationModel, $userModel, $config);
$associationAdminController = new AssociationAdminController($auth, $associationModel, $memberModel, $config);
$memberController = new MemberController($auth, $config);

$router->get('/', fn() => $authController->showLogin());
$router->get('/login', fn() => $authController->showLogin());
$router->post('/login', fn() => $authController->login());
$router->get('/logout', fn() => $authController->logout());
$router->get('/super-admin/register', fn() => $authController->showRegister());
$router->post('/super-admin/register', fn() => $authController->register());

$router->get('/super-admin/dashboard', fn() => $superAdminController->dashboard());
$router->get('/association-admin/dashboard', fn() => $associationAdminController->dashboard());
$router->get('/member/dashboard', fn() => $memberController->dashboard());

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($uri, $_SERVER['REQUEST_METHOD']);
