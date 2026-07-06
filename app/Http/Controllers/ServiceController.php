<?php

namespace App\Http\Controllers;

use App\Repositories\ServiceRepository;
use App\Repositories\ApplicationRepository;

class ServiceController extends Controller
{
    /**
     * Daftar layanan
     */
    public function index(): string
    {
        return $this->view('services.index', [
            'services' => ServiceRepository::all()
        ]);
    }

    /**
     * Detail layanan
     */
    public function show(string $slug): string
    {
        $service = ServiceRepository::find($slug);

        if (!$service) {
            http_response_code(404);
            return "Layanan tidak ditemukan";
        }

        $service['form'] = $this->parseForm($service['form'] ?? []);

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

        if (empty($_SESSION['logged_in'])) {

            $redirect = "/services/" . $slug . "/apply";

            header("Location: /login?redirect=" . urlencode($redirect));

            exit;
        }

        $service = ServiceRepository::find($slug);

        if (!$service) {
            http_response_code(404);
            return "Layanan tidak ditemukan";
        }

        $service['form'] = $this->parseForm($service['form'] ?? []);

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

            if (empty($submittedData["nik"])) {

                $errorMessage = "NIK wajib diisi.";

            } elseif (empty($submittedData["nama"])) {

                $errorMessage = "Nama wajib diisi.";

            } elseif (empty($submittedData["alamat"])) {

                $errorMessage = "Alamat wajib diisi.";

            }

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

            if ($errorMessage === null) {

                try {

                    $submissionId = ApplicationRepository::create(

                        $slug,

                        $service["name"],

                        $submittedData,

                        $_SESSION["user"] ?? null

                    );

                    $submitted = true;

                    $submittedData = [];

                } catch (\Throwable $e) {

                    $errorMessage = $e->getMessage();

                }
            }
        }

        return $this->view("services.apply", [

            "service" => $service,

            "submitted" => $submitted,

            "submittedData" => $submittedData,

            "submissionId" => $submissionId,

            "errorMessage" => $errorMessage,

            "authUser" => $_SESSION["user"] ?? null

        ]);
    }

    /**
     * Parse Form
     */
    private function parseForm($form): array
    {
        if (is_array($form)) {
            return $form;
        }

        if (is_string($form)) {

            $decoded = json_decode($form, true);

            return is_array($decoded)
                ? $decoded
                : [];
        }

        return [];
    }

    public function history(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['logged_in'])) {
        header("Location: /login");
        exit;
    }

    $nik = $_SESSION['user']['nik'];

    return $this->view('service.history', [
        'applications' => ApplicationRepository::historyByUser($nik),
        'authUser' => $_SESSION['user']
    ]);
}

public function detail(int $id): string
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['logged_in'])) {
        header("Location: /login");
        exit;
    }

    $nik = $_SESSION['user']['nik'];

    $application = ApplicationRepository::findByUser($id, $nik);

    if (!$application) {

        http_response_code(404);

        return "Pengajuan tidak ditemukan.";

    }

    return $this->view('service.detail', [

        'application' => $application,

        'authUser' => $_SESSION['user']

    ]);
}
}