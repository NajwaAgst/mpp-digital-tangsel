<?php

namespace App\Services;

use Dompdf\Dompdf;
use App\Support\Database;
use PDO;

class PdfGenerator
{
    public static function generate(array $application): string
    {
        $service = strtolower($application['service_name']);

        ob_start();

        switch ($service) {

            case 'kartu keluarga':
            case 'kk':
                include dirname(__DIR__, 2) . "/resources/views/pdf/kk.php";
                break;

            case 'ktp':
                include dirname(__DIR__, 2) . "/resources/views/pdf/ktp.php";
                break;

            default:
                include dirname(__DIR__, 2) . "/resources/views/pdf/default.php";
        }

        $html = ob_get_clean();

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper("A4", "portrait");

        $dompdf->render();

        $folder = dirname(__DIR__, 2) . "/public/uploads/pdf";

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $filename = "application_" . $application['id'] . ".pdf";

        file_put_contents(
            $folder . "/" . $filename,
            $dompdf->output()
        );

        return $filename;
    }
}