<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;

class AuthController extends Controller
{
    /**
     * ===================================================
     * LOGIN MPP
     * ===================================================
     */
    public function showLogin(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $this->view('auth.login', [
            'redirect' => $_GET['redirect'] ?? '/services',
            'authUser' => $_SESSION['user'] ?? null
        ]);
    }

    /**
     * ===================================================
     * REGISTER MPP
     * ===================================================
     */
    public function showRegister(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $this->view('auth.register', [
            'redirect' => $_GET['redirect'] ?? '/services',
            'authUser' => $_SESSION['user'] ?? null
        ]);
    }

    /**
     * ===================================================
     * LOGIN EMERGENCY
     * ===================================================
     */
    public function showEmergencyLogin(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $this->view('auth.login_emergency', [
            'redirect' => $_GET['redirect'] ?? '/emergency/report',
            'authUser' => $_SESSION['user'] ?? null
        ]);
    }

    /**
     * ===================================================
     * REGISTER EMERGENCY
     * ===================================================
     */
    public function showEmergencyRegister(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $this->view('auth.register_emergency', [
            'redirect' => $_GET['redirect'] ?? '/emergency/report',
            'authUser' => $_SESSION['user'] ?? null
        ]);
    }

    /**
     * ===================================================
     * REGISTER (SSO)
     * ===================================================
     */
    public function register(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $nik       = trim($_POST['nik'] ?? '');
        $name      = trim($_POST['name'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';
        $redirect  = $_POST['redirect'] ?? '/services';

        $isEmergency = str_starts_with($redirect, '/emergency');

        $registerPage = $isEmergency
            ? '/emergency/register'
            : '/register';

        if (
            $nik === '' ||
            $name === '' ||
            $email === '' ||
            $password === ''
        ) {

            header(
                "Location: {$registerPage}?redirect=" .
                urlencode($redirect) .
                "&error=" .
                urlencode("Semua field wajib diisi.")
            );
            exit;
        }

        if (UserRepository::nikExists($nik)) {

            header(
                "Location: {$registerPage}?redirect=" .
                urlencode($redirect) .
                "&error=" .
                urlencode("NIK sudah terdaftar.")
            );
            exit;
        }

        if (UserRepository::emailExists($email)) {

            header(
                "Location: {$registerPage}?redirect=" .
                urlencode($redirect) .
                "&error=" .
                urlencode("Email sudah terdaftar.")
            );
            exit;
        }

        UserRepository::create([
            'nik'      => $nik,
            'name'     => $name,
            'email'    => $email,
            'password' => $password
        ]);

        $user = UserRepository::findByEmail($email);

        $_SESSION['logged_in'] = true;

        $_SESSION['user'] = [
            'id'    => $user['id'] ?? null,
            'nik'   => $user['nik'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'] ?? 'user'
        ];

        $_SESSION['welcome_popup'] = true;

        if (($user['role'] ?? 'user') === 'admin') {
            header("Location: /admin/dashboard");
        } else {
            header("Location: " . $redirect);
        }

        exit;
    }

    /**
     * ===================================================
     * LOGIN (SSO)
     * ===================================================
     */
    public function login(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';
        $redirect  = $_POST['redirect'] ?? '/services';

        $isEmergency = str_starts_with($redirect, '/emergency');

        $loginPage = $isEmergency
            ? '/emergency/login'
            : '/login';

        if ($email === '' || $password === '') {

            header(
                "Location: {$loginPage}?redirect=" .
                urlencode($redirect) .
                "&error=" .
                urlencode("Email dan Password wajib diisi.")
            );
            exit;
        }

        $user = UserRepository::findByEmail($email);

        if (!$user) {

            header(
                "Location: {$loginPage}?redirect=" .
                urlencode($redirect) .
                "&error=" .
                urlencode("Email tidak ditemukan.")
            );
            exit;
        }

        if (!password_verify($password, $user['password'])) {

            header(
                "Location: {$loginPage}?redirect=" .
                urlencode($redirect) .
                "&error=" .
                urlencode("Password salah.")
            );
            exit;
        }

        $_SESSION['logged_in'] = true;

        $_SESSION['user'] = [
            'id'    => $user['id'] ?? null,
            'nik'   => $user['nik'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'] ?? 'user'
        ];

        $_SESSION['welcome_popup'] = true;

        if (($user['role'] ?? 'user') === 'admin') {
            header("Location: /admin/dashboard");
        } else {
            header("Location: " . $redirect);
        }

        exit;
    }

    /**
     * ===================================================
     * LOGOUT
     * ===================================================
     */
    public function logout(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        session_destroy();

        header("Location: /");

        exit;
    }

    /**
     * ===================================================
     * CURRENT USER
     * ===================================================
     */
    public function me(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header("Content-Type: application/json");

        return json_encode([
            'logged_in' => !empty($_SESSION['logged_in']),
            'user'      => $_SESSION['user'] ?? null
        ]);
    }
}