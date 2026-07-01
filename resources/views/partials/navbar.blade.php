<?php $authUser = $authUser ?? null; ?>

<nav class="sticky top-0 z-40 border-b border-white/70 bg-white/80 backdrop-blur-xl">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">

    <a href="/" class="flex items-center gap-3">
      <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-violet-600 text-lg font-semibold text-white shadow-lg">
        <?php
          $logoCandidates = [
            __DIR__ . '/../../public/assets/mpp-logo.png',
            __DIR__ . '/../../public/assets/mpp-logo.jpg',
            __DIR__ . '/../../public/assets/mpp-logo.jpeg',
            __DIR__ . '/../../public/assets/mpp-logo.webp',
            __DIR__ . '/../../public/assets/mpp-logo.svg',
          ];

          $logoPath = null;

          foreach ($logoCandidates as $candidate) {
              if (file_exists($candidate)) {
                  $logoPath = $candidate;
                  break;
              }
          }
        ?>

        <?php if ($logoPath): ?>
          <img src="/assets/<?= basename($logoPath) ?>" alt="Logo MPP" class="h-full w-full object-cover">
        <?php else: ?>
          <span>MPP</span>
        <?php endif; ?>
      </div>

      <div>
        <p class="text-sm font-semibold text-slate-900">
          Mall Pelayanan Publik (MPP)
        </p>
        <p class="text-xs text-slate-500">
          Kota Tangerang Selatan
        </p>
      </div>
    </a>

    <div class="hidden items-center gap-6 lg:flex">
      <a href="/" class="text-sm font-medium text-slate-600 hover:text-emerald-600">
        Beranda
      </a>

      <a href="/services" class="text-sm font-medium text-slate-600 hover:text-emerald-600">
        Layanan
      </a>

      <a href="#telemetry" class="text-sm font-medium text-slate-600 hover:text-emerald-600">
        Telemetry
      </a>
    </div>

    <div class="flex items-center gap-3">

      <label class="hidden items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-500 md:flex">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none">
          <path d="M21 21L16.65 16.65" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          <circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="2"/>
        </svg>

        <input
          class="w-28 bg-transparent outline-none"
          placeholder="Cari layanan">
      </label>

      <?php if (!empty($authUser)): ?>

        <div class="flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-2">

          <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-600 text-sm font-semibold text-white">
            <?= htmlspecialchars(strtoupper(substr($authUser['name'] ?? 'U', 0, 1))) ?>
          </div>

          <div class="hidden text-left sm:block">
            <p class="text-sm font-semibold text-slate-800">
              <?= htmlspecialchars($authUser['name']) ?>
            </p>
          </div>

        </div>

        <form action="/auth/logout" method="POST" class="inline">
          <button
            type="submit"
            class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 transition">
            Keluar
          </button>
        </form>

      <?php else: ?>

        <a
          href="/login"
          class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 transition">
          Login / Register
        </a>

      <?php endif; ?>

    </div>

  </div>

</nav>