<?php

$title = "Detail Pengajuan";

ob_start();

$status = $application["status"] ?? "Pending";

?>

<div class="space-y-8">

    <!-- ====================================== -->
    <!-- Header -->
    <!-- ====================================== -->

    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                Detail Pengajuan

            </h1>

            <p class="text-slate-500 mt-2">

                Informasi lengkap pengajuan layanan masyarakat.

            </p>

        </div>

        <a
            href="/admin/applications"
            class="bg-slate-600 hover:bg-slate-700 text-white px-6 py-3 rounded-xl">

            ← Kembali

        </a>

    </div>

    <!-- ====================================== -->
    <!-- Informasi -->
    <!-- ====================================== -->

    <div class="bg-white rounded-3xl shadow-lg p-8">

        <div class="grid md:grid-cols-2 gap-8">

            <!-- LEFT -->

            <div>

                <h2 class="text-xl font-bold mb-6">

                    Informasi Pengajuan

                </h2>

                <table class="w-full">

                    <tr>

                        <td class="py-3 font-semibold w-48">

                            ID

                        </td>

                        <td>

                            <?= htmlspecialchars($application["id"]) ?>

                        </td>

                    </tr>

                    <tr>

                        <td class="py-3 font-semibold">

                            Nama

                        </td>

                        <td>

                            <?= htmlspecialchars($application["nama"] ?? "-") ?>

                        </td>

                    </tr>

                    <tr>

                        <td class="py-3 font-semibold">

                            NIK

                        </td>

                        <td>

                            <?= htmlspecialchars($application["nik"] ?? "-") ?>

                        </td>

                    </tr>

                    <tr>

                        <td class="py-3 font-semibold">

                            Layanan

                        </td>

                        <td>

                            <?= htmlspecialchars($application["service_name"] ?? "-") ?>

                        </td>

                    </tr>

                    <tr>

                        <td class="py-3 font-semibold">

                            Status

                        </td>

                        <td>

                            <?php if($status=="Approved"): ?>

                                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">

                                    Approved

                                </span>

                            <?php elseif($status=="Rejected"): ?>

                                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full font-semibold">

                                    Rejected

                                </span>

                            <?php else: ?>

                                <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full font-semibold">

                                    Pending

                                </span>

                            <?php endif; ?>

                        </td>

                    </tr>

                    <tr>

                        <td class="py-3 font-semibold">

                            Tanggal

                        </td>

                        <td>

                            <?= !empty($application["created_at"])
                                ? date("d M Y H:i", strtotime($application["created_at"]))
                                : "-" ?>

                        </td>

                    </tr>

                </table>

            </div>

            <!-- RIGHT -->

            <div>

                <h2 class="text-xl font-bold mb-6">

                    Ringkasan

                </h2>

                <div class="grid grid-cols-2 gap-5">

                    <div class="rounded-2xl bg-blue-50 p-6">

                        <div class="text-slate-500">

                            Nomor Pengajuan

                        </div>

                        <div class="text-3xl font-bold mt-3">

                            #<?= htmlspecialchars($application["id"]) ?>

                        </div>

                    </div>

                    <div class="rounded-2xl bg-emerald-50 p-6">

                        <div class="text-slate-500">

                            Status

                        </div>

                        <div class="text-2xl font-bold mt-3">

                            <?= htmlspecialchars($status) ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ====================================== -->
    <!-- FORM DATA -->
    <!-- ====================================== -->

    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-2xl font-bold mb-6">

            Data Pengajuan

        </h2>

        <?php

        $formData = [];

        if(!empty($application["form_data"])){

            $formData = json_decode($application["form_data"], true);

        }

        ?>

        <?php if(empty($formData)): ?>

            <div class="text-slate-500">

                Tidak ada data tambahan.

            </div>

        <?php else: ?>

            <div class="overflow-x-auto">

                <table class="min-w-full border">

                    <thead class="bg-slate-100">

                    <tr>

                        <th class="border px-5 py-3 text-left">

                            Field

                        </th>

                        <th class="border px-5 py-3 text-left">

                            Value

                        </th>

                    </tr>

                    </thead>

                    <tbody>

                    <?php foreach($formData as $key=>$value): ?>

                        <tr>

                            <td class="border px-5 py-3 font-semibold">

                                <?= htmlspecialchars(ucwords(str_replace("_"," ",$key))) ?>

                            </td>

                            <td class="border px-5 py-3">

                                <?= htmlspecialchars(is_array($value) ? implode(", ",$value) : $value) ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

    <!-- ====================================== -->
    <!-- ACTION -->
    <!-- ====================================== -->

    <div class="bg-white rounded-3xl shadow-lg p-8">

        <h2 class="text-xl font-bold mb-6">

            Aksi Administrator

        </h2>

        <div class="flex flex-wrap gap-4">

            <form
                method="POST"
                action="/admin/applications/<?= $application["id"] ?>/approve">

                <button
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl">

                    ✅ Approve

                </button>

            </form>

            <form
                method="POST"
                action="/admin/applications/<?= $application["id"] ?>/reject">

                <button
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-xl">

                    ⚠ Reject

                </button>

            </form>

            <form
                method="POST"
                action="/admin/applications/<?= $application["id"] ?>/pending">

                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

                    🔄 Pending

                </button>

            </form>

            <form
                method="POST"
                action="/admin/applications/<?= $application["id"] ?>/delete"
                onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?');">

                <button
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl">

                    🗑 Delete

                </button>

            </form>

        </div>

    </div>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . '/../layout.blade.php';

?>