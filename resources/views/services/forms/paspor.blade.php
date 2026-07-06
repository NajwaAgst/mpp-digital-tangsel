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

        <div class="grid gap-4 md:grid-cols-2">

            <div>

                <label class="mb-2 block text-sm font-semibold">
                    Tempat Lahir
                </label>

                <input
                    id="tempat_lahir"
                    name="tempat_lahir"
                    readonly
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

            </div>

            <div>

                <label class="mb-2 block text-sm font-semibold">
                    Tanggal Lahir
                </label>

                <input
                    id="tanggal_lahir"
                    name="tanggal_lahir"
                    readonly
                    class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

            </div>

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
<!-- Data Paspor -->
<!-- ========================================= -->

<div class="space-y-4">

    <div>

        <label class="mb-2 block text-sm font-semibold">
            Nomor HP
        </label>

        <input
            name="hp"
            class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

    </div>

    <div>

        <label class="mb-2 block text-sm font-semibold">
            Negara Tujuan
        </label>

        <input
            name="tujuan_negara"
            class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

    </div>

    <div>

        <label class="mb-2 block text-sm font-semibold">
            Tujuan Keberangkatan
        </label>

        <select
            name="tujuan_keberangkatan"
            class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

            <option value="">Pilih</option>
            <option>Wisata</option>
            <option>Bekerja</option>
            <option>Belajar</option>
            <option>Ibadah</option>
            <option>Lainnya</option>

        </select>

    </div>

</div>