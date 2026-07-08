<?php

$title = "Detail Pengajuan";

ob_start();

$status = $application["status"] ?? "Pending";

$data = [];

if (!empty($application["application_data"])) {

    $decoded = json_decode($application["application_data"], true);

    if (is_array($decoded)) {
        $data = $decoded;
    }

}

?>

<div class="max-w-6xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-3xl font-bold text-emerald-700">

                📄 Detail Pengajuan

            </h1>

            <p class="text-slate-500 mt-2">

                ID Pengajuan #<?= htmlspecialchars($application["id"]) ?>

            </p>

        </div>

        <a
            href="/services/history"
            class="bg-slate-700 hover:bg-slate-800 text-white px-6 py-3 rounded-xl">

            ← Kembali

        </a>

    </div>

    <div class="grid lg:grid-cols-2 gap-8">

        <!-- Informasi -->

        <div class="bg-white rounded-3xl shadow-lg p-8">

            <h2 class="text-xl font-bold mb-6">

                Informasi Pengajuan

            </h2>

            <table class="w-full">

                <tr class="border-b">

                    <td class="py-3 font-semibold w-44">

                        Nama Layanan

                    </td>

                    <td>

                        <?= htmlspecialchars($application["service_name"]) ?>

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        Nama

                    </td>

                    <td>

                        <?= htmlspecialchars($application["nama"]) ?>

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        NIK

                    </td>

                    <td>

                        <?= htmlspecialchars($application["nik"]) ?>

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        No HP

                    </td>

                    <td>

                        <?= htmlspecialchars($application["hp"]) ?>

                    </td>

                </tr>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        Alamat

                    </td>

                    <td>

                        <?= nl2br(htmlspecialchars($application["alamat"])) ?>

                    </td>

                </tr>

                <?php

                $badge="bg-yellow-100 text-yellow-700";

                if($status=="Diproses"){

                    $badge="bg-blue-100 text-blue-700";

                }

                if(
                    $status=="Selesai" ||
                    $status=="Approved"
                ){

                    $badge="bg-green-100 text-green-700";

                }

                if(
                    $status=="Ditolak" ||
                    $status=="Rejected"
                ){

                    $badge="bg-red-100 text-red-700";

                }

                ?>

                <tr class="border-b">

                    <td class="py-3 font-semibold">

                        Status

                    </td>

                    <td>

                        <span class="px-4 py-2 rounded-full <?= $badge ?>">

                            <?= htmlspecialchars($status) ?>

                        </span>

                    </td>

                </tr>

                <tr>

                    <td class="py-3 font-semibold">

                        Tanggal

                    </td>

                    <td>

                        <?= date("d M Y H:i",strtotime($application["created_at"])) ?>

                    </td>

                </tr>

            </table>

        </div>

        <!-- Timeline -->

        <div class="bg-white rounded-3xl shadow-lg p-8">

            <h2 class="text-xl font-bold mb-8">

                Timeline Pengajuan

            </h2>

            <div class="space-y-6">

                <div class="flex">

                    <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center">

                        ✓

                    </div>

                    <div class="ml-4">

                        <div class="font-semibold">

                            Pengajuan berhasil dikirim

                        </div>

                        <div class="text-slate-500">

                            <?= date("d M Y H:i",strtotime($application["created_at"])) ?>

                        </div>

                    </div>

                </div>

                <div class="flex">

                    <div class="w-10 h-10 rounded-full <?= $status!="Pending" ? "bg-blue-500 text-white" : "bg-slate-200" ?> flex items-center justify-center">

                        2

                    </div>

                    <div class="ml-4">

                        <div class="font-semibold">

                            Sedang diverifikasi petugas

                        </div>

                    </div>

                </div>

                <div class="flex">

                    <div class="w-10 h-10 rounded-full <?= ($status=="Selesai" || $status=="Approved") ? "bg-green-500 text-white" : "bg-slate-200" ?> flex items-center justify-center">

                        3

                    </div>

                    <div class="ml-4">

                        <div class="font-semibold">

                            Pengajuan selesai

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Data Form -->

    <div class="bg-white rounded-3xl shadow-lg p-8 mt-8">

        <h2 class="text-xl font-bold mb-6">

            Data Pengajuan

        </h2>

        <?php if(empty($data)): ?>

            <div class="text-slate-500">

                Tidak ada data tambahan.

            </div>

        <?php else: ?>

            <table class="w-full">

                <?php foreach($data as $key=>$value): ?>

                    <?php

                    if(in_array($key,[
                        "nama",
                        "nik",
                        "hp",
                        "alamat"
                    ])){
                        continue;
                    }

                    ?>

                    <tr class="border-b">

                        <td class="py-3 w-64 font-semibold">

                            <?= ucwords(str_replace("_"," ",$key)) ?>

                        </td>

                        <td>

                            <?= nl2br(htmlspecialchars((string)$value)) ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </table>

        <?php endif; ?>

    </div>

    <!-- Catatan -->

    <?php if(!empty($application["keterangan"])): ?>

    <div class="bg-white rounded-3xl shadow-lg p-8 mt-8">

        <h2 class="text-xl font-bold mb-5">

            Catatan Petugas

        </h2>

        <div class="rounded-xl bg-yellow-50 border border-yellow-200 p-5">

            <?= nl2br(htmlspecialchars($application["keterangan"])) ?>

        </div>

    </div>

    <?php endif; ?>

    <?php if($application['status']=="Approved"): ?>

<a
href="/services/history/<?= $application['id'] ?>/download"
class="inline-flex items-center rounded-lg bg-emerald-600 px-5 py-3 text-white hover:bg-emerald-700">

📄 Download PDF

</a>

<?php endif; ?>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/../layout.blade.php";