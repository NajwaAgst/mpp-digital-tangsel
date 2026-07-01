<?php

namespace App\Http\Controllers;

use App\Support\Database;

class ServiceController extends Controller
{
    /**
     * Daftar layanan
     */
    public function index(): string
    {
        return $this->view('services.index', [
            'services' => Database::getServices()
        ]);
    }

    /**
     * Detail layanan
     */
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

    /**
     * Form Pengajuan
     */
    public function apply(string $slug): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        /*
        |--------------------------------------------------------------------------
        | Login Check
        |--------------------------------------------------------------------------
        */
        if (empty($_SESSION['logged_in'])) {

            $redirect = '/services/' . urlencode($slug) . '/apply';

            header('Location: /login?redirect=' . urlencode($redirect));

            exit;
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Data Layanan
        |--------------------------------------------------------------------------
        */

        $service = Database::getService($slug);

        if (!$service) {

            http_response_code(404);

            return 'Layanan tidak ditemukan';
        }

        /*
        |--------------------------------------------------------------------------
        | Default Variable
        |--------------------------------------------------------------------------
        */

        $submitted = false;
        $submittedData = [];
        $submissionId = null;
        $errorMessage = null;

        /*
        |--------------------------------------------------------------------------
        | Submit Form
        |--------------------------------------------------------------------------
        */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $submittedData = [

                'nama'       => trim($_POST['nama'] ?? ''),

                'nik'        => trim($_POST['nik'] ?? ''),

                'hp'         => trim($_POST['hp'] ?? ''),

                'alamat'     => trim($_POST['alamat'] ?? ''),

                'keterangan' => trim($_POST['keterangan'] ?? ''),

            ];

            /*
            |--------------------------------------------------------------------------
            | Validasi
            |--------------------------------------------------------------------------
            */

            if ($submittedData['nik'] === '') {

                $errorMessage = 'NIK wajib diisi.';
            }

            elseif ($submittedData['nama'] === '') {

                $errorMessage = 'Nama belum terisi dari sistem interoperabilitas.';
            }

            elseif ($submittedData['alamat'] === '') {

                $errorMessage = 'Alamat belum berhasil diambil.';
            }

            elseif ($submittedData['hp'] === '') {

                $errorMessage = 'Nomor HP wajib diisi.';
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan Pengajuan
            |--------------------------------------------------------------------------
            */

            if ($errorMessage === null) {

                try {

                    $submissionId = Database::saveApplication(

                        $slug,

                        $service['name'],

                        $submittedData,

                        $_SESSION['user'] ?? null

                    );

                    $submitted = true;

                    $submittedData = [];

                } catch (\Throwable $e) {

                    $errorMessage = 'Maaf, pengajuan tidak dapat diproses saat ini.';

                }

            }

        }

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return $this->view('services.apply', [

            'service'       => $service,

            'submitted'     => $submitted,

            'submittedData' => $submittedData,

            'submissionId'  => $submissionId,

            'errorMessage'  => $errorMessage,

            'authUser'      => $_SESSION['user'] ?? null,

        ]);
    }
}