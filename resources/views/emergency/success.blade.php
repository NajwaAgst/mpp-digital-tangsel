<?php

$title = "Laporan Berhasil";

ob_start();

?>

<div class="max-w-4xl mx-auto px-6 py-12">

    <div class="bg-white rounded-3xl shadow-xl p-10 text-center">

        <div class="text-8xl mb-6">
            ✅
        </div>

        <h1 class="text-4xl font-bold text-green-600 mb-4">
            Laporan Berhasil Dikirim
        </h1>

        <p class="text-slate-600 text-lg mb-10">
            Terima kasih telah menggunakan layanan Emergency 112.
            Laporan Anda telah berhasil diterima oleh sistem dan sedang
            menunggu petugas untuk melakukan penanganan.
        </p>

        <div class="bg-slate-50 rounded-2xl p-8 text-left">

            <h2 class="font-bold text-xl mb-6">
                Detail Laporan
            </h2>

            <table class="w-full">

                <tr class="border-b">
                    <td class="py-3 font-semibold w-56">
                        ID Laporan
                    </td>
                    <td>
                        #<?= htmlspecialchars($report["id"] ?? "") ?>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-semibold">
                        Nama Pelapor
                    </td>
                    <td>
                        <?= htmlspecialchars($report["nama"] ?? "") ?>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-semibold">
                        NIK
                    </td>
                    <td>
                        <?= htmlspecialchars($report["nik"] ?? "") ?>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-semibold">
                        Nomor HP
                    </td>
                    <td>
                        <?= htmlspecialchars($report["phone"] ?? "") ?>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-semibold">
                        Jenis Emergency
                    </td>
                    <td>
                        <?= htmlspecialchars($report["emergency_type"] ?? "") ?>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-semibold">
                        Lokasi
                    </td>
                    <td>
                        <?= htmlspecialchars($report["location"] ?? "") ?>
                    </td>
                </tr>

                <tr class="border-b">
                    <td class="py-3 font-semibold">
                        Deskripsi
                    </td>
                    <td>
                        <?= nl2br(htmlspecialchars($report["description"] ?? "")) ?>
                    </td>
                </tr>

                <?php if (!empty($report["alamat"])): ?>

                <tr class="border-b">
                    <td class="py-3 font-semibold">
                        Alamat
                    </td>
                    <td>
                        <?= htmlspecialchars($report["alamat"]) ?>
                    </td>
                </tr>

                <?php endif; ?>

                <tr class="border-b">
                    <td class="py-3 font-semibold">
                        Status
                    </td>
                    <td>

                        <?php

                        $status = $report["status"] ?? "Menunggu";

                        $badge = "bg-yellow-100 text-yellow-700";

                        if ($status == "Diproses") {
                            $badge = "bg-blue-100 text-blue-700";
                        }

                        if ($status == "Selesai") {
                            $badge = "bg-green-100 text-green-700";
                        }

                        ?>

                        <span class="<?= $badge ?> px-4 py-2 rounded-lg font-semibold">

                            <?= htmlspecialchars($status) ?>

                        </span>

                    </td>
                </tr>

                <tr>
                    <td class="py-3 font-semibold">
                        Waktu Laporan
                    </td>
                    <td>
                        <?= htmlspecialchars($report["created_at"] ?? "") ?>
                    </td>
                </tr>

            </table>

        </div>

        <?php if (
            !empty($report["latitude"]) &&
            !empty($report["longitude"])
        ): ?>

            <div class="mt-10">

                <h2 class="font-bold text-xl mb-5">

                    Lokasi Kejadian

                </h2>

                <iframe
                    class="w-full rounded-xl border"
                    height="400"
                    loading="lazy"
                    src="https://maps.google.com/maps?q=<?= urlencode($report["latitude"]) ?>,<?= urlencode($report["longitude"]) ?>&z=16&output=embed">
                </iframe>

            </div>

        <?php endif; ?>

        <div class="mt-10 flex justify-center gap-5">

            <a
                href="/"
                class="bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700">

                Kembali ke Beranda

            </a>

            <a
                href="/emergency"
                class="border px-8 py-4 rounded-xl hover:bg-gray-100">

                Emergency Home

            </a>

        </div>

    </div>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/../layout_emergency.blade.php";