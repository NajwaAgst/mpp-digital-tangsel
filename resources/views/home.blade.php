<?php
$title = 'Mall Pelayanan Publik (MPP) Kota Tangerang Selatan';
$authUser = $_SESSION['user'] ?? null;
ob_start();
?>
<section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-20">
  <div class="grid items-center gap-10 lg:grid-cols-[1.1fr_0.9fr]">
    <div>
      <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700">
        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
        Portal layanan publik digital terpadu
      </div>
      <h1 class="text-4xl font-semibold leading-tight text-slate-900 sm:text-5xl lg:text-6xl">
        Layanan publik cepat, aman, dan terintegrasi untuk warga Tangsel.
      </h1>
      <p class="mt-5 max-w-2xl text-lg text-slate-600">
        Mall Pelayanan Publik (MPP) menghadirkan satu pintu layanan publik modern untuk izin, administrasi, dan pengurusan profesi dengan interoperabilitas data antar instansi.
      </p>
      <div class="mt-8 flex flex-wrap gap-4">
        <a href="/services" class="rounded-full bg-emerald-600 px-6 py-3 font-semibold text-white shadow-lg shadow-emerald-600/25 transition hover:bg-emerald-700">Jelajahi Layanan MPP</a>
        <a href="/services" class="rounded-full border border-slate-300 bg-white px-6 py-3 font-semibold text-slate-700 transition hover:border-emerald-500 hover:text-emerald-600">Lihat Katalog Layanan</a>
      </div>
      <div class="mt-10 grid gap-4 sm:grid-cols-3">
        <?php foreach ($stats as $stat): ?>
          <div class="rounded-2xl border border-white/70 bg-white/80 p-4 shadow-sm backdrop-blur">
            <p class="text-2xl font-semibold text-slate-900"><?= htmlspecialchars($stat['value']) ?></p>
            <p class="text-sm font-medium text-slate-600"><?= htmlspecialchars($stat['label']) ?></p>
            <p class="text-xs text-slate-400"><?= htmlspecialchars($stat['detail']) ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="rounded-[2rem] border border-white/70 bg-white/80 p-6 shadow-2xl shadow-emerald-100 backdrop-blur">
      <div class="rounded-[1.5rem] bg-gradient-to-br from-emerald-500 via-teal-500 to-violet-600 p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-semibold uppercase tracking-[0.24em] text-emerald-100">Status Integrasi</p>
            <h2 class="mt-2 text-2xl font-semibold">Interoperabilitas aktif</h2>
          </div>
          <div class="rounded-full border border-white/30 bg-white/20 px-3 py-1 text-sm">Live demo</div>
        </div>
        <div class="mt-8 grid gap-3">
          <div class="rounded-2xl border border-white/20 bg-slate-950/20 p-4">
            <p class="text-sm text-emerald-50">Dukcapil</p>
            <p class="mt-1 text-xl font-semibold">Autofill identitas terverifikasi</p>
          </div>
          <div class="rounded-2xl border border-white/20 bg-slate-950/20 p-4">
            <p class="text-sm text-emerald-50">Kemenkes</p>
            <p class="mt-1 text-xl font-semibold">Dokumen profesi & STR otomatis</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
  <div class="mb-8 flex items-end justify-between">
    <div>
      <p class="text-sm font-semibold uppercase tracking-[0.28em] text-emerald-600">Layanan yang sering dikunjungi</p>
      <h2 class="text-3xl font-semibold text-slate-900">Portal multi-layanan yang terhubung</h2>
    </div>
    <a href="/services" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">Lihat semua layanan</a>
  </div>
  <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
    <?php foreach ($services as $service): ?>
      <article class="group rounded-[1.75rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/50 backdrop-blur transition hover:-translate-y-1 hover:shadow-xl">
        <div class="flex items-center justify-between">
          <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-slate-500"><?= htmlspecialchars($service['category']) ?></span>
          <span class="h-10 w-10 rounded-2xl bg-gradient-to-br <?= htmlspecialchars($service['accent']) ?>"></span>
        </div>
        <h3 class="mt-5 text-xl font-semibold text-slate-900"><?= htmlspecialchars($service['name']) ?></h3>
        <p class="mt-3 text-sm leading-6 text-slate-600"><?= htmlspecialchars($service['summary']) ?></p>
        <div class="mt-6 flex items-center justify-between">
          <a href="/services/<?= htmlspecialchars($service['slug']) ?>" class="text-sm font-semibold text-emerald-600">Lihat Detail</a>
          <span class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Tersedia</span>
        </div>
      </article>
    <?php endforeach; ?>
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
include __DIR__ . '/layout.blade.php';
?>
