<?php

$data = json_decode($application["application_data"] ?? "{}", true);

$nomorPeserta = "BPJ" . date("Y") . str_pad($application["id"], 8, "0", STR_PAD_LEFT);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Kartu BPJS Ketenagakerjaan</title>

<style>

body{
    font-family:Arial,Helvetica,sans-serif;
    background:#eceff3;
    margin:40px;
}

.card{

    width:900px;
    margin:auto;
    background:white;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,.15);

}

.header{

    background:#0d8f48;
    color:white;
    padding:30px;

}

.header h2{

    margin:0;
    font-size:28px;

}

.header p{

    margin-top:8px;

}

.content{

    padding:35px;

}

.row{

    display:flex;
    margin-bottom:18px;

}

.label{

    width:250px;
    font-weight:bold;

}

.value{

    flex:1;

}

.photo{

    width:140px;
    height:170px;
    border:2px solid #ddd;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#fafafa;

}

.footer{

    display:flex;
    justify-content:space-between;
    margin-top:50px;

}

.qr{

    width:110px;
    height:110px;
    border:1px solid #000;
    display:flex;
    justify-content:center;
    align-items:center;

}

.watermark{

    position:fixed;
    top:35%;
    left:15%;
    font-size:120px;
    color:#d8d8d8;
    transform:rotate(-30deg);
    opacity:.2;

}

</style>

</head>

<body>

<div class="watermark">

SIMULASI

</div>

<div class="card">

<div class="header">

<h2>BPJS KETENAGAKERJAAN</h2>

<p>Kartu Kepesertaan Digital</p>

</div>

<div class="content">

<table width="100%">

<tr>

<td width="75%">

<div class="row">

<div class="label">

Nomor Peserta

</div>

<div class="value">

<?= $nomorPeserta ?>

</div>

</div>

<div class="row">

<div class="label">

Nama

</div>

<div class="value">

<?= htmlspecialchars($data["nama"] ?? "") ?>

</div>

</div>

<div class="row">

<div class="label">

NIK

</div>

<div class="value">

<?= htmlspecialchars($data["nik"] ?? "") ?>

</div>

</div>

<div class="row">

<div class="label">

Tanggal Lahir

</div>

<div class="value">

<?= htmlspecialchars($data["tanggal_lahir"] ?? "-") ?>

</div>

</div>

<div class="row">

<div class="label">

Alamat

</div>

<div class="value">

<?= htmlspecialchars($data["alamat"] ?? "") ?>

</div>

</div>

<div class="row">

<div class="label">

Nomor HP

</div>

<div class="value">

<?= htmlspecialchars($data["hp"] ?? "") ?>

</div>

</div>

<div class="row">

<div class="label">

Jenis Kepesertaan

</div>

<div class="value">

Bukan Penerima Upah (BPU)

</div>

</div>

<div class="row">

<div class="label">

Status

</div>

<div class="value">

AKTIF

</div>

</div>

</td>

<td align="center">

<div class="photo">

FOTO

</div>

</td>

</tr>

</table>

<div class="footer">

<div>

<div class="qr">

QR CODE

</div>

<div align="center">

Verifikasi

</div>

</div>

<div align="center">

Jakarta,

<?= date("d F Y") ?>

<br><br><br>

______________________

<br>

Petugas BPJS

</div>

</div>

</div>

</div>

</body>

</html>