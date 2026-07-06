<?php

$title = "Daftar Emergency 112";

ob_start();

$error = $_GET['error'] ?? '';

$redirect = $_GET['redirect'] ?? '/emergency/report';

?>

<div class="min-h-screen bg-gradient-to-br from-red-700 via-red-600 to-red-800 flex">

    <!-- LEFT -->

    <div class="hidden lg:flex w-1/2 items-center justify-center p-16">

        <div class="text-center text-white">

            <div class="text-[150px] mb-6">

                🚨

            </div>

            <h1 class="text-5xl font-bold mb-6">

                Emergency 112

            </h1>

            <p class="text-red-100 text-xl leading-9">

                Satu akun untuk seluruh layanan

                <br>

                Mall Pelayanan Publik Digital

            </p>

            <div class="mt-10 inline-flex items-center gap-3 bg-white/15 rounded-full px-6 py-3">

                <span class="w-3 h-3 rounded-full bg-green-400 animate-pulse"></span>

                <span>

                    Sistem Terintegrasi (Single Sign-On)

                </span>

            </div>

        </div>

    </div>


    <!-- RIGHT -->

    <div class="w-full lg:w-1/2 flex items-center justify-center p-10">

        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg p-10">

            <div class="text-center">

                <div class="text-6xl mb-3">

                    📝

                </div>

                <h2 class="text-3xl font-bold text-red-600">

                    Registrasi Emergency

                </h2>

                <p class="text-gray-500 mt-3">

                    Gunakan akun yang sama untuk seluruh layanan MPP Digital

                </p>

            </div>

            <?php if($error): ?>

                <div class="mt-6 bg-red-100 text-red-700 p-4 rounded-xl">

                    <?= htmlspecialchars($error) ?>

                </div>

            <?php endif; ?>

            <form

                action="/auth/register"

                method="POST"

                class="mt-8 space-y-5">

                <input

                    type="hidden"

                    name="redirect"

                    value="<?= htmlspecialchars($redirect) ?>">

                <!-- NIK -->

                <div>

                    <label class="font-semibold">

                        NIK

                    </label>

                    <input

                        type="text"

                        name="nik"

                        maxlength="16"

                        required

                        class="mt-2 w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 outline-none">

                </div>

                <!-- Nama -->

                <div>

                    <label class="font-semibold">

                        Nama Lengkap

                    </label>

                    <input

                        type="text"

                        name="name"

                        required

                        class="mt-2 w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 outline-none">

                </div>

                <!-- Email -->

                <div>

                    <label class="font-semibold">

                        Email

                    </label>

                    <input

                        type="email"

                        name="email"

                        required

                        class="mt-2 w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 outline-none">

                </div>

                <!-- Password -->

                <div>

                    <label class="font-semibold">

                        Password

                    </label>

                    <input

                        type="password"

                        name="password"

                        required

                        class="mt-2 w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-red-500 outline-none">

                </div>

                <button

                    class="w-full bg-red-600 hover:bg-red-700 text-white rounded-xl py-4 font-bold transition">

                    DAFTAR SEKARANG

                </button>

            </form>

            <div class="mt-8 text-center">

                Sudah punya akun?

                <a

                    href="/emergency/login?redirect=<?= urlencode($redirect) ?>"

                    class="font-bold text-red-600 hover:underline">

                    Login

                </a>

            </div>

            <div class="mt-8 border-t pt-6 text-center">

                <a

                    href="/"

                    class="text-gray-500 hover:text-red-600">

                    ← Kembali ke Portal

                </a>

            </div>

        </div>

    </div>

</div>

<?php

$content = ob_get_clean();

include __DIR__ . "/../layout_emergency.blade.php";