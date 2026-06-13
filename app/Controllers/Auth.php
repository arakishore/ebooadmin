<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\AdminLoginLogModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('isAdminLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/login');
    }

    public function loginSubmit()
    {
        $email    = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        $adminModel = new AdminModel();
        $logModel   = new AdminLoginLogModel();

        $admin = $adminModel
            ->where('email', $email)
            ->first();

        $ipAddress = $this->request->getIPAddress();
        $userAgent = $this->request->getUserAgent()->getAgentString();
        $now       = date('Y-m-d H:i:s');

        if (!$admin) {
            $logModel->insert([
                'admin_id'       => null,
                'email'          => $email,
                'ip_address'     => $ipAddress,
                'user_agent'     => $userAgent,
                'login_status'   => 'failed',
                'failure_reason' => 'email_not_found',
                'logged_at'      => $now,
            ]);

            return redirect()->back()->with('error', 'Invalid email or password');
        }

        if ((int) $admin['status'] !== 1) {
            $logModel->insert([
                'admin_id'       => $admin['id'],
                'email'          => $email,
                'ip_address'     => $ipAddress,
                'user_agent'     => $userAgent,
                'login_status'   => 'failed',
                'failure_reason' => 'inactive_account',
                'logged_at'      => $now,
            ]);

            return redirect()->back()->with('error', 'Your account is inactive');
        }

        if (!password_verify($password, $admin['password'])) {
            $logModel->insert([
                'admin_id'       => $admin['id'],
                'email'          => $email,
                'ip_address'     => $ipAddress,
                'user_agent'     => $userAgent,
                'login_status'   => 'failed',
                'failure_reason' => 'invalid_password',
                'logged_at'      => $now,
            ]);

            return redirect()->back()->with('error', 'Invalid email or password');
        }

        session()->set([
            'admin_id'          => $admin['id'],
            'admin_role_id'     => $admin['role_id'],
            'admin_name'        => $admin['name'],
            'admin_email'       => $admin['email'],
            'isAdminLoggedIn'   => true,
        ]);

        $adminModel->update($admin['id'], [
            'last_login_at' => $now,
            'last_login_ip' => $ipAddress,
        ]);

        $logModel->insert([
            'admin_id'       => $admin['id'],
            'email'          => $email,
            'ip_address'     => $ipAddress,
            'user_agent'     => $userAgent,
            'login_status'   => 'success',
            'failure_reason' => null,
            'logged_at'      => $now,
        ]);

        return redirect()->to(base_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}