<?php

namespace App\Support;

use PDO;

class Database
{
    private const DB_HOST = '127.0.0.1';
    private const DB_PORT = '3306';
    private const DB_NAME = 'mpp_portal';
    private const DB_USER = 'root';
    private const DB_PASS = '';

    public static function bootstrap(): PDO
    {
        self::ensureDatabaseExists();

        $pdo = self::connect(self::DB_NAME);


        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS services (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                slug VARCHAR(120) UNIQUE NOT NULL,
                name VARCHAR(180) NOT NULL,
                category VARCHAR(120) NOT NULL,
                institution VARCHAR(255) NOT NULL,
                summary TEXT NOT NULL,
                description TEXT NOT NULL,
                duration VARCHAR(120) NOT NULL,
                who TEXT NOT NULL,
                notes TEXT NOT NULL,
                documents LONGTEXT NOT NULL,
                steps LONGTEXT NOT NULL,
                accent VARCHAR(120) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
        );

        

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS stats (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                label VARCHAR(120) NOT NULL,
                value VARCHAR(80) NOT NULL,
                detail VARCHAR(180) NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
        );

        $pdo->exec(
            'CREATE TABLE IF NOT EXISTS applications (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                service_slug VARCHAR(120) NOT NULL,
                service_name VARCHAR(180) NOT NULL,
                nama VARCHAR(180) NOT NULL,
                nik VARCHAR(32) NOT NULL,
                hp VARCHAR(32) NOT NULL,
                alamat TEXT NOT NULL,
                keterangan TEXT NULL,
                user_name VARCHAR(180) NULL,
                user_email VARCHAR(180) NULL,
                created_at DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
        );

        $pdo->exec(
        'CREATE TABLE IF NOT EXISTS users (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nik VARCHAR(16) NOT NULL UNIQUE,
                name VARCHAR(150) NOT NULL,
                email VARCHAR(150) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci'
        );

        $pdo->exec(
        'CREATE TABLE IF NOT EXISTS penduduks (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nik VARCHAR(16) NOT NULL UNIQUE,
                nama VARCHAR(150) NOT NULL,
                tempat_lahir VARCHAR(100),
                tanggal_lahir DATE,
                alamat TEXT,
                created_at DATETIME
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
        );

        $pdo->exec(
        'CREATE TABLE IF NOT EXISTS npwps (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nik VARCHAR(16) NOT NULL,
                npwp VARCHAR(30) NOT NULL,
                status_npwp VARCHAR(50),
                created_at DATETIME
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
        );

        $pdo->exec(
        'CREATE TABLE IF NOT EXISTS nibs (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nik VARCHAR(16) NOT NULL,
                nib VARCHAR(30) NOT NULL,
                nama_usaha VARCHAR(150),
                jenis_usaha VARCHAR(100),
                created_at DATETIME
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
        );

        self::seed($pdo);

        return $pdo;
    }

    private static function ensureDatabaseExists(): void
    {
        $pdo = self::connect(null);
        $database = str_replace('`', '``', self::DB_NAME);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    private static function connect(?string $database): PDO
    {
        $dsn = 'mysql:host=' . self::DB_HOST . ';port=' . self::DB_PORT . ';charset=utf8mb4';

        if ($database !== null) {
            $dsn .= ';dbname=' . $database;
        }

        $pdo = new PDO($dsn, self::DB_USER, self::DB_PASS);
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $pdo;
    }
    public static function getConnection(): PDO
    {
        static $connection = null;

        if ($connection === null) {
            $connection = self::bootstrap();
        }

        return $connection;
    }

    public static function getServices(): array
    {
        $stmt = self::getConnection()->query('SELECT * FROM services ORDER BY id');
        $services = $stmt->fetchAll();

        return array_map(static function (array $service): array {
            $service['documents'] = json_decode($service['documents'], true) ?: [];
            $service['steps'] = json_decode($service['steps'], true) ?: [];
            return $service;
        }, $services);
    }

    public static function getService(string $slug): ?array
    {
        $stmt = self::getConnection()->prepare('SELECT * FROM services WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);
        $service = $stmt->fetch();

        if (!$service) {
            return null;
        }

        $service['documents'] = json_decode($service['documents'], true) ?: [];
        $service['steps'] = json_decode($service['steps'], true) ?: [];

        return $service;
    }

    public static function getStats(): array
    {
        $stmt = self::getConnection()->query('SELECT * FROM stats ORDER BY id');
        return $stmt->fetchAll();
    }

    public static function getCitizenByNik(string $nik): ?array
{
    $sql = "
        SELECT
            p.nik,
            p.nama,
            p.tempat_lahir,
            p.tanggal_lahir,
            p.alamat,
            n.npwp,
            n.status_npwp,
            b.nib,
            b.nama_usaha,
            b.jenis_usaha
        FROM penduduks p
        LEFT JOIN npwps n
            ON p.nik = n.nik
        LEFT JOIN nibs b
            ON p.nik = b.nik
        WHERE p.nik = :nik
        LIMIT 1
    ";

    $stmt = self::getConnection()->prepare($sql);
    $stmt->execute([
        'nik' => $nik
    ]);

    $data = $stmt->fetch();

    return $data ?: null;
}

    public static function saveApplication(string $slug, string $serviceName, array $data, ?array $user = null): int
    {
        $pdo = self::getConnection();
        $stmt = $pdo->prepare(
            'INSERT INTO applications (service_slug, service_name, nama, nik, hp, alamat, keterangan, user_name, user_email, created_at)
             VALUES (:service_slug, :service_name, :nama, :nik, :hp, :alamat, :keterangan, :user_name, :user_email, :created_at)'
        );

        $stmt->execute([
            'service_slug' => $slug,
            'service_name' => $serviceName,
            'nama' => $data['nama'] ?? '',
            'nik' => $data['nik'] ?? '',
            'hp' => $data['hp'] ?? '',
            'alamat' => $data['alamat'] ?? '',
            'keterangan' => $data['keterangan'] ?? '',
            'user_name' => $user['name'] ?? null,
            'user_email' => $user['email'] ?? null,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return (int) $pdo->lastInsertId();
    }

public static function registerUser(array $data): bool
{
    $pdo = self::getConnection();

    $stmt = $pdo->prepare("
        INSERT INTO users
        (nik, name, email, password, created_at)
        VALUES
        (:nik, :name, :email, :password, :created_at)
    ");

    return $stmt->execute([
        'nik' => $data['nik'],
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        'created_at' => date('Y-m-d H:i:s')
    ]);
}

public static function findUserByEmail(string $email): ?array
{
    $stmt = self::getConnection()->prepare("
        SELECT * FROM users
        WHERE email = :email
        LIMIT 1
    ");

    $stmt->execute([
        'email' => $email
    ]);

    $user = $stmt->fetch();

    return $user ?: null;
}

public static function findUserByNik(string $nik): ?array
{
    $stmt = self::getConnection()->prepare("
        SELECT * FROM users
        WHERE nik = :nik
        LIMIT 1
    ");

    $stmt->execute([
        'nik' => $nik
    ]);

    $user = $stmt->fetch();

    return $user ?: null;
}

public static function emailExists(string $email): bool
{
    return self::findUserByEmail($email) !== null;
}

public static function nikExists(string $nik): bool
{
    return self::findUserByNik($nik) !== null;
}

public static function findPendudukByNik(string $nik): ?array
{
    $stmt = self::getConnection()->prepare("
        SELECT *
        FROM penduduks
        WHERE nik = :nik
        LIMIT 1
    ");

    $stmt->execute([
        'nik' => $nik
    ]);

    return $stmt->fetch() ?: null;
}

public static function findNpwpByNik(string $nik): ?array
{
    $stmt = self::getConnection()->prepare("
        SELECT *
        FROM npwps
        WHERE nik = :nik
        LIMIT 1
    ");

    $stmt->execute([
        'nik' => $nik
    ]);

    return $stmt->fetch() ?: null;
}

public static function findNibByNik(string $nik): ?array
{
    $stmt = self::getConnection()->prepare("
        SELECT *
        FROM nibs
        WHERE nik = :nik
        LIMIT 1
    ");

    $stmt->execute([
        'nik' => $nik
    ]);

    return $stmt->fetch() ?: null;
}

    private static function seed(PDO $pdo): void
    {
        $serviceCount = (int) $pdo->query('SELECT COUNT(*) FROM services')->fetchColumn();

        if ($serviceCount !== 8) {
            $pdo->exec('DELETE FROM services');

            $services = [
                [
                    'slug' => 'adminduk',
                    'name' => 'Administrasi Kependudukan',
                    'category' => 'Kependudukan',
                    'institution' => 'Dinas Kependudukan dan Pencatatan Sipil Kota Tangerang Selatan',
                    'summary' => 'Layanan e-KTP, KK, KIA, akta kelahiran, akta kematian, surat pindah, dan dokumen kependudukan lainnya.',
                    'description' => 'Layanan administrasi kependudukan untuk pembuatan e-KTP, Kartu Keluarga, KIA, akta kelahiran, akta kematian, surat pindah, dan dokumen kependudukan lainnya secara terpadu.',
                    'duration' => '1â€“5 hari kerja',
                    'who' => 'Warga Kota Tangerang Selatan yang membutuhkan dokumen kependudukan',
                    'notes' => 'Pastikan seluruh data identitas sesuai dengan database kependudukan. Untuk perubahan data, dokumen pendukung wajib dilampirkan.',
                    'documents' => [
                        'KTP elektronik / biodata penduduk',
                        'Kartu Keluarga',
                        'Formulir permohonan layanan',
                        'Dokumen pendukung sesuai layanan (misalnya surat kelahiran, surat kematian, surat pindah, buku nikah)',
                        'Nomor telepon aktif dan email'
                    ],
                    'steps' => [
                        'Login atau daftar akun MPP Digital.',
                        'Pilih jenis layanan administrasi kependudukan yang ingin diajukan.',
                        'Isi formulir permohonan dan unggah dokumen persyaratan.',
                        'Verifikasi data oleh petugas Disdukcapil.',
                        'Dokumen diproses dan hasil dapat diunduh / diambil sesuai ketentuan.'
                    ],
                    'accent' => 'from-emerald-500 to-teal-600',
                ],
                [
                    'slug' => 'perizinan-berusaha',
                    'name' => 'Perizinan Berusaha dan Non-Berusaha',
                    'category' => 'Perizinan',
                    'institution' => 'DPMPTSP Kota Tangerang Selatan',
                    'summary' => 'Layanan NIB, izin operasional, PBG/IMB, dan izin praktik profesi tertentu.',
                    'description' => 'Layanan pengurusan Nomor Induk Berusaha (NIB), izin operasional, PBG/IMB, dan izin praktik profesi tertentu melalui sistem perizinan terpadu.',
                    'duration' => '3â€“7 hari kerja',
                    'who' => 'Pelaku usaha, badan usaha, atau masyarakat yang membutuhkan perizinan',
                    'notes' => 'Jenis dokumen dapat berbeda tergantung jenis izin yang diajukan. Untuk izin usaha, pastikan data usaha dan lokasi sudah sesuai.',
                    'documents' => [
                        'KTP pemohon / penanggung jawab',
                        'NPWP pribadi atau badan usaha',
                        'Nomor Induk Berusaha (untuk layanan tertentu)',
                        'Akta pendirian usaha / SK badan hukum (jika ada)',
                        'Surat keterangan domisili / bukti alamat usaha',
                        'Dokumen teknis sesuai jenis izin'
                    ],
                    'steps' => [
                        'Login ke portal MPP Digital.',
                        'Pilih jenis izin yang ingin diajukan.',
                        'Lengkapi data pemohon, data usaha, dan data lokasi.',
                        'Unggah dokumen persyaratan perizinan.',
                        'Petugas melakukan verifikasi dan validasi teknis.',
                        'Izin diterbitkan apabila seluruh persyaratan terpenuhi.'
                    ],
                    'accent' => 'from-violet-500 to-purple-600',
                ],
                [
                    'slug' => 'perpajakan',
                    'name' => 'Perpajakan',
                    'category' => 'Perpajakan',
                    'institution' => 'Bapenda Kota Tangerang Selatan / Instansi Pajak Terkait',
                    'summary' => 'Layanan PBB, pajak reklame, pajak restoran, dan administrasi perpajakan lainnya.',
                    'description' => 'Layanan perpajakan daerah seperti PBB, pajak reklame, pajak restoran, serta layanan administrasi perpajakan lain yang terintegrasi.',
                    'duration' => '1â€“5 hari kerja',
                    'who' => 'Wajib pajak orang pribadi, pelaku usaha, dan badan usaha',
                    'notes' => 'Besaran tagihan dan jenis dokumen mengikuti objek pajak dan kewajiban perpajakan masing-masing pemohon.',
                    'documents' => [
                        'KTP wajib pajak',
                        'NPWP (jika ada / sesuai layanan)',
                        'SPPT / bukti objek pajak / nomor objek pajak',
                        'Bukti kepemilikan atau penguasaan objek pajak',
                        'Dokumen usaha (untuk pajak usaha seperti restoran/reklame)',
                        'Email dan nomor telepon aktif'
                    ],
                    'steps' => [
                        'Masuk ke akun MPP Digital.',
                        'Pilih jenis layanan perpajakan yang diinginkan.',
                        'Isi data objek pajak atau data wajib pajak.',
                        'Unggah dokumen pendukung.',
                        'Verifikasi oleh petugas pajak daerah.',
                        'Lanjutkan pembayaran atau proses administrasi sesuai hasil verifikasi.'
                    ],
                    'accent' => 'from-sky-500 to-cyan-600',
                ],
                [
                    'slug' => 'ketenagakerjaan-jaminan-sosial',
                    'name' => 'Ketenagakerjaan dan Jaminan Sosial',
                    'category' => 'Ketenagakerjaan',
                    'institution' => 'Dinas Tenaga Kerja / BPJS Kesehatan / BPJS Ketenagakerjaan',
                    'summary' => 'Layanan AK-1/Kartu Kuning, BPJS Kesehatan, BPJS Ketenagakerjaan, dan administrasi ketenagakerjaan.',
                    'description' => 'Layanan pembuatan AK-1/Kartu Kuning, pendaftaran BPJS Kesehatan, BPJS Ketenagakerjaan, dan layanan administrasi ketenagakerjaan lainnya.',
                    'duration' => '1â€“5 hari kerja',
                    'who' => 'Pencari kerja, pekerja, dan pemberi kerja',
                    'notes' => 'Untuk layanan BPJS, siapkan data peserta dengan lengkap. Untuk AK-1, data pendidikan dan pengalaman kerja perlu diisi dengan benar.',
                    'documents' => [
                        'KTP',
                        'Kartu Keluarga',
                        'Pas foto terbaru',
                        'Ijazah terakhir (untuk AK-1)',
                        'Surat pengalaman kerja / surat keterangan kerja (jika diperlukan)',
                        'Nomor BPJS lama / data kepesertaan (jika pengajuan terkait BPJS)'
                    ],
                    'steps' => [
                        'Login ke akun MPP Digital.',
                        'Pilih layanan AK-1, BPJS Kesehatan, atau BPJS Ketenagakerjaan.',
                        'Lengkapi data pribadi dan data pekerjaan.',
                        'Unggah dokumen persyaratan.',
                        'Petugas melakukan verifikasi dokumen.',
                        'Dokumen/layanan diterbitkan sesuai hasil pemeriksaan.'
                    ],
                    'accent' => 'from-amber-500 to-orange-600',
                ],
                [
                    'slug' => 'pertanahan',
                    'name' => 'Pertanahan (ATR/BPN)',
                    'category' => 'Pertanahan',
                    'institution' => 'ATR/BPN',
                    'summary' => 'Pendaftaran tanah pertama kali, pengecekan sertifikat, balik nama, dan konsultasi pertanahan.',
                    'description' => 'Layanan pertanahan meliputi pendaftaran tanah pertama kali, pengecekan sertifikat, balik nama, serta konsultasi administrasi pertanahan.',
                    'duration' => '5â€“14 hari kerja',
                    'who' => 'Pemilik tanah, ahli waris, pembeli, atau kuasa yang sah',
                    'notes' => 'Pastikan data bidang tanah, nama pemilik, dan dokumen alas hak sesuai. Untuk balik nama atau pendaftaran tanah, dokumen tambahan dapat diminta.',
                    'documents' => [
                        'KTP pemohon',
                        'Kartu Keluarga',
                        'Sertifikat tanah / alas hak / girik / AJB (sesuai layanan)',
                        'SPPT PBB tahun berjalan',
                        'Surat kuasa (jika diwakilkan)',
                        'Dokumen pendukung lain sesuai jenis layanan pertanahan'
                    ],
                    'steps' => [
                        'Masuk ke portal MPP Digital.',
                        'Pilih layanan pertanahan yang dibutuhkan.',
                        'Isi data pemohon dan data objek tanah.',
                        'Unggah dokumen kepemilikan dan dokumen pendukung.',
                        'Verifikasi administrasi oleh petugas ATR/BPN.',
                        'Proses layanan dilanjutkan sesuai jenis permohonan.'
                    ],
                    'accent' => 'from-rose-500 to-pink-600',
                ],
                [
                    'slug' => 'kepolisian-hukum',
                    'name' => 'Kepolisian dan Hukum',
                    'category' => 'Kepolisian',
                    'institution' => 'Polri / Kejaksaan / Instansi Hukum Terkait',
                    'summary' => 'Layanan SKCK, perpanjangan SIM tertentu, dan administrasi hukum lainnya.',
                    'description' => 'Layanan kepolisian dan hukum seperti pembuatan SKCK, perpanjangan SIM tertentu, serta layanan administrasi hukum lain yang tersedia melalui MPP.',
                    'duration' => '1â€“3 hari kerja',
                    'who' => 'Warga yang membutuhkan layanan administrasi kepolisian atau hukum',
                    'notes' => 'Jenis layanan yang tersedia dapat berbeda pada tiap MPP. Untuk SIM dan SKCK, data identitas harus valid dan sesuai dokumen asli.',
                    'documents' => [
                        'KTP',
                        'Kartu Keluarga',
                        'Pas foto terbaru',
                        'Sidik jari / dokumen pendukung kepolisian (jika dipersyaratkan)',
                        'SIM lama (untuk perpanjangan SIM)',
                        'Dokumen tambahan sesuai layanan hukum/kepolisian'
                    ],
                    'steps' => [
                        'Login ke akun MPP Digital.',
                        'Pilih layanan SKCK, SIM, atau layanan hukum yang tersedia.',
                        'Lengkapi formulir pengajuan.',
                        'Unggah dokumen persyaratan.',
                        'Petugas melakukan verifikasi data dan dokumen.',
                        'Pemohon menerima jadwal / hasil proses sesuai layanan.'
                    ],
                    'accent' => 'from-indigo-500 to-blue-600',
                ],
                [
                    'slug' => 'imigrasi-pmi',
                    'name' => 'Imigrasi dan Ketenagakerjaan Luar Negeri',
                    'category' => 'Imigrasi',
                    'institution' => 'Kantor Imigrasi / BP2MI / Instansi Terkait',
                    'summary' => 'Layanan paspor, layanan keimigrasian, dan administrasi pendukung bagi PMI.',
                    'description' => 'Layanan pengurusan paspor, layanan keimigrasian, dan administrasi pendukung bagi Pekerja Migran Indonesia (PMI).',
                    'duration' => '3â€“7 hari kerja',
                    'who' => 'WNI yang membutuhkan paspor atau dokumen untuk keperluan luar negeri / PMI',
                    'notes' => 'Pastikan nama, NIK, dan dokumen pendukung konsisten. Untuk PMI, dokumen tambahan dapat menyesuaikan tujuan penempatan.',
                    'documents' => [
                        'KTP',
                        'Kartu Keluarga',
                        'Akta kelahiran / ijazah / buku nikah',
                        'Paspor lama (jika perpanjangan/penggantian)',
                        'Surat rekomendasi / dokumen penempatan kerja luar negeri (untuk PMI)',
                        'Pas foto / dokumen tambahan sesuai jenis layanan'
                    ],
                    'steps' => [
                        'Login ke MPP Digital.',
                        'Pilih layanan paspor / imigrasi / administrasi PMI.',
                        'Lengkapi data diri dan data perjalanan / penempatan kerja.',
                        'Unggah dokumen persyaratan.',
                        'Verifikasi oleh petugas imigrasi / instansi terkait.',
                        'Ikuti jadwal lanjutan apabila diperlukan wawancara atau biometrik.'
                    ],
                    'accent' => 'from-fuchsia-500 to-violet-600',
                ],
                [
                    'slug' => 'perbankan-keuangan',
                    'name' => 'Perbankan dan Jasa Keuangan',
                    'category' => 'Keuangan',
                    'institution' => 'Bank Mitra / Samsat / Instansi Keuangan Daerah',
                    'summary' => 'Layanan pembayaran tagihan, retribusi, pajak kendaraan, tilang, dan layanan keuangan lain.',
                    'description' => 'Layanan pembayaran tagihan, retribusi, pajak kendaraan, tilang, dan layanan keuangan lain melalui bank mitra atau kanal pembayaran yang terintegrasi di MPP.',
                    'duration' => 'Hari yang sama â€“ 2 hari kerja',
                    'who' => 'Masyarakat umum, wajib pajak, dan pengguna layanan pembayaran daerah',
                    'notes' => 'Nominal tagihan dan dokumen yang diminta bergantung pada jenis pembayaran atau layanan keuangan yang dipilih.',
                    'documents' => [
                        'KTP',
                        'Nomor tagihan / nomor objek layanan',
                        'STNK / data kendaraan (untuk pajak kendaraan)',
                        'Surat tilang / kode pembayaran (untuk tilang)',
                        'Bukti tagihan / surat ketetapan / dokumen pendukung lainnya',
                        'Nomor HP aktif untuk notifikasi transaksi'
                    ],
                    'steps' => [
                        'Login ke portal MPP Digital.',
                        'Pilih jenis pembayaran atau layanan keuangan.',
                        'Masukkan nomor tagihan / data kendaraan / data layanan terkait.',
                        'Lakukan verifikasi data tagihan.',
                        'Pilih metode pembayaran yang tersedia.',
                        'Simpan bukti transaksi setelah pembayaran berhasil.'
                    ],
                    'accent' => 'from-green-500 to-emerald-600',
                ],
            ];

            $insert = $pdo->prepare(
                'INSERT INTO services (slug, name, category, institution, summary, description, duration, who, notes, documents, steps, accent)
                 VALUES (:slug, :name, :category, :institution, :summary, :description, :duration, :who, :notes, :documents, :steps, :accent)'
            );

            foreach ($services as $service) {
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
                    'documents' => json_encode($service['documents']),
                    'steps' => json_encode($service['steps']),
                    'accent' => $service['accent'],
                ]);
            }
        }

        $statsCount = (int) $pdo->query('SELECT COUNT(*) FROM stats')->fetchColumn();
        if ($statsCount === 0) {
            $stats = [
                ['label' => 'Total Kunjungan', 'value' => '18.240+', 'detail' => 'Naik 12% bulan ini'],
                ['label' => 'Berkas Terverifikasi', 'value' => '7.812', 'detail' => '24 jam terakhir'],
                ['label' => 'Antrean Aktif', 'value' => '186', 'detail' => 'Prioritas layanan cepat'],
            ];

            $insert = $pdo->prepare('INSERT INTO stats (label, value, detail) VALUES (:label, :value, :detail)');
            foreach ($stats as $stat) {
                $insert->execute($stat);
            }
        }
    }
}