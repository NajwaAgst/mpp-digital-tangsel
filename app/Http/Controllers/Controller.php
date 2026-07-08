<?php

namespace App\Http\Controllers;

class Controller
{
    /**
     * Render View
     */
    protected function view(string $view, array $data = []): string
    {
        $basePath = dirname(__DIR__, 3) . '/resources/views/';

        // services.user.dashboard
        $viewPath = str_replace('.', DIRECTORY_SEPARATOR, $view);

        $file = $basePath . $viewPath . '.blade.php';

        if (!file_exists($file)) {

            http_response_code(404);

            return "
                <h2 style='font-family:Arial;color:#dc2626'>
                    View not found
                </h2>

                <p>
                    <b>View :</b> {$view}
                </p>

                <p>
                    <b>Expected File :</b><br>
                    {$file}
                </p>
            ";
        }

        extract($data);

        ob_start();

        include $file;

        return ob_get_clean();
    }
}