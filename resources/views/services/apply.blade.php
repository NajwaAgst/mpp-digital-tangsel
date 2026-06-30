<?php
$title = 'Ajukan ' . $service['name'];
$authUser = $_SESSION['user'] ?? null;
ob_start();
?>
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
  <a href="/services/<?= htmlspecialchars($service['slug']) ?>" class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-emerald-600">← Kembali ke detail layanan</a>
  <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
    <div class="rounded-[2rem] border border-white/70 bg-white/90 p-8 shadow-xl shadow-slate-200/50">
      <div class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700"><?= htmlspecialchars($service['category']) ?></div>
      <h1 class="mt-5 text-3xl font-semibold text-slate-900">Ajukan layanan: <?= htmlspecialchars($service['name']) ?></h1>
      <p class="mt-4 text-lg leading-8 text-slate-600">Silakan lengkapi formulir di samping. Setelah data terkirim, tim MPP akan menindaklanjuti pengajuan Anda.</p>
      <div class="mt-8 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">
        <h2 class="text-lg font-semibold text-slate-900">Berkas yang perlu disiapkan</h2>
        <ul class="mt-4 space-y-3 text-sm text-slate-600">
          <?php foreach ($service['documents'] as $document): ?>
            <li class="flex items-start gap-3"><span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-500"></span><span><?= htmlspecialchars($document) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
    <div class="rounded-[2rem] border border-white/70 bg-slate-900 p-8 text-white shadow-xl shadow-slate-300/30">
      <?php if (!empty($errorMessage)): ?>
        <div class="mb-6 rounded-2xl border border-rose-400/30 bg-rose-500/10 p-4 text-sm text-rose-200">
          <p class="font-semibold">Pengajuan belum tersimpan</p>
          <p class="mt-1"><?= htmlspecialchars($errorMessage) ?></p>
        </div>
      <?php endif; ?>

      <?php if (!empty($submitted)): ?>
        <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4 text-sm text-emerald-200">
          <p class="font-semibold">Pengajuan berhasil diterima</p>
          <p class="mt-1">Terima kasih, <?= htmlspecialchars($submittedData['nama'] ?? 'pemohon') ?>. Permohonan Anda untuk layanan <?= htmlspecialchars($service['name']) ?> telah tersimpan dengan nomor #<?= htmlspecialchars($submissionId ?? '-') ?>.</p>
        </div>
      <?php endif; ?>

      <form method="post" action="/services/<?= htmlspecialchars($service['slug']) ?>/apply" class="space-y-4">
        <div>
          <label class="mb-2 block text-sm font-semibold text-slate-200">Nama Lengkap</label>
          <input name="nama" required class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-white outline-none focus:border-emerald-500" value="<?= htmlspecialchars($submittedData['nama'] ?? '') ?>" />
        </div>
        <div class="grid gap-4 md:grid-cols-2">
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-200">NIK</label>
            <input name="nik" required class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-white outline-none focus:border-emerald-500" value="<?= htmlspecialchars($submittedData['nik'] ?? '') ?>" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-200">Nomor HP</label>
            <input name="hp" required class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-white outline-none focus:border-emerald-500" value="<?= htmlspecialchars($submittedData['hp'] ?? '') ?>" />
          </div>
        </div>
        <div>
          <label class="mb-2 block text-sm font-semibold text-slate-200">Alamat</label>
          <textarea name="alamat" rows="3" required class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-white outline-none focus:border-emerald-500"><?= htmlspecialchars($submittedData['alamat'] ?? '') ?></textarea>
        </div>
        <div>
          <label class="mb-2 block text-sm font-semibold text-slate-200">Keterangan Tambahan</label>
          <textarea name="keterangan" rows="4" class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-sm text-white outline-none focus:border-emerald-500"><?= htmlspecialchars($submittedData['keterangan'] ?? '') ?></textarea>
        </div>
        <div class="rounded-2xl border border-slate-700 bg-slate-800/80 p-4 text-sm text-slate-300">
          <p class="font-semibold text-white">Catatan</p>
          <p class="mt-1">Pastikan semua dokumen yang diminta sudah Anda siapkan sebelum mengirimkan formulir.</p>
        </div>
        <button type="submit" class="inline-flex rounded-full bg-emerald-500 px-6 py-3 font-semibold text-white transition hover:bg-emerald-400">Kirim Pengajuan</button>
      </form>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.blade.php';
?>
