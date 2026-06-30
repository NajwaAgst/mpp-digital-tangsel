<?php

namespace App\Http\Controllers;

use App\Support\Database;

class HomeController extends Controller
{
    public function index(): string
    {
        $services = array_map(static function (array $service): array {
            return [
                'slug' => $service['slug'],
                'name' => $service['name'],
                'category' => $service['category'],
                'summary' => $service['summary'],
                'accent' => $service['accent'],
            ];
        }, Database::getServices());

        $stats = Database::getStats();

        return $this->view('home', compact('services', 'stats'));
    }
}
