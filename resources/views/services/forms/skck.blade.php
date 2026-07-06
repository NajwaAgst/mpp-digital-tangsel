<!-- ========================================= -->
<!-- Data Interoperabilitas -->
<!-- ========================================= -->

<div class="rounded-2xl border border-emerald-500 bg-emerald-500/10 p-5">

    <h3 class="text-lg font-semibold text-emerald-300">
        <?= htmlspecialchars($form['title']) ?>
    </h3>

    <div class="mt-5 grid gap-4">

        <input id="nama"
               name="nama"
               readonly
               placeholder="Nama"
               class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

        <input id="tempat_lahir"
               name="tempat_lahir"
               readonly
               placeholder="Tempat Lahir"
               class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

        <input id="tanggal_lahir"
               name="tanggal_lahir"
               readonly
               placeholder="Tanggal Lahir"
               class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

        <textarea id="alamat"
                  name="alamat"
                  readonly
                  rows="3"
                  placeholder="Alamat"
                  class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white"></textarea>

    </div>

</div>

<!-- ========================================= -->
<!-- Data SKCK -->
<!-- ========================================= -->

<div class="space-y-4">

    <div>
        <label class="mb-2 block text-sm font-semibold">
            Keperluan SKCK
        </label>

        <select name="keperluan_skck"
                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

            <option value="">Pilih</option>
            <option>Melamar Pekerjaan</option>
            <option>Melanjutkan Pendidikan</option>
            <option>Keperluan Administrasi</option>

        </select>

    </div>

</div>