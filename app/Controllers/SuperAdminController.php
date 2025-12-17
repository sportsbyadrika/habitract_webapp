<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Association;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function __construct(private Auth $auth, private Association $associationModel, private User $userModel, private array $config)
    {
    }

    public function dashboard(): void
    {
        $user = $this->auth->user();
        if (!$user || $user['user_type'] !== 'super_admin') {
            $this->redirect('/login');
        }

        $data = [
            'totalAssociations' => $this->associationModel->count(),
            'activeAssociations' => $this->associationModel->countByStatus(true),
            'inactiveAssociations' => $this->associationModel->countByStatus(false),
            'totalAdmins' => $this->userModel->getAssociationAdminsCount(),
            'config' => $this->config,
            'user' => $user
        ];

        $this->view('dashboard/super_admin', $data);
    }
}
