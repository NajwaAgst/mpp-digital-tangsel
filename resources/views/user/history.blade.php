<?php

$title = "Riwayat Pengajuan";

ob_start();

?>

<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-3xl font-bold text-emerald-700">
                📄 Riwayat Pengajuan Layanan
            </h1>

            <p class="text-slate-500 mt-2">
                Seluruh pengajuan layanan MPP yang pernah Anda buat.
            </p>

        </div>

        <a
            href="/services"
            class="rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white hover:bg-emerald-700">

            + Ajukan Layanan Baru

        </a>

    </div>

    <?php if(empty($applications)): ?>

        <div class="rounded-3xl bg-white p-16 text-center shadow-lg">

            <div class="mb-6 text-7xl">
                📂
            </div>

            <h2 class="text-2xl font-bold text-slate-700">

                Belum Ada Pengajuan

            </h2>

            <p class="mt-4 text-slate-500">

                Anda belum pernah mengajukan layanan MPP.

            </p>

            <a
                href="/services"
                class="mt-8 inline-block rounded-xl bg-emerald-600 px-8 py-4 text-white hover:bg-emerald-700">

                Ajukan Sekarang

            </a>

        </div>

    <?php else: ?>

    <div class="overflow-x-auto rounded-3xl bg-white shadow-lg">

        <table class="min-w-full">

            <thead class="bg-slate-100">

                <tr>

                    <th class="px-6 py-4 text-left">
                        ID
                    </th>

                    <th class="px-6 py-4 text-left">
                        Layanan
                    </th>

                    <th class="px-6 py-4 text-left">
                        Status
                    </th>

                    <th class="px-6 py-4 text-left">
                        Tanggal
                    </th>

                    <th class="px-6 py-4 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php foreach($applications as $row): ?>

                <?php

                $status = $row["status"] ?? "Pending";

                $badge = "bg-yellow-100 text-yellow-700";

                if($status=="Diproses"){
                    $badge="bg-blue-100 text-blue-700";
                }

                if($status=="Approved" || $status=="Selesai"){
                    $badge="bg-green-100 text-green-700";
                }

                if($status=="Rejected" || $status=="Ditolak"){
                    $badge="bg-red-100 text-red-700";
                }

                ?>

                <tr class="border-b hover:bg-slate-50">

                    <td class="px-6 py-5">

                        #<?= $row["id"] ?>

                    </td>

                    <td class="px-6 py-5">

                        <div class="font-semibold">

                            <?= htmlspecialchars($row["service_name"] ?? "-") ?>

                        </div>

                        <div class="text-sm text-slate-500">

                            <?= htmlspecialchars($row["service_slug"] ?? "-") ?>

                        </div>

                    </td>

                    <td class="px-6 py-5">

                        <span class="rounded-full px-3 py-1 text-sm font-semibold <?= $badge ?>">

                            <?= htmlspecialchars($status) ?>

                        </span>

                    </td>

                    <td class="px-6 py-5">

                        <?= !empty($row["created_at"])
                            ? date("d M Y H:i", strtotime($row["created_at"]))
                            : "-" ?>

                    </td>

                    <td class="px-6 py-5 text-center">

                        <a
                            href="/services/history/<?= $row["id"] ?>"
                            class="rounded-lg bg-slate-600 px-4 py-2 text-white hover:bg-slate-700">

                            Detail

                        </a>

                        <?php if(
                            ($status=="Approved" || $status=="Selesai")
                            && !empty($row["pdf_file"])
                        ): ?>

                            <a
                                href="/services/history/<?= $row["id"] ?>/download"
                                class="ml-2 rounded-lg bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">

                                Download PDF

                            </a>

                        <?php endif; ?>

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

include __DIR__ . '/layout_emergency.blade.php';