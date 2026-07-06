<?php

$title = "Emergency 112";

ob_start();

?>

<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- HERO -->
    <div class="bg-gradient-to-r from-red-600 to-red-500 rounded-3xl text-white shadow-xl overflow-hidden">

        <div class="grid lg:grid-cols-2 gap-8 items-center p-10">

            <div>

                <span class="inline-block bg-white/20 px-4 py-2 rounded-full text-sm mb-5">
                    🚨 Layanan Darurat Terintegrasi MPP Digital
                </span>

                <h1 class="text-5xl font-bold mb-5">
                    Emergency Call Center 112
                </h1>

                <p class="text-lg text-red-100 leading-8">

                    Laporkan keadaan darurat secara cepat dan mudah.
                    Layanan ini terhubung dengan dashboard Admin sehingga
                    setiap laporan dapat segera diterima dan diproses.

                </p>

                <div class="mt-8 flex flex-wrap gap-4">

                    <?php if (!empty($authUser)): ?>

                        <a
                            href="/emergency/report"
                            class="bg-white text-red-600 px-7 py-4 rounded-xl font-semibold hover:bg-red-100 transition">

                            🚨 Buat Laporan

                        </a>

                    <?php else: ?>

                        <a
                            href="/emergency/login?redirect=/emergency/report"
                            class="bg-white text-red-600 px-7 py-4 rounded-xl font-semibold hover:bg-red-100 transition">

                            🚨 Login Emergency

                        </a>

                        <?php endif; ?>

                    <a
                        href="/"
                        class="border border-white px-7 py-4 rounded-xl hover:bg-white hover:text-red-600 transition">

                        Kembali ke Beranda

                    </a>

                </div>

            </div>

            <div class="text-center">

                <div class="text-[170px]">

                    🚑

                </div>

            </div>

        </div>

    </div>


    <!-- FITUR -->

    <div class="grid md:grid-cols-3 gap-6 mt-12">

        <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">

            <div class="text-6xl mb-5">
                🚒
            </div>

            <h2 class="font-bold text-xl mb-3">

                Kebakaran

            </h2>

            <p class="text-slate-600 leading-7">

                Laporkan kebakaran rumah, gedung,
                kendaraan maupun lahan agar petugas
                pemadam segera menuju lokasi.

            </p>

        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">

            <div class="text-6xl mb-5">

                🚑

            </div>

            <h2 class="font-bold text-xl mb-3">

                Kesehatan

            </h2>

            <p class="text-slate-600 leading-7">

                Digunakan untuk kondisi medis darurat,
                kecelakaan lalu lintas, serangan jantung,
                maupun keadaan yang membutuhkan ambulans.

            </p>

        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition">

            <div class="text-6xl mb-5">

                👮

            </div>

            <h2 class="font-bold text-xl mb-3">

                Keamanan

            </h2>

            <p class="text-slate-600 leading-7">

                Laporkan tindakan kriminal,
                pencurian, perkelahian,
                ataupun gangguan keamanan lainnya.

            </p>

        </div>

    </div>


    <!-- ALUR -->

    <div class="bg-white rounded-3xl shadow-lg p-10 mt-12">

        <h2 class="text-3xl font-bold text-center mb-10">

            Cara Menggunakan Layanan

        </h2>

        <div class="grid md:grid-cols-4 gap-8">

            <div class="text-center">

                <div class="text-5xl mb-4">

                    1️⃣

                </div>

                <h3 class="font-bold">

                    Login

                </h3>

                <p class="text-slate-500 mt-3">

                    Masuk menggunakan akun MPP Digital.

                </p>

            </div>

            <div class="text-center">

                <div class="text-5xl mb-4">

                    2️⃣

                </div>

                <h3 class="font-bold">

                    Isi Form

                </h3>

                <p class="text-slate-500 mt-3">

                    Isi seluruh data kejadian.

                </p>

            </div>

            <div class="text-center">

                <div class="text-5xl mb-4">

                    3️⃣

                </div>

                <h3 class="font-bold">

                    Kirim

                </h3>

                <p class="text-slate-500 mt-3">

                    Laporan langsung masuk ke Dashboard Admin.

                </p>

            </div>

            <div class="text-center">

                <div class="text-5xl mb-4">

                    4️⃣

                </div>

                <h3 class="font-bold">

                    Diproses

                </h3>

                <p class="text-slate-500 mt-3">

                    Status laporan berubah menjadi
                    Menunggu → Diproses → Selesai.

                </p>

            </div>

        </div>

    </div>


    <!-- STATUS -->

    <div class="grid md:grid-cols-3 gap-6 mt-12">

        <div class="bg-yellow-50 rounded-xl p-6 border-l-4 border-yellow-500">

            <h3 class="font-bold text-yellow-700 mb-2">

                🟡 Menunggu

            </h3>

            <p class="text-slate-600">

                Laporan telah diterima dan sedang menunggu petugas.

            </p>

        </div>

        <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-500">

            <h3 class="font-bold text-blue-700 mb-2">

                🔵 Diproses

            </h3>

            <p class="text-slate-600">

                Petugas sedang menuju lokasi kejadian.

            </p>

        </div>

        <div class="bg-green-50 rounded-xl p-6 border-l-4 border-green-500">

            <h3 class="font-bold text-green-700 mb-2">

                🟢 Selesai

            </h3>

            <p class="text-slate-600">

                Penanganan kejadian telah selesai dilakukan.

            </p>

        </div>

    </div>


    <!-- WARNING -->

    <div class="bg-red-50 border-l-4 border-red-600 rounded-xl p-8 mt-12">

        <h3 class="font-bold text-red-700 text-xl mb-3">

            ⚠ Gunakan Layanan Dengan Bijak

        </h3>

        <p class="text-red-700 leading-8">

            Emergency 112 hanya diperuntukkan bagi kondisi darurat.
            Penyalahgunaan layanan dapat dikenakan sanksi sesuai
            peraturan perundang-undangan yang berlaku.

        </p>

    </div>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/../layout_emergency.blade.php";
?>