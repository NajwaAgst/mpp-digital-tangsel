<?php

$title = "Emergency 112";

ob_start();

?>

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
                <th class="px-6 py-4 text-left">Tanggal</th>
                <th class="px-6 py-4 text-center">Aksi</th>

            </tr>

        </thead>

        <tbody>

        <?php if (empty($reports)): ?>

            <tr>

                <td colspan="8" class="py-10 text-center text-slate-500">

                    Belum ada laporan Emergency 112.

                </td>

            </tr>

        <?php else: ?>

            <?php foreach ($reports as $r): ?>

                <?php

                $badge = "bg-yellow-100 text-yellow-700";

                if (($r["status"] ?? "") == "Diproses") {
                    $badge = "bg-blue-100 text-blue-700";
                }

                if (($r["status"] ?? "") == "Selesai") {
                    $badge = "bg-green-100 text-green-700";
                }

                ?>

                <tr class="border-b hover:bg-slate-50 transition">

                    <td class="px-6 py-4 font-semibold">

                        #<?= htmlspecialchars($r["id"] ?? "") ?>

                    </td>

                    <td class="px-6 py-4">

                        <?= htmlspecialchars($r["nama"] ?? "-") ?>

                    </td>

                    <td class="px-6 py-4">

                        <?= htmlspecialchars($r["nik"] ?? "-") ?>

                    </td>

                    <td class="px-6 py-4">

                        <?= htmlspecialchars($r["phone"] ?? "-") ?>

                    </td>

                    <td class="px-6 py-4">

                        <?= htmlspecialchars($r["emergency_type"] ?? "-") ?>

                    </td>

                    <td class="px-6 py-4">

                        <span class="rounded-full px-3 py-1 text-sm font-semibold <?= $badge ?>">

                            <?= htmlspecialchars($r["status"] ?? "-") ?>

                        </span>

                    </td>

                    <td class="px-6 py-4">

                        <?php if (!empty($r["created_at"])): ?>

                            <?= date("d M Y H:i", strtotime($r["created_at"])) ?>

                        <?php else: ?>

                            -

                        <?php endif; ?>

                    </td>

                    <td class="px-6 py-4 text-center">

                        <a
                            href="/admin/emergencies/<?= $r["id"] ?>"
                            class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">

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

?>