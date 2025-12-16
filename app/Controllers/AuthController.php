<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Security;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct(private Auth $auth, private User $userModel, private array $config)
    {
    }

    public function showLogin(): void
    {
        $csrfToken = Security::generateCsrfToken($this->config['security']['csrf_token_name']);
        $this->view('auth/login', ['csrfToken' => $csrfToken, 'config' => $this->config]);
    }

    public function login(): void
    {
        $tokenName = $this->config['security']['csrf_token_name'];
        if (!Security::validateCsrfToken($tokenName, $_POST[$tokenName] ?? null)) {
            http_response_code(400);
            echo 'Invalid CSRF token';
            return;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($this->auth->attemptLogin($username, $password)) {
            $userType = $_SESSION['user_type'];
            if ($userType === 'super_admin') {
                $this->redirect('/super-admin/dashboard');
            } elseif ($userType === 'association_admin') {
                $this->redirect('/association-admin/dashboard');
            } else {
                $this->redirect('/member/dashboard');
            }
        } else {
            $csrfToken = Security::generateCsrfToken($tokenName);
            $this->view('auth/login', [
                'csrfToken' => $csrfToken,
                'error' => 'Invalid credentials or inactive account',
                'config' => $this->config
            ]);
        }
    }

    public function logout(): void
    {
        $this->auth->logout();
        $this->redirect('/login');
    }

    public function showRegister(): void
    {
        $user = $this->auth->user();
        if (!$user || $user['user_type'] !== 'super_admin') {
            $this->redirect('/login');
        }

        $csrfToken = Security::generateCsrfToken($this->config['security']['csrf_token_name']);
        $this->view('auth/register', ['csrfToken' => $csrfToken, 'config' => $this->config, 'user' => $user]);
    }

    public function register(): void
    {
        $user = $this->auth->user();
        if (!$user || $user['user_type'] !== 'super_admin') {
            $this->redirect('/login');
        }

        $tokenName = $this->config['security']['csrf_token_name'];
        if (!Security::validateCsrfToken($tokenName, $_POST[$tokenName] ?? null)) {
            http_response_code(400);
            echo 'Invalid CSRF token';
            return;
        }

        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'user_type' => $_POST['user_type'] ?? 'member',
            'password_hash' => password_hash($_POST['password'] ?? '', PASSWORD_ARGON2ID),
            'is_active' => true,
        ];

        $this->userModel->create($data);

        $csrfToken = Security::generateCsrfToken($tokenName);
        $this->view('auth/register', [
            'csrfToken' => $csrfToken,
            'config' => $this->config,
            'user' => $user,
            'success' => 'User created successfully.',
        ]);
    }
}
