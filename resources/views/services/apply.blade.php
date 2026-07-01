<?php
$title = 'Ajukan ' . $service['name'];
$authUser = $_SESSION['user'] ?? null;
ob_start();
?>

<div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">

    <a href="/services/<?= htmlspecialchars($service['slug']) ?>"
       class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-emerald-600">
        ← Kembali ke detail layanan
    </a>

    <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">

        <!-- ========================= -->
        <!-- Informasi Layanan -->
        <!-- ========================= -->

        <div class="rounded-[2rem] border border-white/70 bg-white/90 p-8 shadow-xl shadow-slate-200/50">

            <div class="inline-flex rounded-full bg-emerald-50 px-3 py-1 text-sm font-semibold text-emerald-700">
                <?= htmlspecialchars($service['category']) ?>
            </div>

            <h1 class="mt-5 text-3xl font-semibold text-slate-900">
                Ajukan Layanan
            </h1>

            <h2 class="mt-2 text-xl font-bold text-emerald-700">
                <?= htmlspecialchars($service['name']) ?>
            </h2>

            <p class="mt-4 text-lg leading-8 text-slate-600">
                Lengkapi data menggunakan NIK.
                Seluruh data persyaratan akan diambil otomatis
                melalui layanan Interoperabilitas SPBE.
            </p>

            <div class="mt-8 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    Persyaratan Dokumen
                </h2>

                <ul class="mt-4 space-y-3 text-sm text-slate-600">

                    <?php foreach ($service['documents'] as $document): ?>

                        <li class="flex items-start gap-3">

                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-500"></span>

                            <span><?= htmlspecialchars($document) ?></span>

                        </li>

                    <?php endforeach; ?>

                </ul>

            </div>

            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-5">

                <h3 class="font-semibold text-emerald-700">
                    Alur Pengajuan
                </h3>

                <ol class="mt-3 space-y-2 text-sm text-slate-600">

                    <?php foreach ($service['steps'] as $i => $step): ?>

                        <li>
                            <strong><?= $i + 1 ?>.</strong>
                            <?= htmlspecialchars($step) ?>
                        </li>

                    <?php endforeach; ?>

                </ol>

            </div>

        </div>

        <!-- ========================= -->
        <!-- Form -->
        <!-- ========================= -->

        <div class="rounded-[2rem] border border-white/70 bg-slate-900 p-8 text-white shadow-xl shadow-slate-300/30">

            <?php if (!empty($errorMessage)): ?>

                <div class="mb-6 rounded-2xl border border-rose-400/30 bg-rose-500/10 p-4">

                    <p class="font-semibold text-rose-200">
                        Pengajuan gagal
                    </p>

                    <p class="mt-1 text-rose-100">
                        <?= htmlspecialchars($errorMessage) ?>
                    </p>

                </div>

            <?php endif; ?>

            <?php if (!empty($submitted)): ?>

                <div class="mb-6 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 p-4">

                    <p class="font-semibold text-emerald-300">
                        Pengajuan berhasil
                    </p>

                    <p class="mt-1">
                        Nomor Pengajuan
                        <strong>#<?= htmlspecialchars($submissionId) ?></strong>
                    </p>

                </div>

            <?php endif; ?>

<form
method="post"
action="/services/<?= htmlspecialchars($service['slug']) ?>/apply"
class="space-y-6">

<div class="grid gap-4 md:grid-cols-2">

    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-200">
            NIK
        </label>

        <input
            id="nik"
            type="text"
            name="nik"
            maxlength="16"
            required
            autocomplete="off"
            value="<?= htmlspecialchars($submittedData['nik'] ?? ($authUser['nik'] ?? '')) ?>"
            class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

    </div>

    <div>

        <label class="mb-2 block text-sm font-semibold text-slate-200">
            Nomor HP
        </label>

        <input
            type="text"
            name="hp"
            required
            value="<?= htmlspecialchars($submittedData['hp'] ?? '') ?>"
            class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

    </div>

</div>
<!-- ========================= -->
<!-- Data Interoperabilitas -->
<!-- ========================= -->

<div class="rounded-2xl border border-emerald-500 bg-emerald-500/10 p-5">

    <h3 class="text-lg font-semibold text-emerald-300">
        Data Persyaratan
        <span class="text-white">(Terambil Otomatis melalui Interoperabilitas)</span>
    </h3>

    <p class="mt-2 text-sm text-slate-300">
        Masukkan NIK, maka sistem akan mengambil data dari
        Dukcapil, NPWP dan OSS secara otomatis.
    </p>

    <div class="mt-6 grid gap-4">

        <div>

            <label class="mb-2 block text-sm font-semibold">
                Nama Penduduk
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

    <div class="mt-5 grid gap-4 md:grid-cols-2">

        <div>

            <label class="mb-2 block text-sm font-semibold">
                Nomor NPWP
            </label>

            <input
                id="npwp"
                readonly
                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

        </div>

        <div>

            <label class="mb-2 block text-sm font-semibold">
                Status NPWP
            </label>

            <input
                id="status_npwp"
                readonly
                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

        </div>

    </div>

    <div class="mt-5 grid gap-4 md:grid-cols-3">

        <div>

            <label class="mb-2 block text-sm font-semibold">
                NIB
            </label>

            <input
                id="nib"
                readonly
                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

        </div>

        <div>

            <label class="mb-2 block text-sm font-semibold">
                Nama Usaha
            </label>

            <input
                id="nama_usaha"
                readonly
                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

        </div>

        <div>

            <label class="mb-2 block text-sm font-semibold">
                Jenis Usaha
            </label>

            <input
                id="jenis_usaha"
                readonly
                class="w-full rounded-xl border border-slate-700 bg-slate-800 px-4 py-3 text-white">

        </div>

    </div>

</div>

<div>

    <label class="mb-2 block text-sm font-semibold text-slate-200">
        Keterangan Tambahan
    </label>

    <textarea
        name="keterangan"
        rows="4"
        class="w-full rounded-2xl border border-slate-700 bg-slate-800 px-4 py-3 text-white"><?= htmlspecialchars($submittedData['keterangan'] ?? '') ?></textarea>

</div>

<button
    type="submit"
    class="w-full rounded-2xl bg-emerald-500 py-3 text-lg font-semibold text-white hover:bg-emerald-600 transition">

    Kirim Pengajuan

</button>

</form>

</div>

</div>

</div>
<script>

const nikInput = document.getElementById("nik");

let timeout = null;

nikInput.addEventListener("keyup", function(){

    clearTimeout(timeout);

    const nik = this.value;

    if(nik.length < 16){

        document.getElementById("nama").value = "";
        document.getElementById("alamat").value = "";
        document.getElementById("npwp").value = "";
        document.getElementById("status_npwp").value = "";
        document.getElementById("nib").value = "";
        document.getElementById("nama_usaha").value = "";
        document.getElementById("jenis_usaha").value = "";

        return;
    }

    timeout = setTimeout(loadInteroperability,300);

});

async function loadInteroperability(){

    const nik = document.getElementById("nik").value;

    try{

        const response = await fetch("/mock/interoperability/" + nik);

        const json = await response.json();

        if(!json.success){

            alert(json.message);

            return;

        }

        const data = json.data;

        // ======================
        // Dukcapil
        // ======================

        if(data.dukcapil){

            document.getElementById("nama").value =
                data.dukcapil.nama ?? "";

            document.getElementById("alamat").value =
                data.dukcapil.alamat ?? "";

        }

        // ======================
        // NPWP
        // ======================

        if(data.npwp){

            document.getElementById("npwp").value =
                data.npwp.npwp ?? "-";

            document.getElementById("status_npwp").value =
                data.npwp.status_npwp ?? "-";

        }else{

            document.getElementById("npwp").value = "-";
            document.getElementById("status_npwp").value = "-";

        }

        // ======================
        // NIB
        // ======================

        if(data.nib){

            document.getElementById("nib").value =
                data.nib.nib ?? "-";

            document.getElementById("nama_usaha").value =
                data.nib.nama_usaha ?? "-";

            document.getElementById("jenis_usaha").value =
                data.nib.jenis_usaha ?? "-";

        }else{

            document.getElementById("nib").value = "-";
            document.getElementById("nama_usaha").value = "-";
            document.getElementById("jenis_usaha").value = "-";

        }

    }catch(e){

        console.log(e);

        alert("Gagal mengambil data interoperabilitas.");

    }

}

</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.blade.php';
?>