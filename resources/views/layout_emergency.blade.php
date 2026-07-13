<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? "Emergency 112" ?></title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 min-h-screen">

<!-- ===========================
NAVBAR
=========================== -->

<header class="bg-red-600 shadow-lg">

    <div class="max-w-7xl mx-auto px-6">

        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <a href="/emergency" class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-red-600 font-bold">

                    🚨

                </div>

                <div>

                    <h1 class="font-bold text-white">
                        Emergency 112
                    </h1>

                    <p class="text-xs text-red-100">
                        Kota Tangerang Selatan
                    </p>

                </div>

            </a>

            <!-- Menu -->
            <nav class="hidden md:flex items-center gap-8 text-white">

                

                <a href="/emergency" class="hover:text-red-200">
                    Dashboard
                </a>

                <a href="/emergency/report" class="hover:text-red-200">
                    Buat Laporan
                </a>

                <a href="/emergency/history">
    Riwayat
</a>

            </nav>

            <!-- Login / User -->
            <div>

                <?php if (!empty($_SESSION['logged_in'])): ?>

                    <div class="flex items-center gap-4">

                        <span class="text-white font-medium">

                            Halo,
                            <?= htmlspecialchars($_SESSION['user']['name']) ?>

                        </span>

                        <form action="/auth/logout" method="POST">

                            <button
                                class="bg-white text-red-600 px-4 py-2 rounded-lg font-semibold hover:bg-red-100 transition">

                                Logout

                            </button>

                        </form>

                    </div>

                <?php else: ?>

                    <!-- ==============================
                    FIX DI SINI
                    =============================== -->

                    <a
                        href="/emergency/login?redirect=/emergency/report"
                        class="bg-white text-red-600 px-5 py-2 rounded-lg font-semibold hover:bg-red-100 transition">

                        Login

                    </a>

                <?php endif; ?>

            </div>

        </div>

    </div>

</header>


<!-- ===========================
CONTENT
=========================== -->

<main>

    <?= $content ?>

</main>


<!-- ===========================
FOOTER
=========================== -->

<footer class="bg-red-700 mt-20">

    <div class="max-w-7xl mx-auto px-6 py-8 text-center text-red-100">

        <div class="text-lg font-semibold">
            Emergency Call Center 112
        </div>

        <div class="mt-2">
            Mall Pelayanan Publik Digital
        </div>

        <div>
            Kota Tangerang Selatan
        </div>

    </div>

</footer>

</body>

</html>