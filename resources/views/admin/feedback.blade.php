<?php

$title = "Feedback Layanan";

ob_start();

?>

<div class="max-w-7xl mx-auto p-8">

    <h1 class="text-3xl font-bold mb-8">
        Feedback Layanan
    </h1>

    <!-- ============================= -->
    <!-- FEEDBACK MPP -->
    <!-- ============================= -->

    <div class="bg-white rounded-2xl shadow mb-10">

        <div class="flex justify-between items-center p-6 border-b">

            <h2 class="text-2xl font-bold">
                🏛️ Feedback Layanan MPP
            </h2>

            <span class="rounded-full bg-green-100 text-green-700 px-4 py-2 font-semibold">
                Total : <?= count($mppFeedback) ?>
            </span>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-100">

                <tr>

                    <th class="px-4 py-3 text-left">Layanan</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-center">Rating</th>
                    <th class="px-4 py-3 text-left">Komentar</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>

                </tr>

                </thead>

                <tbody>

                <?php if(empty($mppFeedback)): ?>

                    <tr>

                        <td colspan="5" class="text-center py-10 text-slate-500">
                            Belum ada feedback.
                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach($mppFeedback as $row): ?>

                    <tr class="border-b hover:bg-slate-50">

                        <td class="px-4 py-4">
                            <?= htmlspecialchars($row["service_name"]) ?>
                        </td>

                        <td class="px-4 py-4">
                            <?= htmlspecialchars($row["nama"]) ?>
                        </td>

                        <td class="px-4 py-4 text-center">

                            <?php
                            for($i=1;$i<=5;$i++){
                                echo $i <= (int)$row["rating"] ? "⭐" : "☆";
                            }
                            ?>

                            <div class="text-xs text-slate-500">
                                <?= $row["rating"] ?>/5
                            </div>

                        </td>

                        <td class="px-4 py-4">
                            <?= htmlspecialchars($row["comment"]) ?>
                        </td>

                        <td class="px-4 py-4">
                            <?= date("d M Y H:i", strtotime($row["created_at"])) ?>
                        </td>

                    </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

    <!-- ============================= -->
    <!-- FEEDBACK EMERGENCY -->
    <!-- ============================= -->

    <div class="bg-white rounded-2xl shadow">

        <div class="flex justify-between items-center p-6 border-b">

            <h2 class="text-2xl font-bold">
                🚨 Feedback Emergency 112
            </h2>

            <span class="rounded-full bg-red-100 text-red-700 px-4 py-2 font-semibold">
                Total : <?= count($emergencyFeedback) ?>
            </span>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-100">

                <tr>

                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center">Rating</th>
                    <th class="px-4 py-3 text-left">Review</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>

                </tr>

                </thead>

                <tbody>

                <?php if(empty($emergencyFeedback)): ?>

                    <tr>

                        <td colspan="6" class="text-center py-10 text-slate-500">
                            Belum ada feedback Emergency.
                        </td>

                    </tr>

                <?php else: ?>

                    <?php foreach($emergencyFeedback as $row): ?>

                    <tr class="border-b hover:bg-slate-50">

                        <td class="px-4 py-4">
                            <?= htmlspecialchars($row["nama"]) ?>
                        </td>

                        <td class="px-4 py-4">
                            <?= htmlspecialchars($row["emergency_type"]) ?>
                        </td>

                        <td class="px-4 py-4">

                            <span class="rounded-full px-3 py-1 bg-green-100 text-green-700 text-sm">
                                <?= htmlspecialchars($row["status"]) ?>
                            </span>

                        </td>

                        <td class="px-4 py-4 text-center">

                            <?php
                            for($i=1;$i<=5;$i++){
                                echo $i <= (int)$row["rating"] ? "⭐" : "☆";
                            }
                            ?>

                            <div class="text-xs text-slate-500">
                                <?= $row["rating"] ?>/5
                            </div>

                        </td>

                        <td class="px-4 py-4">
                            <?= htmlspecialchars($row["review"]) ?>
                        </td>

                        <td class="px-4 py-4">
                            <?= date("d M Y H:i", strtotime($row["created_at"])) ?>
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

include __DIR__ . "/layout.blade.php";