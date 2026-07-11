<?php

$data = json_decode($application["application_data"] ?? "{}", true);

$nop = $data["nop"] ??
"36.74.".rand(100,999).".".rand(100,999).".".rand(1000,9999);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>SPPT PBB</title>

<style>

body{

    font-family:Arial;

    background:#efefef;

    margin:40px;

}

.paper{

    width:900px;

    margin:auto;

    background:white;

    padding:35px;

    border:3px solid black;

}

.header{

    text-align:center;

    border-bottom:2px solid black;

    padding-bottom:15px;

}

.header h2{

    margin:0;

}

table{

    width:100%;

    border-collapse:collapse;

    margin-top:25px;

}

td{

    border:1px solid #999;

    padding:10px;

}

.label{

    width:250px;

    background:#f3f3f3;

    font-weight:bold;

}

.footer{

    margin-top:40px;

    display:flex;

    justify-content:space-between;

}

.qr{

    width:100px;

    height:100px;

    border:1px solid black;

    display:flex;

    align-items:center;

    justify-content:center;

}

.watermark{

position:fixed;

top:35%;

left:18%;

font-size:150px;

opacity:.15;

transform:rotate(-30deg);

color:#999;

}

</style>

</head>

<body>

<div class="watermark">

SIMULASI

</div>

<div class="paper">

<div class="header">

<h2>

PEMERINTAH KOTA TANGERANG SELATAN

</h2>

<h3>

SPPT PAJAK BUMI DAN BANGUNAN

</h3>

</div>

<table>

<tr>

<td class="label">

NOP

</td>

<td>

<?= $nop ?>

</td>

</tr>

<tr>

<td class="label">

Nama Wajib Pajak

</td>

<td>

<?= htmlspecialchars($data["nama"] ?? "") ?>

</td>

</tr>

<tr>

<td class="label">

Alamat

</td>

<td>

<?= htmlspecialchars($data["alamat"] ?? "") ?>

</td>

</tr>

<tr>

<td class="label">

Objek Pajak

</td>

<td>

<?= htmlspecialchars($data["alamat_objek_pajak"] ?? "") ?>

</td>

</tr>

<tr>

<td class="label">

Tahun Pajak

</td>

<td>

<?= htmlspecialchars($data["tahun_pajak"] ?? date("Y")) ?>

</td>

</tr>

<tr>

<td class="label">

NJOP

</td>

<td>

Rp 450.000.000

</td>

</tr>

<tr>

<td class="label">

PBB Terutang

</td>

<td>

Rp 425.000

</td>

</tr>

</table>

<div class="footer">

<div>

<div class="qr">

QR

</div>

</div>

<div align="center">

Tangerang Selatan,

<?= date("d F Y") ?>

<br><br><br>

____________________

<br>

BAPENDA

</div>

</div>

</div>

</body>

</html>