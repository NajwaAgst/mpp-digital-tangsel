<?php
$title = $service['name'];
$authUser = $_SESSION['user'] ?? null;

$applyUrl = '/services/' . rawurlencode($service['slug']) . '/apply';

/**
 * Catatan per layanan
 * Karena di tabel services sekarang belum ada kolom "notes",
 * catatan ditentukan berdasarkan slug layanan.
 */
$serviceNotesMap = [
    'adminduk' => 'Pastikan seluruh data identitas sesuai dengan database kependudukan. Jika ada perubahan data, siapkan dokumen pendukung agar proses verifikasi berjalan lebih cepat.',
    'perizinan-berusaha' => 'Jenis persyaratan dapat berbeda tergantung izin yang diajukan. Pastikan data usaha, alamat usaha, dan dokumen legalitas sudah sesuai sebelum mengajukan.',
    'perpajakan' => 'Besaran tagihan, objek pajak, dan dokumen pendukung mengikuti jenis layanan perpajakan yang dipilih. Pastikan nomor objek pajak atau data wajib pajak sudah benar.',
    'ketenagakerjaan-jaminan-sosial' => 'Untuk layanan AK-1, BPJS Kesehatan, maupun BPJS Ketenagakerjaan, pastikan data pendidikan, riwayat kerja, atau data kepesertaan diisi dengan benar.',
    'pertanahan' => 'Pastikan data bidang tanah, nama pemilik, dan dokumen alas hak sudah sesuai. Untuk balik nama atau pendaftaran tanah, petugas dapat meminta dokumen tambahan.',
    'kepolisian' => 'Layanan seperti SKCK atau perpanjangan SIM dapat memiliki syarat tambahan sesuai kebijakan instansi terkait. Pastikan identitas dan dokumen asli sesuai.',
    'imigrasi' => 'Nama, NIK, dan dokumen identitas harus konsisten. Untuk layanan terkait PMI atau paspor, dokumen tambahan dapat disesuaikan dengan tujuan pengajuan.',
    'perbankan' => 'Nomor tagihan, data kendaraan, atau kode pembayaran harus dipastikan benar sebelum transaksi dilakukan agar proses pembayaran berjalan lancar.',
];

$serviceNote = $serviceNotesMap[$service['slug']]
    ?? 'Pastikan semua dokumen sudah lengkap dan data yang diisi benar agar proses verifikasi berjalan lebih cepat.';

ob_start();
?>

<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
  <!-- Back -->
  <a
    href="/services"
    class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 transition hover:text-emerald-700"
  >
    ← Kembali ke daftar layanan
  </a>

  <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
    <!-- LEFT PANEL -->
    <section class="rounded-[2rem] border border-white/70 bg-white/90 p-8 shadow-xl shadow-slate-200/50">
      <div class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">
        <?= htmlspecialchars($service['category']) ?>
      </div>

      <h1 class="mt-5 text-3xl font-semibold text-slate-900">
        <?= htmlspecialchars($service['name']) ?>
      </h1>

      <p class="mt-4 text-lg leading-8 text-slate-600">
        <?= htmlspecialchars($service['description']) ?>
      </p>

      <div class="mt-8 grid gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
          <p class="text-sm font-semibold text-slate-500">Instansi Pengampu</p>
          <p class="mt-2 text-base font-semibold text-slate-800">
            <?= htmlspecialchars($service['institution']) ?>
          </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
          <p class="text-sm font-semibold text-slate-500">Estimasi Waktu</p>
          <p class="mt-2 text-base font-semibold text-slate-800">
            <?= htmlspecialchars($service['duration']) ?>
          </p>
        </div>
      </div>

      <div class="mt-8">
        <h2 class="text-lg font-semibold text-slate-900">Alur Pengajuan</h2>

        <ol class="mt-4 space-y-3 text-sm text-slate-600">
          <?php foreach (($service['steps'] ?? []) as $step): ?>
            <li class="flex items-start gap-3">
              <span class="mt-1.5 h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
              <span><?= htmlspecialchars($step) ?></span>
            </li>
          <?php endforeach; ?>
        </ol>
      </div>
    </section>

    <!-- RIGHT PANEL -->
    <aside class="rounded-[2rem] border border-white/70 bg-slate-900 p-8 text-white shadow-xl shadow-slate-300/30">
      <p class="text-sm font-semibold uppercase tracking-[0.28em] text-emerald-400">
        Siapa yang bisa mengajukan
      </p>

      <h2 class="mt-3 text-2xl font-semibold">
        <?= htmlspecialchars($service['who']) ?>
      </h2>

      <div class="mt-8">
        <h3 class="text-lg font-semibold">Persyaratan Dokumen</h3>

        <ul class="mt-4 space-y-3 text-sm text-slate-300">
          <?php foreach (($service['documents'] ?? []) as $document): ?>
            <li class="flex items-start gap-3">
              <span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
              <span><?= htmlspecialchars($document) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="mt-8 rounded-2xl border border-white/10 bg-white/5 p-5">
        <p class="text-sm font-semibold text-emerald-300">Catatan</p>
        <p class="mt-2 text-sm leading-7 text-slate-300">
          <?= htmlspecialchars($serviceNote) ?>
        </p>
      </div>

      <div class="mt-8 flex flex-wrap gap-3">
        <?php if (!empty($authUser)): ?>
          <a
            href="<?= htmlspecialchars($applyUrl) ?>"
            class="inline-flex rounded-full bg-emerald-500 px-6 py-3 font-semibold text-white transition hover:bg-emerald-400"
          >
            Ajukan Sekarang
          </a>
        <?php else: ?>
          <a
            href="/login?redirect=<?= urlencode($applyUrl) ?>"
            class="inline-flex rounded-full bg-emerald-500 px-6 py-3 font-semibold text-white transition hover:bg-emerald-400"
          >
            Ajukan Sekarang
          </a>
        <?php endif; ?>

        <a
          href="/services"
          class="inline-flex rounded-full border border-white/20 px-6 py-3 font-semibold text-white/90 transition hover:bg-white/10"
        >
          Lihat Layanan Lain
        </a>
      </div>
    </aside>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.blade.php';
?>