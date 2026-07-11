<?php

$data = json_decode($application["application_data"] ?? "{}", true);

$passport =
"A".str_pad($application["id"],8,"0",STR_PAD_LEFT);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Paspor Republik Indonesia</title>

<style>

body{

    background:#ddd;

    font-family:Arial,Helvetica,sans-serif;

    margin:40px;

}

.passport{

    width:900px;

    margin:auto;

    background:#fff;

    border-radius:12px;

    overflow:hidden;

    box-shadow:0 15px 35px rgba(0,0,0,.25);

}

.top{

    background:#082b76;

    color:white;

    padding:25px;

}

.top h2{

    margin:0;

}

.top h3{

    margin-top:6px;

}

.content{

    padding:35px;

}

table{

    width:100%;

}

.photo{

    width:170px;

    height:220px;

    border:2px solid #222;

    display:flex;

    justify-content:center;

    align-items:center;

    background:#fafafa;

}

.label{

    width:230px;

    font-weight:bold;

}

td{

    padding:8px;

}

.mrz{

    margin-top:40px;

    border-top:2px solid #000;

    padding-top:20px;

    font-family:"Courier New";

    font-size:18px;

    letter-spacing:2px;

}

.watermark{

position:fixed;

top:35%;

left:18%;

font-size:140px;

color:#d9d9d9;

transform:rotate(-30deg);

opacity:.2;

}

.qr{

width:90px;

height:90px;

border:1px solid #000;

display:flex;

align-items:center;

justify-content:center;

}

</style>

</head>

<body>

<div class="watermark">

SIMULASI

</div>

<div class="passport">

<div class="top">

<h2>REPUBLIK INDONESIA</h2>

<h3>PASPOR</h3>

</div>

<div class="content">

<table>

<tr>

<td width="75%">

<table>

<tr>

<td class="label">

Nomor Paspor

</td>

<td>

<?= $passport ?>

</td>

</tr>

<tr>

<td class="label">

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

<?= htmlspecialchars($data["tempat_lahir"] ?? "") ?>

</td>

</tr>

<tr>

<td>

Tanggal Lahir

</td>

<td>

<?= htmlspecialchars($data["tanggal_lahir"] ?? "") ?>

</td>

</tr>

<tr>

<td>

Jenis Kelamin

</td>

<td>

<?= htmlspecialchars($data["jenis_kelamin"] ?? "L/P") ?>

</td>

</tr>

<tr>

<td>

Kewarganegaraan

</td>

<td>

INDONESIA

</td>

</tr>

<tr>

<td>

Tanggal Terbit

</td>

<td>

<?= date("d-m-Y") ?>

</td>

</tr>

<tr>

<td>

Tanggal Berakhir

</td>

<td>

<?= date("d-m-Y",strtotime("+10 years")) ?>

</td>

</tr>

</table>

</td>

<td align="center">

<div class="photo">

FOTO

</div>

<br>

<div class="qr">

QR

</div>

</td>

</tr>

</table>

<div class="mrz">

P&lt;IDN<?= strtoupper(substr($data["nama"] ?? "USER",0,25)) ?>

<br>

<?= $passport ?>IDN<?= date("ymd") ?>M<?= rand(100000000,999999999) ?>

</div>

</div>

</div>

</body>

</html>