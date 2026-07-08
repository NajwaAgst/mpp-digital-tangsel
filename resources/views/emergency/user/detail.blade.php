<?php

$title="Detail Laporan Emergency";

ob_start();

$status=$report["status"] ?? "Menunggu";

?>

<div class="max-w-6xl mx-auto px-6 py-10">

<div class="flex justify-between items-center mb-8">

<div>

<h1 class="text-3xl font-bold text-red-600">

🚨 Detail Laporan

</h1>

<p class="text-slate-500">

Laporan #<?= htmlspecialchars($report["id"]) ?>

</p>

</div>

<a
href="/emergency/history"
class="bg-slate-700 text-white px-5 py-3 rounded-xl">

← Kembali

</a>

</div>

<div class="grid lg:grid-cols-2 gap-8">

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

<?= htmlspecialchars($report["nama"]) ?>

</td>

</tr>

<tr>

<td class="py-2 font-semibold">

NIK

</td>

<td>

<?= htmlspecialchars($report["nik"]) ?>

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

$badge="bg-yellow-100 text-yellow-700";

if($status=="Diproses"){
$badge="bg-blue-100 text-blue-700";
}

if($status=="Selesai"){
$badge="bg-green-100 text-green-700";
}

?>

<span class="px-4 py-2 rounded-full <?= $badge ?>">

<?= htmlspecialchars($status) ?>

</span>

</td>

</tr>

<tr>

<td class="py-2 font-semibold">

Tanggal

</td>

<td>

<?= date("d M Y H:i",strtotime($report["created_at"])) ?>

</td>

</tr>

</table>

</div>

<div class="bg-white rounded-2xl shadow p-8">

<h2 class="text-xl font-bold mb-6">

Detail Kejadian

</h2>

<div class="mb-6">

<div class="font-semibold mb-2">

Alamat

</div>

<div class="text-slate-600">

<?= nl2br(htmlspecialchars($report["alamat"] ?? "-")) ?>

</div>

</div>

<div class="mb-6">

<div class="font-semibold mb-2">

Lokasi

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

<div class="bg-white rounded-2xl shadow p-8 mt-8">

<h2 class="text-xl font-bold mb-6">

Progress Penanganan

</h2>

<div class="space-y-8">

<div class="flex items-center">

<div class="w-10 h-10 rounded-full flex items-center justify-center <?= in_array($status,["Menunggu","Diproses","Selesai"]) ? "bg-green-600 text-white":"bg-gray-300" ?>">

✓

</div>

<div class="ml-5">

<div class="font-bold">

Laporan Diterima

</div>

<div class="text-slate-500">

Laporan berhasil dikirim.

</div>

</div>

</div>

<div class="flex items-center">

<div class="w-10 h-10 rounded-full flex items-center justify-center <?= in_array($status,["Diproses","Selesai"]) ? "bg-green-600 text-white":"bg-gray-300" ?>">

✓

</div>

<div class="ml-5">

<div class="font-bold">

Sedang Diproses

</div>

<div class="text-slate-500">

Petugas sedang menangani laporan.

</div>

</div>

</div>

<div class="flex items-center">

<div class="w-10 h-10 rounded-full flex items-center justify-center <?= $status=="Selesai" ? "bg-green-600 text-white":"bg-gray-300" ?>">

✓

</div>

<div class="ml-5">

<div class="font-bold">

Penanganan Selesai

</div>

<div class="text-slate-500">

Kasus telah ditutup.

</div>

</div>

</div>

</div>

</div>

<?php if($status=="Selesai"): ?>

<div class="bg-green-50 border border-green-200 rounded-2xl p-8 mt-8">

<h2 class="text-2xl font-bold text-green-700">

🎉 Penanganan Selesai

</h2>

<p class="mt-3 text-green-700">

Laporan Anda telah selesai ditangani oleh petugas Emergency 112.

Terima kasih atas partisipasi Anda.

</p>

</div>

<?php endif; ?>

</div>

<?php

$content=ob_get_clean();

include __DIR__."/../layout_emergency.blade.php";

?>