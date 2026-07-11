<?php
$data = json_decode($application["application_data"] ?? "{}", true);

$nomorKK = "3175" . str_pad($application["id"], 12, "0", STR_PAD_LEFT);

header("Content-Type: text/html; charset=UTF-8");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">

<title>Kartu Keluarga</title>

<style>

body{
    font-family:Arial,Helvetica,sans-serif;
    margin:40px;
    color:#000;
}

.watermark{
    position:fixed;
    top:35%;
    left:15%;
    font-size:120px;
    color:#d9d9d9;
    transform:rotate(-30deg);
    z-index:-1;
    opacity:.35;
    font-weight:bold;
}

.header{
    text-align:center;
    margin-bottom:20px;
}

.header h2{
    margin:0;
    font-size:24px;
}

.header h3{
    margin:4px 0;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,
td{
    border:1px solid #000;
    padding:8px;
    font-size:13px;
}

.info td{
    border:none;
    padding:4px;
}

.footer{
    margin-top:50px;
    text-align:right;
}

.qr{
    width:90px;
    height:90px;
    border:1px solid #000;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:11px;
}

.small{
    font-size:12px;
}

</style>

</head>

<body>

<div class="watermark">
SIMULASI
</div>

<div class="header">

<h2>PEMERINTAH REPUBLIK INDONESIA</h2>

<h3>KARTU KELUARGA</h3>

<p><strong>No. <?= $nomorKK ?></strong></p>

</div>

<table class="info">

<tr>

<td width="200">Nama Kepala Keluarga</td>

<td width="10">:</td>

<td><?= htmlspecialchars($data["nama"] ?? "") ?></td>

</tr>

<tr>

<td>Alamat</td>

<td>:</td>

<td><?= htmlspecialchars($data["alamat"] ?? "") ?></td>

</tr>

<tr>

<td>No. HP</td>

<td>:</td>

<td><?= htmlspecialchars($data["hp"] ?? "-") ?></td>

</tr>

</table>

<br>

<table>

<thead>

<tr>

<th>No</th>

<th>Nama Lengkap</th>

<th>NIK</th>

<th>Tempat Lahir</th>

<th>Tanggal Lahir</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<tr>

<td align="center">1</td>

<td><?= htmlspecialchars($data["nama"] ?? "") ?></td>

<td><?= htmlspecialchars($data["nik"] ?? "") ?></td>

<td><?= htmlspecialchars($data["tempat_lahir"] ?? "-") ?></td>

<td><?= htmlspecialchars($data["tanggal_lahir"] ?? "-") ?></td>

<td><?= htmlspecialchars($data["status_perkawinan"] ?? "-") ?></td>

</tr>

</tbody>

</table>

<div class="footer">

<p>Jakarta, <?= date("d F Y") ?></p>

<p>Kepala Dinas Kependudukan</p>

<br><br><br>

<strong>______________________</strong>

<div style="float:left">

<div class="qr">

QR CODE

</div>

<p class="small">

Verifikasi Digital

</p>

</div>

</div>

</body>
</html>