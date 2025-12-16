<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Association;
use App\Models\Member;

class AssociationAdminController extends Controller
{
    public function __construct(private Auth $auth, private Association $associationModel, private Member $memberModel, private array $config)
    {
    }

    public function dashboard(): void
    {
        $user = $this->auth->user();
        if (!$user || $user['user_type'] !== 'association_admin') {
            $this->redirect('/login');
        }

        $association = $this->associationModel->findByAdminUser((int) $user['id']);
        if (!$association) {
            http_response_code(403);
            echo 'Association not found for admin';
            return;
        }

        $data = [
            'association' => $association,
            'memberCount' => $this->memberModel->countByAssociation((int) $association['id']),
            'config' => $this->config,
            'user' => $user
        ];

        $this->view('dashboard/association_admin', $data);
    }
}
