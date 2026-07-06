<?php
$authUser = $authUser ?? ($_SESSION['user'] ?? null);
?>

<nav class="sticky top-0 z-40 border-b border-white/70 bg-white/80 backdrop-blur-xl">

    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">

        <!-- ===================== LOGO ===================== -->

        <a href="/" class="flex items-center gap-3">

            <div class="flex h-11 w-11 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-violet-600 shadow-lg">

                <?php

                $logoCandidates = [
                    __DIR__ . '/../../public/assets/mpp-logo.png',
                    __DIR__ . '/../../public/assets/mpp-logo.jpg',
                    __DIR__ . '/../../public/assets/mpp-logo.jpeg',
                    __DIR__ . '/../../public/assets/mpp-logo.webp',
                    __DIR__ . '/../../public/assets/mpp-logo.svg'
                ];

                $logoPath = null;

                foreach ($logoCandidates as $candidate) {

                    if (file_exists($candidate)) {
                        $logoPath = $candidate;
                        break;
                    }

                }

                ?>

                <?php if ($logoPath): ?>

                    <img
                        src="/assets/<?= basename($logoPath) ?>"
                        class="h-full w-full object-cover"
                        alt="MPP">

                <?php else: ?>

                    <span class="text-white font-bold">
                        MPP
                    </span>

                <?php endif; ?>

            </div>

            <div>

                <div class="font-bold text-slate-800">
                    Mall Pelayanan Publik (MPP)
                </div>

                <div class="text-xs text-slate-500">
                    Kota Tangerang Selatan
                </div>

            </div>

        </a>

        <!-- ===================== MENU ===================== -->

        <div class="hidden lg:flex items-center gap-8">

            <a
                href="/"
                class="font-medium text-slate-600 hover:text-emerald-600">

                Beranda

            </a>

            <a
                href="/services"
                class="font-medium text-slate-600 hover:text-emerald-600">

                Layanan

            </a>

            <?php if (!empty($authUser)): ?>

                <a
                    href="/dashboard"
                    class="font-medium text-slate-600 hover:text-emerald-600">

                    Dashboard Saya

                </a>

            <?php endif; ?>

            <a
                href="#telemetry"
                class="font-medium text-slate-600 hover:text-emerald-600">

                Telemetry

            </a>

        </div>

        <!-- ===================== RIGHT ===================== -->

        <div class="flex items-center gap-4">

            <!-- Search -->

            <label class="hidden md:flex h-11 items-center gap-2 rounded-full border border-slate-200 bg-slate-50 px-4">

                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none">

                    <path
                        d="M21 21L16.65 16.65"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round" />

                    <circle
                        cx="11"
                        cy="11"
                        r="6"
                        stroke="currentColor"
                        stroke-width="2" />

                </svg>

                <input
                    class="w-28 bg-transparent outline-none"
                    placeholder="Cari layanan">

            </label>

            <?php if (!empty($authUser)): ?>

                <div class="flex items-center gap-3">

                    <!-- USER -->

                    <div class="flex h-11 items-center gap-3 rounded-full border border-emerald-200 bg-emerald-50 px-4 shadow-sm">

                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-600 font-bold text-white">

                            <?= strtoupper(substr($authUser["name"] ?? "U", 0, 1)) ?>

                        </div>

                        <div class="hidden sm:block">

                            <div class="font-semibold text-slate-700">

                                <?= htmlspecialchars($authUser["name"] ?? "") ?>

                            </div>

                            <div class="text-xs text-slate-500">

                                <?= htmlspecialchars($authUser["nik"] ?? "") ?>

                            </div>

                        </div>

                    </div>

                    <!-- Dashboard Button -->

                    <a
                        href="/dashboard"
                        class="flex h-11 items-center rounded-full bg-emerald-600 px-5 font-semibold text-white hover:bg-emerald-700">

                        Dashboard

                    </a>

                    <!-- Logout -->

                    <form
                        action="/auth/logout"
                        method="POST"
                        class="m-0">

                        <button
                            type="submit"
                            class="flex h-11 items-center rounded-full border border-red-300 px-5 font-semibold text-red-600 hover:bg-red-600 hover:text-white">

                            Logout

                        </button>

                    </form>

                </div>

            <?php else: ?>

                <a
                    href="/login"
                    class="flex h-11 items-center rounded-full bg-emerald-600 px-6 font-semibold text-white shadow hover:bg-emerald-700">

                    Login / Register

                </a>

            <?php endif; ?>

        </div>

    </div>

</nav>