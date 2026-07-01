<?php

namespace App\Http\Controllers;

use App\Support\Database;

class AuthController extends Controller
{
    public function showLogin(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $redirect = $_GET['redirect'] ?? '/services';

        return $this->view('auth.login', [
            'authUser' => $_SESSION['user'] ?? null,
            'redirect' => $redirect
        ]);
    }

    public function showRegister(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $redirect = $_GET['redirect'] ?? '/services';

        return $this->view('auth.register', [
            'authUser' => $_SESSION['user'] ?? null,
            'redirect' => $redirect
        ]);
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

        if (
            $nik === '' ||
            $name === '' ||
            $email === '' ||
            $password === ''
        ) {
            header('Location: /register?redirect=' . urlencode($redirect) . '&error=' . urlencode('Semua field wajib diisi.'));
            exit;
        }

        if (Database::nikExists($nik)) {
            header('Location: /register?redirect=' . urlencode($redirect) . '&error=' . urlencode('NIK sudah terdaftar.'));
            exit;
        }

        if (Database::emailExists($email)) {
            header('Location: /register?redirect=' . urlencode($redirect) . '&error=' . urlencode('Email sudah terdaftar.'));
            exit;
        }

        Database::registerUser([
            'nik' => $nik,
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        $_SESSION['user'] = [
            'nik' => $nik,
            'name' => $name,
            'email' => $email
        ];

        $_SESSION['logged_in'] = true;

        header('Location: ' . $redirect);
        exit;
    }

    public function login(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $redirect = $_POST['redirect'] ?? '/services';

        if ($email === '' || $password === '') {
            header('Location: /login?redirect=' . urlencode($redirect) . '&error=' . urlencode('Email dan password wajib diisi.'));
            exit;
        }

        $user = Database::findUserByEmail($email);

        if (!$user) {
            header('Location: /login?redirect=' . urlencode($redirect) . '&error=' . urlencode('Email tidak ditemukan.'));
            exit;
        }

        if (!password_verify($password, $user['password'])) {
            header('Location: /login?redirect=' . urlencode($redirect) . '&error=' . urlencode('Password salah.'));
            exit;
        }

        $_SESSION['user'] = [
            'nik' => $user['nik'],
            'name' => $user['name'],
            'email' => $user['email']
        ];

        $_SESSION['logged_in'] = true;

        header('Location: ' . $redirect);
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

        return json_encode([
            'logged_in' => !empty($_SESSION['logged_in']),
            'user' => $_SESSION['user'] ?? null
        ]);
    }
}