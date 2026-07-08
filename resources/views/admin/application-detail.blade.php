<?php

$title = "Detail Pengajuan MPP";

ob_start();

$data = [];

if (!empty($application['application_data'])) {
    $decoded = json_decode($application['application_data'], true);

    if (is_array($decoded)) {
        $data = $decoded;
    }
}

?>

<div class="space-y-8">

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Detail Pengajuan
            </h1>

            <p class="text-slate-500 mt-1">
                Nomor Pengajuan #<?= $application['id'] ?>
            </p>

        </div>

        <a
            href="/admin/applications"
            class="rounded-xl bg-slate-600 px-5 py-3 font-semibold text-white hover:bg-slate-700">

            ← Kembali

        </a>

    </div>

    <!-- DATA PEMOHON -->

    <div class="rounded-2xl bg-white shadow">

        <div class="border-b px-6 py-4">

            <h2 class="text-xl font-bold">
                Data Pemohon
            </h2>

        </div>

        <div class="grid md:grid-cols-2 gap-6 p-6">

            <div>
                <label class="text-sm text-slate-500">Nama</label>

                <div class="mt-1 font-semibold">
                    <?= htmlspecialchars($application['nama']) ?>
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">NIK</label>

                <div class="mt-1 font-semibold">
                    <?= htmlspecialchars($application['nik']) ?>
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">Nomor HP</label>

                <div class="mt-1 font-semibold">
                    <?= htmlspecialchars($application['hp']) ?>
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">Alamat</label>

                <div class="mt-1 font-semibold">
                    <?= nl2br(htmlspecialchars($application['alamat'])) ?>
                </div>
            </div>

        </div>

    </div>

    <!-- DATA LAYANAN -->

    <div class="rounded-2xl bg-white shadow">

        <div class="border-b px-6 py-4">

            <h2 class="text-xl font-bold">
                Informasi Layanan
            </h2>

        </div>

        <div class="grid md:grid-cols-2 gap-6 p-6">

            <div>
                <label class="text-sm text-slate-500">
                    Nama Layanan
                </label>

                <div class="mt-1 font-semibold">
                    <?= htmlspecialchars($application['service_name']) ?>
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Status
                </label>

                <div class="mt-1">

                    <?php

                    $status = $application['status'];

                    $color = "bg-yellow-100 text-yellow-700";

                    if ($status == "Approved") {
                        $color = "bg-green-100 text-green-700";
                    }

                    if ($status == "Rejected") {
                        $color = "bg-red-100 text-red-700";
                    }

                    ?>

                    <span class="rounded-full px-3 py-1 text-sm font-semibold <?= $color ?>">

                        <?= htmlspecialchars($status) ?>

                    </span>

                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Tanggal Pengajuan
                </label>

                <div class="mt-1 font-semibold">
                    <?= htmlspecialchars($application['created_at']) ?>
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">
                    Keterangan
                </label>

                <div class="mt-1 font-semibold">
                    <?= htmlspecialchars($application['keterangan'] ?: '-') ?>
                </div>
            </div>

        </div>

    </div>

    <!-- DATA FORM -->

    <div class="rounded-2xl bg-white shadow">

        <div class="border-b px-6 py-4">

            <h2 class="text-xl font-bold">
                Data Form Pengajuan
            </h2>

        </div>

        <div class="p-6">

            <?php if(empty($data)): ?>

                <p class="text-slate-500">

                    Tidak ada data tambahan.

                </p>

            <?php else: ?>

                <table class="w-full">

                    <?php foreach($data as $key=>$value): ?>

                        <tr class="border-b">

                            <td class="w-72 py-3 font-semibold">

                                <?= ucwords(str_replace("_"," ",$key)) ?>

                            </td>

                            <td class="py-3">

                                <?= htmlspecialchars(is_array($value) ? json_encode($value) : $value) ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </table>

            <?php endif; ?>

        </div>

    </div>

    <!-- ACTION -->

    <div class="flex flex-wrap gap-3">

        <form method="POST" action="/admin/applications/<?= $application['id'] ?>/approve">

            <button
                class="rounded-xl bg-green-600 px-5 py-3 font-semibold text-white hover:bg-green-700">

                ✔ Approve

            </button>

        </form>

        <form method="POST" action="/admin/applications/<?= $application['id'] ?>/pending">

            <button
                class="rounded-xl bg-yellow-500 px-5 py-3 font-semibold text-white hover:bg-yellow-600">

                ⏳ Pending

            </button>

        </form>

        <form method="POST" action="/admin/applications/<?= $application['id'] ?>/reject">

            <button
                class="rounded-xl bg-red-600 px-5 py-3 font-semibold text-white hover:bg-red-700">

                ✖ Reject

            </button>

        </form>

        <form
            method="POST"
            action="/admin/applications/<?= $application['id'] ?>/delete"
            onsubmit="return confirm('Hapus pengajuan ini?')">

            <button
                class="rounded-xl bg-slate-700 px-5 py-3 font-semibold text-white hover:bg-slate-800">

                🗑 Hapus

            </button>

        </form>

    </div>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . '/layout.blade.php';

?>