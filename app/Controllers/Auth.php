<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function register()
    {
        return view('auth/register');
    }

    public function registerSubmit()
    {
        // Set JSON response header
        $this->response->setHeader('Content-Type', 'application/json');
        
        $userModel = new UserModel();
        
        // Get JSON input from AngularJS
        $json = $this->request->getJSON();
        $username = $json->username ?? null;
        $password = $json->password ?? null;
        
        // Validate input
        if (empty($username) || empty($password)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Username and password are required'
            ]);
        }
        
        // Check if username already exists
        if ($userModel->getUserByUsername($username)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Username already exists'
            ]);
        }
        
        // Hash password and save user
        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        if ($userModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Registration successful'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Registration failed'
            ]);
        }
    }

    public function login()
    {
        return view('auth/login');
    }

    public function loginSubmit()
    {
        // Set JSON response header
        $this->response->setHeader('Content-Type', 'application/json');
        
        $userModel = new UserModel();
        
        // Get JSON input from AngularJS
        $json = $this->request->getJSON();
        $username = $json->username ?? null;
        $password = $json->password ?? null;
        
        // Validate input
        if (empty($username) || empty($password)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Username and password are required'
            ]);
        }
        
        $user = $userModel->getUserByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $session = session();
            $session->set([
                'user_id' => $user['id'],
                'username' => $user['username'],
                'logged_in' => true
            ]);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Login successful'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid username or password'
            ]);
        }
    }

    public function logout()
    {
        $session = session();
        $session->remove(['user_id', 'username', 'logged_in']);
        $session->destroy();
        return redirect()->to('auth/login')->with('message', 'You have been logged out successfully');
    }
}
