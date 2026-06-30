<?php

namespace App\Http\Controllers;

use App\Support\Database;

class ServiceController extends Controller
{
    public function index(): string
    {
        return $this->view('services.index', [
            'services' => Database::getServices()
        ]);
    }

    public function show(string $slug): string
    {
        $service = Database::getService($slug);

        if (!$service) {
            http_response_code(404);
            return 'Layanan tidak ditemukan';
        }

        return $this->view('services.show', [
            'service' => $service
        ]);
    }

    public function apply(string $slug): string
    {
        session_start();

        if (empty($_SESSION['logged_in'])) {
            $redirect = '/services/' . urlencode($slug) . '/apply';
            header('Location: /login?redirect=' . urlencode($redirect));
            exit;
        }

        $service = Database::getService($slug);
        if (!$service) {
            http_response_code(404);
            return 'Layanan tidak ditemukan';
        }

        $submitted = false;
        $submittedData = [];
        $submissionId = null;
        $errorMessage = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $submittedData = [
                'nama' => trim($_POST['nama'] ?? ''),
                'nik' => trim($_POST['nik'] ?? ''),
                'hp' => trim($_POST['hp'] ?? ''),
                'alamat' => trim($_POST['alamat'] ?? ''),
                'keterangan' => trim($_POST['keterangan'] ?? ''),
            ];

            try {
                $submissionId = Database::saveApplication(
                    $slug,
                    $service['name'],
                    $submittedData,
                    $_SESSION['user'] ?? null
                );
                $submitted = true;
            } catch (\Throwable $e) {
                $errorMessage = 'Maaf, pengajuan tidak bisa disimpan saat ini.';
            }
        }

        return $this->view('services.apply', [
            'service' => $service,
            'submitted' => $submitted,
            'submittedData' => $submittedData,
            'submissionId' => $submissionId,
            'errorMessage' => $errorMessage,
            'authUser' => $_SESSION['user'] ?? null,
        ]);
    }
}