<?php

namespace App\Support;

use PDO;

class Seeder
{
    public static function run(PDO $pdo): void
    {
        self::seedServices($pdo);
        self::seedStats($pdo);
    }

    private static function seedServices(PDO $pdo): void
    {
        $count = (int) $pdo
            ->query("SELECT COUNT(*) FROM services")
            ->fetchColumn();

        if ($count === 8) {
            return;
        }

        $pdo->exec("DELETE FROM services");

        $insert = $pdo->prepare("
            INSERT INTO services
            (
                slug,
                name,
                category,
                institution,
                summary,
                description,
                duration,
                who,
                notes,
                documents,
                steps,
                accent
            )
            VALUES
            (
                :slug,
                :name,
                :category,
                :institution,
                :summary,
                :description,
                :duration,
                :who,
                :notes,
                :documents,
                :steps,
                :accent
            )
        ");

        foreach (self::services() as $service) {

            $insert->execute([

                'slug' => $service['slug'],

                'name' => $service['name'],

                'category' => $service['category'],

                'institution' => $service['institution'],

                'summary' => $service['summary'],

                'description' => $service['description'],

                'duration' => $service['duration'],

                'who' => $service['who'],

                'notes' => $service['notes'],

                'documents' => json_encode(
                    $service['documents'],
                    JSON_UNESCAPED_UNICODE
                ),

                'steps' => json_encode(
                    $service['steps'],
                    JSON_UNESCAPED_UNICODE
                ),

                'accent' => $service['accent']

            ]);

        }
    }

    private static function seedStats(PDO $pdo): void
    {
        $count = (int)$pdo
            ->query("SELECT COUNT(*) FROM stats")
            ->fetchColumn();

        if ($count > 0) {
            return;
        }

        $insert = $pdo->prepare("
            INSERT INTO stats
            (
                label,
                value,
                detail
            )
            VALUES
            (
                :label,
                :value,
                :detail
            )
        ");

        foreach (self::stats() as $stat) {

            $insert->execute($stat);

        }
    }

    private static function stats(): array
    {
        return [

            [
                'label'=>'Total Kunjungan',
                'value'=>'18.240+',
                'detail'=>'Naik 12% bulan ini'
            ],

            [
                'label'=>'Berkas Terverifikasi',
                'value'=>'7.812',
                'detail'=>'24 Jam Terakhir'
            ],

            [
                'label'=>'Antrean Aktif',
                'value'=>'186',
                'detail'=>'Prioritas Cepat'
            ]

        ];
    }

    private static function services(): array
    {
        return [

            // TEMPEL seluruh array $services
            // yang ada di Database.php

        ];
    }
}