<?php
$title = 'Daftar Layanan MPP';
$authUser = $_SESSION['user'] ?? null;
ob_start();
?>

<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="mb-8">
    <p class="text-sm font-semibold uppercase tracking-[0.28em] text-emerald-600">Katalog layanan</p>
    <h1 class="mt-3 text-3xl font-semibold text-slate-900 sm:text-4xl">Seluruh layanan MPP dalam satu portal</h1>
    <p class="mt-3 max-w-3xl text-lg text-slate-600">
      Portal MPP Digital menyatukan layanan administrasi kependudukan, perizinan, perpajakan, ketenagakerjaan,
      pertanahan, hukum, imigrasi, dan jasa keuangan dalam satu pengalaman layanan publik yang modern, cepat, dan terintegrasi.
    </p>
  </div>

  <!-- Search -->
  <div class="mb-6 rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm">
    <label for="service-search" class="mb-2 block text-sm font-semibold text-slate-700">Cari layanan</label>
    <input
      id="service-search"
      type="text"
      placeholder="Contoh: e-KTP, pajak, SIM, BPJS, paspor..."
      class="w-full rounded-full border border-slate-300 px-4 py-3 text-sm outline-none ring-0 focus:border-emerald-500"
    />
  </div>

  <!-- Filter kategori -->
  <div class="mb-8 flex flex-wrap gap-3">
    <button
      type="button"
      class="filter-btn rounded-full border border-emerald-600 bg-emerald-600 px-4 py-2 text-sm font-semibold text-white"
      data-filter="all"
    >
      Semua
    </button>

    <?php
      $categories = array_unique(array_column($services, 'category'));
      foreach ($categories as $category):
    ?>
      <button
        type="button"
        class="filter-btn rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:border-emerald-500 hover:text-emerald-600"
        data-filter="<?= htmlspecialchars($category) ?>"
      >
        <?= htmlspecialchars($category) ?>
      </button>
    <?php endforeach; ?>
  </div>

  <!-- Grid layanan -->
  <div id="service-grid" class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
    <?php foreach ($services as $service): ?>
      <?php
        $detailUrl = '/services/' . rawurlencode($service['slug']);
        $applyUrl  = '/services/' . rawurlencode($service['slug']) . '/apply';
      ?>

      <article
        class="service-card flex flex-col rounded-[1.75rem] border border-white/70 bg-white/80 p-6 shadow-lg shadow-slate-200/40 backdrop-blur transition hover:-translate-y-1 hover:shadow-xl"
        data-category="<?= htmlspecialchars($service['category']) ?>"
        data-name="<?= htmlspecialchars(strtolower($service['name'])) ?>"
        data-summary="<?= htmlspecialchars(strtolower($service['summary'])) ?>"
      >
        <div class="flex items-center justify-between">
          <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">
            <?= htmlspecialchars($service['category']) ?>
          </span>
          <span class="h-10 w-10 rounded-2xl bg-gradient-to-br <?= htmlspecialchars($service['accent']) ?>"></span>
        </div>

        <h2 class="mt-5 text-xl font-semibold text-slate-900">
          <?= htmlspecialchars($service['name']) ?>
        </h2>

        <p class="mt-3 flex-1 text-sm leading-6 text-slate-600">
          <?= htmlspecialchars($service['summary']) ?>
        </p>

        <div class="mt-6 flex items-center justify-between gap-3">
          <!-- FIXED: detail route -->
          <a
            href="<?= htmlspecialchars($detailUrl) ?>"
            class="text-sm font-semibold text-emerald-600 hover:text-emerald-700"
          >
            Lihat Detail
          </a>

          <!-- FIXED: apply route -->
          <a
            href="<?= htmlspecialchars($applyUrl) ?>"
            class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
          >
            Ajukan
          </a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <!-- Empty state -->
  <div id="empty-state" class="mt-10 hidden rounded-[2rem] border border-dashed border-slate-300 bg-white/70 p-10 text-center shadow-sm">
    <p class="text-lg font-semibold text-slate-800">Layanan tidak ditemukan</p>
    <p class="mt-2 text-sm text-slate-500">
      Coba gunakan kata kunci lain seperti
      <span class="font-medium">KTP</span>,
      <span class="font-medium">BPJS</span>,
      <span class="font-medium">Paspor</span>,
      atau
      <span class="font-medium">Pajak</span>.
    </p>
  </div>
</div>

<?php
$content = ob_get_clean();
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const buttons = document.querySelectorAll('.filter-btn');
  const cards = document.querySelectorAll('.service-card');
  const searchInput = document.getElementById('service-search');
  const emptyState = document.getElementById('empty-state');

  let activeFilter = 'all';

  function applyFilters() {
    const query = (searchInput.value || '').toLowerCase().trim();
    let visibleCount = 0;

    cards.forEach((card) => {
      const category = card.getAttribute('data-category') || '';
      const name = card.getAttribute('data-name') || '';
      const summary = card.getAttribute('data-summary') || '';

      const matchesCategory = activeFilter === 'all' || category === activeFilter;
      const matchesQuery = !query || name.includes(query) || summary.includes(query);

      if (matchesCategory && matchesQuery) {
        card.classList.remove('hidden');
        visibleCount++;
      } else {
        card.classList.add('hidden');
      }
    });

    if (visibleCount === 0) {
      emptyState.classList.remove('hidden');
    } else {
      emptyState.classList.add('hidden');
    }
  }

  buttons.forEach((button) => {
    button.addEventListener('click', function () {
      activeFilter = this.getAttribute('data-filter');

      buttons.forEach((btn) => {
        btn.classList.remove('border-emerald-600', 'bg-emerald-600', 'text-white');
        btn.classList.add('border-slate-200', 'bg-white', 'text-slate-700');
      });

      this.classList.remove('border-slate-200', 'bg-white', 'text-slate-700');
      this.classList.add('border-emerald-600', 'bg-emerald-600', 'text-white');

      applyFilters();
    });
  });

  if (searchInput) {
    searchInput.addEventListener('input', applyFilters);
  }
});
</script>

<?php include __DIR__ . '/../layout.blade.php'; ?>