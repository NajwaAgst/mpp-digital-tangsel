<!-- ========================================= -->
<!-- Data Interoperabilitas -->
<!-- ========================================= -->

<div class="rounded-2xl border border-emerald-500 bg-emerald-500/10 p-5">

    <h3 class="text-lg font-semibold text-emerald-300">
        <?= htmlspecialchars($form['title']) ?>
    </h3>

    <div class="mt-5 grid gap-4">

        <div>
            <label class="mb-2 block text-sm font-semibold">Nama Pemohon</label>
            <input id="nama"
                   name="nama"
                   readonly
                   class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">Alamat</label>
            <textarea id="alamat"
                      name="alamat"
                      rows="3"
                      readonly
                      class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white"></textarea>
        </div>

        <div>
            <label class="mb-2 block text-sm font-semibold">NPWP</label>
            <input id="npwp"
                   name="npwp"
                   readonly
                   class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">
        </div>

    </div>

</div>

<!-- ========================================= -->
<!-- Data Tanah -->
<!-- ========================================= -->

<div class="space-y-4">

    <div>
        <label class="mb-2 block text-sm font-semibold">
            Lokasi Tanah
        </label>

        <textarea name="lokasi_tanah"
                  rows="3"
                  class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white"></textarea>
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">
            Luas Tanah (m²)
        </label>

        <input type="number"
               name="luas_tanah"
               class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold">
            Status Kepemilikan
        </label>

        <select name="status_kepemilikan"
                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

            <option value="">Pilih</option>
            <option>Hak Milik</option>
            <option>Hak Guna Bangunan</option>
            <option>Hak Pakai</option>

        </select>
    </div>

</div>