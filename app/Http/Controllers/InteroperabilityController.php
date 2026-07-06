<?php

namespace App\Http\Controllers;

use App\Support\Database;

class InteroperabilityController extends Controller
{
    /**
     * Masking NIK
     * Contoh:
     * 3674011201010001
     * menjadi
     * 367401******0001
     */
    private function maskNik(?string $nik): ?string
    {
        if (!$nik || strlen($nik) < 16) {
            return $nik;
        }

        return substr($nik, 0, 6)
            . str_repeat('*', 6)
            . substr($nik, -4);
    }

    /**
     * Halaman Interoperability
     */
    public function index(): string
    {
        return $this->view('interoperability.index');
    }

    /**
     * API Dukcapil
     */
    public function dukcapil(string $nik): string
    {
        header('Content-Type: application/json');

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT
                nik,
                nama,
                tempat_lahir,
                tanggal_lahir,
                alamat
            FROM penduduks
            WHERE nik = ?
            LIMIT 1
        ");

        $stmt->execute([$nik]);

        $penduduk = $stmt->fetch();

        usleep(400000);

        if (!$penduduk) {

            http_response_code(404);

            return json_encode([
                "success" => false,
                "message" => "Data penduduk tidak ditemukan",
                "response_time_ms" => 400
            ]);
        }

        // Masking NIK
        $penduduk['nik'] = $this->maskNik($penduduk['nik']);

        return json_encode([
            "success" => true,
            "response_time_ms" => 400,
            "data" => $penduduk
        ]);
    }

    /**
     * API NPWP
     */
    public function npwp(string $nik): string
    {
        header('Content-Type: application/json');

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT
                npwp,
                status_npwp
            FROM npwps
            WHERE nik = ?
            LIMIT 1
        ");

        $stmt->execute([$nik]);

        $npwp = $stmt->fetch();

        usleep(700000);

        if (!$npwp) {

            http_response_code(404);

            return json_encode([
                "success" => false,
                "message" => "NPWP tidak ditemukan",
                "response_time_ms" => 700
            ]);
        }

        return json_encode([
            "success" => true,
            "response_time_ms" => 700,
            "data" => $npwp
        ]);
    }

    /**
     * API NIB
     */
    public function nib(string $nik): string
    {
        header('Content-Type: application/json');

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT
                nib,
                nama_usaha,
                jenis_usaha
            FROM nibs
            WHERE nik = ?
            LIMIT 1
        ");

        $stmt->execute([$nik]);

        $nib = $stmt->fetch();

        usleep(900000);

        if (!$nib) {

            http_response_code(404);

            return json_encode([
                "success" => false,
                "message" => "NIB tidak ditemukan",
                "response_time_ms" => 900
            ]);
        }

        return json_encode([
            "success" => true,
            "response_time_ms" => 900,
            "data" => $nib
        ]);
    }

    /**
     * Aggregator Interoperability
     */
    public function aggregate(string $nik): string
    {
        header('Content-Type: application/json');

        $pdo = Database::getConnection();

        // ==========================
        // DUKCAPIL
        // ==========================
        $stmt = $pdo->prepare("
            SELECT
                nik,
                nama,
                tempat_lahir,
                tanggal_lahir,
                alamat
            FROM penduduks
            WHERE nik = ?
            LIMIT 1
        ");

        $stmt->execute([$nik]);

        $dukcapil = $stmt->fetch();

        if ($dukcapil) {
            $dukcapil['nik'] = $this->maskNik($dukcapil['nik']);
        }

        // ==========================
        // NPWP
        // ==========================
        $stmt = $pdo->prepare("
            SELECT
                npwp,
                status_npwp
            FROM npwps
            WHERE nik = ?
            LIMIT 1
        ");

        $stmt->execute([$nik]);

        $npwp = $stmt->fetch();

        // ==========================
        // NIB
        // ==========================
        $stmt = $pdo->prepare("
            SELECT
                nib,
                nama_usaha,
                jenis_usaha
            FROM nibs
            WHERE nik = ?
            LIMIT 1
        ");

        $stmt->execute([$nik]);

        $nib = $stmt->fetch();

        usleep(1200000);

        return json_encode([
            "success" => true,
            "response_time_ms" => 1200,
            "data" => [
                "dukcapil" => $dukcapil,
                "npwp" => $npwp,
                "nib" => $nib
            ]
        ]);
    }

    /**
     * API Citizen Data
     */
    public function getCitizenData(string $nik): string
    {
        return $this->aggregate($nik);
    }

    /**
     * API Penduduk
     */
    public function penduduk(string $nik): string
    {
        return $this->dukcapil($nik);
    }
}