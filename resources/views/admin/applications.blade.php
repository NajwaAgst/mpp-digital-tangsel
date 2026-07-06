<?php

$title = "Data Pengajuan";

ob_start();

?>

<div class="space-y-8">

    <!-- ============================= -->
    <!-- Header -->
    <!-- ============================= -->

    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">

                Data Pengajuan

            </h1>

            <p class="text-slate-500 mt-2">

                Kelola seluruh pengajuan layanan masyarakat.

            </p>

        </div>

    </div>

    <!-- ============================= -->
    <!-- Search & Filter -->
    <!-- ============================= -->

    <div class="bg-white rounded-3xl shadow-lg p-6">

        <form
            action="/admin/applications"
            method="GET"
            class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <input
                type="text"
                name="search"
                value="<?= htmlspecialchars($search ?? '') ?>"
                placeholder="Cari Nama / NIK / Layanan..."
                class="border rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:outline-none">

            <select
                name="status"
                class="border rounded-xl px-4 py-3 focus:ring-2 focus:ring-emerald-500 focus:outline-none">

                <option value="">Semua Status</option>

                <option
                    value="Pending"
                    <?= (($status ?? '') == "Pending") ? "selected" : "" ?>>

                    Pending

                </option>

                <option
                    value="Approved"
                    <?= (($status ?? '') == "Approved") ? "selected" : "" ?>>

                    Approved

                </option>

                <option
                    value="Rejected"
                    <?= (($status ?? '') == "Rejected") ? "selected" : "" ?>>

                    Rejected

                </option>

            </select>

            <button
                class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold transition">

                Cari

            </button>

            <a
                href="/admin/applications"
                class="bg-slate-500 hover:bg-slate-600 text-white rounded-xl flex items-center justify-center transition">

                Reset

            </a>

        </form>

    </div>

    <!-- ============================= -->
    <!-- Table -->
    <!-- ============================= -->

    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-100">

                <tr>

                    <th class="px-5 py-4 text-left font-semibold">
                        ID
                    </th>

                    <th class="px-5 py-4 text-left font-semibold">
                        Nama
                    </th>

                    <th class="px-5 py-4 text-left font-semibold">
                        NIK
                    </th>

                    <th class="px-5 py-4 text-left font-semibold">
                        Layanan
                    </th>

                    <th class="px-5 py-4 text-left font-semibold">
                        Status
                    </th>

                    <th class="px-5 py-4 text-left font-semibold">
                        Tanggal
                    </th>

                    <th class="px-5 py-4 text-center font-semibold">
                        Aksi
                    </th>

                </tr>

                </thead>

                <tbody>

                <?php if(empty($applications)): ?>

                    <tr>

                        <td
                            colspan="7"
                            class="text-center py-12 text-slate-500">

                            Belum ada data pengajuan.

                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach($applications as $row): ?>

                        <tr class="border-t hover:bg-slate-50 transition">

                            <td class="px-5 py-4">

                                <?= $row["id"] ?>

                            </td>

                            <td class="px-5 py-4 font-medium">

                                <?= htmlspecialchars($row["nama"] ?? $row["user_name"] ?? "-") ?>

                            </td>

                            <td class="px-5 py-4">

                                <?= htmlspecialchars($row["nik"] ?? "-") ?>

                            </td>

                            <td class="px-5 py-4">

                                <?= htmlspecialchars($row["service_name"]) ?>

                            </td>

                            <td class="px-5 py-4">

                                <?php if($row["status"]=="Approved"): ?>

                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">

                                        Approved

                                    </span>

                                <?php elseif($row["status"]=="Rejected"): ?>

                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-sm font-semibold">

                                        Rejected

                                    </span>

                                <?php else: ?>

                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold">

                                        Pending

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td class="px-5 py-4">

                                <?php

                                if(!empty($row["created_at"])){

                                    echo date(
                                        "d M Y H:i",
                                        strtotime($row["created_at"])
                                    );

                                }else{

                                    echo "-";

                                }

                                ?>

                            </td>

                            <td class="px-5 py-4">

                                <div class="flex justify-center">

                                    <a
                                        href="/admin/applications/<?= $row["id"] ?>"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

                                        Detail

                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . '/layout.blade.php';

?>