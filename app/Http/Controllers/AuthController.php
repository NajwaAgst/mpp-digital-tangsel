<?php

namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function showLogin(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $redirect = $_GET['redirect'] ?? '/services';
        return $this->view('auth.login', ['authUser' => $_SESSION['user'] ?? null, 'redirect' => $redirect]);
    }

    public function showRegister(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $redirect = $_GET['redirect'] ?? '/services';
        return $this->view('auth.register', ['authUser' => $_SESSION['user'] ?? null, 'redirect' => $redirect]);
    }

    public function login(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $redirect = $_POST['redirect'] ?? '/services';

        if ($email !== '' && $password !== '') {
            $_SESSION['user'] = [
                'nik' => $_POST['nik'] ?? '3674011111110001',
                'name' => $_POST['name'] ?? 'Maya Salsabila',
                'email' => $email,
            ];
            $_SESSION['logged_in'] = true;
            header('Location: ' . $redirect);
            exit;
        }

        header('Location: /login?redirect=' . urlencode($redirect));
        exit;
    }

    public function register(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $nik = trim($_POST['nik'] ?? '');
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $redirect = $_POST['redirect'] ?? '/services';

        if ($nik !== '' && $name !== '' && $email !== '' && $password !== '') {
            $_SESSION['user'] = [
                'nik' => $nik,
                'name' => $name,
                'email' => $email,
            ];
            $_SESSION['logged_in'] = true;
            header('Location: ' . $redirect);
            exit;
        }

        header('Location: /register?redirect=' . urlencode($redirect));
        exit;
    }

    public function logout(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /');
        exit;
    }

    public function me(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return json_encode(['logged_in' => !empty($_SESSION['logged_in']), 'user' => $_SESSION['user'] ?? null]);
    }
}
