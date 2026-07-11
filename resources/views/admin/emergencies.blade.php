<?php

$title = "Emergency 112";

ob_start();

?>

<form method="GET" action="/admin/emergencies" class="mb-8">

    <div class="rounded-3xl bg-white p-6 shadow">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <input
                type="text"
                name="search"
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                placeholder="Cari Nama / NIK / Kategori..."
                class="rounded-xl border border-gray-300 px-4 py-3 focus:border-red-500 focus:outline-none">

            <select
                name="status"
                class="rounded-xl border border-gray-300 px-4 py-3 focus:border-red-500 focus:outline-none">

                <option value="">Semua Status</option>

                <option value="Menunggu"
                    <?= (($_GET['status'] ?? '') == 'Menunggu') ? 'selected' : '' ?>>
                    Menunggu
                </option>

                <option value="Diproses"
                    <?= (($_GET['status'] ?? '') == 'Diproses') ? 'selected' : '' ?>>
                    Diproses
                </option>

                <option value="Selesai"
                    <?= (($_GET['status'] ?? '') == 'Selesai') ? 'selected' : '' ?>>
                    Selesai
                </option>

            </select>

            <button
                type="submit"
                class="rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700">

                Cari

            </button>

            <a
                href="/admin/emergencies"
                class="rounded-xl bg-slate-500 text-white font-semibold flex items-center justify-center hover:bg-slate-600">

                Reset

            </a>

        </div>

    </div>

</form>



<div class="flex justify-between items-center mb-6">

    <div>

        <h2 class="text-2xl font-bold">
            Data Laporan Emergency 112
        </h2>

        <p class="text-gray-500">
            Semua laporan masyarakat.
        </p>

    </div>

    <a
        href="/admin/emergencies/export/pdf"
        class="bg-red-600 text-white px-5 py-3 rounded-xl hover:bg-red-700">

        Export PDF

    </a>

</div>

<div class="overflow-hidden rounded-2xl bg-white shadow">

    <table class="min-w-full">

        <thead class="bg-slate-100">

        <tr class="text-slate-700">

            <th class="px-6 py-4 text-left">ID</th>
            <th class="px-6 py-4 text-left">Nama</th>
            <th class="px-6 py-4 text-left">NIK</th>
            <th class="px-6 py-4 text-left">No HP</th>
            <th class="px-6 py-4 text-left">Kategori</th>
            <th class="px-6 py-4 text-left">Status</th>
            <th class="px-6 py-4 text-center">Rating</th>
            <th class="px-6 py-4 text-left">Review</th>
            <th class="px-6 py-4 text-left">Tanggal</th>
            <th class="px-6 py-4 text-center">Aksi</th>

        </tr>

        </thead>

       <tbody>

<?php if(empty($reports)): ?>

<tr>
    <td colspan="10" class="py-12 text-center text-slate-500">
        Belum ada laporan Emergency 112.
    </td>
</tr>

<?php else: ?>

<?php foreach($reports as $r): ?>

<?php

$badge = "bg-yellow-100 text-yellow-700";

if(($r["status"] ?? "") == "Diproses"){
    $badge = "bg-blue-100 text-blue-700";
}

if(($r["status"] ?? "") == "Selesai"){
    $badge = "bg-green-100 text-green-700";
}

?>

<tr class="border-b hover:bg-slate-50 transition">

    <td class="px-6 py-4 font-semibold">
        #<?= $r["id"] ?>
    </td>

    <td class="px-6 py-4">
        <?= htmlspecialchars($r["nama"]) ?>
    </td>

    <td class="px-6 py-4">
        <?= htmlspecialchars($r["nik"]) ?>
    </td>

    <td class="px-6 py-4">
        <?= htmlspecialchars($r["phone"]) ?>
    </td>

    <td class="px-6 py-4">
        <?= htmlspecialchars($r["emergency_type"]) ?>
    </td>

    <td class="px-6 py-4">
        <span class="rounded-full px-3 py-1 text-sm font-semibold <?= $badge ?>">
            <?= htmlspecialchars($r["status"]) ?>
        </span>
    </td>

    <!-- Rating -->
    <td class="px-6 py-4 text-center">

        <?php if(!empty($r["rating"])): ?>

            <div class="text-yellow-500 text-lg">
                <?php
                for($i=1;$i<=5;$i++){
                    echo $i <= (int)$r["rating"] ? "⭐" : "☆";
                }
                ?>
            </div>

            <div class="text-xs text-slate-500">
                <?= $r["rating"] ?>/5
            </div>

        <?php else: ?>

            <span class="text-slate-400">
                Belum
            </span>

        <?php endif; ?>

    </td>

    <!-- Review -->
    <td class="px-6 py-4 max-w-xs">

        <?php if(!empty($r["review"])): ?>

            <div class="break-words">
                <?= htmlspecialchars($r["review"]) ?>
            </div>

        <?php else: ?>

            <span class="text-slate-400">
                -
            </span>

        <?php endif; ?>

    </td>

    <!-- Tanggal -->
    <td class="px-6 py-4 whitespace-nowrap">

        <?php if(!empty($r["created_at"])): ?>

            <?= date("d M Y H:i", strtotime($r["created_at"])) ?>

        <?php else: ?>

            -

        <?php endif; ?>

    </td>

    <!-- Aksi -->
    <td class="px-6 py-4 text-center">

        <a
            href="/admin/emergencies/<?= $r["id"] ?>"
            class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">

            Detail

        </a>

    </td>

</tr>

<?php endforeach; ?>

<?php endif; ?>

</tbody>

    </table>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/layout.blade.php";