<?php

namespace App\Http\Controllers;

use App\Support\Database;

class ApiController extends Controller
{
    public function citizen(): string
    {
        header('Content-Type: application/json');

        $nik = $_GET['nik'] ?? '';

        if ($nik === '') {
            http_response_code(400);

            return json_encode([
                'success' => false,
                'message' => 'NIK wajib diisi'
            ]);
        }

        $data = Database::getCitizenByNik($nik);

        if (!$data) {
            http_response_code(404);

            return json_encode([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return json_encode([
            'success' => true,
            'data' => $data
        ]);
    }
}