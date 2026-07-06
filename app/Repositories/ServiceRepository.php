<?php

namespace App\Repositories;

use App\Support\Database;

class ServiceRepository
{
    public static function all(): array
    {
        $stmt = Database::getConnection()->query(
            "SELECT * FROM services ORDER BY id"
        );

        $services = $stmt->fetchAll();

        $forms = require __DIR__ . '/../../config/ServiceForm.php';

        foreach ($services as &$service) {

            $service['documents'] =
                json_decode($service['documents'], true) ?: [];

            $service['steps'] =
                json_decode($service['steps'], true) ?: [];

            $service['form'] =
                $forms[$service['slug']] ?? [];

        }

        return $services;
    }

    public static function find(string $slug): ?array
    {
        $stmt = Database::getConnection()->prepare(
            "SELECT * FROM services
             WHERE slug=:slug
             LIMIT 1"
        );

        $stmt->execute([
            'slug'=>$slug
        ]);

        $service = $stmt->fetch();

        if(!$service){
            return null;
        }

        $forms = require __DIR__.'/../../config/ServiceForm.php';

        $service['documents']=json_decode(
            $service['documents'],
            true
        ) ?: [];

        $service['steps']=json_decode(
            $service['steps'],
            true
        ) ?: [];

        $service['form']=$forms[$slug] ?? [];

        return $service;
    }
}