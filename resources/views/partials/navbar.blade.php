<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$authUser = $authUser ?? ($_SESSION['user'] ?? null);
?>

<nav class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur-md shadow-sm">

    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6">

        <!-- ================= LOGO ================= -->

        <a href="/" class="flex items-center gap-3 shrink-0">

            <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl bg-emerald-600 shadow">

                <img
                    src="/assets/logo.png"
                    alt="MPP"
                    class="h-full w-full object-cover"
                    onerror="this.style.display='none';this.parentNode.innerHTML='🏛️';">

            </div>

            <div>

                <h1 class="text-lg font-bold leading-tight text-slate-800">
                    Mall Pelayanan Publik
                </h1>

                <p class="text-sm text-slate-500">
                    Kota Tangerang Selatan
                </p>

            </div>

        </a>

        <!-- ================= MENU ================= -->

        <div class="hidden lg:flex items-center gap-8">

            <a
                href="/services"
                class="font-medium text-slate-600 transition hover:text-emerald-600">

                Layanan

            </a>

            

            <?php if (!empty($authUser)): ?>

                <a
                    href="/dashboard"
                    class="font-medium text-slate-600 transition hover:text-emerald-600">

                    Dashboard

                </a>

                <a
                    href="/services/history"
                    class="font-medium text-slate-600 transition hover:text-emerald-600">

                    Riwayat

                </a>

            <?php endif; ?>

        </div>

        <!-- ================= USER ================= -->

        <div class="flex items-center gap-6">

            <?php if (!empty($authUser)): ?>

                <!-- USER PROFILE -->

                <div class="flex items-center gap-3 rounded-full border border-slate-200 bg-slate-50 px-3 py-2">

                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-600 font-bold text-white">

                        <?= strtoupper(substr($authUser['name'] ?? 'U', 0, 1)) ?>

                    </div>

                    <div class="hidden md:block leading-tight">

                        <div class="font-semibold text-slate-800">

                            <?= htmlspecialchars($authUser['name']) ?>

                        </div>

                        <div class="text-xs text-slate-500">

                            Pengguna

                        </div>

                    </div>

                </div>

                <!-- LOGOUT -->

                <form action="/auth/logout" method="POST" class="m-0">

    <button
        type="submit"
        class="font-medium text-slate-600 hover:text-red-600 transition">

        Logout

    </button>

</form>
            <?php else: ?>

                <a
                    href="/login"
                    class="rounded-full bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">

                    Login

                </a>

            <?php endif; ?>

        </div>

    </div>

</nav>