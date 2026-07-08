<?php

$authUser=$_SESSION['user'] ?? null;

?>

<header class="sticky top-0 z-50 bg-white shadow-sm border-b">

<div class="max-w-7xl mx-auto">

<div class="flex items-center justify-between h-20 px-6">

<!-- Logo -->

<a href="/" class="flex items-center gap-4">

<div class="w-14 h-14 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 text-white flex items-center justify-center font-bold text-xl">

🏛

</div>

<div>

<h2 class="font-bold text-lg">

Portal Pelayanan Publik

</h2>

<p class="text-sm text-gray-500">

Kota Tangerang Selatan

</p>

</div>

</a>

<!-- Menu -->

<nav class="hidden lg:flex gap-10 font-semibold">

<a href="#layanan"

class="hover:text-blue-600">

Layanan

</a>

<a href="#fitur"

class="hover:text-blue-600">

Fitur

</a>

<a href="#tentang"

class="hover:text-blue-600">

Tentang

</a>

</nav>

<!-- Login -->

<div>

<?php if($authUser): ?>

<a
href="/services"
class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

Masuk Portal

</a>

<?php else: ?>



<?php endif; ?>

</div>

</div>

</div>

</header>