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

<title><?= $title ?? 'Portal Pelayanan Publik Digital' ?></title>

<script src="https://cdn.tailwindcss.com"></script>

<script>
tailwind.config = {
theme:{
extend:{
colors:{
brand:{
500:"#0f8f7a",
600:"#0d7564"
}
}
}
}
}
</script>

</head>

<body class="bg-slate-50 text-slate-800">

<?php include __DIR__.'/partials/navbar_home.blade.php'; ?>

<main>

<?= $content ?>

</main>

<?php include __DIR__.'/partials/footer.blade.php'; ?>

</body>
</html>