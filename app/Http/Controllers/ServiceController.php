<?php

namespace App\Http\Controllers;

use App\Repositories\ApplicationRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\RatingRepository;
use App\Support\Database;
use PDO;

class ServiceController extends Controller
{
    /**
     * ==========================================
     * Daftar Layanan
     * ==========================================
     */
    public function index(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $this->view(
            'services.index',
            [
                'services' => ServiceRepository::all(),
                'authUser' => $_SESSION['user'] ?? null
            ]
        );
    }

    /**
     * ==========================================
     * Dashboard User
     * ==========================================
     */
    public function dashboard(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['logged_in'])) {
            header("Location:/login");
            exit;
        }

        $nik = $_SESSION['user']['nik'];

        $applications = ApplicationRepository::byNik($nik);

        foreach ($applications as &$app) {

            $app['rating'] = RatingRepository::findByApplication(
                $app['id']
            );
        }

        $stats = [
            'total' => count($applications),
            'pending' => 0,
            'processing' => 0,
            'done' => 0,
            'rejected' => 0
        ];

        foreach ($applications as $item) {

            switch ($item['status']) {

                case 'Pending':
                case 'Menunggu':
                    $stats['pending']++;
                    break;

                case 'Diproses':
                    $stats['processing']++;
                    break;

                case 'Approved':
                case 'Selesai':
                    $stats['done']++;
                    break;

                case 'Rejected':
                case 'Ditolak':
                    $stats['rejected']++;
                    break;
            }
        }

        return $this->view(
            'user.dashboard',
            [
                'applications' => $applications,
                'stats' => $stats,
                'authUser' => $_SESSION['user']
            ]
        );
    }

    /**
     * ==========================================
     * Detail Layanan
     * ==========================================
     */
    public function show(string $slug): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $service = ServiceRepository::find($slug);

        if (!$service) {

            http_response_code(404);

            return "Layanan tidak ditemukan.";
        }

        $service['form'] = $this->parseForm(
            $service['form'] ?? []
        );

        return $this->view(
            'services.show',
            [
                'service' => $service,
                'authUser' => $_SESSION['user'] ?? null
            ]
        );
    }

    /**
     * ==========================================
     * Form Pengajuan
     * ==========================================
     */
    public function apply(string $slug): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['logged_in'])) {

            $redirect = "/services/" . $slug . "/apply";

            header(
                "Location:/login?redirect=" .
                urlencode($redirect)
            );

            exit;
        }

        $service = ServiceRepository::find($slug);

        if (!$service) {

            http_response_code(404);

            return "Layanan tidak ditemukan.";
        }

        $service['form'] = $this->parseForm(
            $service['form'] ?? []
        );

        $submitted = false;
        $submittedData = [];
        $submissionId = null;
        $errorMessage = null;
                if ($_SERVER["REQUEST_METHOD"] === "POST") {

            foreach ($_POST as $key => $value) {

                $submittedData[$key] = is_string($value)
                    ? trim($value)
                    : $value;
            }

            /*
            |--------------------------------------------------------------------------
            | Ambil data user login
            |--------------------------------------------------------------------------
            */

            if (!empty($_SESSION["user"])) {

                $submittedData["nama"] =
                    $_SESSION["user"]["name"]
                    ?? $_SESSION["user"]["nama"]
                    ?? "";

                $submittedData["nik"] =
                    $_SESSION["user"]["nik"]
                    ?? "";

                if (empty($submittedData["hp"])) {

                    $submittedData["hp"] =
                        $_SESSION["user"]["phone"]
                        ?? $_SESSION["user"]["hp"]
                        ?? "";
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Validasi dasar
            |--------------------------------------------------------------------------
            */

            if (empty($submittedData["nik"])) {

                $errorMessage = "NIK akun tidak ditemukan.";

            } elseif (empty($submittedData["nama"])) {

                $errorMessage = "Nama akun tidak ditemukan.";

            } elseif (empty($submittedData["alamat"])) {

                $errorMessage = "Alamat wajib diisi.";
            }

            /*
            |--------------------------------------------------------------------------
            | Validasi Form Dinamis
            |--------------------------------------------------------------------------
            */

            if (
                $errorMessage === null &&
                !empty($service["form"]["manual"])
            ) {

                foreach ($service["form"]["manual"] as $field) {

                    if (empty($submittedData[$field])) {

                        $label = ucwords(
                            str_replace("_", " ", $field)
                        );

                        $errorMessage = $label . " wajib diisi.";

                        break;
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan Pengajuan
            |--------------------------------------------------------------------------
            */

            if ($errorMessage === null) {

                try {

                    $submissionId = ApplicationRepository::create(
                        $slug,
                        $service["name"],
                        $submittedData,
                        $_SESSION["user"]
                    );

                    $submitted = true;

                    $submittedData = [];

                } catch (\Throwable $e) {

                    $errorMessage = $e->getMessage();
                }
            }
        }

        return $this->view(
            "services.apply",
            [
                "service" => $service,
                "submitted" => $submitted,
                "submittedData" => $submittedData,
                "submissionId" => $submissionId,
                "errorMessage" => $errorMessage,
                "authUser" => $_SESSION["user"] ?? null
            ]
        );
    }

    /**
     * ==========================================
     * Riwayat Pengajuan
     * ==========================================
     */
    public function history(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION["logged_in"])) {
            header("Location:/login");
            exit;
        }

        $applications = ApplicationRepository::byNik(
            $_SESSION["user"]["nik"]
        );

        foreach ($applications as &$app) {

            $app["rating"] =
                RatingRepository::findByApplication(
                    $app["id"]
                );
        }

        return $this->view(
            "user.history",
            [
                "applications" => $applications,
                "authUser" => $_SESSION["user"]
            ]
        );
    }

    /**
     * ==========================================
     * Detail Riwayat
     * ==========================================
     */
    public function historyDetail(int $id): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION["logged_in"])) {
            header("Location:/login");
            exit;
        }

        $application = ApplicationRepository::findByUser(
            $id,
            $_SESSION["user"]["nik"]
        );

        if (!$application) {

            http_response_code(404);

            return "Pengajuan tidak ditemukan.";
        }

        return $this->view(
            "user.history-detail",
            [
                "application" => $application,
                "authUser" => $_SESSION["user"]
            ]
        );
    }
        /**
     * ==========================================
     * Download Dokumen
     * ==========================================
     */
    public function downloadPdf(int $id): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION["logged_in"])) {
        header("Location: /login");
        exit;
    }

    $pdo = Database::getConnection();

    $stmt = $pdo->prepare("
        SELECT *
        FROM applications
        WHERE id = ?
        AND nik = ?
        LIMIT 1
    ");

    $stmt->execute([
        $id,
        $_SESSION["user"]["nik"]
    ]);

    $application = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$application) {
        exit("Data tidak ditemukan.");
    }

    if (
        $application["status"] !== "Approved" &&
        $application["status"] !== "Selesai"
    ) {
        exit("Dokumen belum tersedia.");
    }

    /*
    |--------------------------------------------------------------------------
    | Tentukan template berdasarkan SERVICE SLUG
    |--------------------------------------------------------------------------
    */

    $slug = strtolower(trim($application["service_slug"]));

    switch ($slug) {

        case "adminduk":
            $template = "kk";
            break;

        case "perizinan-berusaha":
            $template = "nib";      // pastikan file nib.blade.php ada
            break;

        case "perpajakan":
            $template = "pbb";
            break;

        case "ketenagakerjaan-jaminan-sosial":
            $template = "bpjs";
            break;

        case "pertanahan":
            $template = "tanah";
            break;

        case "kepolisian-hukum":
            $template = "skck";
            break;

        case "imigrasi-pmi":
            $template = "paspor";
            break;

        case "perbankan-keuangan":
            $template = "tilang";
            break;

        default:
            $template = "kk";
            break;
    }

    $view =
        dirname(__DIR__, 3)
        . "/resources/views/pdf/"
        . $template
        . ".blade.php";

    if (!file_exists($view)) {
        exit("Template PDF belum tersedia: " . $template);
    }

    header("Content-Type: text/html; charset=UTF-8");

    header(
        'Content-Disposition: attachment; filename="' .
        preg_replace('/[^A-Za-z0-9]/', '_', $application["service_name"]) .
        '_' .
        $application["id"] .
        '.html"'
    );

    include $view;

    exit;
}

    /**
     * ==========================================
     * Submit Rating
     * ==========================================
     */
    public function submitRating(int $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION["logged_in"])) {
            header("Location:/login");
            exit;
        }

        $rating = (int)($_POST["rating"] ?? 0);
        $comment = trim($_POST["comment"] ?? "");

        if ($rating < 1 || $rating > 5) {
            $_SESSION["error"] = "Rating tidak valid.";
            header("Location:/services/history");
            exit;
        }

        $pdo = Database::getConnection();

        // Pastikan pengajuan milik user
        $stmt = $pdo->prepare("
            SELECT *
            FROM applications
            WHERE id = ?
            AND nik = ?
            LIMIT 1
        ");

        $stmt->execute([
            $id,
            $_SESSION["user"]["nik"]
        ]);

        $application = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$application) {
            exit("Data tidak ditemukan.");
        }

        // Cek apakah sudah pernah memberi rating
        $stmt = $pdo->prepare("
            SELECT COUNT(*)
            FROM ratings
            WHERE application_id = ?
        ");

        $stmt->execute([$id]);

        if ($stmt->fetchColumn() > 0) {
            $_SESSION["error"] = "Anda sudah memberi rating.";
            header("Location:/services/history");
            exit;
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Rating (Sudah ditambah service_slug dan nama)
        |--------------------------------------------------------------------------
        */
        $stmt = $pdo->prepare("
            INSERT INTO ratings
            (
                application_id,
                service_name,
                service_slug,
                nik,
                nama,
                rating,
                comment
            )
            VALUES
            (
                ?, ?, ?, ?, ?, ?, ?
            )
        ");

        // Ambil data slug
        $serviceSlug = $application["service_slug"] ?? $application["slug"] ?? "";

        // Ambil data nama dari application atau session user
        $namaUser = $application["nama"] 
            ?? $application["user_name"] 
            ?? $_SESSION["user"]["name"] 
            ?? $_SESSION["user"]["nama"] 
            ?? "";

        $stmt->execute([
            $id,
            $application["service_name"],
            $serviceSlug,
            $_SESSION["user"]["nik"],
            $namaUser, // <--- Data nama dimasukkan di sini
            $rating,
            $comment
        ]);

        $_SESSION["success"] = "Terima kasih atas penilaiannya.";
        header("Location:/services/history");
        exit;
    }
        /**
     * ==========================================
     * Parse JSON Form
     * ==========================================
     */
    private function parseForm($form): array
    {
        if (is_array($form)) {
            return $form;
        }

        if (is_string($form)) {

            $decoded = json_decode($form, true);

            if (
                json_last_error() === JSON_ERROR_NONE &&
                is_array($decoded)
            ) {
                return $decoded;
            }
        }

        return [];
    }

    /**
     * ==========================================
     * Helper Status Finished
     * ==========================================
     */
    private function isFinished(string $status): bool
    {
        return in_array(
            $status,
            [
                "Approved",
                "Selesai"
            ]
        );
    }

    /**
     * ==========================================
     * Helper Pending
     * ==========================================
     */
    private function isPending(string $status): bool
    {
        return in_array(
            $status,
            [
                "Pending",
                "Menunggu"
            ]
        );
    }

    /**
     * ==========================================
     * Helper Processing
     * ==========================================
     */
    private function isProcessing(string $status): bool
    {
        return $status === "Diproses";
    }

    /**
     * ==========================================
     * Helper Rejected
     * ==========================================
     */
    private function isRejected(string $status): bool
    {
        return in_array(
            $status,
            [
                "Rejected",
                "Ditolak"
            ]
        );
    }

}