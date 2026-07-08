<?php

$title = "Riwayat Laporan Emergency";

ob_start();

?>

<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-red-600">
                🚨 Riwayat Laporan Emergency
            </h1>

            <p class="text-slate-500 mt-2">
                Pantau perkembangan laporan emergency yang pernah Anda kirim.
            </p>

        </div>

        <a
            href="/emergency/report"
            class="bg-red-600 text-white px-5 py-3 rounded-xl hover:bg-red-700">

            + Buat Laporan Baru

        </a>

    </div>

    <?php if(empty($reports)): ?>

        <div class="bg-white rounded-2xl shadow p-12 text-center">

            <div class="text-7xl mb-5">
                📭
            </div>

            <h2 class="text-2xl font-bold mb-3">

                Belum Ada Laporan

            </h2>

            <p class="text-slate-500 mb-8">

                Anda belum pernah membuat laporan Emergency 112.

            </p>

            <a
                href="/emergency/report"
                class="bg-red-600 text-white px-6 py-3 rounded-xl hover:bg-red-700">

                Buat Laporan

            </a>

        </div>

    <?php else: ?>

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="min-w-full">

            <thead class="bg-slate-100">

                <tr>

                    <th class="px-6 py-4 text-left">
                        ID
                    </th>

                    <th class="px-6 py-4 text-left">
                        Kategori
                    </th>

                    <th class="px-6 py-4 text-left">
                        Lokasi
                    </th>

                    <th class="px-6 py-4 text-left">
                        Tanggal
                    </th>

                    <th class="px-6 py-4 text-left">
                        Status
                    </th>

                    <th class="px-6 py-4 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($reports as $r): ?>

                <?php

                $badge="bg-yellow-100 text-yellow-700";

                if($r["status"]=="Diproses"){
                    $badge="bg-blue-100 text-blue-700";
                }

                if($r["status"]=="Selesai"){
                    $badge="bg-green-100 text-green-700";
                }

                ?>

                <tr class="border-b hover:bg-slate-50">

                    <td class="px-6 py-5 font-semibold">

                        #<?= htmlspecialchars($r["id"]) ?>

                    </td>

                    <td class="px-6 py-5">

                        <?= htmlspecialchars($r["emergency_type"] ?? "-") ?>

                    </td>

                    <td class="px-6 py-5">

                        <?= htmlspecialchars($r["location"] ?? "-") ?>

                    </td>

                    <td class="px-6 py-5">

                        <?= date("d M Y H:i",strtotime($r["created_at"])) ?>

                    </td>

                    <td class="px-6 py-5">

                        <span class="px-4 py-2 rounded-full <?= $badge ?>">

                            <?= htmlspecialchars($r["status"]) ?>

                        </span>

                    </td>

                    <td class="px-6 py-5 text-center">

                        <a
                            href="/emergency/history/<?= $r["id"] ?>"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">

                            Detail

                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <?php endif; ?>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/../layout_emergency.blade.php";

?>