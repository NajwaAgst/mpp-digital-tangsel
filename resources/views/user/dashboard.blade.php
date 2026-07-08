<?php

$title = "Dashboard Saya";

$authUser = $_SESSION['user'] ?? null;

$applications = $applications ?? [];

ob_start();

?>

<div class="mx-auto max-w-7xl px-6 py-10">

    <div class="mb-10">

        <h1 class="text-4xl font-bold text-emerald-700">
            Dashboard Saya
        </h1>

        <p class="mt-2 text-slate-500">
            Selamat datang,
            <strong><?= htmlspecialchars($authUser["name"] ?? "Pengguna") ?></strong>
        </p>

    </div>

    <!-- Statistik -->

    <div class="grid gap-6 md:grid-cols-3">

        <div class="rounded-3xl bg-white p-8 shadow">

            <div class="text-sm text-slate-500">
                Total Pengajuan
            </div>

            <div class="mt-3 text-5xl font-bold text-emerald-600">
                <?= count($applications) ?>
            </div>

        </div>

        <div class="rounded-3xl bg-white p-8 shadow">

            <div class="text-sm text-slate-500">
                Pengajuan Diproses
            </div>

            <div class="mt-3 text-5xl font-bold text-blue-600">

                <?= count(array_filter($applications,function($item){

                    return ($item["status"] ?? "")=="Diproses";

                })) ?>

            </div>

        </div>

        <div class="rounded-3xl bg-white p-8 shadow">

            <div class="text-sm text-slate-500">
                Pengajuan Selesai
            </div>

            <div class="mt-3 text-5xl font-bold text-green-600">

                <?= count(array_filter($applications,function($item){

                    return
                        ($item["status"] ?? "")=="Approved"
                        ||
                        ($item["status"] ?? "")=="Selesai";

                })) ?>

            </div>

        </div>

    </div>

    <!-- Shortcut -->

    <div class="mt-10 flex gap-4">

        <a
            href="/services"
            class="rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white hover:bg-emerald-700">

            Ajukan Layanan

        </a>

        <a
            href="/services/history"
            class="rounded-xl border border-emerald-600 px-6 py-3 font-semibold text-emerald-600 hover:bg-emerald-50">

            Lihat Riwayat

        </a>

    </div>

    <!-- Riwayat -->

    <div class="mt-12 rounded-3xl bg-white p-8 shadow">

        <div class="mb-6 flex items-center justify-between">

            <h2 class="text-2xl font-bold">
                Riwayat Pengajuan Terbaru
            </h2>

            <a
                href="/services/history"
                class="text-sm font-semibold text-emerald-600">

                Lihat Semua →

            </a>

        </div>

        <?php if(empty($applications)): ?>

            <div class="py-10 text-center text-slate-500">
                Belum ada pengajuan.
            </div>

        <?php else: ?>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead>

                    <tr class="border-b bg-slate-100">

                        <th class="px-4 py-3 text-left">
                            Layanan
                        </th>

                        <th class="px-4 py-3 text-left">
                            Status
                        </th>

                        <th class="px-4 py-3 text-left">
                            Tanggal
                        </th>

                        <th class="px-4 py-3 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php foreach(array_slice($applications,0,5) as $row): ?>

                    <?php

                    $status = $row["status"] ?? "Pending";

                    $color = "bg-yellow-100 text-yellow-700";

                    if($status=="Diproses"){
                        $color="bg-blue-100 text-blue-700";
                    }

                    if($status=="Approved" || $status=="Selesai"){
                        $color="bg-green-100 text-green-700";
                    }

                    if($status=="Rejected"){
                        $color="bg-red-100 text-red-700";
                    }

                    ?>

                    <tr class="border-b hover:bg-slate-50">

                        <td class="px-4 py-4">
                            <?= htmlspecialchars($row["service_name"] ?? "-") ?>
                        </td>

                        <td class="px-4 py-4">

                            <span class="rounded-full px-3 py-1 text-sm font-semibold <?= $color ?>">

                                <?= htmlspecialchars($status) ?>

                            </span>

                        </td>

                        <td class="px-4 py-4">

                            <?= !empty($row["created_at"])
                                ? date("d M Y", strtotime($row["created_at"]))
                                : "-" ?>

                        </td>

                        <td class="px-4 py-4 text-center">

                            <a
                                href="/services/history/<?= $row["id"] ?>"
                                class="rounded-lg bg-slate-600 px-3 py-2 text-sm text-white hover:bg-slate-700">

                                Detail

                            </a>

                            <?php if(
                                ($status=="Approved" || $status=="Selesai")
                                && !empty($row["pdf_file"])
                            ): ?>

                                <a
                                    href="/services/history/<?= $row["id"] ?>/download"
                                    class="ml-2 rounded-lg bg-emerald-600 px-3 py-2 text-sm text-white hover:bg-emerald-700">

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

</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/../layout.blade.php";