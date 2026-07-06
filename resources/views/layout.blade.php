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

    <title><?= $title ?? 'Mall Pelayanan Publik (MPP) Kota Tangerang Selatan' ?></title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f1fcf7',
                            100: '#d9f6e7',
                            500: '#0f8f7a',
                            600: '#0d7564',
                            700: '#0b5b4e',
                            900: '#113c3a'
                        },
                        orchid: '#7c4dff'
                    }
                }
            }
        }
    </script>

</head>

<body class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(15,143,122,0.12),_transparent_35%),linear-gradient(135deg,_#f8fffc_0%,_#f5f7ff_100%)] text-slate-800">

    <!-- Navbar -->
    <?php include __DIR__ . '/partials/navbar.blade.php'; ?>

    <!-- Content -->
    <main class="pb-16">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/partials/footer.blade.php'; ?>

    <!-- Login/Register Modal -->
    <?php include __DIR__ . '/partials/auth-modal.blade.php'; ?>

    <!-- Welcome Popup -->
    <?php if (!empty($_SESSION['welcome_popup'])): ?>

        <div id="welcomeModal"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">

            <div class="bg-white rounded-3xl shadow-2xl p-8 w-[430px] text-center">

                <div class="text-6xl mb-4">
                    👋
                </div>

                <h2 class="text-3xl font-bold text-emerald-700">

                    Hi,

                    <?= htmlspecialchars($_SESSION['user']['name'] ?? 'User') ?>

                </h2>

                <p class="mt-4 text-gray-600 leading-relaxed">

                    Selamat datang di

                    <br>

                    <span class="font-bold text-emerald-700">

                        Portal Mall Pelayanan Publik Digital

                    </span>

                    <br><br>

                    Semoga layanan kami dapat membantu
                    kebutuhan administrasi Anda.

                </p>

                <button
                    onclick="closeWelcome()"
                    class="mt-8 bg-emerald-600 hover:bg-emerald-700 transition px-8 py-3 rounded-xl text-white font-semibold">

                    Mulai

                </button>

            </div>

        </div>

        <?php unset($_SESSION['welcome_popup']); ?>

    <?php endif; ?>

    <script>

        function closeWelcome() {

            const modal = document.getElementById("welcomeModal");

            if (modal) {
                modal.remove();
            }

        }

    </script>

    <script src="/assets/app.js"></script>

</body>

</html>