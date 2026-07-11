<?php
$data = json_decode($application["application_data"] ?? "{}", true);

$nomorNib = "9120" . str_pad($application["id"], 9, "0", STR_PAD_LEFT);

header("Content-Type:text/html;charset=UTF-8");
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>NIB OSS</title>

<style>

body{
    font-family:Arial,Helvetica,sans-serif;
    background:#f5f5f5;
    margin:0;
    padding:40px;
}

.page{

    background:#fff;
    width:900px;
    margin:auto;
    border:3px solid #005baa;
    padding:35px;

}

.header{

    display:flex;
    justify-content:space-between;
    align-items:center;
    border-bottom:3px solid #005baa;
    padding-bottom:20px;

}

.logo{

    width:70px;
    height:70px;
    border-radius:50%;
    border:2px solid #005baa;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    color:#005baa;

}

.title{

    text-align:center;
    flex:1;

}

.title h2{

    margin:0;
    color:#005baa;

}

.title h3{

    margin-top:6px;

}

.watermark{

    position:fixed;
    top:35%;
    left:15%;
    font-size:120px;
    color:#d8d8d8;
    transform:rotate(-30deg);
    opacity:.25;
    z-index:-1;

}

.info{

    margin-top:30px;

}

table{

    width:100%;
    border-collapse:collapse;

}

td{

    padding:10px;
    border-bottom:1px solid #ddd;

}

.label{

    width:260px;
    font-weight:bold;

}

.box{

    margin-top:30px;
    border:1px solid #005baa;
    padding:20px;
    border-radius:8px;

}

.qr{

    width:100px;
    height:100px;
    border:1px solid #000;
    display:flex;
    justify-content:center;
    align-items:center;

}

.footer{

    margin-top:60px;
    display:flex;
    justify-content:space-between;

}

.signature{

    text-align:center;

}

</style>

</head>

<body>

<div class="watermark">

SIMULASI

</div>

<div class="page">

<div class="header">

<div class="logo">

OSS

</div>

<div class="title">

<h2>ONLINE SINGLE SUBMISSION</h2>

<h3>NOMOR INDUK BERUSAHA (NIB)</h3>

</div>

<div class="logo">

RBA

</div>

</div>

<div class="info">

<table>

<tr>

<td class="label">

Nomor Induk Berusaha

</td>

<td>

<strong><?= $nomorNib ?></strong>

</td>

</tr>

<tr>

<td class="label">

Nama Pelaku Usaha

</td>

<td>

<?= htmlspecialchars($data["nama"] ?? "") ?>

</td>

</tr>

<tr>

<td class="label">

NIK

</td>

<td>

<?= htmlspecialchars($data["nik"] ?? "") ?>

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

Email

</td>

<td>

<?= htmlspecialchars($application["user_email"] ?? "-") ?>

</td>

</tr>

<tr>

<td class="label">

Nomor HP

</td>

<td>

<?= htmlspecialchars($data["hp"] ?? "-") ?>

</td>

</tr>

<tr>

<td class="label">

Nama Usaha

</td>

<td>

<?= htmlspecialchars($data["nama_usaha"] ?? "Usaha Perseorangan") ?>

</td>

</tr>

<tr>

<td class="label">

KBLI

</td>

<td>

<?= htmlspecialchars($data["kbli"] ?? "47111") ?>

</td>

</tr>

<tr>

<td class="label">

Jenis Usaha

</td>

<td>

<?= htmlspecialchars($data["jenis_usaha"] ?? "Perdagangan") ?>

</td>

</tr>

<tr>

<td class="label">

Status

</td>

<td>

AKTIF

</td>

</tr>

</table>

</div>

<div class="box">

<strong>Keterangan</strong>

<p>

Nomor Induk Berusaha ini diterbitkan secara elektronik melalui sistem
OSS-RBA sebagai dokumen simulasi pada aplikasi Mall Pelayanan Publik
Digital.

</p>

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

<div class="signature">

<p>

Jakarta,

<?= date("d F Y") ?>

</p>

<br><br><br>

_____________________

<br>

Kepala OSS

</div>

</div>

</div>

</body>

</html>