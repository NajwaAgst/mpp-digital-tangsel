<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$title = 'Ajukan ' . $service['name'];

$authUser = $_SESSION['user'] ?? null;

$form = $service['form'] ?? [];

ob_start();

?>

<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

    <div class="mb-8 flex items-center justify-between">

        <a
            href="/services/<?= htmlspecialchars($service['slug']) ?>"
            class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700">

            ← Kembali ke Detail Layanan

        </a>

        <?php if ($authUser): ?>

            <a
                href="/dashboard"
                class="rounded-xl bg-emerald-600 px-5 py-2 font-semibold text-white hover:bg-emerald-700">

                Dashboard Saya

            </a>

        <?php endif; ?>

    </div>

    <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">

        <!-- ========================= -->
        <!-- INFORMASI LAYANAN -->
        <!-- ========================= -->

        <div class="rounded-[2rem] border border-white bg-white p-8 shadow-xl">

            <div class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">

                <?= htmlspecialchars($service['category']) ?>

            </div>

            <h1 class="mt-5 text-3xl font-bold text-slate-900">

                <?= htmlspecialchars($service['name']) ?>

            </h1>

            <p class="mt-4 text-slate-600">

                Lengkapi formulir berikut.

                Seluruh data identitas akan diambil otomatis melalui
                layanan interoperabilitas SPBE
                (Dukcapil, DJP/NPWP dan OSS/NIB)
                berdasarkan NIK yang dimasukkan.

            </p>

            <div class="mt-8">

                <h3 class="font-semibold text-slate-900">

                    Persyaratan

                </h3>

                <ul class="mt-4 space-y-2 text-sm text-slate-600">

                    <?php foreach($service['documents'] as $doc): ?>

                        <li>
                            • <?= htmlspecialchars($doc) ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

        </div>

        <!-- ========================= -->
        <!-- FORM -->
        <!-- ========================= -->

        <div class="rounded-[2rem] bg-slate-900 p-8 text-white shadow-xl">

            <?php if (!empty($_SESSION['flash_success'])): ?>

                <div class="mb-6 rounded-xl border border-emerald-500 bg-emerald-500/20 p-4">

                    <?= htmlspecialchars($_SESSION['flash_success']) ?>

                </div>

                <?php unset($_SESSION['flash_success']); ?>

            <?php endif; ?>

            <?php if(!empty($errorMessage)): ?>

                <div class="mb-5 rounded-xl border border-red-500 bg-red-500/20 p-4">

                    <?= htmlspecialchars($errorMessage) ?>

                </div>

            <?php endif; ?>

            <?php if(!empty($submitted)): ?>

                <div class="mb-6 rounded-xl border border-emerald-500 bg-emerald-500/20 p-5">

                    <h2 class="text-xl font-bold">

                        ✅ Pengajuan Berhasil

                    </h2>

                    <p class="mt-2">

                        Nomor Pengajuan :

                        <strong>#<?= htmlspecialchars($submissionId) ?></strong>

                    </p>

                    <div class="mt-5 flex gap-3">

                        <a
                            href="/dashboard"
                            class="rounded-lg bg-emerald-500 px-5 py-2 font-semibold">

                            Dashboard

                        </a>

                        <a
                            href="/services/history"
                            class="rounded-lg bg-white px-5 py-2 font-semibold text-slate-900">

                            Riwayat

                        </a>

                    </div>

                </div>

            <?php endif; ?>

            <form
                method="POST"
                action="/services/<?= htmlspecialchars($service['slug']) ?>/apply"
                class="space-y-6">

                                <!-- ============================== -->
                <!-- NIK -->
                <!-- ============================== -->

                <div>

                    <label class="mb-2 block text-sm font-semibold">

                        NIK

                    </label>

                    <input
                        id="nik"
                        name="nik"
                        maxlength="16"
                        autocomplete="off"
                        required
                        value="<?= htmlspecialchars(
                            $submittedData['nik']
                            ?? ($_SESSION['user']['nik'] ?? '')
                        ) ?>"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

                    <small
                        id="nik-mask"
                        class="mt-2 block text-xs text-emerald-300">

                    </small>

                </div>

                <!-- Loading -->

                <div
                    id="loading"
                    class="hidden rounded-xl border border-blue-500 bg-blue-600/20 p-4 text-sm">

                    Mengambil data dari layanan interoperabilitas...

                </div>

                <!-- ============================== -->
                <!-- FORM DINAMIS -->
                <!-- ============================== -->

                <?php

                $formFile = __DIR__ . '/forms/' . ($form['code'] ?? '') . '.blade.php';

                if (file_exists($formFile)) {

                    include $formFile;

                }

                ?>

                <!-- ============================== -->
                <!-- Keterangan -->
                <!-- ============================== -->

                <div>

                    <label class="mb-2 block text-sm font-semibold">

                        Keterangan Tambahan

                    </label>

                    <textarea
                        name="keterangan"
                        rows="4"
                        class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white"><?= htmlspecialchars($submittedData['keterangan'] ?? '') ?></textarea>

                </div>

                <div class="flex gap-4">

                    <a
                        href="/dashboard"
                        class="flex-1 rounded-xl border border-slate-600 py-3 text-center font-semibold hover:bg-slate-700">

                        Batal

                    </a>

                    <button
                        type="submit"
                        class="flex-1 rounded-xl bg-emerald-500 py-3 font-semibold transition hover:bg-emerald-600">

                        Kirim Pengajuan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

document.addEventListener("DOMContentLoaded", () => {

    const nikInput = document.getElementById("nik");
    const loading = document.getElementById("loading");
    const nikMask = document.getElementById("nik-mask");

    if (!nikInput) return;

    let timer = null;

    //------------------------------------------------------
    // Masking NIK
    //------------------------------------------------------

    function maskNik(nik) {

        if (nik.length !== 16) {
            nikMask.innerHTML = "";
            return;
        }

        nikMask.innerHTML =
            "NIK Terverifikasi : <b>" +
            nik.substring(0, 4) +
            "********" +
            nik.substring(12) +
            "</b>";

    }

    //------------------------------------------------------
    // Helper
    //------------------------------------------------------

    function setValue(id, value) {

        const el = document.getElementById(id);

        if (el) {

            el.value = value ?? "";

        }

    }

    function clearFields() {

        [

            "nama",
            "tempat_lahir",
            "tanggal_lahir",
            "alamat",
            "hp",
            "npwp",
            "status_npwp",
            "nib",
            "nama_usaha",
            "jenis_usaha"

        ].forEach(id => setValue(id, ""));

    }

    //------------------------------------------------------
    // Event
    //------------------------------------------------------

    nikInput.addEventListener("keyup", () => {

        clearTimeout(timer);

        maskNik(nikInput.value);

        if (nikInput.value.length !== 16) {

            clearFields();

            return;

        }

        timer = setTimeout(loadInteroperability, 500);

    });

    //------------------------------------------------------
    // API
    //------------------------------------------------------

    async function loadInteroperability() {

        loading.classList.remove("hidden");

        try {

            const response = await fetch(
                "/mock/interoperability/" + nikInput.value
            );

            const json = await response.json();

            loading.classList.add("hidden");

            if (!json.success) {

                alert(json.message ?? "Data tidak ditemukan");

                clearFields();

                return;

            }

            //--------------------------------------------
            // Dukcapil
            //--------------------------------------------

            if (json.data.dukcapil) {

                const d = json.data.dukcapil;

                setValue("nik", d.nik);
                setValue("nama", d.nama);
                setValue("tempat_lahir", d.tempat_lahir);
                setValue("tanggal_lahir", d.tanggal_lahir);
                setValue("alamat", d.alamat);

            }

            //--------------------------------------------
            // NPWP
            //--------------------------------------------

            if (json.data.npwp) {

                const p = json.data.npwp;

                setValue("npwp", p.npwp);
                setValue("status_npwp", p.status_npwp);

            }

            //--------------------------------------------
            // NIB
            //--------------------------------------------

            if (json.data.nib) {

                const b = json.data.nib;

                setValue("nib", b.nib);
                setValue("nama_usaha", b.nama_usaha);
                setValue("jenis_usaha", b.jenis_usaha);

            }

        } catch (err) {

            loading.classList.add("hidden");

            console.error(err);

            alert("Gagal mengambil data dari server.");

        }

    }

    //------------------------------------------------------
    // Autofill jika user login
    //------------------------------------------------------

    if (nikInput.value.length === 16) {

        maskNik(nikInput.value);

        loadInteroperability();

    }

});

</script>

<?php

$content = ob_get_clean();

include __DIR__ . '/../layout.blade.php';

?>