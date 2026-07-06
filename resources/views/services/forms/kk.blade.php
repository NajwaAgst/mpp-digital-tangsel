<!-- ========================================= -->
<!-- DATA INTEROPERABILITAS -->
<!-- ========================================= -->

<div class="rounded-xl border border-emerald-500 bg-emerald-500/10 p-5">

    <h3 class="mb-4 text-lg font-semibold text-emerald-300">
        Data Kependudukan (Interoperabilitas Dukcapil)
    </h3>

    <div class="grid gap-4">

        <div>
            <label class="block mb-2 text-sm">Nama Lengkap</label>
            <input
                id="nama"
                name="nama"
                readonly
                class="w-full rounded-lg bg-slate-800 p-3">
        </div>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <label class="block mb-2 text-sm">Tempat Lahir</label>
                <input
                    id="tempat_lahir"
                    name="tempat_lahir"
                    readonly
                    class="w-full rounded-lg bg-slate-800 p-3">
            </div>

            <div>
                <label class="block mb-2 text-sm">Tanggal Lahir</label>
                <input
                    id="tanggal_lahir"
                    name="tanggal_lahir"
                    readonly
                    class="w-full rounded-lg bg-slate-800 p-3">
            </div>

        </div>

        <div>

            <label class="block mb-2 text-sm">
                Alamat
            </label>

            <textarea
                id="alamat"
                name="alamat"
                rows="3"
                readonly
                class="w-full rounded-lg bg-slate-800 p-3"></textarea>

        </div>

    </div>

</div>

<!-- ========================================= -->
<!-- DATA MANUAL -->
<!-- ========================================= -->

<div class="rounded-xl border border-slate-700 p-5">

    <h3 class="mb-4 font-semibold">
        Data Permohonan KK
    </h3>

    <div class="grid gap-4">

        <div>

            <label class="block mb-2">
                Nomor HP
            </label>

            <input
                name="hp"
                class="w-full rounded-lg bg-slate-800 p-3">

        </div>

        <div>

            <label class="block mb-2">
                Status Perkawinan
            </label>

            <select
                name="status_perkawinan"
                class="w-full rounded-lg bg-slate-800 p-3">

                <option value="">Pilih</option>
                <option>Belum Kawin</option>
                <option>Kawin</option>
                <option>Cerai Hidup</option>
                <option>Cerai Mati</option>

            </select>

        </div>

    </div>

</div>