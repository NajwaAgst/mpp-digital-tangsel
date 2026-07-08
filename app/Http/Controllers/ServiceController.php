<?php

namespace App\Http\Controllers;

use App\Repositories\ApplicationRepository;
use App\Repositories\ServiceRepository;
use App\Support\Database;
use Dompdf\Dompdf;
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

        return $this->view('services.index', [
            'services' => ServiceRepository::all(),
            'authUser' => $_SESSION['user'] ?? null
        ]);
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
            header("Location: /login");
            exit;
        }

        $nik = $_SESSION['user']['nik'];

        $applications = ApplicationRepository::byNik($nik);

        $stats = [
            'total' => count($applications),
            'pending' => 0,
            'processing' => 0,
            'done' => 0,
            'rejected' => 0
        ];

        foreach ($applications as $app) {

            switch ($app['status']) {

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
                "Location: /login?redirect=" .
                urlencode($redirect)
            );

            exit;
        }

        $service = ServiceRepository::find($slug);

        if (!$service) {

            http_response_code(404);

            return "Layanan tidak ditemukan.";
        }

        $service["form"] = $this->parseForm(
            $service["form"] ?? []
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
            | Ambil data akun login
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
            | Validasi form dinamis
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

        return $this->view(
            "user.history",
            [
                "applications"=>$applications,
                "authUser"=>$_SESSION["user"]
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
                "application"=>$application,
                "authUser"=>$_SESSION["user"]
            ]
        );
    }

    /**
     * ==========================================
     * Download PDF Hasil Layanan
     * ==========================================
     */
    public function downloadPdf(int $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION["logged_in"])) {
            header("Location:/login");
            exit;
        }

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT *
            FROM applications
            WHERE id=?
            AND nik=?
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

        /*
        |--------------------------------------------------------------------------
        | Hanya boleh download jika Approved / Selesai
        |--------------------------------------------------------------------------
        */

        if (
            $application["status"] != "Approved"
            &&
            $application["status"] != "Selesai"
        ){
            exit("Dokumen belum tersedia.");
        }

        /*
        |--------------------------------------------------------------------------
        | Tentukan Template PDF
        |--------------------------------------------------------------------------
        */

        $service = strtolower(trim($application["service_name"]));

        $template = "kk";

        if (str_contains($service,"bpjs")) {

            $template="bpjs";

        } elseif (str_contains($service,"paspor")) {

            $template="paspor";

        } elseif (str_contains($service,"skck")) {

            $template="skck";

        } elseif (str_contains($service,"pbb")) {

            $template="pbb";

        } elseif (str_contains($service,"pbg")) {

            $template="pbg";

        } elseif (str_contains($service,"tanah")) {

            $template="tanah";

        } elseif (str_contains($service,"tilang")) {

            $template="tilang";

        }

        $view = dirname(__DIR__,3)
            ."/resources/views/pdf/"
            .$template
            .".blade.php";

        if (!file_exists($view)) {

            exit("Template PDF belum tersedia.");
        }

        ob_start();

        include $view;

        $html = ob_get_clean();

        $pdf = new Dompdf();

        $pdf->loadHtml($html);

        $pdf->setPaper("A4","portrait");

        $pdf->render();

        $filename =
            preg_replace(
                '/[^A-Za-z0-9]/',
                '_',
                $application["service_name"]
            )
            ."_"
            .$application["id"]
            .".pdf";

        $pdf->stream(
            $filename,
            [
                "Attachment"=>true
            ]
        );

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
     * Helper Status Badge
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