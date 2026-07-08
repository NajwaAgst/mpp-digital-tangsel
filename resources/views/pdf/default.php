<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<style>

body{

font-family:DejaVu Sans;

font-size:13px;

}

table{

width:100%;

border-collapse:collapse;

margin-top:20px;

}

td{

border:1px solid #000;

padding:8px;

}

h2{

text-align:center;

}

</style>

</head>

<body>

<h2>

HASIL LAYANAN MPP

</h2>

<table>

<tr>

<td width="35%">Nomor Pengajuan</td>

<td><?= $application['id'] ?></td>

</tr>

<tr>

<td>Layanan</td>

<td><?= htmlspecialchars($application['service_name']) ?></td>

</tr>

<tr>

<td>Nama</td>

<td><?= htmlspecialchars($application['nama']) ?></td>

</tr>

<tr>

<td>NIK</td>

<td><?= htmlspecialchars($application['nik']) ?></td>

</tr>

<tr>

<td>Status</td>

<td><?= htmlspecialchars($application['status']) ?></td>

</tr>

<tr>

<td>Tanggal</td>

<td><?= date("d-m-Y") ?></td>

</tr>

</table>

<br><br>

<p>

Dokumen ini diterbitkan secara elektronik oleh

Mall Pelayanan Publik Digital.

</p>

</body>

</html>