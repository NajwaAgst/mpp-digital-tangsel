<div id="authModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 px-4 backdrop-blur-sm">
  <div class="w-full max-w-2xl rounded-[2rem] border border-white/70 bg-white p-6 shadow-2xl shadow-slate-900/20">
    <div class="flex items-start justify-between">
      <div>
        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-emerald-600">Akses akun</p>
        <h2 class="mt-2 text-2xl font-semibold text-slate-900">Masuk atau buat akun MPP Digital</h2>
      </div>
      <button data-close-auth class="rounded-full border border-slate-200 p-2 text-slate-500 hover:bg-slate-100">✕</button>
    </div>
    <div id="authNotice" class="mb-6 hidden rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800"></div>
    <div class="mt-8 grid gap-8 lg:grid-cols-2">
      <form id="registerForm" class="space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Daftar akun</h3>
        <input id="registerNik" name="nik" class="w-full rounded-2xl border border-slate-200 px-4 py-3" placeholder="NIK" />
        <input id="registerName" name="name" class="w-full rounded-2xl border border-slate-200 px-4 py-3" placeholder="Nama Lengkap" />
        <input id="registerEmail" name="email" class="w-full rounded-2xl border border-slate-200 px-4 py-3" placeholder="Email / Username" />
        <input id="registerPassword" name="password" type="password" class="w-full rounded-2xl border border-slate-200 px-4 py-3" placeholder="Password" />
        <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-3 font-semibold text-white">Daftar Sekarang</button>
      </form>
      <form id="loginForm" class="space-y-4">
        <h3 class="text-lg font-semibold text-slate-900">Login</h3>
        <input id="loginEmail" class="w-full rounded-2xl border border-slate-200 px-4 py-3" placeholder="Email / Username" />
        <input id="loginPassword" type="password" class="w-full rounded-2xl border border-slate-200 px-4 py-3" placeholder="Password" />
        <button type="submit" class="w-full rounded-2xl border border-slate-200 px-4 py-3 font-semibold text-slate-700">Masuk</button>
      </form>
    </div>
  </div>
</div>
