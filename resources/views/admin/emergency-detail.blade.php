<?php

$title = "Detail Emergency 112";

ob_start();

$status = $report["status"] ?? "Menunggu";

?>

<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="flex items-center justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                🚨 Detail Laporan Emergency
            </h1>

            <p class="text-slate-500 mt-2">
                ID Laporan #<?= htmlspecialchars($report["id"] ?? "") ?>
            </p>

        </div>

        <a
            href="/admin/emergencies"
            class="rounded-lg bg-slate-700 px-5 py-3 text-white hover:bg-slate-800">

            ← Kembali

        </a>

    </div>

    <!-- Informasi -->
    <div class="grid lg:grid-cols-2 gap-8">

        <!-- Pelapor -->
        <div class="bg-white rounded-2xl shadow p-8">

            <h2 class="text-xl font-bold mb-6">

                Informasi Pelapor

            </h2>

            <table class="w-full">

                <tr>

                    <td class="py-2 font-semibold w-44">
                        Nama
                    </td>

                    <td>
                        <?= htmlspecialchars($report["nama"] ?? "-") ?>
                    </td>

                </tr>

                <tr>

                    <td class="py-2 font-semibold">
                        NIK
                    </td>

                    <td>
                        <?= htmlspecialchars($report["nik"] ?? "-") ?>
                    </td>

                </tr>

                <tr>

                    <td class="py-2 font-semibold">
                        No HP
                    </td>

                    <td>
                        <?= htmlspecialchars($report["phone"] ?? "-") ?>
                    </td>

                </tr>

                <tr>

                    <td class="py-2 font-semibold">
                        Kategori
                    </td>

                    <td>
                        <?= htmlspecialchars($report["emergency_type"] ?? "-") ?>
                    </td>

                </tr>

                <tr>

                    <td class="py-2 font-semibold">
                        Status
                    </td>

                    <td>

                        <?php

                        $badge = "bg-yellow-100 text-yellow-700";

                        if ($status == "Diproses") {
                            $badge = "bg-blue-100 text-blue-700";
                        }

                        if ($status == "Selesai") {
                            $badge = "bg-green-100 text-green-700";
                        }

                        ?>

                        <span class="px-3 py-1 rounded-full <?= $badge ?>">

                            <?= htmlspecialchars($status) ?>

                        </span>

                    </td>

                </tr>

                <tr>

                    <td class="py-2 font-semibold">
                        Tanggal
                    </td>

                    <td>

                        <?php if (!empty($report["created_at"])): ?>

                            <?= date("d M Y H:i", strtotime($report["created_at"])) ?>

                        <?php else: ?>

                            -

                        <?php endif; ?>

                    </td>

                </tr>

            </table>

        </div>

        <!-- Detail -->
        <div class="bg-white rounded-2xl shadow p-8">

            <h2 class="text-xl font-bold mb-6">

                Detail Kejadian

            </h2>

            <div class="mb-6">

                <div class="font-semibold mb-2">

                    Lokasi Kejadian

                </div>

                <div class="text-slate-600">

                    <?= nl2br(htmlspecialchars($report["location"] ?? "-")) ?>

                </div>

            </div>

            <div>

                <div class="font-semibold mb-2">

                    Deskripsi

                </div>

                <div class="text-slate-600 leading-7">

                    <?= nl2br(htmlspecialchars($report["description"] ?? "-")) ?>

                </div>

            </div>

        </div>

    </div>

    <!-- Foto -->
    <?php if (!empty($report["photo"])): ?>

        <div class="bg-white rounded-2xl shadow p-8 mt-8">

            <h2 class="text-xl font-bold mb-6">

                Foto Kejadian

            </h2>

            <img
                src="/uploads/emergency/<?= htmlspecialchars($report["photo"]) ?>"
                class="rounded-xl border max-h-[500px]"
                alt="Foto Emergency">

        </div>

    <?php endif; ?>

    <!-- Google Maps -->
    <?php if (!empty($report["latitude"]) && !empty($report["longitude"])): ?>

        <div class="bg-white rounded-2xl shadow p-8 mt-8">

            <h2 class="text-xl font-bold mb-6">

                Lokasi Kejadian

            </h2>

            <iframe
                width="100%"
                height="450"
                class="rounded-xl border"
                loading="lazy"
                src="https://maps.google.com/maps?q=<?= urlencode($report["latitude"]) ?>,<?= urlencode($report["longitude"]) ?>&output=embed">
            </iframe>

        </div>

    <?php endif; ?>

    <!-- Update Status -->
    <div class="bg-white rounded-2xl shadow p-8 mt-8">

        <h2 class="text-xl font-bold mb-6">

            Update Status

        </h2>

        <div class="flex gap-4 flex-wrap">

            <form
                method="POST"
                action="/admin/emergencies/<?= $report["id"] ?>/waiting">

                <button
                    class="px-6 py-3 rounded-xl bg-yellow-500 text-white hover:bg-yellow-600">

                    Menunggu

                </button>

            </form>

            <form
                method="POST"
                action="/admin/emergencies/<?= $report["id"] ?>/process">

                <button
                    class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700">

                    Diproses

                </button>

            </form>

            <form
                method="POST"
                action="/admin/emergencies/<?= $report["id"] ?>/done">

                <button
                    class="px-6 py-3 rounded-xl bg-green-600 text-white hover:bg-green-700">

                    Selesai

                </button>

            </form>

            <form
                method="POST"
                action="/admin/emergencies/<?= $report["id"] ?>/delete"
                onsubmit="return confirm('Hapus laporan ini?')">

                <button
                    class="px-6 py-3 rounded-xl bg-red-600 text-white hover:bg-red-700">

                    🗑 Hapus

                </button>

            </form>

        </div>

    </div>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/layout.blade.php";
?>