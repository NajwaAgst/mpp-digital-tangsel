<?php

$title = "Riwayat Pengajuan";

ob_start();

?>

<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-emerald-700">
                📄 Riwayat Pengajuan Layanan
            </h1>
            <p class="text-slate-500 mt-2">
                Seluruh pengajuan layanan MPP yang pernah Anda buat.
            </p>
        </div>

        <a href="/services" class="rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white hover:bg-emerald-700">
            + Ajukan Layanan Baru
        </a>
    </div>

    <?php if(isset($_SESSION["success"])): ?>
        <div class="mb-6 rounded-xl bg-green-100 border border-green-300 px-5 py-4 text-green-700">
            <?= $_SESSION["success"] ?>
        </div>
        <?php unset($_SESSION["success"]); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION["error"])): ?>
        <div class="mb-6 rounded-xl bg-red-100 border border-red-300 px-5 py-4 text-red-700">
            <?= $_SESSION["error"] ?>
        </div>
        <?php unset($_SESSION["error"]); ?>
    <?php endif; ?>

    <?php if(empty($applications)): ?>
        <div class="rounded-3xl bg-white p-16 text-center shadow-lg">
            <div class="mb-6 text-7xl">📂</div>
            <h2 class="text-2xl font-bold text-slate-700">Belum Ada Pengajuan</h2>
            <p class="mt-4 text-slate-500">Anda belum pernah mengajukan layanan.</p>
            <a href="/services" class="mt-8 inline-block rounded-xl bg-emerald-600 px-8 py-4 text-white hover:bg-emerald-700">
                Ajukan Sekarang
            </a>
        </div>
    <?php else: ?>

    <div class="overflow-x-auto rounded-3xl bg-white shadow-lg">
        <table class="min-w-full">
            <thead class="bg-slate-100">
                <tr>
                    <th class="px-6 py-4 text-left">ID</th>
                    <th class="px-6 py-4 text-left">Layanan</th>
                    <th class="px-6 py-4 text-left">Status</th>
                    <th class="px-6 py-4 text-left">Tanggal</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($applications as $row): ?>
                <?php
                $status = $row["status"] ?? "Pending";
                $badge = "bg-yellow-100 text-yellow-700";

                if($status=="Diproses"){
                    $badge="bg-blue-100 text-blue-700";
                }
                if($status=="Approved" || $status=="Selesai"){
                    $badge="bg-green-100 text-green-700";
                }
                if($status=="Rejected" || $status=="Ditolak"){
                    $badge="bg-red-100 text-red-700";
                }
                ?>

                <tr class="border-b hover:bg-slate-50">
                    <td class="px-6 py-5">#<?= $row["id"] ?></td>
                    <td class="px-6 py-5">
                        <div class="font-semibold"><?= htmlspecialchars($row["service_name"] ?? "-") ?></div>
                        <div class="text-sm text-slate-500"><?= htmlspecialchars($row["service_slug"] ?? "-") ?></div>
                    </td>
                    <td class="px-6 py-5">
                        <span class="rounded-full px-3 py-1 text-sm font-semibold <?= $badge ?>">
                            <?= htmlspecialchars($status) ?>
                        </span>
                    </td>
                    <td class="px-6 py-5">
                        <?= !empty($row["created_at"]) ? date("d M Y H:i", strtotime($row["created_at"])) : "-" ?>
                    </td>
                    <td class="px-6 py-5 text-center">
                        <a href="/services/history/<?= $row["id"] ?>" class="rounded-lg bg-slate-600 px-4 py-2 text-white hover:bg-slate-700">
                            Detail
                        </a>

                        <?php if($status=="Approved" || $status=="Selesai"): ?>
                            <?php if(empty($row["rating"])): ?>
                                <button onclick="jalankanAksiDownloadDanRating(<?= $row["id"] ?>)" class="ml-2 rounded-lg bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
                                    Download PDF
                                </button>
                            <?php else: ?>
                                <span class="ml-2 rounded-lg bg-yellow-100 px-4 py-2 text-yellow-700 font-semibold">
                                    Sudah Dinilai ⭐ <?= $row["rating"]["rating"] ?>/5
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<div id="ratingModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
    <div class="w-full max-w-lg rounded-3xl bg-white p-8">
        <h2 class="text-2xl font-bold text-emerald-700">⭐ Berikan Penilaian</h2>
        <p class="mt-2 text-slate-500">Bagaimana pengalaman Anda menggunakan layanan ini?</p>

        <form id="ratingForm" method="POST" onsubmit="submitRating(event)">
            <input type="hidden" id="ratingValue" name="rating" required>

            <div id="stars" class="mt-6 flex justify-center gap-3 text-5xl cursor-pointer">
                <span onclick="setRating(1)">☆</span>
                <span onclick="setRating(2)">☆</span>
                <span onclick="setRating(3)">☆</span>
                <span onclick="setRating(4)">☆</span>
                <span onclick="setRating(5)">☆</span>
            </div>

            <textarea name="comment" rows="5" class="mt-6 w-full rounded-xl border p-4" placeholder="Masukan / Kritik / Saran"></textarea>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="closeRating()" class="rounded-xl border px-5 py-2">Nanti</button>
                <button type="submit" class="rounded-xl bg-emerald-600 px-6 py-2 text-white hover:bg-emerald-700">
                    Kirim Penilaian
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function jalankanAksiDownloadDanRating(id) {
    // 1. Trigger download dokumen via window.open (agar berjalan di background/tab baru tersembunyi)
    window.open("/services/download/" + id, "_blank");

    // 2. Berikan jeda 600ms sebentar supaya download ke-trigger browser, lalu munculkan modal rating
    setTimeout(function() {
        openRating(id);
    }, 600);
}

function openRating(id) {
    document.getElementById("ratingModal").classList.remove("hidden");
    document.getElementById("ratingModal").classList.add("flex");
    document.getElementById("ratingForm").action = "/services/rating/" + id;
}

function closeRating() {
    document.getElementById("ratingModal").classList.remove("flex");
    document.getElementById("ratingModal").classList.add("hidden");
}

function setRating(rating) {
    document.getElementById("ratingValue").value = rating;
    let stars = document.querySelectorAll("#stars span");
    stars.forEach(function(star, index) {
        star.innerHTML = index < rating ? "★" : "☆";
    });
}

function submitRating(e) {
    e.preventDefault();

    let form = document.getElementById("ratingForm");

    fetch(form.action, {
        method: "POST",
        body: new FormData(form)
    })
    .then(() => {
        closeRating();
        // Refresh halaman utama agar session flash message sukses & teks "Sudah Dinilai" terupdate
        location.reload();
    });
}
</script>

<?php
$content = ob_get_clean();
include __DIR__ . "/../layout.blade.php";
?>