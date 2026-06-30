<?php

namespace App\Http\Controllers;

class Controller
{
    protected function view(string $view, array $data = []): string
    {
        $file = __DIR__ . '/../../../resources/views/' . str_replace('.', '/', $view) . '.blade.php';
        if (!file_exists($file)) {
            return 'View not found: ' . $view;
        }

        extract($data);
        ob_start();
        include $file;
        return ob_get_clean();
    }
}
