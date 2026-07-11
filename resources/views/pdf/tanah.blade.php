<?php

$data = json_decode($application["application_data"] ?? "{}", true);

$nomor =
"HM-".date("Y")."-".str_pad($application["id"],8,"0",STR_PAD_LEFT);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Sertifikat Hak Milik</title>

<style>

body{

    background:#ececec;

    font-family:Arial,Helvetica,sans-serif;

    margin:40px;

}

.paper{

    width:900px;

    margin:auto;

    background:white;

    padding:40px;

    border:8px double #2e7d32;

    position:relative;

}

.header{

    text-align:center;

    border-bottom:3px solid #2e7d32;

    padding-bottom:20px;

}

.header h1{

    margin:0;

    color:#2e7d32;

    font-size:32px;

}

.header h2{

    margin:8px 0;

    font-size:22px;

}

table{

    width:100%;

    margin-top:30px;

}

td{

    padding:10px;

    vertical-align:top;

}

.label{

    width:250px;

    font-weight:bold;

}

.qr{

    width:120px;

    height:120px;

    border:2px solid #444;

    display:flex;

    align-items:center;

    justify-content:center;

}

.footer{

    margin-top:60px;

    display:flex;

    justify-content:space-between;

}

.watermark{

    position:fixed;

    top:35%;

    left:15%;

    font-size:150px;

    color:#d6d6d6;

    transform:rotate(-35deg);

    opacity:.18;

}

.note{

    margin-top:40px;

    border:1px solid #bbb;

    background:#f8f8f8;

    padding:15px;

    font-size:14px;

    line-height:1.7;

}

</style>

</head>

<body>

<div class="watermark">

SIMULASI

</div>

<div class="paper">

<div class="header">

<h1>ATR / BPN</h1>

<h2>SERTIFIKAT HAK MILIK</h2>

<h3>REPUBLIK INDONESIA</h3>

</div>

<table>

<tr>

<td class="label">

Nomor Sertifikat

</td>

<td>

<?= $nomor ?>

</td>

</tr>

<tr>

<td>

Nama Pemegang Hak

</td>

<td>

<?= htmlspecialchars($data["nama"] ?? "") ?>

</td>

</tr>

<tr>

<td>

NIK

</td>

<td>

<?= htmlspecialchars($data["nik"] ?? "") ?>

</td>

</tr>

<tr>

<td>

Alamat Pemegang

</td>

<td>

<?= htmlspecialchars($data["alamat"] ?? "") ?>

</td>

</tr>

<tr>

<td>

Lokasi Tanah

</td>

<td>

<?= htmlspecialchars($data["lokasi_tanah"] ?? "") ?>

</td>

</tr>

<tr>

<td>

Luas Tanah

</td>

<td>

<?= htmlspecialchars($data["luas_tanah"] ?? "") ?> m²

</td>

</tr>

<tr>

<td>

Status Kepemilikan

</td>

<td>

<?= htmlspecialchars($data["status_kepemilikan"] ?? "Hak Milik") ?>

</td>

</tr>

<tr>

<td>

Tanggal Terbit

</td>

<td>

<?= date("d F Y") ?>

</td>

</tr>

</table>

<div class="note">

Dokumen ini merupakan simulasi Sertifikat Hak Milik yang dihasilkan oleh aplikasi Mall Pelayanan Publik Digital (MPP Digital). Seluruh data pada dokumen ini digunakan hanya untuk keperluan demonstrasi sistem dan tidak memiliki kekuatan hukum.

</div>

<div class="footer">

<div>

<div class="qr">

QR CODE

</div>

<div align="center">

Verifikasi Digital

</div>

</div>

<div align="center">

Jakarta,

<?= date("d F Y") ?>

<br><br><br>

_____________________

<br>

Kepala Kantor Pertanahan

</div>

</div>

</div>

</body>

</html>