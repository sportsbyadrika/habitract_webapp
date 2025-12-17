<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;

class MemberController extends Controller
{
    public function __construct(private Auth $auth, private array $config)
    {
    }

    public function dashboard(): void
    {
        $user = $this->auth->user();
        if (!$user || $user['user_type'] !== 'member') {
            $this->redirect('/login');
        }

        $member = $this->auth->memberProfile();

        $this->view('dashboard/member', [
            'member' => $member,
            'config' => $this->config,
            'user' => $user
        ]);
    }
}
