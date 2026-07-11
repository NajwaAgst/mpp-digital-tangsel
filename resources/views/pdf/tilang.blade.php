<?php

$data = json_decode($application["application_data"] ?? "{}", true);

$nomor =
$data["nomor_tilang"]
??
"TLG".date("Y").rand(100000,999999);

$briva =
$data["nomor_briva"]
??
rand(7000000000000000,7999999999999999);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Bukti Pembayaran Tilang</title>

<style>

body{

background:#efefef;

font-family:Arial,Helvetica,sans-serif;

margin:40px;

}

.paper{

width:900px;

margin:auto;

background:white;

padding:35px;

border-radius:12px;

box-shadow:0 8px 25px rgba(0,0,0,.15);

}

.header{

background:#00529B;

color:white;

padding:20px;

margin:-35px -35px 30px;

border-radius:12px 12px 0 0;

}

.header h2{

margin:0;

}

.header p{

margin-top:8px;

}

table{

width:100%;

border-collapse:collapse;

}

td{

padding:12px;

border-bottom:1px solid #ddd;

}

.label{

width:280px;

font-weight:bold;

background:#fafafa;

}

.status{

display:inline-block;

padding:10px 20px;

background:#28a745;

color:white;

font-weight:bold;

border-radius:30px;

}

.total{

margin-top:30px;

padding:20px;

background:#e9f7ef;

border:2px solid #28a745;

font-size:28px;

font-weight:bold;

text-align:center;

color:#28a745;

}

.footer{

margin-top:45px;

display:flex;

justify-content:space-between;

}

.qr{

width:120px;

height:120px;

border:2px solid #333;

display:flex;

align-items:center;

justify-content:center;

}

.watermark{

position:fixed;

top:35%;

left:15%;

font-size:160px;

color:#ccc;

transform:rotate(-30deg);

opacity:.18;

}

.note{

margin-top:25px;

padding:18px;

background:#f9f9f9;

border-left:5px solid #00529B;

line-height:1.7;

font-size:14px;

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

🚔 KORPS LALU LINTAS POLRI

</h2>

<p>

BUKTI PEMBAYARAN DENDA TILANG ELEKTRONIK

</p>

</div>

<table>

<tr>

<td class="label">

Nomor Tilang

</td>

<td>

<?= $nomor ?>

</td>

</tr>

<tr>

<td class="label">

Nama Pelanggar

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

Nomor Kendaraan

</td>

<td>

<?= htmlspecialchars($data["nomor_kendaraan"] ?? "") ?>

</td>

</tr>

<tr>

<td class="label">

Virtual Account BRIVA

</td>

<td>

<?= $briva ?>

</td>

</tr>

<tr>

<td class="label">

Tanggal Pembayaran

</td>

<td>

<?= date("d F Y H:i") ?>

</td>

</tr>

<tr>

<td class="label">

Status

</td>

<td>

<span class="status">

LUNAS

</span>

</td>

</tr>

</table>

<div class="total">

TOTAL PEMBAYARAN

<br><br>

Rp 500.000

</div>

<div class="note">

Dokumen ini merupakan bukti pembayaran tilang yang dihasilkan oleh sistem simulasi Mall Pelayanan Publik Digital. Dokumen digunakan hanya untuk kebutuhan demonstrasi aplikasi dan bukan merupakan dokumen resmi Kepolisian Republik Indonesia.

</div>

<div class="footer">

<div>

<div class="qr">

QR CODE

</div>

<div align="center">

Validasi Digital

</div>

</div>

<div align="center">

Jakarta,

<?= date("d F Y") ?>

<br><br><br>

_____________________

<br>

Petugas ETLE

</div>

</div>

</div>

</body>

</html>