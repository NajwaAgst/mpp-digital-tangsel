<?php

$title = 'Mall Pelayanan Publik (MPP) Kota Tangerang Selatan';

$authUser = $_SESSION['user'] ?? null;

ob_start();

?>

<!-- ===================================================== -->
<!-- HERO -->
<!-- ===================================================== -->

<section class="relative overflow-hidden">

    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-600"></div>

    <div
        class="absolute inset-0 opacity-10"
        style="
            background-image:
            radial-gradient(circle,#ffffff 1px,transparent 1px);
            background-size:30px 30px;
        ">
    </div>

    <div class="relative mx-auto max-w-7xl px-6 py-24">

        <div class="text-center text-white">

            <span class="inline-flex items-center rounded-full bg-white/20 px-6 py-2 text-sm font-semibold">

                🔵 Portal Pelayanan Publik Terpadu

            </span>

            <h1 class="mt-8 text-6xl font-extrabold leading-tight">

                Mall Pelayanan Publik

                <br>

                <span class="text-yellow-300">

                    Kota Tangerang Selatan

                </span>

            </h1>

            <p class="mx-auto mt-8 max-w-3xl text-xl leading-9 text-blue-100">

                Portal digital yang mengintegrasikan seluruh layanan
                administrasi pemerintahan dan layanan Emergency 112
                dalam satu sistem berbasis interoperabilitas SPBE.

            </p>

           

        </div>

    </div>

</section>


<!-- ===================================================== -->
<!-- PILIH LAYANAN -->
<!-- ===================================================== -->

<section class="bg-white py-20">

    <div class="mx-auto max-w-7xl px-6">

        <div class="text-center">

            <span
                class="rounded-full bg-emerald-100 px-5 py-2 font-semibold text-emerald-700">

                PILIH LAYANAN

            </span>

            <h2 class="mt-6 text-5xl font-bold text-slate-900">

                Portal Pelayanan Publik Digital

            </h2>

            <p class="mx-auto mt-5 max-w-3xl text-lg leading-8 text-slate-600">

                Portal ini terdiri dari dua layanan utama,
                yaitu Mall Pelayanan Publik Digital (MPP)
                dan Emergency 112 yang saling terintegrasi.

            </p>

        </div>

        <div class="mt-16 grid gap-10 lg:grid-cols-2 items-stretch">

    <!-- ================= MPP ================= -->

    <div class="flex flex-col overflow-hidden rounded-[32px] border bg-white shadow-xl transition hover:-translate-y-2">

        <div class="bg-gradient-to-r from-emerald-700 to-emerald-500 p-10 text-white">

            <div class="text-7xl">
                🏛️
            </div>

            <h3 class="mt-6 text-4xl font-bold">
                Mall Pelayanan Publik
            </h3>

            <p class="mt-4 text-lg text-emerald-100">
                Seluruh layanan administrasi pemerintah
                secara online dalam satu platform digital.
            </p>

        </div>

        <div class="flex flex-1 flex-col p-8">

            <div class="grid grid-cols-2 gap-5">

                <div class="rounded-xl bg-emerald-50 p-5">

                    <div class="text-3xl font-bold text-emerald-700">
                        <?= count($services) ?>
                    </div>

                    <div class="mt-2 text-slate-600">
                        Jenis Layanan
                    </div>

                </div>

                <div class="rounded-xl bg-cyan-50 p-5">

                    <div class="text-3xl font-bold text-cyan-700">
                        18+
                    </div>

                    <div class="mt-2 text-slate-600">
                        Instansi
                    </div>

                </div>

            </div>

            <ul class="mt-8 space-y-3 text-slate-700">

                <li>✔ Dukcapil</li>
                <li>✔ Perizinan</li>
                <li>✔ Pajak Daerah</li>
                <li>✔ BPJS</li>
                <li>✔ Kepolisian</li>

            </ul>

            <a
                href="/services"
                class="mt-auto rounded-xl bg-emerald-600 py-4 text-center text-lg font-bold text-white transition hover:bg-emerald-700">

                Masuk ke MPP

            </a>

        </div>

    </div>

    <!-- ================= EMERGENCY ================= -->

    <div class="flex flex-col overflow-hidden rounded-[32px] border bg-white shadow-xl transition hover:-translate-y-2">

        <div class="bg-gradient-to-r from-red-600 to-red-500 p-10 text-white">

            <div class="text-7xl">
                🚨
            </div>

            <h3 class="mt-6 text-4xl font-bold">
                Emergency 112
            </h3>

            <p class="mt-4 text-lg text-red-100">
                Layanan tanggap darurat terpadu
                selama 24 jam untuk seluruh masyarakat.
            </p>

        </div>

        <div class="flex flex-1 flex-col p-8">

            <div class="grid grid-cols-3 gap-4">

                <div class="rounded-xl bg-red-50 p-5 text-center">

                    <div class="text-4xl">
                        🚒
                    </div>

                    <div class="mt-3">
                        Damkar
                    </div>

                </div>

                <div class="rounded-xl bg-red-50 p-5 text-center">

                    <div class="text-4xl">
                        🚑
                    </div>

                    <div class="mt-3">
                        Ambulans
                    </div>

                </div>

                <div class="rounded-xl bg-red-50 p-5 text-center">

                    <div class="text-4xl">
                        👮
                    </div>

                    <div class="mt-3">
                        Polisi
                    </div>

                </div>

            </div>

            <p class="mt-8 leading-8 text-slate-600">
                Digunakan untuk melaporkan kebakaran,
                kecelakaan, kriminalitas, bencana alam,
                maupun kondisi darurat lainnya.
            </p>

            <a
                href="/emergency"
                class="mt-auto rounded-xl bg-red-600 py-4 text-center text-lg font-bold text-white transition hover:bg-red-700">

                Masuk Emergency 112

            </a>

        </div>

    </div>

</div>


<!-- ===================================================== -->
<!-- DASHBOARD -->
<!-- ===================================================== -->

<section class="bg-slate-100 py-20">

    <div class="mx-auto max-w-7xl px-6">

        <div class="text-center">

            <span
                class="rounded-full bg-indigo-100 px-5 py-2 font-semibold text-indigo-700">

                DASHBOARD

            </span>

            <h2 class="mt-6 text-4xl font-bold text-slate-900">

                Statistik Pelayanan Publik

            </h2>

            <p class="mt-4 text-slate-600">

                Monitoring pelayanan publik secara realtime.

            </p>

        </div>

        <div class="mt-14 grid gap-8 md:grid-cols-2 xl:grid-cols-4">

            <div class="rounded-3xl bg-white p-8 shadow-lg">

                <div class="text-5xl">
                    🏛️ </div>

                <div class="mt-5 text-5xl font-bold text-emerald-600">

                    <?= $stats['services'] ?? count($services) ?>

                </div>

                <div class="mt-2 text-slate-600">

                    Layanan MPP

                </div>

            </div>

            <div class="rounded-3xl bg-white p-8 shadow-lg">

                <div class="text-5xl">
                    📑 </div>

                <div class="mt-5 text-5xl font-bold text-blue-600">

                    <?= $stats['applications'] ?? '0' ?>+

                </div>

                <div class="mt-2 text-slate-600">

                    Total Pengajuan

                </div>

            </div>

            <div class="rounded-3xl bg-white p-8 shadow-lg">

                <div class="text-5xl">
                    👨‍👩‍👧 </div>

                <div class="mt-5 text-5xl font-bold text-violet-600">

                    <?= $stats['users'] ?? '0' ?>

                </div>

                <div class="mt-2 text-slate-600">

                    Pengguna

                </div>

            </div>

            <div class="rounded-3xl bg-white p-8 shadow-lg">

                <div class="text-5xl">
                    🚨 </div>

                <div class="mt-5 text-5xl font-bold text-red-600">

                    <?= $stats['emergency'] ?? '24 Jam' ?>

                </div>

                <div class="mt-2 text-slate-600">

                    Emergency 112

                </div>

            </div>

        </div>

    </div>

</section>

<!-- Masukkan kode ini persis di bawah barisan 4 kotak statistik (Layanan MPP, Total Pengajuan, dll) -->
    
    <div class="mt-12 bg-white rounded-3xl p-8 shadow-md border border-slate-100 max-w-5xl mx-auto">
        <div class="text-center mb-8">
            <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">IKM</span>
            <h3 class="text-2xl font-bold text-slate-800 mt-2">Indeks Kepuasan Masyarakat</h3>
            <p class="text-slate-500 text-sm mt-1">Nilai kepuasan real-time berdasarkan ulasan langsung dari pengguna layanan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
            
            <!-- KIRI: Skor Utama -->
            <div class="text-center md:border-r border-slate-100 py-4">
                <div class="text-5xl font-black text-emerald-600"><?= $avgRating ?> <span class="text-lg font-normal text-slate-400">/ 5</span></div>
                <div class="text-yellow-400 text-xl mt-2 tracking-wider">
                    <?php 
                    $floorRating = floor($avgRating);
                    echo str_repeat('★', $floorRating) . ($avgRating - $floorRating >= 0.5 ? '½' : '') . str_repeat('☆', 5 - ceil($avgRating));
                    ?>
                </div>
                <p class="text-xs text-slate-400 mt-2">Berdasarkan <span class="font-bold text-slate-600"><?= $totalPenilaian ?></span> Penilaian</p>
            </div>

            <!-- TENGAH: Persentase Puas -->
            <div class="text-center md:border-r border-slate-100 py-4 px-2">
                <div class="text-5xl font-black text-slate-800"><?= $persenPuas ?>%</div>
                <p class="text-sm font-semibold text-slate-700 mt-2">Pengguna Puas</p>
                <p class="text-xs text-slate-400 mt-1">merasa terbantu dengan efisiensi sistem MPP.</p>
                <div class="w-full bg-slate-100 rounded-full h-2 mt-4 max-w-[200px] mx-auto overflow-hidden">
                    <div class="bg-emerald-500 h-2 rounded-full" style="width: <?= $persenPuas ?>%"></div>
                </div>
            </div>

            <!-- KANAN: Rating per Layanan (Diagram Batang Teks Keren) -->
            <div class="space-y-3 py-2">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Performa Layanan:</p>
                <?php if(empty($serviceRatings)): ?>
                    <p class="text-xs text-slate-400 italic">Belum ada data rating masuk.</p>
                <?php else: ?>
                    <?php 
                    // Tampilkan maksimal 4 layanan teratas di halaman depan agar rapi
                    $counter = 0;
                    foreach($serviceRatings as $sr): 
                        if($counter >= 4) break;
                        $score = round($sr['avg_rating'], 1);
                        $barLength = round(($score / 5) * 10);
                        $barHtml = str_repeat('█', $barLength) . str_repeat('░', 10 - $barLength);
                    ?>
                        <div class="text-xs">
                            <div class="flex justify-between text-slate-600 font-medium mb-0.5">
                                <span><?= htmlspecialchars($sr['service_name']) ?></span>
                                <span class="font-bold text-slate-800"><?= $score ?></span>
                            </div>
                            <div class="font-mono text-emerald-600 tracking-wider text-[11px] leading-none">
                                <?= $barHtml ?>
                            </div>
                        </div>
                    <?php 
                        $counter++;
                    endforeach; 
                    ?>
                <?php endif; ?>
            </div>

        </div>
    </div>

<!-- ===================================================== -->
<!-- DASHBOARD USER -->
<!-- ===================================================== -->

<?php if (!empty($authUser)): ?>

<section class="bg-white py-20">

    <div class="mx-auto max-w-7xl px-6">

        <div class="rounded-[32px] bg-gradient-to-r from-emerald-600 to-cyan-600 p-10 text-white shadow-2xl">

            <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">

                <div>

                    <span class="rounded-full bg-white/20 px-4 py-2 text-sm font-semibold">

                        DASHBOARD USER

                    </span>

                    <h2 class="mt-6 text-4xl font-bold">

                        Halo,

                        <?= htmlspecialchars($authUser['name']) ?>

                        👋

                    </h2>

                    <p class="mt-5 max-w-2xl text-lg text-emerald-100">

                        Selamat datang kembali di Portal Mall Pelayanan Publik
                        Kota Tangerang Selatan.

                    </p>

                </div>

                <div class="flex flex-wrap gap-4">

                    <a
                        href="/dashboard"
                        class="rounded-xl bg-white px-8 py-4 font-bold text-emerald-700 hover:bg-slate-100">

                        Dashboard Saya

                    </a>

                    <a
                        href="/services/history"
                        class="rounded-xl border border-white px-8 py-4 font-bold text-white hover:bg-white hover:text-emerald-700">

                        Riwayat Pengajuan

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

<?php endif; ?>


<!-- ===================================================== -->
<!-- PENGUMUMAN -->
<!-- ===================================================== -->

<section class="bg-slate-50 py-20">

    <div class="mx-auto max-w-7xl px-6">

        <div class="flex items-center justify-between">

            <div>

                <span
                    class="rounded-full bg-yellow-100 px-4 py-2 font-semibold text-yellow-700">

                    PENGUMUMAN

                </span>

                <h2 class="mt-6 text-4xl font-bold">

                    Informasi Pemerintah

                </h2>

            </div>

            <a
                href="#"
                class="font-semibold text-blue-600">

                Lihat Semua →

            </a>

        </div>

        <div class="mt-12 grid gap-8 md:grid-cols-3">

            <div class="rounded-3xl bg-white p-8 shadow-lg">

                <div class="text-5xl">

                    📢

                </div>

                <h3 class="mt-6 text-2xl font-bold">

                    Pelayanan Libur Nasional

                </h3>

                <p class="mt-4 leading-8 text-slate-600">

                    Seluruh pelayanan MPP mengikuti
                    kalender hari libur nasional.

                </p>

            </div>

            <div class="rounded-3xl bg-white p-8 shadow-lg">

                <div class="text-5xl">

                    🏥

                </div>

                <h3 class="mt-6 text-2xl font-bold">

                    Emergency Tetap Aktif

                </h3>

                <p class="mt-4 leading-8 text-slate-600">

                    Emergency 112 tetap beroperasi
                    selama 24 jam.

                </p>

            </div>

            <div class="rounded-3xl bg-white p-8 shadow-lg">

                <div class="text-5xl">

                    🌐

                </div>

                <h3 class="mt-6 text-2xl font-bold">

                    Integrasi Data SPBE

                </h3>

                <p class="mt-4 leading-8 text-slate-600">

                    Seluruh data pelayanan
                    telah terhubung melalui
                    interoperabilitas SPBE.

                </p>

            </div>

        </div>

    </div>

</section>

<!-- ===================================================== -->
<!-- SMART CITY DASHBOARD -->
<!-- ===================================================== -->

<section class="bg-white py-20">

    <div class="mx-auto max-w-7xl px-6">

        <div class="text-center">

            <span
                class="rounded-full bg-blue-100 px-5 py-2 font-semibold text-blue-700">

                SMART CITY DASHBOARD

            </span>

            <h2 class="mt-6 text-5xl font-bold text-slate-900">

                Monitoring Pelayanan Publik

            </h2>

            <p class="mx-auto mt-5 max-w-3xl text-lg leading-8 text-slate-600">

                Monitoring pelayanan publik Kota Tangerang Selatan
                secara real-time melalui interoperabilitas data.

            </p>

        </div>

        <div class="mt-16 grid gap-8 lg:grid-cols-3">

            <!-- STATUS SISTEM -->

            <div class="rounded-3xl bg-white p-8 shadow-xl border">

                <h3 class="text-2xl font-bold">

                    🟢 Status Sistem

                </h3>

                <div class="mt-8 space-y-5">

                    <div class="flex justify-between">

                        <span>Dukcapil</span>

                        <span class="font-bold text-green-600">

                            ONLINE

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span>OSS / NIB</span>

                        <span class="font-bold text-green-600">

                            ONLINE

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span>NPWP</span>

                        <span class="font-bold text-green-600">

                            ONLINE

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span>Emergency 112</span>

                        <span class="font-bold text-green-600">

                            ONLINE

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span>Gateway API</span>

                        <span class="font-bold text-yellow-500">

                            WARNING

                        </span>

                    </div>

                </div>

            </div>

            <!-- RESPONSE TIME -->

            <div class="rounded-3xl bg-white p-8 shadow-xl border">

                <h3 class="text-2xl font-bold">

                    ⚡ Response Time

                </h3>

                <div class="mt-8 space-y-7">

                    <div>

                        <div class="flex justify-between">

                            <span>Dukcapil</span>

                            <span>0.8 s</span>

                        </div>

                        <div class="mt-2 h-3 rounded-full bg-slate-200">

                            <div class="h-3 w-[92%] rounded-full bg-green-500"></div>

                        </div>

                    </div>

                    <div>

                        <div class="flex justify-between">

                            <span>OSS</span>

                            <span>1.2 s</span>

                        </div>

                        <div class="mt-2 h-3 rounded-full bg-slate-200">

                            <div class="h-3 w-[85%] rounded-full bg-blue-500"></div>

                        </div>

                    </div>

                    <div>

                        <div class="flex justify-between">

                            <span>NPWP</span>

                            <span>1.0 s</span>

                        </div>

                        <div class="mt-2 h-3 rounded-full bg-slate-200">

                            <div class="h-3 w-[90%] rounded-full bg-cyan-500"></div>

                        </div>

                    </div>

                    <div>

                        <div class="flex justify-between">

                            <span>Emergency</span>

                            <span>0.4 s</span>

                        </div>

                        <div class="mt-2 h-3 rounded-full bg-slate-200">

                            <div class="h-3 w-[96%] rounded-full bg-red-500"></div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- NOTIFIKASI -->

            <div class="rounded-3xl bg-white p-8 shadow-xl border">

                <h3 class="text-2xl font-bold">

                    🔔 Notifikasi

                </h3>

                <div class="mt-8 space-y-5">

                    <div class="rounded-xl bg-green-50 p-4">

                        ✅ Dukcapil berhasil sinkron

                    </div>

                    <div class="rounded-xl bg-blue-50 p-4">

                        📄 Pengajuan izin baru diterima

                    </div>

                    <div class="rounded-xl bg-yellow-50 p-4">

                        ⚠ Sinkronisasi OSS selesai

                    </div>

                    <div class="rounded-xl bg-red-50 p-4">

                        🚨 Emergency baru masuk

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- ===================================================== -->
<!-- TELEMETRY SPBE -->
<!-- ===================================================== -->

<section id="telemetry" class="mx-auto max-w-7xl px-6 py-20">

    <div class="rounded-[2rem] bg-slate-900 p-10 text-white shadow-2xl">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">

            <div>

                <span class="rounded-full bg-emerald-500/20 px-4 py-2 text-sm font-semibold text-emerald-300">

                    DASHBOARD TELEMETRY SPBE

                </span>

                <h2 class="mt-6 text-4xl font-bold">

                    Status Integrasi Data Pemerintah

                </h2>

                <p class="mt-5 max-w-3xl text-slate-300">

                    Monitoring konektivitas layanan Dukcapil,
                    OSS, NPWP, Emergency 112,
                    dan Gateway API secara realtime.

                </p>

            </div>

            <div>

                <div class="rounded-full bg-emerald-500/20 px-6 py-3 font-semibold text-emerald-300">

                    ● Traffic Light Monitoring

                </div>

            </div>

        </div>

        <div class="mt-12 grid gap-6 lg:grid-cols-3">

            <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-6">

                <div class="text-lg font-semibold text-emerald-300">

                    🟢 Hijau

                </div>

                <div class="mt-4 text-3xl font-bold">

                    NORMAL

                </div>

                <p class="mt-4 text-slate-300">

                    Seluruh layanan berjalan normal
                    dan sinkronisasi berhasil.

                </p>

            </div>

            <div class="rounded-2xl border border-yellow-500/30 bg-yellow-500/10 p-6">

                <div class="text-lg font-semibold text-yellow-300">

                    🟡 Warning

                </div>

                <div class="mt-4 text-3xl font-bold">

                    LATENCY

                </div>

                <p class="mt-4 text-slate-300">

                    Gateway OSS mengalami
                    keterlambatan respon.

                </p>

            </div>

            <div class="rounded-2xl border border-red-500/30 bg-red-500/10 p-6">

                <div class="text-lg font-semibold text-red-300">

                    🔴 Critical

                </div>

                <div class="mt-4 text-3xl font-bold">

                    OFFLINE

                </div>

                <p class="mt-4 text-slate-300">

                    Tidak ada layanan yang sedang
                    mengalami gangguan.

                </p>

            </div>

        </div>

    </div>

</section>




<?php

$content = ob_get_clean();

include __DIR__ . '/home_layout.blade.php';

?>