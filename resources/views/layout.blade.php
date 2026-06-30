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
              50: '#f1fcf7', 100: '#d9f6e7', 500: '#0f8f7a', 600: '#0d7564', 700: '#0b5b4e', 900: '#113c3a'
            },
            orchid: '#7c4dff'
          }
        }
      }
    }
  </script>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(15,143,122,0.12),_transparent_35%),linear-gradient(135deg,_#f8fffc_0%,_#f5f7ff_100%)] text-slate-800">
  <?php include __DIR__ . '/partials/navbar.blade.php'; ?>
  <main class="pb-16">
    <?= $content ?? '' ?>
  </main>
  <?php include __DIR__ . '/partials/footer.blade.php'; ?>
  <?php include __DIR__ . '/partials/auth-modal.blade.php'; ?>
  <script src="/assets/app.js"></script>
</body>
</html>
