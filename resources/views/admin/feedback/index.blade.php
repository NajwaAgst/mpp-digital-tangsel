<?php
$title = "Feedback Layanan";
ob_start();
?>

<div class="max-w-7xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-emerald-700 mb-2">💬 Feedback & Ulasan Layanan</h1>
    <p class="text-slate-500 mb-8">Kritik, saran, dan nilai kepuasan yang dikirimkan oleh masyarakat pemohon.</p>

    <div class="overflow-x-auto rounded-3xl bg-white shadow-lg">
        <table class="min-w-full">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left">Layanan</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Rating</th>
                    <th class="px-6 py-4 text-left">Kritik / Saran / Komentar</th>
                    <th class="px-6 py-4 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($feedbacks)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400">Belum ada feedback masuk.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($feedbacks as $fb): ?>
                        <tr class="border-b hover:bg-slate-50">
                            <td class="px-6 py-5 font-semibold text-slate-700">
                                <?= htmlspecialchars($fb['service_name']) ?>
                            </td>
                            <td class="px-6 py-5 text-slate-600">
                                <div class="font-medium"><?= htmlspecialchars($fb['nama']) ?></div>
                                <div class="text-xs text-slate-400">NIK: <?= htmlspecialchars($fb['nik']) ?></div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-yellow-500 text-lg">
                                    <?= str_repeat('★', $fb['rating']) . str_repeat('☆', 5 - $fb['rating']) ?>
                                </div>
                                <span class="text-xs text-slate-400 font-bold"><?= $fb['rating'] ?>/5</span>
                            </td>
                            <td class="px-6 py-5 text-slate-600 max-w-md">
                                <p class="italic text-sm">"<?= htmlspecialchars($fb['comment'] ?: '-') ?>"</p>
                            </td>
                            <td class="px-6 py-5 text-sm text-slate-400">
                                <?= !empty($fb['aplikasi_tanggal']) ? date("d M Y H:i", strtotime($fb['aplikasi_tanggal'])) : date("d M Y") ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . "/../layout.blade.php";
?>