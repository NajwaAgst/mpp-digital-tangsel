<?php
$title = 'Interoperability Dashboard';
ob_start();
?>

<div class="max-w-7xl mx-auto px-6 py-10">

    <h1 class="text-4xl font-bold text-emerald-700 mb-2">
        Simulasi Interoperabilitas SPBE
    </h1>

    <p class="text-gray-600 mb-10">
        Dashboard ini mensimulasikan pertukaran data antar instansi
        menggunakan NIK sebagai Single Source of Truth.
    </p>

    <!-- Input -->
    <div class="bg-white rounded-xl shadow p-6 mb-8">

        <label class="block font-semibold mb-2">
            Masukkan NIK
        </label>

        <div class="flex gap-3">

            <input
                id="nik"
                type="text"
                class="border rounded-lg px-4 py-2 w-full"
                placeholder="Masukkan NIK">

            <button
                onclick="loadData()"
                class="bg-emerald-600 text-white px-6 rounded-lg hover:bg-emerald-700">

                Ambil Data

            </button>

        </div>

    </div>

    <!-- Loader -->

    <div id="loading" class="hidden text-blue-600 mb-6">
        Mengambil data...
    </div>

    <!-- Result -->

    <div id="result"></div>

</div>

<script>

async function loadData(){

    let nik=document.getElementById("nik").value;

    if(nik===""){
        alert("Masukkan NIK");
        return;
    }

    document.getElementById("loading").classList.remove("hidden");

    document.getElementById("result").innerHTML="";

    const response=await fetch("/mock/interoperability/"+nik);

    const json=await response.json();

    document.getElementById("loading").classList.add("hidden");

    if(!json.success){

        document.getElementById("result").innerHTML=
        `
        <div class="bg-red-100 text-red-700 p-4 rounded">
            ${json.message}
        </div>
        `;

        return;
    }

    const d=json.data;

    document.getElementById("result").innerHTML=`

    <div class="grid md:grid-cols-3 gap-6">

        <div class="bg-white shadow rounded-xl p-5">

            <h2 class="font-bold text-lg text-emerald-700 mb-4">
                Dukcapil
            </h2>

            <p><b>NIK</b><br>${d.dukcapil.nik}</p>

            <p class="mt-3"><b>Nama</b><br>${d.dukcapil.nama}</p>

            <p class="mt-3"><b>Tempat Lahir</b><br>${d.dukcapil.tempat_lahir}</p>

            <p class="mt-3"><b>Tanggal Lahir</b><br>${d.dukcapil.tanggal_lahir}</p>

            <p class="mt-3"><b>Alamat</b><br>${d.dukcapil.alamat}</p>

        </div>

        <div class="bg-white shadow rounded-xl p-5">

            <h2 class="font-bold text-lg text-blue-700 mb-4">
                NPWP
            </h2>

            ${
                d.npwp
                ?
                `
                <p><b>Nomor NPWP</b><br>${d.npwp.npwp}</p>

                <p class="mt-3"><b>Status</b><br>${d.npwp.status_npwp}</p>
                `
                :
                `<p class="text-red-500">Data NPWP tidak ditemukan</p>`
            }

        </div>

        <div class="bg-white shadow rounded-xl p-5">

            <h2 class="font-bold text-lg text-purple-700 mb-4">
                OSS / NIB
            </h2>

            ${
                d.nib
                ?
                `
                <p><b>NIB</b><br>${d.nib.nib}</p>

                <p class="mt-3"><b>Nama Usaha</b><br>${d.nib.nama_usaha}</p>

                <p class="mt-3"><b>Jenis Usaha</b><br>${d.nib.jenis_usaha}</p>
                `
                :
                `<p class="text-red-500">Data NIB tidak ditemukan</p>`
            }

        </div>

    </div>

    <div class="mt-8 bg-gray-100 rounded-lg p-5">

        <h3 class="font-bold mb-3">
            Response Time
        </h3>

        <span class="text-2xl font-bold text-emerald-600">
            ${json.response_time_ms} ms
        </span>

    </div>

    `;

}

</script>

<?php
$content = ob_get_clean();

include __DIR__ . '/../layout.blade.php';
?>