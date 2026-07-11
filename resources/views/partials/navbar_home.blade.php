<?php
// Deteksi apakah user sedang berada di halaman utama atau bukan
$isHomePage = ($_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php');
$prefix = $isHomePage ? '' : '/';
?>

<header class="sticky top-0 z-50 backdrop-blur-md bg-white/90 border-b border-slate-100 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 items-center h-20">
            
            <div class="justify-self-start">
                <a href="/" class="flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-[#0052A3] to-cyan-500 text-white flex items-center justify-center font-bold text-2xl shadow-md shadow-blue-500/10 group-hover:scale-105 transition-transform duration-300">
                        🏛
                    </div>
                    <div class="hidden md:block">
                        <h2 class="font-bold text-slate-800 text-sm sm:text-base tracking-tight group-hover:text-[#0052A3] transition-colors whitespace-nowrap">
                            Portal Pelayanan Publik
                        </h2>
                        <p class="text-xs text-slate-500 font-medium">
                            Kota Tangerang Selatan
                        </p>
                    </div>
                </a>
            </div>

            <div class="justify-self-center">
                <nav class="flex items-center gap-6 sm:gap-8 text-xs sm:text-sm font-semibold text-slate-600 whitespace-nowrap">
                    <a href="<?= $prefix ?>#layanan" class="hover:text-[#0052A3] py-2 border-b-2 border-transparent hover:border-[#0052A3] transition-all">
                        Layanan
                    </a>
                    
                    <a href="<?= $prefix ?>#statistik" class="hover:text-[#0052A3] py-2 border-b-2 border-transparent hover:border-[#0052A3] transition-all">
                        Statistik
                    </a>
                    
                    <a href="<?= $prefix ?>#indeks-kepuasan" class="hover:text-[#0052A3] py-2 border-b-2 border-transparent hover:border-[#0052A3] transition-all">
                        Indeks Kepuasan
                    </a>
                    
                    <a href="<?= $prefix ?>#pengumuman" class="hover:text-[#0052A3] py-2 border-b-2 border-transparent hover:border-[#0052A3] transition-all">
                        Pengumuman
                    </a>
                </nav>
            </div>

            <div class="justify-self-end">
                </div>

        </div>
    </div>
</header>