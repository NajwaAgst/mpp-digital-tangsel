<?php

namespace App\Http\Controllers;

use App\Repositories\EmergencyRepository;

class EmergencyController extends Controller
{
    /**
     * ==========================================
     * Landing Emergency
     * ==========================================
     */
    public function index(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $this->view('emergency.index', [
            'authUser' => $_SESSION['user'] ?? null
        ]);
    }

    /**
     * ==========================================
     * Form Laporan
     * ==========================================
     */
    public function report(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['logged_in'])) {
            header("Location: /emergency/login?redirect=/emergency/report");
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [

                'nama'            => trim($_POST['nama'] ?? ''),
                'nik'             => trim($_POST['nik'] ?? ''),
                'phone'           => trim($_POST['phone'] ?? ''),
                'alamat'          => trim($_POST['alamat'] ?? ''),
                'emergency_type'  => trim($_POST['emergency_type'] ?? ''),
                'location'        => trim($_POST['location'] ?? ''),
                'description'     => trim($_POST['description'] ?? ''),
                'latitude'        => trim($_POST['latitude'] ?? ''),
                'longitude'       => trim($_POST['longitude'] ?? ''),

            ];

            /*
            |----------------------------------
            | VALIDASI
            |----------------------------------
            */

            if ($data['nama'] == '') {
                $errors[] = "Nama wajib diisi.";
            }

            if ($data['nik'] == '') {
                $errors[] = "NIK wajib diisi.";
            }

            if ($data['phone'] == '') {
                $errors[] = "Nomor HP wajib diisi.";
            }

            if ($data['alamat'] == '') {
                $errors[] = "Alamat wajib diisi.";
            }

            if ($data['emergency_type'] == '') {
                $errors[] = "Kategori emergency wajib dipilih.";
            }

            if ($data['location'] == '') {
                $errors[] = "Lokasi kejadian wajib diisi.";
            }

            if ($data['description'] == '') {
                $errors[] = "Deskripsi kejadian wajib diisi.";
            }

            /*
            |----------------------------------
            | SIMPAN
            |----------------------------------
            */

            if (empty($errors)) {

                try {

                    $id = EmergencyRepository::create($data);

                    header("Location: /emergency/success/" . $id);
                    exit;

                } catch (\Throwable $e) {

                    $errors[] = $e->getMessage();

                }

            }

        }

        return $this->view('emergency.report', [

            'errors' => $errors,
            'categories' => EmergencyRepository::categories(),
            'authUser' => $_SESSION['user'] ?? null

        ]);
    }

    /**
     * ==========================================
     * Success
     * ==========================================
     */
    public function success(int $id): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $report = EmergencyRepository::find($id);

        if (!$report) {
            http_response_code(404);
            return "Laporan tidak ditemukan.";
        }

        return $this->view('emergency.success', [
            'report' => $report,
            'authUser' => $_SESSION['user'] ?? null
        ]);
    }

    public function history(): string
{
    if(session_status()===PHP_SESSION_NONE){
        session_start();
    }

    if(empty($_SESSION["logged_in"])){
        header("Location:/emergency/login");
        exit;
    }

    $nik=$_SESSION["user"]["nik"];

    return $this->view("emergency.history",[

        "reports"=>EmergencyRepository::getByNik($nik),

        "authUser"=>$_SESSION["user"]

    ]);
}

public function detail(int $id): string
{
    if(session_status()===PHP_SESSION_NONE){
        session_start();
    }

    if(empty($_SESSION["logged_in"])){
        header("Location:/emergency/login");
        exit;
    }

    $report=EmergencyRepository::getById($id);

    if(!$report){
        http_response_code(404);
        return "Data tidak ditemukan";
    }

    return $this->view("emergency.detail",[

        "report"=>$report,

        "authUser"=>$_SESSION["user"]

    ]);
}

    /**
     * ==========================================
     * API
     * ==========================================
     */
    public function api(): string
    {
        header("Content-Type: application/json");

        return json_encode(
            EmergencyRepository::all(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }
}