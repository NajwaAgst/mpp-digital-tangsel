<div class="rounded-xl border border-emerald-500 bg-emerald-500/10 p-5">

    <h3 class="mb-4 text-lg font-semibold text-emerald-300">
        Data Pemohon
    </h3>

    <div class="grid gap-4">

        <input
            id="nama"
            name="nama"
            readonly
            placeholder="Nama Lengkap"
            class="w-full rounded-lg bg-slate-800 p-3">

        <textarea
            id="alamat"
            name="alamat"
            readonly
            rows="3"
            placeholder="Alamat"
            class="w-full rounded-lg bg-slate-800 p-3"></textarea>

        <div class="grid md:grid-cols-2 gap-4">

            <input
                id="npwp"
                name="npwp"
                readonly
                placeholder="NPWP"
                class="rounded-lg bg-slate-800 p-3">

            <input
                id="status_npwp"
                name="status_npwp"
                readonly
                placeholder="Status NPWP"
                class="rounded-lg bg-slate-800 p-3">

        </div>

    </div>

</div>


<div class="rounded-xl border border-slate-700 p-5">

    <h3 class="mb-5 text-lg font-semibold">
        Data Pengajuan NIB
    </h3>

    <div class="grid gap-4">

        <input
            name="nama_usaha"
            required
            placeholder="Nama Usaha"
            class="w-full rounded-lg bg-slate-800 p-3">

        <select
            name="jenis_usaha"
            required
            class="w-full rounded-lg bg-slate-800 p-3">

            <option value="">
                Pilih Jenis Usaha
            </option>

            <option>Kuliner</option>
            <option>Perdagangan</option>
            <option>Jasa</option>
            <option>Fashion</option>
            <option>Pertanian</option>
            <option>Teknologi</option>
            <option>Industri</option>
            <option>Lainnya</option>

        </select>

        <input
            type="email"
            name="email"
            required
            placeholder="Alamat Email Aktif"
            class="w-full rounded-lg bg-slate-800 p-3">

        <input
            name="whatsapp"
            required
            placeholder="Nomor WhatsApp"
            class="w-full rounded-lg bg-slate-800 p-3">

        <input
            name="modal_usaha"
            placeholder="Modal Usaha (Rp)"
            class="w-full rounded-lg bg-slate-800 p-3">

        <input
            name="lokasi_usaha"
            placeholder="Lokasi Usaha"
            class="w-full rounded-lg bg-slate-800 p-3">

        <input
            type="number"
            name="jumlah_tenaga_kerja"
            placeholder="Jumlah Tenaga Kerja"
            class="w-full rounded-lg bg-slate-800 p-3">

        <input
            name="kbli"
            placeholder="Kode KBLI"
            class="w-full rounded-lg bg-slate-800 p-3">

    </div>

</div>