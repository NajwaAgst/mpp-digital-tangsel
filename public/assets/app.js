document.addEventListener('DOMContentLoaded', () => {
  const authKey = 'mppDemoAuth';

  // =========================
  // MOCK DATA
  // =========================
  const mockDukcapil = {
    '3674011111110001': {
      nama: 'Maya Salsabila',
      alamat: 'Jl. Serpong Raya No. 12, Tangerang Selatan',
      tempat_lahir: 'Jakarta',
      tanggal_lahir: '1991-05-14',
      jenis_kelamin: 'Perempuan'
    }
  };

  const mockKemenkes = {
    'STR-001': {
      success: true,
      response_time_ms: 650,
      data: {
        spesialisasi: 'Spesialis Penyakit Dalam',
        masa_berlaku: '2028-12-31',
        asal_universitas: 'Universitas Indonesia',
        status: 'Aktif'
      }
    },
    'STR-LAMBAT': {
      success: true,
      response_time_ms: 4200,
      data: {
        spesialisasi: 'Spesialis Anak',
        masa_berlaku: '2029-09-10',
        asal_universitas: 'Universitas Padjadjaran',
        status: 'Aktif'
      }
    },
    'STR-404': {
      success: false,
      message: 'Nomor STR tidak ditemukan',
      response_time_ms: 3200
    }
  };

  // =========================
  // ELEMENT REFERENCES
  // =========================
  const authModal = document.getElementById('authModal');
  const openButtons = document.querySelectorAll('[data-open-auth]');
  const closeButtons = document.querySelectorAll('[data-close-auth]');
  const registerForm = document.getElementById('registerForm');
  const loginForm = document.getElementById('loginForm');
  const sipForm = document.getElementById('sipForm');

  // cari container kanan navbar supaya badge user masuk di tempat yang benar
  const navbarActionContainer =
    document.querySelector('nav .mx-auto > .flex.items-center.gap-3') ||
    document.querySelector('nav .flex.items-center.gap-3');

  // =========================
  // STORAGE HELPERS
  // =========================
  const getStoredUser = () => {
    try {
      return JSON.parse(localStorage.getItem(authKey) || 'null');
    } catch (error) {
      console.error('Failed to parse auth data:', error);
      return null;
    }
  };

  const setStoredUser = (user) => {
    localStorage.setItem(authKey, JSON.stringify(user));
  };

  const clearStoredUser = () => {
    localStorage.removeItem(authKey);
  };

  // =========================
  // AUTH MODAL HELPERS
  // =========================
  const ensureNoticeBox = () => {
    const pageNotice = document.getElementById('authNotice');
    if (pageNotice) return pageNotice;
    if (!authModal) return null;

    let noticeBox = document.getElementById('authNotice');
    if (!noticeBox) {
      const modalCard = authModal.querySelector('.max-w-2xl');
      if (modalCard) {
        const headerBlock = modalCard.querySelector('.mt-8')?.previousElementSibling || modalCard.firstElementChild;
        noticeBox = document.createElement('div');
        noticeBox.id = 'authNotice';
        noticeBox.className =
          'hidden mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800';
        if (headerBlock && headerBlock.parentNode) {
          headerBlock.parentNode.insertBefore(noticeBox, headerBlock.nextSibling);
        } else {
          modalCard.appendChild(noticeBox);
        }
      }
    }
    return noticeBox;
  };

  const noticeBox = ensureNoticeBox();

  const showAuthNotice = (title = '', message = '') => {
    if (!noticeBox) return;

    if (!title && !message) {
      noticeBox.classList.add('hidden');
      noticeBox.innerHTML = '';
      return;
    }

    noticeBox.classList.remove('hidden');
    noticeBox.innerHTML = `
      <div class="flex items-start gap-2">
        <span class="mt-0.5">âš ï¸</span>
        <div>
          ${title ? `<p class="font-semibold">${title}</p>` : ''}
          ${message ? `<p class="mt-1">${message}</p>` : ''}
        </div>
      </div>
    `;
  };

  const openModal = (options = {}) => {
    if (!authModal) return;

    if (options.noticeTitle || options.noticeMessage) {
      showAuthNotice(options.noticeTitle || '', options.noticeMessage || '');
    } else {
      showAuthNotice('', '');
    }

    authModal.classList.remove('hidden');
    authModal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
  };

  const closeModal = () => {
    if (!authModal) return;
    authModal.classList.add('hidden');
    authModal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
    showAuthNotice('', '');
  };

  // =========================
  // NAVBAR AUTH UI
  // =========================
  const createUserBadge = (user) => {
    const wrapper = document.createElement('div');
    wrapper.id = 'authUserBadge';
    wrapper.className = 'flex items-center gap-3';

    const initial = (user?.name || 'U').trim().charAt(0).toUpperCase();

    wrapper.innerHTML = `
      <div class="flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-2 shadow-sm">
        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-600 text-sm font-semibold text-white">
          ${initial}
        </div>
        <div class="hidden text-left sm:block">
          <p class="max-w-[140px] truncate text-sm font-semibold text-slate-800">
            ${user?.name || 'Pengguna'}
          </p>
          <p class="text-xs text-slate-500">Akun aktif</p>
        </div>
      </div>

      <button
        id="logoutButton"
        type="button"
        class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
      >
        Logout
      </button>
    `;

    return wrapper;
  };

  const renderAuthState = (user) => {
    const existingBadge = document.getElementById('authUserBadge');
    if (existingBadge) existingBadge.remove();

    const loginButtons = document.querySelectorAll('[data-open-auth]:not([data-require-auth]), nav a[href="login.html"], nav a[href="register.html"]');

    if (!user) {
      loginButtons.forEach((btn) => btn.classList.remove('hidden'));
      return;
    }

    // sembunyikan tombol login/register biasa
    loginButtons.forEach((btn) => btn.classList.add('hidden'));

    if (navbarActionContainer) {
      const badge = createUserBadge(user);
      navbarActionContainer.appendChild(badge);

      const logoutButton = badge.querySelector('#logoutButton');
      logoutButton?.addEventListener('click', handleLogout);
    }
  };

  // =========================
  // AUTH ACTIONS
  // =========================
  const handleLoginSuccess = (userPayload) => {
    setStoredUser(userPayload);
    renderAuthState(userPayload);
    closeModal();

    const urlRedirect = new URLSearchParams(window.location.search).get('redirect');
    if (urlRedirect) {
      window.location.href = urlRedirect;
      return;
    }

    // kalau user sedang di halaman detail layanan dan sebelumnya mau daftar
    const pendingRedirect = sessionStorage.getItem('mppPostLoginRedirect');
    if (pendingRedirect) {
      sessionStorage.removeItem('mppPostLoginRedirect');
      window.location.href = pendingRedirect;
      return;
    }

    const currentPage = window.location.pathname.split('/').pop();
    if (currentPage === 'login.html' || currentPage === 'register.html') {
      window.location.href = 'index.html';
      return;
    }

    // refresh supaya state halaman konsisten
    window.location.reload();
  };

  async function handleLogout(event) {
    event?.preventDefault?.();
    clearStoredUser();

    try {
      await fetch('/auth/logout', { method: 'POST' });
    } catch (error) {
      // mock only - aman kalau endpoint tidak ada
      console.warn('Mock logout endpoint not available:', error);
    }

    // kalau lagi di halaman register service / area private, bisa redirect
    window.location.href = 'index.html';
  }

  // =========================
  // OPEN / CLOSE AUTH MODAL
  // =========================
  openButtons.forEach((button) => {
    button.addEventListener('click', (event) => {
      const user = getStoredUser();

      // tombol yang butuh login dulu
      if (button.hasAttribute('data-require-auth')) {
        event.preventDefault();

        if (!user) {
          const redirect = button.getAttribute('data-redirect') || 'services.html';
          sessionStorage.setItem('mppPostLoginRedirect', redirect);

          window.location.href = 'login.html?redirect=' + encodeURIComponent(redirect);
          return;
        }

        const redirect = button.getAttribute('data-redirect');
        if (redirect) {
          window.location.href = redirect;
        }
        return;
      }

      // tombol login biasa
      if (button.tagName !== 'A') {
        event.preventDefault();
        window.location.href = 'login.html';
      }
    });
  });

  closeButtons.forEach((button) => {
    button.addEventListener('click', closeModal);
  });

  authModal?.addEventListener('click', (event) => {
    if (event.target === authModal) closeModal();
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && authModal && !authModal.classList.contains('hidden')) {
      closeModal();
    }
  });

  // =========================
  // REGISTER FORM
  // =========================
  registerForm?.addEventListener('submit', (event) => {
    event.preventDefault();

    const nik = document.getElementById('registerNik')?.value.trim() || '';
    const nameInput = document.getElementById('registerName')?.value.trim() || '';
    const email = document.getElementById('registerEmail')?.value.trim() || '';
    const password = document.getElementById('registerPassword')?.value.trim() || '';

    if (!nik || !email || !password) {
      showAuthNotice('Form belum lengkap', 'NIK, email/username, dan password wajib diisi.');
      return;
    }

    if (!/^\d{16}$/.test(nik)) {
      showAuthNotice('NIK tidak valid', 'NIK harus terdiri dari 16 digit angka.');
      return;
    }

    const dukcapilData = mockDukcapil[nik];
    const finalName = nameInput || dukcapilData?.nama || 'Pengguna MPP';

    const userPayload = {
      nik,
      name: finalName,
      email,
      source: 'register'
    };

    handleLoginSuccess(userPayload);
  });

  // =========================
  // LOGIN FORM
  // =========================
  loginForm?.addEventListener('submit', (event) => {
    event.preventDefault();

    const email = document.getElementById('loginEmail')?.value.trim() || '';
    const password = document.getElementById('loginPassword')?.value.trim() || '';

    if (!email || !password) {
      showAuthNotice('Form belum lengkap', 'Email/username dan password wajib diisi.');
      return;
    }

    // mock login
    const userPayload = {
      nik: '3674011111110001',
      name: 'Maya Salsabila',
      email,
      source: 'login'
    };

    handleLoginSuccess(userPayload);
  });

  // =========================
  // INITIAL AUTH RENDER
  // =========================
  const currentUser = getStoredUser();
  renderAuthState(currentUser);

  if (currentUser) {
    const currentPage = window.location.pathname.split('/').pop();
    if (currentPage === 'login.html' || currentPage === 'register.html') {
      const redirect = new URLSearchParams(window.location.search).get('redirect');
      window.location.href = redirect || 'index.html';
      return;
    }
  }

  // =========================
  // SERVICE DETAIL CTA GUARD
  // Jika ada tombol daftar di halaman detail layanan,
  // paksa login dulu sebelum masuk ke register-service
  // =========================
  const registerBtn = document.getElementById('registerBtn');
  if (registerBtn) {
    registerBtn.addEventListener('click', (event) => {
      const user = getStoredUser();
      const targetHref = registerBtn.getAttribute('href') || 'services.html';

      if (!user) {
        event.preventDefault();
        sessionStorage.setItem('mppPostLoginRedirect', targetHref);

        window.location.href = 'login.html?redirect=' + encodeURIComponent(targetHref);
      }
    });
  }

  // =========================
  // SIP FORM MOCK INTEGRATION
  // =========================
  if (sipForm) {
    const nikInput = document.getElementById('nik');
    const nameInput = document.getElementById('nama');
    const addressInput = document.getElementById('alamat');
    const placeInput = document.getElementById('tempat_lahir');
    const birthInput = document.getElementById('tanggal_lahir');
    const genderInput = document.getElementById('jenis_kelamin');

    const strInput = document.getElementById('str');
    const specialtyInput = document.getElementById('spesialisasi');
    const expiryInput = document.getElementById('masa_berlaku');
    const universityInput = document.getElementById('asal_universitas');

    const validationStatus = document.getElementById('validationStatus');
    const documentPreview = document.getElementById('documentPreview');
    const documentBadge = document.getElementById('documentBadge');

    const telemetryStatus = document.getElementById('telemetryStatus');
    const telemetrySource = document.getElementById('telemetrySource');
    const telemetryResponse = document.getElementById('telemetryResponse');
    const telemetryTimestamp = document.getElementById('telemetryTimestamp');

    const setValidationText = (text) => {
      if (validationStatus) validationStatus.textContent = text;
    };

    const updateTelemetry = (source, status, responseTime, detail) => {
      if (telemetrySource) telemetrySource.textContent = source;
      if (telemetryResponse) telemetryResponse.textContent = `${responseTime} ms`;
      if (telemetryTimestamp) telemetryTimestamp.textContent = new Date().toLocaleString('id-ID');
      if (validationStatus) validationStatus.textContent = detail;

      if (!telemetryStatus) return;

      telemetryStatus.textContent = status;
      telemetryStatus.className = 'rounded-full border px-3 py-1 text-sm font-semibold';

      if (status === 'Hijau') {
        telemetryStatus.classList.add(
          'border-emerald-400',
          'bg-emerald-500/20',
          'text-emerald-300'
        );
      } else if (status === 'Kuning') {
        telemetryStatus.classList.add(
          'border-amber-400',
          'bg-amber-500/20',
          'text-amber-300'
        );
      } else {
        telemetryStatus.classList.add(
          'border-rose-400',
          'bg-rose-500/20',
          'text-rose-300'
        );
      }
    };

    const runDukcapil = async () => {
      if (!nikInput) return;

      const nik = nikInput.value.trim();
      if (!/^\d{16}$/.test(nik)) {
        return;
      }

      setValidationText('Menghubungkan ke Dukcapil...');

      // simulasi response
      const result = mockDukcapil[nik]
        ? {
            success: true,
            response_time_ms: 450,
            data: mockDukcapil[nik]
          }
        : {
            success: false,
            message: 'Data NIK tidak ditemukan',
            response_time_ms: 0
          };

      if (result.success) {
        if (nameInput) nameInput.value = result.data.nama || '';
        if (addressInput) addressInput.value = result.data.alamat || '';
        if (placeInput) placeInput.value = result.data.tempat_lahir || '';
        if (birthInput) birthInput.value = result.data.tanggal_lahir || '';
        if (genderInput) genderInput.value = result.data.jenis_kelamin || '';

        updateTelemetry(
          'Dukcapil',
          'Hijau',
          result.response_time_ms,
          'Data identitas berhasil diambil dari Dukcapil.'
        );
      } else {
        updateTelemetry(
          'Dukcapil',
          'Merah',
          result.response_time_ms,
          result.message || 'Data NIK tidak ditemukan.'
        );
      }
    };

    const runKemenkes = async () => {
      if (!strInput) return;

      const str = strInput.value.trim();
      if (!str) return;

      setValidationText('Menghubungkan ke Kemenkes...');

      const result =
        mockKemenkes[str] || {
          success: false,
          message: 'Nomor STR tidak ditemukan',
          response_time_ms: 3200
        };

      if (result.success) {
        if (specialtyInput) specialtyInput.value = result.data.spesialisasi || '';
        if (expiryInput) expiryInput.value = result.data.masa_berlaku || '';
        if (universityInput) universityInput.value = result.data.asal_universitas || '';

        if (documentBadge) {
          documentBadge.textContent = 'STR Valid';
          documentBadge.className =
            'inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700';
        }

        if (documentPreview) {
          documentPreview.innerHTML = `
            <div class="rounded-2xl border border-emerald-200 bg-white p-4 shadow-sm">
              <p class="text-sm font-semibold text-slate-700">Nomor STR: ${str}</p>
              <p class="mt-2 text-sm text-slate-600">Status: ${result.data.status}</p>
              <p class="mt-2 text-sm text-slate-600">Spesialisasi: ${result.data.spesialisasi}</p>
              <p class="mt-2 text-sm text-slate-600">Instansi Penerbit: Kementerian Kesehatan RI</p>
              <p class="mt-2 text-sm text-slate-600">Berlaku hingga: ${result.data.masa_berlaku}</p>
              <p class="mt-2 text-sm text-slate-600">Asal Universitas: ${result.data.asal_universitas}</p>
            </div>
          `;
        }

        if (result.response_time_ms >= 4000) {
          updateTelemetry(
            'Kemenkes',
            'Kuning',
            result.response_time_ms,
            'Respons Kemenkes cukup lambat, tetapi data STR berhasil diambil.'
          );
        } else {
          updateTelemetry(
            'Kemenkes',
            'Hijau',
            result.response_time_ms,
            'Data STR/profesi berhasil diverifikasi.'
          );
        }
      } else {
        if (documentBadge) {
          documentBadge.textContent = 'STR Tidak Valid';
          documentBadge.className =
            'inline-flex rounded-full border border-rose-200 bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700';
        }

        if (documentPreview) {
          documentPreview.innerHTML = `
            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4">
              <p class="text-sm font-semibold text-rose-700">Nomor STR tidak ditemukan.</p>
              <p class="mt-2 text-sm text-rose-600">Silakan periksa kembali nomor STR yang Anda masukkan.</p>
            </div>
          `;
        }

        updateTelemetry(
          'Kemenkes',
          'Merah',
          result.response_time_ms || 0,
          result.message || 'Data STR tidak ditemukan.'
        );
      }
    };

    nikInput?.addEventListener('input', runDukcapil);
    strInput?.addEventListener('input', runKemenkes);
  }
});
