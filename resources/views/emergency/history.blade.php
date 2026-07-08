<?php

$title = "Riwayat Laporan Emergency";
$authUser = $_SESSION['user'] ?? null;

ob_start();

?>

<div class="mx-auto max-w-7xl px-6 py-10">

    <!-- HERO -->
    <div class="mb-10 overflow-hidden rounded-[2rem] bg-gradient-to-r from-red-600 to-red-500 p-10 text-white shadow-2xl">

        <div class="flex flex-col items-center justify-between gap-8 lg:flex-row">

            <div>

                <div class="mb-4 inline-flex rounded-full bg-white/20 px-4 py-2 text-sm font-semibold">

                    🚨 Emergency 112 Kota Tangerang Selatan

                </div>

                <h1 class="text-4xl font-extrabold">

                    Riwayat Laporan Emergency

                </h1>

                <p class="mt-4 max-w-2xl text-red-100">

                    Seluruh laporan emergency yang pernah Anda kirim dapat dipantau
                    status penanganannya secara realtime.

                </p>

            </div>

            <div class="flex gap-4">

                <a href="/emergency/report"
                   class="rounded-xl bg-white px-6 py-3 font-semibold text-red-600 transition hover:scale-105">

                    ➕ Buat Laporan

                </a>

                <a href="/emergency"
                   class="rounded-xl border border-white px-6 py-3 font-semibold text-white transition hover:bg-white hover:text-red-600">

                    ← Kembali

                </a>

            </div>

        </div>

    </div>

    <?php if(empty($reports)): ?>

        <div class="rounded-[2rem] bg-white p-16 text-center shadow-xl">

            <div class="text-7xl">

                📭

            </div>

            <h2 class="mt-6 text-3xl font-bold">

                Belum Ada Laporan

            </h2>

            <p class="mt-4 text-slate-500">

                Anda belum pernah membuat laporan Emergency 112.

            </p>

            <a href="/emergency/report"
               class="mt-8 inline-block rounded-xl bg-red-600 px-8 py-3 font-semibold text-white hover:bg-red-700">

                Buat Laporan Sekarang

            </a>

        </div>

    <?php else: ?>

        <div class="grid gap-6 lg:grid-cols-2">

            <?php foreach($reports as $row): ?>

                <?php

                $status = $row["status"] ?? "Menunggu";

                $badge = "bg-yellow-100 text-yellow-700";
                $icon = "🟡";

                if($status=="Diproses"){
                    $badge="bg-blue-100 text-blue-700";
                    $icon="🔵";
                }

                if($status=="Selesai"){
                    $badge="bg-green-100 text-green-700";
                    $icon="🟢";
                }

                ?>

                <div class="rounded-[2rem] bg-white p-8 shadow-xl transition duration-300 hover:-translate-y-2 hover:shadow-2xl">

                    <div class="mb-5 flex items-center justify-between">

                        <span class="rounded-full bg-red-100 px-4 py-2 text-sm font-bold text-red-600">

                            #<?= $row["id"] ?>

                        </span>

                        <span class="rounded-full px-4 py-2 text-sm font-semibold <?= $badge ?>">

                            <?= $icon ?>

                            <?= htmlspecialchars($status) ?>

                        </span>

                    </div>

                    <h2 class="mb-4 text-2xl font-bold text-slate-800">

                        <?= htmlspecialchars($row["emergency_type"] ?? '-') ?>

                    </h2>

                    <div class="space-y-3 text-slate-600">

                        <div>

                            📍
                            <strong>Lokasi</strong>

                            <div class="mt-1">

                                <?= htmlspecialchars($row["location"] ?? '-') ?>

                            </div>

                        </div>

                        <div>

                            📅
                            <strong>Tanggal</strong>

                            <div class="mt-1">

                                <?= date("d M Y H:i", strtotime($row["created_at"])) ?>

                            </div>

                        </div>

                    </div>

                    <div class="mt-8">

                        <a href="/emergency/history/<?= $row["id"] ?>"
                           class="block rounded-xl bg-red-600 py-3 text-center font-semibold text-white transition hover:bg-red-700">

                            Lihat Detail →

                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/../layout_emergency.blade.php";

?>