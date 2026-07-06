<?php

namespace App\Repositories;

use App\Support\Database;

class StatsRepository
{
    public static function all(): array
    {
        $stmt = Database::getConnection()->query(

            "SELECT * FROM stats ORDER BY id"

        );

        return $stmt->fetchAll();
    }
}