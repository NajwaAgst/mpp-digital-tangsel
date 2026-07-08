<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>

body{
    font-family: DejaVu Sans,sans-serif;
    font-size:13px;
}

h1{
    text-align:center;
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

</style>
</head>
<body>

<h1>HASIL LAYANAN MPP</h1>

<p>
Dokumen ini diterbitkan oleh Mall Pelayanan Publik Digital.
</p>

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
<td>DISETUJUI</td>
</tr>

<tr>
<td>Tanggal</td>
<td><?= date('d-m-Y') ?></td>
</tr>

</table>

<br><br>

<p>
Dokumen ini diterbitkan secara elektronik oleh
Mall Pelayanan Publik Digital.
</p>

</body>
</html>