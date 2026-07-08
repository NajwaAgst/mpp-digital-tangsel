<?php

namespace App\Http\Controllers;

use App\Support\Database;
use PDO;

class AdminController extends Controller
{
    /**
     * ==========================================
     * Middleware Admin
     * ==========================================
     */
    private function checkAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (
            empty($_SESSION["logged_in"]) ||
            empty($_SESSION["user"]) ||
            (($_SESSION["user"]["role"] ?? "") !== "admin")
        ) {
            header("Location: /login");
            exit;
        }
    }

    /**
     * ==========================================
     * Dashboard
     * ==========================================
     */
    public function dashboard(): string
    {
        $this->checkAdmin();

        $pdo = Database::getConnection();

        /*
        |--------------------------------------------------------------------------
        | Summary Applications
        |--------------------------------------------------------------------------
        */

        $total = (int)$pdo->query("
            SELECT COUNT(*)
            FROM applications
        ")->fetchColumn();

        $pending = (int)$pdo->query("
            SELECT COUNT(*)
            FROM applications
            WHERE status='Pending'
        ")->fetchColumn();

        $approved = (int)$pdo->query("
            SELECT COUNT(*)
            FROM applications
            WHERE status='Approved'
        ")->fetchColumn();

        $rejected = (int)$pdo->query("
            SELECT COUNT(*)
            FROM applications
            WHERE status='Rejected'
        ")->fetchColumn();

        /*
        |--------------------------------------------------------------------------
        | Total Users
        |--------------------------------------------------------------------------
        */

        $totalUsers = (int)$pdo->query("
            SELECT COUNT(*)
            FROM users
        ")->fetchColumn();

        /*
        |--------------------------------------------------------------------------
        | Total Services
        |--------------------------------------------------------------------------
        */

        $totalServices = (int)$pdo->query("
            SELECT COUNT(*)
            FROM services
        ")->fetchColumn();

        /*
|--------------------------------------------------------------------------
| Emergency Statistics
|--------------------------------------------------------------------------
*/

$totalEmergency = (int)$pdo->query("
    SELECT COUNT(*)
    FROM emergencies
")->fetchColumn();

$waitingEmergency = (int)$pdo->query("
    SELECT COUNT(*)
    FROM emergencies
    WHERE status='Menunggu'
")->fetchColumn();

$processEmergency = (int)$pdo->query("
    SELECT COUNT(*)
    FROM emergencies
    WHERE status='Diproses'
")->fetchColumn();

$doneEmergency = (int)$pdo->query("
    SELECT COUNT(*)
    FROM emergencies
    WHERE status='Selesai'
")->fetchColumn();

$newEmergency = $waitingEmergency;

        /*
        |--------------------------------------------------------------------------
        | Recent Applications
        |--------------------------------------------------------------------------
        */

        $stmt = $pdo->query("
            SELECT
                id,
                service_name,
                nama,
                nik,
                status,
                created_at
            FROM applications
            ORDER BY created_at DESC
            LIMIT 5
        ");

        $recentApplications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*
        |--------------------------------------------------------------------------
        | Chart Applications
        |--------------------------------------------------------------------------
        */

        $stmt = $pdo->query("
            SELECT
                service_name,
                COUNT(*) AS total
            FROM applications
            GROUP BY service_name
            ORDER BY total DESC
        ");

        $chart = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*
|--------------------------------------------------------------------------
| Emergency Category Chart
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT
        emergency_type,
        COUNT(*) AS total
    FROM emergencies
    GROUP BY emergency_type
    ORDER BY total DESC
");

$emergencyChart = $stmt->fetchAll(PDO::FETCH_ASSOC);


        /*
        |--------------------------------------------------------------------------
        | Emergency Status Chart
        |--------------------------------------------------------------------------
        */

        $stmt = $pdo->query("
            SELECT
                status,
                COUNT(*) AS total
            FROM emergencies
            GROUP BY status
        ");

        $emergencyStatusChart = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*
        |--------------------------------------------------------------------------
        | Interoperability
        |--------------------------------------------------------------------------
        */

        $dukcapil = (int)$pdo->query("
            SELECT COUNT(*)
            FROM penduduks
        ")->fetchColumn();

        $npwp = (int)$pdo->query("
            SELECT COUNT(*)
            FROM npwps
        ")->fetchColumn();

        $nib = (int)$pdo->query("
            SELECT COUNT(*)
            FROM nibs
        ")->fetchColumn();

        return $this->view("admin.dashboard", [

            "total" => $total,
            "pending" => $pending,
            "approved" => $approved,
            "rejected" => $rejected,

            "totalUsers" => $totalUsers,
            "totalServices" => $totalServices,

            "recentApplications" => $recentApplications,

            "chart" => $chart,

            "dukcapil" => $dukcapil,
            "npwp" => $npwp,
            "nib" => $nib,

            "newEmergency" => $newEmergency,
            "totalEmergency" => $totalEmergency,
            "waitingEmergency" => $waitingEmergency,
            "processEmergency" => $processEmergency,
            "doneEmergency" => $doneEmergency,

            "emergencyChart" => $emergencyChart,
            "emergencyStatusChart" => $emergencyStatusChart

        ]);
    }    /**
     * ==========================================
     * Semua Pengajuan
     * ==========================================
     */
    public function applications(): string
    {
        $this->checkAdmin();

        $pdo = Database::getConnection();

        $search = trim($_GET["search"] ?? "");
        $status = trim($_GET["status"] ?? "");

        $sql = "
            SELECT *
            FROM applications
            WHERE 1=1
        ";

        $params = [];

        if ($search !== "") {

            $sql .= "
                AND (
                    service_name LIKE ?
                    OR nama LIKE ?
                    OR nik LIKE ?
                )
            ";

            $keyword = "%{$search}%";

            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        if ($status !== "") {

            $sql .= "
                AND status = ?
            ";

            $params[] = $status;
        }

        $sql .= "
            ORDER BY created_at DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->view("admin.applications", [

            "applications" => $applications,
            "search" => $search,
            "status" => $status

        ]);
    }

    /**
 * ==========================================
 * Data Emergency
 * ==========================================
 */
public function emergencies(): string
{
    $this->checkAdmin();

    $pdo = Database::getConnection();

    $stmt = $pdo->query("
        SELECT *
        FROM emergencies
        ORDER BY created_at DESC
    ");

    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $this->view("admin.emergencies", [
        "reports" => $reports
    ]);
}

/**
 * ==========================================
 * Detail Emergency
 * ==========================================
 */
public function emergencyDetail(int $id): string
{
    $this->checkAdmin();

    $pdo = Database::getConnection();

    $stmt = $pdo->prepare("
        SELECT *
        FROM emergencies
        WHERE id=?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $report = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$report) {

        http_response_code(404);

        return "Data Emergency tidak ditemukan.";
    }

    return $this->view("admin.emergency-detail", [
        "report" => $report
    ]);
}

    /**
     * ==========================================
     * Detail Pengajuan
     * ==========================================
     */
    public function show(int $id): string
    {
        $this->checkAdmin();

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            SELECT *
            FROM applications
            WHERE id=?
            LIMIT 1
        ");

        $stmt->execute([$id]);

        $application = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$application) {

            http_response_code(404);

            return "Pengajuan tidak ditemukan.";
        }

        return $this->view(
            "admin.application-detail",
            [
                "application" => $application
            ]
        );
    }

    public function emergencyWaiting(int $id): void
{
    $this->updateEmergencyStatus(
        $id,
        "Pending"
    );
}

public function emergencyProcess(int $id): void
{
    $this->updateEmergencyStatus(
        $id,
        "Diproses"
    );
}
public function emergencyDone(int $id): void
{
    $this->updateEmergencyStatus(
        $id,
        "Selesai"
    );
}

private function updateEmergencyStatus(
    int $id,
    string $status
): void
{
    $this->checkAdmin();

    $pdo = Database::getConnection();

    $stmt = $pdo->prepare("
        UPDATE emergencies
        SET status=?
        WHERE id=?
    ");

    $stmt->execute([
        $status,
        $id
    ]);

    $_SESSION["success"] = "Status Emergency berhasil diperbarui.";

    header("Location: /admin/emergencies/" . $id);

    exit;
}

public function deleteEmergency(int $id): void
{
    $this->checkAdmin();

    $pdo = Database::getConnection();

    $stmt = $pdo->prepare("
        DELETE
        FROM emergencies
        WHERE id=?
    ");

    $stmt->execute([$id]);

    $_SESSION["success"] = "Laporan Emergency berhasil dihapus.";

    header("Location: /admin/emergencies");

    exit;
}



    public function approve(int $id): void
{
    $this->checkAdmin();

    $pdo = Database::getConnection();

    /*
    |--------------------------------------------------------------------------
    | Update Status
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE applications
        SET status='Approved'
        WHERE id=?
    ");

    $stmt->execute([$id]);

    /*
    |--------------------------------------------------------------------------
    | Ambil Data Pengajuan
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT *
        FROM applications
        WHERE id=?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $application = $stmt->fetch(PDO::FETCH_ASSOC);

    /*
|--------------------------------------------------------------------------
| Simpan nama file saja
|--------------------------------------------------------------------------
*/

$filename = "LAYANAN-" . $application["id"] . ".pdf";

$stmt = $pdo->prepare("
    UPDATE applications
    SET pdf_file=?
    WHERE id=?
");

$stmt->execute([
    $filename,
    $id
]);

    /*
    |--------------------------------------------------------------------------
    | Update Database
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE applications
        SET pdf_file=?
        WHERE id=?
    ");

    $stmt->execute([

        $filename,

        $id

    ]);

    $_SESSION["success"] = "Pengajuan berhasil disetujui dan PDF berhasil dibuat.";

    header("Location: /admin/applications/".$id);

    exit;
}


    /**
     * ==========================================
     * Reject
     * ==========================================
     */
    public function reject(int $id): void
    {
        $this->changeStatus(
            $id,
            "Rejected",
            "Pengajuan berhasil ditolak."
        );
    }

    /**
     * ==========================================
     * Pending
     * ==========================================
     */
    public function pending(int $id): void
    {
        $this->changeStatus(
            $id,
            "Pending",
            "Status berhasil dikembalikan menjadi Pending."
        );
    }

    /**
     * ==========================================
     * Delete Application
     * ==========================================
     */
    public function delete(int $id): void
    {
        $this->checkAdmin();

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            DELETE
            FROM applications
            WHERE id=?
        ");

        $stmt->execute([$id]);

        $_SESSION["success"] = "Pengajuan berhasil dihapus.";

        header("Location: /admin/applications");
        exit;
    }

    /**
     * ==========================================
     * Helper Change Status
     * ==========================================
     */
    private function changeStatus(
        int $id,
        string $status,
        string $message
    ): void
    {
        $this->checkAdmin();

        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("
            UPDATE applications
            SET status=?
            WHERE id=?
        ");

        $stmt->execute([
            $status,
            $id
        ]);

        $_SESSION["success"] = $message;

        header("Location: /admin/applications/" . $id);
        exit;
    }
}