<?php
$title = 'Form Pendaftaran SIP Dokter';
$authUser = $_SESSION['user'] ?? null;
ob_start();
?>
<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
  <a href="/services/sip-dokter" class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-emerald-600">← Kembali ke detail layanan</a>
  <div class="mb-8">
    <p class="text-sm font-semibold uppercase tracking-[0.28em] text-emerald-600">Use case utama</p>
    <h1 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">Pendaftaran Surat Izin Praktik (SIP) Dokter</h1>
    <p class="mt-3 max-w-3xl text-lg text-slate-600">Alur end-to-end yang menggabungkan login, autofill data dukcapil, validasi kemenkes, preview dokumen digital, dan telemetry SPBE.</p>
  </div>

  <?php if (empty($isLoggedIn)): ?>
    <div class="rounded-[2rem] border border-amber-200 bg-amber-50 p-6 text-amber-800 shadow-lg">
      <p class="text-lg font-semibold">Anda harus login/register terlebih dahulu untuk melanjutkan.</p>
      <p class="mt-2 text-sm">Silakan buka modal login/register dari navbar untuk mengakses formulir pendaftaran.</p>
    </div>
  <?php else: ?>
    <div class="grid gap-8 xl:grid-cols-[1.05fr_0.95fr]">
      <form id="sipForm" class="rounded-[2rem] border border-white/70 bg-white/90 p-6 shadow-xl shadow-slate-200/50 backdrop-blur lg:p-8">
        <div class="grid gap-6 md:grid-cols-2">
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">NIK</label>
            <input id="nik" name="nik" value="3674011111110001" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-0" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Lengkap</label>
            <input id="nama" name="nama" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-0" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Alamat</label>
            <input id="alamat" name="alamat" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-0" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Tempat Lahir</label>
            <input id="tempat_lahir" name="tempat_lahir" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-0" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Tanggal Lahir</label>
            <input id="tanggal_lahir" name="tanggal_lahir" type="date" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-0" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Jenis Kelamin</label>
            <input id="jenis_kelamin" name="jenis_kelamin" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-0" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Nomor STR / SIP Dokter</label>
            <input id="str" name="str" value="STR-001" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-0" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Spesialisasi</label>
            <input id="spesialisasi" name="spesialisasi" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-0" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Masa Berlaku STR</label>
            <input id="masa_berlaku" name="masa_berlaku" type="date" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-0" />
          </div>
          <div>
            <label class="mb-2 block text-sm font-semibold text-slate-700">Asal Universitas</label>
            <input id="asal_universitas" name="asal_universitas" class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none ring-0" />
          </div>
        </div>
        <div class="mt-6 flex items-center justify-between rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
          <div>
            <p class="text-sm font-semibold text-emerald-800">Status validasi data</p>
            <p id="validationStatus" class="text-sm text-emerald-700">Menunggu validasi interoperabilitas...</p>
          </div>
          <button type="submit" class="rounded-full bg-emerald-600 px-6 py-3 font-semibold text-white shadow-lg shadow-emerald-600/20 hover:bg-emerald-700">Ajukan Permohonan</button>
        </div>
      </form>

      <div class="space-y-6">
        <div class="rounded-[2rem] border border-white/70 bg-white/90 p-6 shadow-xl shadow-slate-200/50 backdrop-blur">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-semibold uppercase tracking-[0.28em] text-violet-600">Dokumen Digital</p>
              <h2 class="mt-2 text-2xl font-semibold text-slate-900">Preview STR otomatis</h2>
            </div>
            <div id="documentBadge" class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-600">Belum tersedia</div>
          </div>
          <div id="documentPreview" class="mt-6 rounded-[1.5rem] border border-dashed border-slate-200 bg-slate-50 p-5">
            <p class="text-sm text-slate-500">Dokumen digital akan tampil setelah validasi Kemenkes berhasil.</p>
          </div>
        </div>

        <div id="telemetryPanel" class="rounded-[2rem] border border-white/70 bg-slate-900 p-6 text-white shadow-xl shadow-slate-300/30">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-sm font-semibold uppercase tracking-[0.28em] text-emerald-400">Telemetri SPBE</p>
              <h2 class="mt-2 text-2xl font-semibold">Status interoperabilitas</h2>
            </div>
            <div id="telemetryStatus" class="rounded-full border border-slate-700 bg-slate-800 px-3 py-1 text-sm font-semibold text-slate-200">Menunggu</div>
          </div>
          <div class="mt-6 grid gap-3">
            <div class="rounded-2xl border border-slate-700 bg-slate-800/80 p-4">
              <p class="text-sm text-slate-400">Sumber Terakhir</p>
              <p id="telemetrySource" class="mt-1 text-lg font-semibold">-</p>
            </div>
            <div class="rounded-2xl border border-slate-700 bg-slate-800/80 p-4">
              <p class="text-sm text-slate-400">Response Time</p>
              <p id="telemetryResponse" class="mt-1 text-lg font-semibold">- ms</p>
            </div>
            <div class="rounded-2xl border border-slate-700 bg-slate-800/80 p-4">
              <p class="text-sm text-slate-400">Timestamp</p>
              <p id="telemetryTimestamp" class="mt-1 text-lg font-semibold">-</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../../layout.blade.php';
?>
