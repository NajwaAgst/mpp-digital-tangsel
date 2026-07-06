<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$authUser = $_SESSION["user"] ?? null;

$currentPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? "SPBE Admin") ?></title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Chart JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- ========================= -->
    <!-- SIDEBAR -->
    <!-- ========================= -->

    <aside class="w-72 bg-slate-900 text-white flex flex-col shadow-xl">

        <!-- Logo -->
        <div class="px-8 py-8 border-b border-slate-700">

            <h1 class="text-3xl font-bold tracking-wide">
                SPBE
            </h1>

            <p class="text-slate-400 mt-1">
                Admin Dashboard
            </p>

        </div>

        <!-- User -->
        <div class="px-8 py-6 border-b border-slate-700">

            <div class="w-14 h-14 rounded-full bg-emerald-500 flex items-center justify-center text-xl font-bold">

                <?= strtoupper(substr($authUser["name"] ?? "A",0,1)) ?>

            </div>

            <div class="mt-3 font-semibold">

                <?= htmlspecialchars($authUser["name"] ?? "Administrator") ?>

            </div>

            <div class="text-sm text-slate-400">

                <?= htmlspecialchars($authUser["email"] ?? "") ?>

            </div>

            <div class="mt-3">

                <span class="bg-emerald-600 px-3 py-1 rounded-full text-xs font-semibold">

                    ADMIN

                </span>

            </div>

        </div>

        <!-- ========================= -->
        <!-- MENU -->
        <!-- ========================= -->

        <nav class="flex-1 py-6">

            <!-- Dashboard -->
            <a
                href="/admin"
                class="block px-8 py-4 transition duration-200
                <?= ($currentPath=="/admin" || $currentPath=="/admin/dashboard")
                    ? "bg-emerald-600 text-white"
                    : "hover:bg-slate-800 text-slate-200" ?>">

                📊 Dashboard

            </a>

            <!-- Pengajuan -->
            <a
                href="/admin/applications"
                class="block px-8 py-4 transition duration-200
                <?= str_contains($currentPath,"/admin/applications")
                    ? "bg-emerald-600 text-white"
                    : "hover:bg-slate-800 text-slate-200" ?>">

                📄 Data Pengajuan MPP

            </a>

            <!-- Emergency -->
            <a
                href="/admin/emergencies"
                class="block px-8 py-4 transition duration-200
                <?= str_contains($currentPath,"/admin/emergencies")
                    ? "bg-red-600 text-white"
                    : "hover:bg-slate-800 text-slate-200" ?>">

                🚨 Emergency 112

            </a>

        </nav>

        <!-- ========================= -->
        <!-- Logout -->
        <!-- ========================= -->

        <div class="p-6 border-t border-slate-700">

            <form method="POST" action="/auth/logout">

                <button
                    type="submit"
                    class="w-full rounded-xl bg-red-600 py-3 font-semibold hover:bg-red-700 transition">

                    Logout

                </button>

            </form>

        </div>

    </aside>

    <!-- ========================= -->
    <!-- CONTENT -->
    <!-- ========================= -->

    <main class="flex-1 flex flex-col">

        <!-- Header -->

        <header class="bg-white shadow px-10 py-6 flex justify-between items-center">

            <div>

                <h2 class="text-3xl font-bold text-slate-800">

                    <?= htmlspecialchars($title ?? "Dashboard") ?>

                </h2>

                <p class="text-slate-500 mt-1">

                    Sistem Pelayanan Publik Berbasis Elektronik

                </p>

            </div>

            <div class="text-right">

                <div class="font-semibold">

                    <?= htmlspecialchars($authUser["name"] ?? "") ?>

                </div>

                <div class="text-sm text-slate-500">

                    <?= date("d F Y") ?>

                </div>

            </div>

        </header>

        <!-- ========================= -->
        <!-- CONTENT -->
        <!-- ========================= -->

        <section class="flex-1 p-10">

            <?php if(!empty($_SESSION["success"])): ?>

                <div class="mb-6 rounded-xl border border-green-300 bg-green-100 p-5 text-green-700">

                    <?= htmlspecialchars($_SESSION["success"]) ?>

                </div>

                <?php unset($_SESSION["success"]); ?>

            <?php endif; ?>

            <?= $content ?>

        </section>

        <!-- Footer -->

        <footer class="bg-white border-t px-10 py-5 text-center text-sm text-slate-500">

            © <?= date("Y") ?> SPBE - Mall Pelayanan Publik Digital

        </footer>

    </main>

</div>

</body>

</html>