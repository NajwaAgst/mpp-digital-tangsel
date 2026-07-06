<?php
$title = 'Mall Pelayanan Publik (MPP) Kota Tangerang Selatan';
$authUser = $_SESSION['user'] ?? null;
ob_start();
?>
<section class="relative overflow-hidden">

    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-600"></div>

    <div class="absolute inset-0 opacity-10"
        style="background-image:
        radial-gradient(circle,#ffffff 1px,transparent 1px);
        background-size:30px 30px;"></div>

    <div class="relative mx-auto max-w-7xl px-6 py-20">

        <div class="text-center text-white">

            <span
                class="inline-flex items-center rounded-full bg-white/20 px-5 py-2 text-sm font-semibold">

                🔵 Portal Pelayanan Terpadu

            </span>

            <h1 class="mt-8 text-6xl font-extrabold">

                Pelayanan Publik

                <br>

                <span class="text-yellow-300">

                    Kota Tangerang Selatan

                </span>

            </h1>

            <p class="mx-auto mt-8 max-w-3xl text-xl leading-9 text-blue-100">

                Temukan seluruh layanan Pemerintah Kota Tangerang Selatan
                mulai dari administrasi, perizinan, hingga layanan
                tanggap darurat Emergency 112 dalam satu portal digital.

            </p>

        </div>

    </div>

</section>

<section class="bg-white py-20">

<div class="mx-auto max-w-7xl px-6">

<div class="text-center">

<span class="rounded-full bg-emerald-100 px-5 py-2 font-semibold text-emerald-700">

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

<div class="mt-16 grid gap-10 lg:grid-cols-2">

<!-- ================= MPP ================= -->

<div
class="overflow-hidden rounded-[32px] bg-white shadow-xl border hover:-translate-y-2 transition">

<div
class="bg-gradient-to-r from-emerald-700 to-emerald-500 p-10 text-white">

<div class="text-7xl">

🏛️

</div>

<h3 class="mt-6 text-4xl font-bold">

Mall Pelayanan Publik

</h3>

<p class="mt-4 text-lg text-emerald-100">

Seluruh layanan administrasi pemerintah
secara online dalam satu platform.

</p>

</div>

<div class="p-8">

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
class="mt-10 block rounded-xl bg-emerald-600 py-4 text-center text-lg font-bold text-white hover:bg-emerald-700">

Masuk ke MPP

</a>

</div>

</div>

<!-- ================= EMERGENCY ================= -->

<div
class="overflow-hidden rounded-[32px] bg-white shadow-xl border hover:-translate-y-2 transition">

<div
class="bg-gradient-to-r from-red-600 to-red-500 p-10 text-white">

<div class="text-7xl">

🚨

</div>

<h3 class="mt-6 text-4xl font-bold">

Emergency 112

</h3>

<p class="mt-4 text-lg text-red-100">

Layanan tanggap darurat terpadu
24 jam untuk masyarakat.

</p>

</div>

<div class="p-8">

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
kecelakaan, kriminalitas,
bencana alam,
dan kondisi darurat lainnya.

</p>

<a
href="/emergency"
class="mt-10 block rounded-xl bg-red-600 py-4 text-center text-lg font-bold text-white hover:bg-red-700">

Masuk Emergency 112

</a>

</div>

</div>

</div>

</div>

</section>



<section class="bg-slate-100 py-20">

    <div class="mx-auto max-w-7xl px-6">

        <div class="text-center">

            <span class="rounded-full bg-indigo-100 px-5 py-2 text-indigo-700 font-semibold">

                DASHBOARD

            </span>

            <h2 class="mt-5 text-4xl font-bold">

                Statistik Pelayanan Publik

            </h2>

            <p class="mt-4 text-slate-600">

                Monitoring layanan publik secara real-time.

            </p>

        </div>

        <div class="mt-14 grid gap-8 md:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-3xl bg-white shadow-lg p-8">

                <div class="text-5xl">

                    🏛️

                </div>

                <div class="mt-5 text-5xl font-bold text-emerald-600">

                    <?= count($services) ?>

                </div>

                <div class="mt-2 text-slate-600">

                    Layanan MPP

                </div>

            </div>

            <div class="rounded-3xl bg-white shadow-lg p-8">

                <div class="text-5xl">

                    📑

                </div>

                <div class="mt-5 text-5xl font-bold text-blue-600">

                    <?= $stats[0]['value'] ?? '0' ?>

                </div>

                <div class="mt-2 text-slate-600">

                    Total Pengajuan

                </div>

            </div>

            <div class="rounded-3xl bg-white shadow-lg p-8">

                <div class="text-5xl">

                    👨‍👩‍👧

                </div>

                <div class="mt-5 text-5xl font-bold text-violet-600">

                    <?= $stats[1]['value'] ?? '0' ?>

                </div>

                <div class="mt-2 text-slate-600">

                    Pengguna

                </div>

            </div>

            <div class="rounded-3xl bg-white shadow-lg p-8">

                <div class="text-5xl">

                    🚨

                </div>

                <div class="mt-5 text-5xl font-bold text-red-600">

                    24 Jam

                </div>

                <div class="mt-2 text-slate-600">

                    Emergency 112

                </div>

            </div>

        </div>

    </div>

</section>

<section class="bg-slate-50 py-20">

<div class="mx-auto max-w-7xl px-6">

<div class="flex justify-between items-center">

<div>

<span class="rounded-full bg-yellow-100 px-4 py-2 font-semibold text-yellow-700">

PENGUMUMAN

</span>

<h2 class="mt-5 text-4xl font-bold">

Informasi Pemerintah

</h2>

</div>

<a href="#"
class="text-blue-600 font-semibold">

Lihat Semua →

</a>

</div>

<div class="mt-10 grid md:grid-cols-3 gap-8">

<div class="bg-white rounded-3xl shadow-lg p-8">

<div class="text-5xl">

📢

</div>

<h3 class="mt-5 text-2xl font-bold">

Pelayanan Libur Nasional

</h3>

<p class="mt-4 text-slate-600">

Seluruh pelayanan MPP tutup pada tanggal merah.

</p>

</div>

<div class="bg-white rounded-3xl shadow-lg p-8">

<div class="text-5xl">

🏥

</div>

<h3 class="mt-5 text-2xl font-bold">

Emergency Tetap Aktif

</h3>

<p class="mt-4 text-slate-600">

Layanan 112 tetap beroperasi selama 24 jam.

</p>

</div>

<div class="bg-white rounded-3xl shadow-lg p-8">

<div class="text-5xl">

🌐

</div>

<h3 class="mt-5 text-2xl font-bold">

Integrasi Data

</h3>

<p class="mt-4 text-slate-600">

Seluruh data telah terhubung melalui SPBE.

</p>

</div>

</div>

</div>

</section>

<section class="bg-slate-50 py-20">

<div class="mx-auto max-w-7xl px-6">

<div class="text-center">

<span class="rounded-full bg-blue-100 px-5 py-2 font-semibold text-blue-700">

SMART CITY DASHBOARD

</span>

<h2 class="mt-6 text-5xl font-bold text-slate-900">

Monitoring Pelayanan Publik

</h2>

<p class="mt-5 text-lg text-slate-600">

Monitoring pelayanan publik Kota Tangerang Selatan
secara real-time melalui interoperabilitas data.

</p>

</div>



<div class="mt-16 grid lg:grid-cols-3 gap-8">



<!-- STATUS SERVER -->

<div class="rounded-3xl bg-white shadow-xl p-8">

<h3 class="text-2xl font-bold">

🟢 Status Sistem

</h3>

<div class="mt-8 space-y-4">

<div class="flex justify-between">

<span>Dukcapil</span>

<span class="text-green-600 font-bold">

ONLINE

</span>

</div>

<div class="flex justify-between">

<span>OSS / NIB</span>

<span class="text-green-600 font-bold">

ONLINE

</span>

</div>

<div class="flex justify-between">

<span>Emergency 112</span>

<span class="text-green-600 font-bold">

ONLINE

</span>

</div>

<div class="flex justify-between">

<span>Database MPP</span>

<span class="text-green-600 font-bold">

NORMAL

</span>

</div>

<div class="flex justify-between">

<span>Gateway API</span>

<span class="text-yellow-500 font-bold">

WARNING

</span>

</div>

</div>

</div>



<!-- RESPONSE -->

<div class="rounded-3xl bg-white shadow-xl p-8">

<h3 class="text-2xl font-bold">

⚡ Response Time

</h3>

<div class="mt-8 space-y-6">

<div>

<div class="flex justify-between">

<span>Dukcapil</span>

<span>0.8 s</span>

</div>

<div class="mt-2 h-3 rounded-full bg-slate-200">

<div class="h-3 rounded-full bg-green-500 w-[90%]">

</div>

</div>

</div>

<div>

<div class="flex justify-between">

<span>OSS</span>

<span>1.1 s</span>

</div>

<div class="mt-2 h-3 rounded-full bg-slate-200">

<div class="h-3 rounded-full bg-blue-500 w-[85%]">

</div>

</div>

</div>

<div>

<div class="flex justify-between">

<span>Emergency</span>

<span>0.4 s</span>

</div>

<div class="mt-2 h-3 rounded-full bg-slate-200">

<div class="h-3 rounded-full bg-red-500 w-[95%]">

</div>

</div>

</div>

</div>

</div>



<!-- NOTIFICATION -->

<div class="rounded-3xl bg-white shadow-xl p-8">

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

<div class="rounded-xl bg-red-50 p-4">

🚨 Emergency baru masuk

</div>

<div class="rounded-xl bg-yellow-50 p-4">

⚠ API OSS mengalami latency

</div>

</div>

</div>



</div>

</div>

</section>

<section id="telemetry" class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
  <div class="rounded-[2rem] border border-white/70 bg-slate-900 px-6 py-8 text-white shadow-2xl shadow-slate-800/20 md:px-8">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
      <div>
        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-emerald-400">Dashboard Telemetry SPBE</p>
        <h2 class="mt-2 text-3xl font-semibold">Status integrasi data berjalan aman</h2>
      </div>
      <div class="rounded-full border border-emerald-400/30 bg-emerald-500/10 px-4 py-2 text-sm font-semibold text-emerald-300">Traffic Light System</div>
    </div>
    <div class="mt-8 grid gap-4 md:grid-cols-3">
      <div class="rounded-2xl border border-emerald-400/20 bg-emerald-500/10 p-5">
        <p class="text-sm text-emerald-300">Hijau</p>
        <p class="mt-2 text-2xl font-semibold">Normal</p>
        <p class="mt-2 text-sm text-slate-300">Dukcapil & Kemenkes respons stabil</p>
      </div>
      <div class="rounded-2xl border border-amber-400/20 bg-amber-500/10 p-5">
        <p class="text-sm text-amber-300">Kuning</p>
        <p class="mt-2 text-2xl font-semibold">Warning</p>
        <p class="mt-2 text-sm text-slate-300">Latensi respons 4 detik untuk simulasi lambat</p>
      </div>
      <div class="rounded-2xl border border-rose-400/20 bg-rose-500/10 p-5">
        <p class="text-sm text-rose-300">Merah</p>
        <p class="mt-2 text-2xl font-semibold">Kritis</p>
        <p class="mt-2 text-sm text-slate-300">Data tidak ditemukan atau gateway timeout</p>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/home_layout.blade.php';
?>
