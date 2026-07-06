<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<style>

body{

font-family:DejaVu Sans;

font-size:12px;

}

table{

width:100%;

border-collapse:collapse;

}

th,td{

border:1px solid #000;

padding:8px;

}

th{

background:#ddd;

}

</style>

</head>

<body>

<h2>

Laporan Emergency 112

</h2>

<table>

<tr>

<th>ID</th>

<th>Nama</th>

<th>Kategori</th>

<th>Status</th>

<th>Tanggal</th>

</tr>

<?php foreach($reports as $r): ?>

<tr>

<td><?= $r["id"] ?></td>

<td><?= htmlspecialchars($r["nama"]) ?></td>

<td><?= htmlspecialchars($r["category"]) ?></td>

<td><?= htmlspecialchars($r["status"]) ?></td>

<td><?= $r["created_at"] ?></td>

</tr>

<?php endforeach; ?>

</table>

</body>

</html>