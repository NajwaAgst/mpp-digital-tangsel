<?php if(!empty($authUser)): ?>

<div class="bg-white rounded-3xl shadow p-8 mt-8">

<h2 class="text-2xl font-bold mb-6">

Riwayat Pengajuan Saya

</h2>

<table class="w-full">

<thead>

<tr>

<th>No</th>

<th>Layanan</th>

<th>Status</th>

<th>Tanggal</th>

<th></th>

</tr>

</thead>

<tbody>

<?php foreach($applications as $i=>$a): ?>

<tr class="border-b">

<td>

<?= $i+1 ?>

</td>

<td>

<?= htmlspecialchars($a["service_name"]) ?>

</td>

<td>

<?= htmlspecialchars($a["status"]) ?>

</td>

<td>

<?= date("d M Y",strtotime($a["created_at"])) ?>

</td>

<td>

<a
href="/applications/<?= $a["id"] ?>"
class="text-blue-600">

Detail

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<?php endif; ?>