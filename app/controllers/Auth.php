<?php
class Auth extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->call->model('UserModel');
    }

    public function login()
    {
        if (!empty($_SESSION['user_id'])) {
            header('Location: /products');
            exit;
        }
        $this->call->view('auth/login');
    }

    public function authenticate()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->UserModel->findByUsername($username);

        // plain-text comparison, no hashing
        if ($user && $password === $user->password) {
            $_SESSION['user_id']  = $user->id;
            $_SESSION['username'] = $user->username;
            header('Location: /products');
            exit;
        } else {
            $data['error'] = 'Invalid username or password.';
            $this->call->view('auth/login', $data);
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }
}