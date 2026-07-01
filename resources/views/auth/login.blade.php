<?php
$title = 'Login MPP Digital';
$authUser = $authUser ?? null;
$redirect = $redirect ?? '/services';
$error = $_GET['error'] ?? '';

ob_start();
?>

<div class="mx-auto flex min-h-[70vh] max-w-6xl items-center justify-center px-4 py-16 sm:px-6 lg:px-8">
    <div class="grid w-full overflow-hidden rounded-[2rem] border border-white/70 bg-white/90 shadow-2xl shadow-slate-200/60 lg:grid-cols-2">

        <div class="bg-gradient-to-br from-emerald-600 to-violet-600 p-8 text-white">
            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-emerald-100">
                Portal MPP Digital
            </p>

            <h1 class="mt-4 text-3xl font-semibold">
                Masuk untuk mengajukan berkas
            </h1>

            <p class="mt-4 max-w-md text-sm leading-7 text-emerald-50">
                Login untuk melanjutkan pengajuan layanan,
                memantau status dokumen,
                dan mengakses halaman akun Anda.
            </p>

        </div>

        <div class="p-8 sm:p-10">

            <h2 class="text-2xl font-semibold text-slate-900">
                Login
            </h2>

            <p class="mt-2 text-sm text-slate-600">
                Belum punya akun?
                <a href="/register?redirect=<?= urlencode($redirect) ?>"
                    class="font-semibold text-emerald-600">
                    Daftar sekarang
                </a>
            </p>

            <?php if ($error): ?>
                <div class="mt-5 rounded-xl bg-red-100 border border-red-300 p-3 text-red-700 text-sm">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="/auth/login" method="POST" class="mt-8 space-y-4">

                <input
                    type="hidden"
                    name="redirect"
                    value="<?= htmlspecialchars($redirect) ?>">

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500"
                        placeholder="nama@email.com">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500"
                        placeholder="Password">
                </div>

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-emerald-600 px-4 py-3 font-semibold text-white hover:bg-emerald-700">

                    Masuk

                </button>

            </form>

        </div>

    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__.'/../layout.blade.php';
?>