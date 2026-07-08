<!-- ========================================= -->
<!-- DATA INTEROPERABILITAS -->
<!-- ========================================= -->

<div class="rounded-xl border border-emerald-500 bg-emerald-500/10 p-5">

    <h3 class="mb-4 text-lg font-semibold text-emerald-300">
        Data Kependudukan (Interoperabilitas Dukcapil)
    </h3>

    <div class="grid gap-4">

        <!-- Nama -->
        <div>
            <label class="block mb-2 text-sm">Nama Lengkap</label>

            <input
                id="nama"
                name="nama"
                type="text"
                readonly
                value="<?= htmlspecialchars($submittedData['nama'] ?? ($_SESSION['user']['name'] ?? '')) ?>"
                class="w-full rounded-lg bg-slate-800 p-3 text-white">
        </div>

        <div class="grid md:grid-cols-2 gap-4">

            <!-- Tempat Lahir -->
            <div>
                <label class="block mb-2 text-sm">Tempat Lahir</label>

                <input
                    id="tempat_lahir"
                    name="tempat_lahir"
                    type="text"
                    readonly
                    value="<?= htmlspecialchars($submittedData['tempat_lahir'] ?? '') ?>"
                    class="w-full rounded-lg bg-slate-800 p-3 text-white">
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label class="block mb-2 text-sm">Tanggal Lahir</label>

                <input
                    id="tanggal_lahir"
                    name="tanggal_lahir"
                    type="text"
                    readonly
                    value="<?= htmlspecialchars($submittedData['tanggal_lahir'] ?? '') ?>"
                    class="w-full rounded-lg bg-slate-800 p-3 text-white">
            </div>

        </div>

        <!-- Alamat -->
        <div>

            <label class="block mb-2 text-sm">
                Alamat
            </label>

            <textarea
                id="alamat"
                name="alamat"
                rows="3"
                readonly
                class="w-full rounded-lg bg-slate-800 p-3 text-white"><?= htmlspecialchars($submittedData['alamat'] ?? '') ?></textarea>

        </div>

    </div>

</div>

<!-- ========================================= -->
<!-- DATA PERMOHONAN -->
<!-- ========================================= -->

<div class="rounded-xl border border-slate-700 p-5">

    <h3 class="mb-4 font-semibold">
        Data Permohonan KK
    </h3>

    <div class="grid gap-4">

        <!-- No HP -->
        <div>

            <label class="block mb-2">
                Nomor HP
            </label>

            <input
                id="hp"
                name="hp"
                type="text"
                value="<?= htmlspecialchars($submittedData['hp'] ?? ($_SESSION['user']['hp'] ?? '')) ?>"
                class="w-full rounded-lg bg-slate-800 p-3 text-white">

        </div>

        <!-- Status Perkawinan -->
        <div>

            <label class="block mb-2">
                Status Perkawinan
            </label>

            <select
                name="status_perkawinan"
                class="w-full rounded-lg bg-slate-800 p-3 text-white">

                <option value="">Pilih</option>

                <option value="Belum Kawin"
                    <?= (($submittedData['status_perkawinan'] ?? '') == 'Belum Kawin') ? 'selected' : '' ?>>
                    Belum Kawin
                </option>

                <option value="Kawin"
                    <?= (($submittedData['status_perkawinan'] ?? '') == 'Kawin') ? 'selected' : '' ?>>
                    Kawin
                </option>

                <option value="Cerai Hidup"
                    <?= (($submittedData['status_perkawinan'] ?? '') == 'Cerai Hidup') ? 'selected' : '' ?>>
                    Cerai Hidup
                </option>

                <option value="Cerai Mati"
                    <?= (($submittedData['status_perkawinan'] ?? '') == 'Cerai Mati') ? 'selected' : '' ?>>
                    Cerai Mati
                </option>

            </select>

        </div>

    </div>

</div>