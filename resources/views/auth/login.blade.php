<?php
$title = 'Login MPP Digital';

$redirect = $redirect ?? '/services';
$error = $_GET['error'] ?? '';

ob_start();
?>

<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-cyan-50 to-blue-100 flex items-center justify-center px-6 py-10 overflow-hidden">

    <!-- Background Blur -->
    <div class="absolute inset-0 overflow-hidden">

        <div class="absolute -top-40 -left-32 w-96 h-96 bg-emerald-300 rounded-full blur-3xl opacity-20"></div>

        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-cyan-300 rounded-full blur-3xl opacity-20"></div>

    </div>

    <div class="relative w-full max-w-6xl grid lg:grid-cols-2 bg-white rounded-[32px] shadow-2xl overflow-hidden">

        <!-- LEFT -->

        <div class="bg-gradient-to-br from-emerald-600 via-emerald-500 to-cyan-600 text-white p-14 flex flex-col justify-center">

            <div class="text-7xl mb-8">
                🏛️
            </div>

            <h1 class="text-5xl font-bold leading-tight">

                Mall Pelayanan Publik

            </h1>

            <h2 class="text-3xl mt-2 font-semibold text-emerald-100">

                Kota Tangerang Selatan

            </h2>

            <p class="mt-8 text-lg leading-8 text-emerald-50 max-w-md">

                Portal pelayanan publik digital untuk
                mengajukan berbagai layanan pemerintah,
                memonitor status pengajuan,
                dan mengunduh dokumen resmi secara online.

            </p>

            <div class="mt-12 flex flex-wrap gap-4">

                <div class="rounded-full bg-white/20 px-6 py-3 backdrop-blur">

                    ✅ Cepat

                </div>

                <div class="rounded-full bg-white/20 px-6 py-3 backdrop-blur">

                    🔐 Aman

                </div>

                <div class="rounded-full bg-white/20 px-6 py-3 backdrop-blur">

                    🌐 Terintegrasi

                </div>

            </div>

        </div>

        <!-- RIGHT -->

        <div class="p-12 lg:p-16 flex items-center">

            <div class="w-full">

                <div class="text-center mb-10">

                    <div class="text-6xl">

                        👤

                    </div>

                    <h2 class="text-4xl font-bold text-slate-800 mt-4">

                        Login MPP

                    </h2>

                    <p class="text-slate-500 mt-3">

                        Masuk menggunakan akun Portal MPP Digital

                    </p>

                </div>

                <?php if($error): ?>

                    <div class="mb-6 rounded-2xl border border-red-300 bg-red-50 p-4 text-red-700">

                        <?= htmlspecialchars($error) ?>

                    </div>

                <?php endif; ?>

                <form action="/auth/login" method="POST" class="space-y-6">

                    <input
                        type="hidden"
                        name="redirect"
                        value="<?= htmlspecialchars($redirect) ?>">

                    <div>

                        <label class="mb-2 block font-semibold text-slate-700">

                            Email

                        </label>

                        <input
                            type="email"
                            name="email"
                            required
                            placeholder="nama@email.com"
                            class="w-full rounded-2xl border border-slate-300 px-5 py-4 focus:border-emerald-500 focus:outline-none">

                    </div>

                    <div>

                        <label class="mb-2 block font-semibold text-slate-700">

                            Password

                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            placeholder="Masukkan password"
                            class="w-full rounded-2xl border border-slate-300 px-5 py-4 focus:border-emerald-500 focus:outline-none">

                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-2xl bg-emerald-600 py-4 text-lg font-bold text-white transition hover:bg-emerald-700 hover:shadow-lg">

                        LOGIN MPP

                    </button>

                </form>

                <div class="mt-8 text-center">

                    Belum punya akun?

                    <a
                        href="/register?redirect=<?= urlencode($redirect) ?>"
                        class="font-bold text-emerald-600 hover:text-emerald-700">

                        Daftar Sekarang

                    </a>

                </div>

                <hr class="my-8">

                <div class="text-center">

                    <a
                        href="/"
                        class="text-slate-500 hover:text-emerald-600">

                        ← Kembali ke Beranda

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

$content = ob_get_clean();

include __DIR__.'/layout.blade.php';

?>