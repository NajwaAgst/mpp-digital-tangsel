<?php

$title = "Detail Pengajuan MPP";

ob_start();

$data = [];

if (!empty($application['application_data'])) {

    $decoded = json_decode(
        $application['application_data'],
        true
    );

    if (is_array($decoded)) {
        $data = $decoded;
    }
}

?>

<div class="space-y-8">

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                Detail Pengajuan Layanan

            </h1>

            <p class="mt-2 text-slate-500">

                Nomor Pengajuan
                #<?= $application["id"] ?>

            </p>

        </div>

        <a
            href="/admin/applications"
            class="rounded-xl bg-slate-600 px-5 py-3 font-semibold text-white hover:bg-slate-700">

            ← Kembali

        </a>

    </div>

    <!-- ========================= -->
    <!-- DATA PEMOHON -->
    <!-- ========================= -->

    <div class="rounded-2xl bg-white shadow">

        <div class="border-b px-6 py-4">

            <h2 class="text-xl font-bold">

                👤 Data Pemohon

            </h2>

        </div>

        <div class="grid gap-6 p-6 md:grid-cols-2">

            <div>

                <label class="text-sm text-slate-500">

                    Nama

                </label>

                <div class="mt-2 rounded-lg bg-slate-100 px-4 py-3 font-semibold">

                    <?= htmlspecialchars($application["nama"]) ?>

                </div>

            </div>

            <div>

                <label class="text-sm text-slate-500">

                    NIK

                </label>

                <div class="mt-2 rounded-lg bg-slate-100 px-4 py-3 font-semibold">

                    <?= htmlspecialchars($application["nik"]) ?>

                </div>

            </div>

            <div>

                <label class="text-sm text-slate-500">

                    Nomor HP

                </label>

                <div class="mt-2 rounded-lg bg-slate-100 px-4 py-3 font-semibold">

                    <?= htmlspecialchars($application["hp"]) ?>

                </div>

            </div>

            <div>

                <label class="text-sm text-slate-500">

                    Alamat

                </label>

                <div class="mt-2 rounded-lg bg-slate-100 px-4 py-3 font-semibold">

                    <?= nl2br(htmlspecialchars($application["alamat"])) ?>

                </div>

            </div>

        </div>

    </div>
    <!-- ========================= -->
<!-- DETAIL PENGAJUAN -->
<!-- ========================= -->

<div class="rounded-2xl bg-white shadow">

    <div class="border-b px-6 py-4">

        <h2 class="text-xl font-bold">

            📑 Detail Pengajuan

        </h2>

        <p class="mt-1 text-sm text-slate-500">

            Data yang diisi pemohon saat mengajukan layanan.

        </p>

    </div>

    <?php if(empty($data)): ?>

        <div class="p-8 text-center text-slate-500">

            Tidak ada data tambahan.

        </div>

    <?php else: ?>

        <div class="grid gap-6 p-6 md:grid-cols-2">

            <?php

            $hiddenFields = [

                "nama",
                "nik",
                "alamat",
                "hp"

            ];

            foreach($data as $key=>$value):

                if(in_array($key,$hiddenFields)){
                    continue;
                }

                $label = ucwords(
                    str_replace("_"," ",$key)
                );

            ?>

            <div>

                <label class="text-sm text-slate-500">

                    <?= $label ?>

                </label>

                <div class="mt-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 font-semibold">

                    <?=
                        htmlspecialchars(
                            is_array($value)
                            ? implode(", ",$value)
                            : ($value==="" ? "-" : $value)
                        )
                    ?>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>
<!-- ========================= -->
<!-- ACTION -->
<!-- ========================= -->

<div class="rounded-2xl bg-white shadow">

    <div class="border-b px-6 py-4">

        <h2 class="text-xl font-bold">

            ⚙ Aksi Administrator

        </h2>

        <p class="mt-1 text-sm text-slate-500">

            Pilih tindakan terhadap pengajuan layanan ini.

        </p>

    </div>

    <div class="flex flex-wrap gap-4 p-6">

        <!-- APPROVE -->

        <form
            method="POST"
            action="/admin/applications/<?= $application["id"] ?>/approve">

            <button
                type="submit"
                onclick="return confirm('Approve pengajuan ini?')"
                class="rounded-xl bg-green-600 px-6 py-3 font-semibold text-white transition hover:bg-green-700">

                ✔ Approve

            </button>

        </form>

        <!-- PENDING -->

        <form
            method="POST"
            action="/admin/applications/<?= $application["id"] ?>/pending">

            <button
                type="submit"
                class="rounded-xl bg-yellow-500 px-6 py-3 font-semibold text-white transition hover:bg-yellow-600">

                ⏳ Pending

            </button>

        </form>

        <!-- REJECT -->

        <form
            method="POST"
            action="/admin/applications/<?= $application["id"] ?>/reject">

            <button
                type="submit"
                onclick="return confirm('Tolak pengajuan ini?')"
                class="rounded-xl bg-red-600 px-6 py-3 font-semibold text-white transition hover:bg-red-700">

                ✖ Reject

            </button>

        </form>

        <!-- DELETE -->

        <form
            method="POST"
            action="/admin/applications/<?= $application["id"] ?>/delete"
            onsubmit="return confirm('Hapus data ini?')">

            <button
                type="submit"
                class="rounded-xl bg-slate-700 px-6 py-3 font-semibold text-white transition hover:bg-slate-800">

                🗑 Hapus

            </button>

        </form>

    </div>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . '/layout.blade.php';

?>