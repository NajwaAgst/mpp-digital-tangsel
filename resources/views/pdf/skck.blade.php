<?php

$data = json_decode($application["application_data"] ?? "{}", true);

$nomor = "SKCK-" . date("Y") . "-" . str_pad($application["id"],6,"0",STR_PAD_LEFT);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>SKCK</title>

<style>

body{

    font-family:Arial;

    margin:40px;

    background:#f5f5f5;

}

.page{

    width:900px;

    margin:auto;

    background:white;

    padding:35px;

    border:3px solid #000;

}

.header{

    text-align:center;

    border-bottom:3px solid black;

    padding-bottom:15px;

}

.header h2{

    margin:0;

}

.header h3{

    margin-top:5px;

}

table{

    width:100%;

    border-collapse:collapse;

}

td{

    padding:7px;

}

.photo{

    width:140px;

    height:180px;

    border:2px solid #000;

    text-align:center;

}

.sidik{

    width:120px;

    height:120px;

    border:2px solid #000;

    text-align:center;

}

.qr{

    width:110px;

    height:110px;

    border:1px solid black;

    text-align:center;

}

.watermark{

    position:fixed;

    top:35%;

    left:18%;

    font-size:140px;

    color:#ddd;

    transform:rotate(-30deg);

    opacity:.2;

}

</style>

</head>

<body>

<div class="watermark">

SIMULASI

</div>

<div class="page">

<div class="header">

<h2>KEPOLISIAN NEGARA REPUBLIK INDONESIA</h2>

<h3>SURAT KETERANGAN CATATAN KEPOLISIAN</h3>

<p>No : <?= $nomor ?></p>

</div>

<br>

<table>

<tr>

<td width="70%">

<table>

<tr>

<td width="170">

Nama

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

Tempat Lahir

</td>

<td>

<?= htmlspecialchars($data["tempat_lahir"] ?? "-") ?>

</td>

</tr>

<tr>

<td>

Tanggal Lahir

</td>

<td>

<?= htmlspecialchars($data["tanggal_lahir"] ?? "-") ?>

</td>

</tr>

<tr>

<td>

Alamat

</td>

<td>

<?= htmlspecialchars($data["alamat"] ?? "") ?>

</td>

</tr>

<tr>

<td>

Keperluan

</td>

<td>

<?= htmlspecialchars($data["keperluan_skck"] ?? "Administrasi") ?>

</td>

</tr>

<tr>

<td>

Berlaku Sampai

</td>

<td>

<?= date("d-m-Y",strtotime("+6 Months")) ?>

</td>

</tr>

</table>

</td>

<td align="center">

<div class="photo">

FOTO

</div>

</td>

</tr>

</table>

<br><br>

<table>

<tr>

<td align="center">

<div class="sidik">

SIDIK<br>JARI

</div>

</td>

<td align="center">

<div class="qr">

QR CODE

</div>

</td>

<td align="center">

Jakarta,

<?= date("d F Y") ?>

<br><br><br><br>

_____________________

<br>

Kasat Intelkam

</td>

</tr>

</table>

<br>

<hr>

<p style="font-size:12px;text-align:center">

Dokumen ini merupakan hasil simulasi aplikasi Mall Pelayanan Publik Digital.

</p>

</div>

</body>

</html>