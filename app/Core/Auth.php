<?php

namespace App\Core;

use App\Models\User;
use App\Models\Member;
use App\Models\Association;

class Auth
{
    public function __construct(
        private User $userModel,
        private Member $memberModel,
        private Association $associationModel,
        private array $config
    ) {
    }

    public function attemptLogin(string $username, string $password): bool
    {
        $user = $this->userModel->findByUsername($username);

        if (!$user || !password_verify($password, $user['password_hash']) || !(bool) $user['is_active']) {
            return false;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_type'] = $user['user_type'];

        return true;
    }

    public function logout(): void
    {
        session_unset();
        session_destroy();
    }

    public function user(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $user = $this->userModel->findById((int) $_SESSION['user_id']);

        if ($user && $user['user_type'] === 'association_admin') {
            $association = $this->associationModel->findByAdminUser((int) $user['id']);
            if ($association) {
                $user['association_id'] = $association['id'];
            }
        }

        return $user;
    }

    public function memberProfile(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        return $this->memberModel->findByUser((int) $_SESSION['user_id']);
    }
}
