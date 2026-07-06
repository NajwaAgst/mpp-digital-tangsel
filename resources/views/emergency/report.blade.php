<?php

$title = "Laporan Emergency 112";

ob_start();

?>

<div class="max-w-5xl mx-auto px-6 py-10">

    <div class="bg-white rounded-3xl shadow-xl p-8">

        <h1 class="text-4xl font-bold text-red-600 mb-2">
            🚨 Form Laporan Emergency
        </h1>

        <p class="text-slate-500 mb-8">
            Isi data kejadian secara lengkap agar petugas dapat segera melakukan penanganan.
        </p>

        <?php if (!empty($errors)): ?>

            <div class="bg-red-100 border border-red-300 rounded-xl p-5 mb-6">

                <h4 class="font-semibold text-red-700 mb-2">
                    Terjadi Kesalahan
                </h4>

                <ul class="list-disc ml-6 text-red-700">

                    <?php foreach ($errors as $error): ?>

                        <li><?= htmlspecialchars($error) ?></li>

                    <?php endforeach; ?>

                </ul>

            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="grid md:grid-cols-2 gap-6">

                <!-- Nama -->

                <div>

                    <label class="font-semibold">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama"
                        required
                        class="w-full mt-2 border rounded-xl p-3"
                        value="<?= htmlspecialchars($_POST['nama'] ?? ($authUser['name'] ?? '')) ?>">

                </div>

                <!-- NIK -->

                <div>

                    <label class="font-semibold">
                        NIK
                    </label>

                    <input
                        type="text"
                        name="nik"
                        readonly
                        class="w-full mt-2 border rounded-xl p-3 bg-gray-100"
                        value="<?= htmlspecialchars($_POST['nik'] ?? ($authUser['nik'] ?? '')) ?>">

                </div>

                <!-- Nomor HP -->

                <div>

                    <label class="font-semibold">
                        Nomor HP
                    </label>

                    <input
                        type="text"
                        name="phone"
                        required
                        class="w-full mt-2 border rounded-xl p-3"
                        value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">

                </div>

                <!-- Alamat -->

                <div>

                    <label class="font-semibold">
                        Alamat
                    </label>

                    <input
                        type="text"
                        name="alamat"
                        required
                        class="w-full mt-2 border rounded-xl p-3"
                        value="<?= htmlspecialchars($_POST['alamat'] ?? '') ?>">

                </div>

            </div>

            <!-- Jenis -->

            <div class="mt-6">

                <label class="font-semibold">
                    Jenis Kejadian
                </label>

                <select
                    name="emergency_type"
                    required
                    class="w-full mt-2 border rounded-xl p-3">

                    <option value="">-- Pilih --</option>

                    <?php foreach ($categories as $category): ?>

                        <option
                            value="<?= htmlspecialchars($category) ?>"
                            <?= (($_POST['emergency_type'] ?? '') == $category) ? 'selected' : '' ?>>

                            <?= htmlspecialchars($category) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- Lokasi -->

            <div class="mt-6">

                <label class="font-semibold">
                    Lokasi Kejadian
                </label>

                <textarea
                    name="location"
                    rows="3"
                    required
                    class="w-full mt-2 border rounded-xl p-3"><?= htmlspecialchars($_POST['location'] ?? '') ?></textarea>

            </div>

            <!-- Deskripsi -->

            <div class="mt-6">

                <label class="font-semibold">
                    Deskripsi Kejadian
                </label>

                <textarea
                    name="description"
                    rows="6"
                    required
                    class="w-full mt-2 border rounded-xl p-3"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>

            </div>

            <!-- GPS -->

            <input
                type="hidden"
                id="latitude"
                name="latitude"
                value="<?= htmlspecialchars($_POST['latitude'] ?? '') ?>">

            <input
                type="hidden"
                id="longitude"
                name="longitude"
                value="<?= htmlspecialchars($_POST['longitude'] ?? '') ?>">

            <div class="mt-6">

                <button
                    type="button"
                    onclick="ambilLokasi()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

                    📍 Gunakan Lokasi Saya

                </button>

                <div
                    id="lokasi-info"
                    class="mt-3 text-green-600 font-semibold">

                </div>

            </div>

            <div class="mt-10 flex gap-4">

                <button
                    type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-xl font-semibold">

                    🚨 Kirim Laporan

                </button>

                <a
                    href="/emergency"
                    class="border px-8 py-4 rounded-xl">

                    Batal

                </a>

            </div>

        </form>

    </div>

</div>

<script>

function ambilLokasi(){

    if(!navigator.geolocation){

        alert("Browser tidak mendukung GPS.");
        return;

    }

    navigator.geolocation.getCurrentPosition(

        function(position){

            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;

            document.getElementById("lokasi-info").innerHTML =
                "📍 Lokasi berhasil diperoleh<br>" +
                "Latitude : " + position.coords.latitude +
                "<br>Longitude : " + position.coords.longitude;

        },

        function(){

            alert("Lokasi gagal diperoleh.");

        }

    );

}

</script>

<?php

$content = ob_get_clean();

include __DIR__ . "/../layout_emergency.blade.php";