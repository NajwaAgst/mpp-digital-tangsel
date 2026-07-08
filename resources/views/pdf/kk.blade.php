<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<style>

body{

    font-family: DejaVu Sans, sans-serif;
    font-size:13px;
    margin:40px;

}

.header{

    text-align:center;
    border-bottom:2px solid #000;
    padding-bottom:15px;
    margin-bottom:25px;

}

.title{

    font-size:22px;
    font-weight:bold;

}

.subtitle{

    font-size:14px;

}

table{

    width:100%;
    border-collapse:collapse;

}

td{

    padding:8px;

}

.box{

    border:1px solid #000;
    padding:20px;
    margin-top:20px;

}

.footer{

    margin-top:70px;
    text-align:right;

}

.signature{

    margin-top:70px;

}

.badge{

    display:inline-block;
    padding:8px 18px;
    background:#16a34a;
    color:white;
    border-radius:5px;
    font-weight:bold;

}

</style>

</head>

<body>

<div class="header">

<div class="title">

PEMERINTAH KOTA TANGERANG SELATAN

</div>

<div class="subtitle">

Mall Pelayanan Publik Digital (SPBE)

</div>

<div class="subtitle">

Dokumen Elektronik Resmi

</div>

</div>


<h2 style="text-align:center">

SURAT KETERANGAN PENGAJUAN
KARTU KELUARGA

</h2>

<br>

<table>

<tr>

<td width="180">

Nomor Dokumen

</td>

<td>

:

</td>

<td>

KK-<?= date("Y") ?>-<?= str_pad($application["id"],5,"0",STR_PAD_LEFT) ?>

</td>

</tr>

<tr>

<td>

Nama

</td>

<td>

:

</td>

<td>

<?= htmlspecialchars($application["nama"]) ?>

</td>

</tr>

<tr>

<td>

NIK

</td>

<td>

:

</td>

<td>

<?= htmlspecialchars($application["nik"]) ?>

</td>

</tr>

<tr>

<td>

Alamat

</td>

<td>

:

</td>

<td>

<?= htmlspecialchars($application["alamat"]) ?>

</td>

</tr>

<tr>

<td>

Jenis Layanan

</td>

<td>

:

</td>

<td>

<?= htmlspecialchars($application["service_name"]) ?>

</td>

</tr>

<tr>

<td>

Tanggal Pengajuan

</td>

<td>

:

</td>

<td>

<?= date("d F Y",strtotime($application["created_at"])) ?>

</td>

</tr>

<tr>

<td>

Status

</td>

<td>

:

</td>

<td>

<span class="badge">

DISETUJUI

</span>

</td>

</tr>

</table>

<div class="box">

Dokumen ini diterbitkan secara elektronik melalui Sistem Pelayanan Publik Berbasis Elektronik (SPBE).

Pemohon telah memenuhi seluruh persyaratan administrasi untuk layanan Kartu Keluarga.

Dokumen ini sah tanpa tanda tangan basah.

</div>

<div class="footer">

Tangerang Selatan,

<?= date("d F Y") ?>

<br><br><br><br>

<b>

Kepala Dinas Kependudukan
dan Pencatatan Sipil

</b>

</div>

</body>

</html>