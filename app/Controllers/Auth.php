<?php

namespace App\Controllers;

use App\Models\AuthModel;

class Auth extends BaseController
{
    public function index(): string
    {
        return view('auth/index');
    }

    public function processLogin()
    {

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $authModel = new AuthModel();

        $user = $authModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            return redirect()->to(base_url('dashboard'));
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
    }

    public function testdb()
    {
        $db = db_connect();
        $query = $db->query('SELECT * FROM users');
        $result = $query->getResult();
        foreach ($result as $row) {
            echo 'ID: ' . $row->id . '<br>';
            echo 'Name: ' . $row->email . '<br>';
            echo '<br>';
        }
    }
}
