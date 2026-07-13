<?php

header("Content-Type: text/html; charset=UTF-8");

?>
<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Laporan Data Pengajuan MPP</title>

<style>

body{

font-family:Arial,Helvetica,sans-serif;

font-size:12px;

color:#333;

}

h2{

margin-bottom:5px;

}

table{

width:100%;

border-collapse:collapse;

margin-top:20px;

}

table th{

background:#0f766e;

color:white;

padding:8px;

border:1px solid #ddd;

}

table td{

padding:8px;

border:1px solid #ddd;

}

.text-center{

text-align:center;

}

</style>

</head>

<body>

<h2>LAPORAN DATA PENGAJUAN MPP</h2>

<p>

Tanggal Export :
<?= date("d M Y H:i") ?>

</p>

<table>

<thead>

<tr>

<th>ID</th>

<th>Nama</th>

<th>NIK</th>

<th>Layanan</th>

<th>Status</th>

<th>Tanggal</th>

</tr>

</thead>

<tbody>

<?php foreach($applications as $row): ?>

<tr>

<td class="text-center">

<?= $row["id"] ?>

</td>

<td>

<?= htmlspecialchars($row["nama"]) ?>

</td>

<td>

<?= htmlspecialchars($row["nik"]) ?>

</td>

<td>

<?= htmlspecialchars($row["service_name"]) ?>

</td>

<td>

<?= htmlspecialchars($row["status"]) ?>

</td>

<td>

<?= date("d M Y H:i",strtotime($row["created_at"])) ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</body>

</html>