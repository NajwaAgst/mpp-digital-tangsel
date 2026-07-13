<?php

$title="Detail Emergency";

$authUser=$_SESSION["user"] ?? null;

ob_start();

$status=$report["status"] ?? "Menunggu";

?>

<div class="mx-auto max-w-6xl px-6 py-10">

    <div class="mb-8 flex justify-between">

        <div>

            <h1 class="text-3xl font-bold text-red-600">

                🚨 Detail Laporan Emergency

            </h1>

            <p class="mt-2 text-slate-500">

                ID Laporan #<?= $report["id"] ?>

            </p>

        </div>

        <a href="/emergency/history"
           class="rounded-xl bg-slate-700 px-5 py-3 text-white">

            ← Kembali

        </a>

    </div>

    <div class="rounded-3xl bg-white p-8 shadow">

        <table class="w-full">

            <tr class="border-b">

                <td class="py-4 font-semibold w-52">

                    Nama

                </td>

                <td>

                    <?= htmlspecialchars($report["nama"]) ?>

                </td>

            </tr>

            <tr class="border-b">

                <td class="py-4 font-semibold">

                    NIK

                </td>

                <td>

                    <?= htmlspecialchars($report["nik"]) ?>

                </td>

            </tr>

            <tr class="border-b">

                <td class="py-4 font-semibold">

                    No HP

                </td>

                <td>

                    <?= htmlspecialchars($report["phone"]) ?>

                </td>

            </tr>

            <tr class="border-b">

                <td class="py-4 font-semibold">

                    Kategori

                </td>

                <td>

                    <?= htmlspecialchars($report["emergency_type"]) ?>

                </td>

            </tr>

            <tr class="border-b">

                <td class="py-4 font-semibold">

                    Lokasi

                </td>

                <td>

                    <?= htmlspecialchars($report["location"]) ?>

                </td>

            </tr>

            <tr class="border-b">

                <td class="py-4 font-semibold">

                    Alamat

                </td>

                <td>

                    <?= nl2br(htmlspecialchars($report["alamat"])) ?>

                </td>

            </tr>

            <tr class="border-b">

                <td class="py-4 font-semibold">

                    Deskripsi

                </td>

                <td>

                    <?= nl2br(htmlspecialchars($report["description"])) ?>

                </td>

            </tr>

            <tr class="border-b">

                <td class="py-4 font-semibold">

                    Status

                </td>

                <td>

                    <span class="rounded-full bg-red-100 px-4 py-2 text-red-700">

                        <?= htmlspecialchars($status) ?>

                    </span>

                </td>

            </tr>

            <tr>

                <td class="py-4 font-semibold">

                    Tanggal

                </td>

                <td>

                    <?= date("d M Y H:i",strtotime($report["created_at"])) ?>

                </td>

            </tr>

        </table>

    </div>

</div>

<?php if(
    $report["status"] == "Selesai"
    && empty($report["rating"])
): ?>

<div class="mt-8 rounded-3xl bg-white p-8 shadow">

    <h2 class="text-2xl font-bold">
        ⭐ Beri Penilaian
    </h2>

    <p class="mt-2 text-slate-500">
        Bagaimana pelayanan Emergency 112 yang Anda terima?
    </p>

    <form
        action="/emergency/rating"
        method="POST"
        class="mt-6">

        <input
            type="hidden"
            name="report_id"
            value="<?= $report["id"] ?>">

        <div class="mb-5">

            <select
                name="rating"
                required
                class="w-full rounded-xl border p-3">

                <option value="">Pilih Rating</option>
                <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
                <option value="4">⭐⭐⭐⭐ Puas</option>
                <option value="3">⭐⭐⭐ Cukup</option>
                <option value="2">⭐⭐ Kurang</option>
                <option value="1">⭐ Sangat Kurang</option>

            </select>

        </div>

        <textarea
            name="review"
            rows="4"
            class="w-full rounded-xl border p-3"
            placeholder="Tulis ulasan..."></textarea>

        <button
            type="submit"
            class="mt-5 rounded-xl bg-red-600 px-6 py-3 text-white font-semibold hover:bg-red-700">

            Kirim Penilaian

        </button>

    </form>

</div>

<?php elseif(!empty($report["rating"])): ?>

<div class="mt-8 rounded-3xl bg-green-50 border border-green-200 p-8">

    <h2 class="text-2xl font-bold text-green-700">

        Terima Kasih atas Penilaian Anda

    </h2>

    <div class="mt-4 text-2xl">

        <?php
        for($i=1;$i<=5;$i++){
            echo $i <= $report["rating"] ? "⭐" : "☆";
        }
        ?>

    </div>

    <p class="mt-4 text-slate-700">

        <?= nl2br(htmlspecialchars($report["review"] ?? "-")) ?>

    </p>

</div>

<?php endif; ?>

<?php

$content = ob_get_clean();

include __DIR__ . "/../layout_emergency.blade.php";

?>