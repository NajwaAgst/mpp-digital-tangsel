<!-- ========================================= -->
<!-- Data Interoperabilitas -->
<!-- ========================================= -->

<div class="rounded-2xl border border-emerald-500 bg-emerald-500/10 p-5">

    <h3 class="text-lg font-semibold text-emerald-300">
        <?= htmlspecialchars($form['title']) ?>
    </h3>

    <div class="mt-5 grid gap-4">

        <div>

            <label class="mb-2 block text-sm font-semibold">
                Nama
            </label>

            <input
                id="nama"
                name="nama"
                readonly
                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

        </div>

        <div>

            <label class="mb-2 block text-sm font-semibold">
                Alamat
            </label>

            <textarea
                id="alamat"
                name="alamat"
                rows="3"
                readonly
                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white"></textarea>

        </div>

    </div>

</div>

<!-- ========================================= -->
<!-- Data Pembayaran Tilang -->
<!-- ========================================= -->

<div class="space-y-4">

    <div>

        <label class="mb-2 block text-sm font-semibold">
            Nomor Tilang
        </label>

        <input
            name="nomor_tilang"
            class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

    </div>

    <div>

        <label class="mb-2 block text-sm font-semibold">
            Nomor Kendaraan
        </label>

        <input
            name="nomor_kendaraan"
            class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

    </div>

    <div>

        <label class="mb-2 block text-sm font-semibold">
            Nomor BRIVA
        </label>

        <input
            name="nomor_briva"
            class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

    </div>

</div>