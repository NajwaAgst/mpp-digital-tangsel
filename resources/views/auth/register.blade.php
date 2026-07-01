<?php
$title = 'Register MPP Digital';
$authUser = $authUser ?? null;
$redirect = $redirect ?? '/services';
$error = $_GET['error'] ?? '';

ob_start();
?>

<div class="mx-auto flex min-h-[70vh] max-w-6xl items-center justify-center px-4 py-16 sm:px-6 lg:px-8">

    <div class="grid w-full overflow-hidden rounded-[2rem] border border-white/70 bg-white/90 shadow-2xl shadow-slate-200/60 lg:grid-cols-2">

        <div class="bg-gradient-to-br from-violet-600 to-emerald-600 p-8 text-white">

            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-violet-100">
                Buat akun
            </p>

            <h1 class="mt-4 text-3xl font-semibold">
                Daftar untuk mulai mengajukan layanan
            </h1>

            <p class="mt-4 max-w-md text-sm leading-7 text-violet-50">
                Daftarkan akun Anda untuk mengakses layanan MPP Digital dan mengajukan dokumen secara online.
            </p>

        </div>

        <div class="p-8 sm:p-10">

            <h2 class="text-2xl font-semibold text-slate-900">
                Register
            </h2>

            <p class="mt-2 text-sm text-slate-600">
                Sudah punya akun?
                <a href="/login?redirect=<?= urlencode($redirect) ?>"
                    class="font-semibold text-emerald-600">
                    Masuk di sini
                </a>
            </p>

            <?php if ($error): ?>
                <div class="mt-5 rounded-xl bg-red-100 border border-red-300 p-3 text-red-700 text-sm">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="/auth/register" method="POST" class="mt-8 space-y-4">

                <input
                    type="hidden"
                    name="redirect"
                    value="<?= htmlspecialchars($redirect) ?>">

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        NIK
                    </label>

                    <input
                        type="text"
                        name="nik"
                        maxlength="16"
                        minlength="16"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500"
                        placeholder="16 digit NIK">

                </div>

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500"
                        placeholder="Nama Lengkap">

                </div>

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
                        placeholder="Minimal 6 karakter">

                </div>

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-violet-600 px-4 py-3 font-semibold text-white hover:bg-violet-700">

                    Daftar

                </button>

            </form>

        </div>

    </div>

</div>

<?php
$content = ob_get_clean();
include __DIR__.'/../layout.blade.php';
?>