<?php
$title = 'Register MPP Digital';

$authUser = $authUser ?? null;
$redirect = $redirect ?? '/services';
$error = $_GET['error'] ?? '';

ob_start();
?>

<style>
body{
    margin:0;
    min-height:100vh;
    background:
        radial-gradient(circle at top left,#d1fae5 0%,transparent 45%),
        radial-gradient(circle at bottom right,#dbeafe 0%,transparent 40%),
        linear-gradient(135deg,#ecfeff,#f8fafc,#eff6ff);
    font-family:Inter,sans-serif;
}

.register-bg{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px;
}

.register-card{
    width:100%;
    max-width:1180px;
    display:grid;
    grid-template-columns:1fr 470px;
    background:white;
    border-radius:34px;
    overflow:hidden;
    box-shadow:0 25px 60px rgba(15,23,42,.15);
}

.left-panel{
    background:linear-gradient(135deg,#0891b2,#2563eb,#10b981);
    color:white;
    padding:70px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    position:relative;
    overflow:hidden;
}

.left-panel::before{
    content:"";
    position:absolute;
    width:380px;
    height:380px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    right:-120px;
    top:-100px;
}

.left-panel::after{
    content:"";
    position:absolute;
    width:250px;
    height:250px;
    border-radius:50%;
    background:rgba(255,255,255,.06);
    left:-60px;
    bottom:-60px;
}

.logo-icon{
    font-size:70px;
    margin-bottom:25px;
}

.left-panel h1{
    font-size:44px;
    font-weight:700;
    line-height:1.2;
    margin-bottom:18px;
}

.left-panel p{
    font-size:18px;
    line-height:1.8;
    color:rgba(255,255,255,.92);
    max-width:430px;
}

.badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:rgba(255,255,255,.18);
    backdrop-filter:blur(10px);
    border-radius:999px;
    padding:12px 24px;
    margin-top:40px;
    width:max-content;
    font-size:15px;
}

.right-panel{
    padding:55px;
    display:flex;
    align-items:center;
}

.form-wrapper{
    width:100%;
}

.icon{
    font-size:48px;
    text-align:center;
    margin-bottom:10px;
}

.form-wrapper h2{
    text-align:center;
    font-size:36px;
    font-weight:700;
    color:#0f172a;
}

.subtitle{
    text-align:center;
    color:#64748b;
    margin-top:8px;
    margin-bottom:30px;
}

.input-group{
    margin-bottom:18px;
}

.input-group label{
    display:block;
    font-weight:600;
    margin-bottom:8px;
    color:#334155;
}

.input-group input{
    width:100%;
    padding:15px 18px;
    border:1px solid #cbd5e1;
    border-radius:14px;
    font-size:15px;
    transition:.2s;
}

.input-group input:focus{
    outline:none;
    border-color:#0ea5e9;
    box-shadow:0 0 0 4px rgba(14,165,233,.15);
}

button{
    width:100%;
    padding:16px;
    border:none;
    border-radius:14px;
    background:#0ea5e9;
    color:white;
    font-weight:700;
    cursor:pointer;
    transition:.25s;
}

button:hover{
    background:#0284c7;
}

.login-link{
    margin-top:22px;
    text-align:center;
    color:#64748b;
}

.login-link a{
    color:#0891b2;
    font-weight:700;
    text-decoration:none;
}

.back{
    margin-top:25px;
    text-align:center;
}

.back a{
    color:#64748b;
    text-decoration:none;
}

.error-box{
    background:#fee2e2;
    color:#b91c1c;
    border:1px solid #fecaca;
    border-radius:12px;
    padding:14px;
    margin-bottom:20px;
}

@media(max-width:960px){

.register-card{
grid-template-columns:1fr;
}

.left-panel{
display:none;
}

.right-panel{
padding:35px;
}

}
</style>

<div class="register-bg">

<div class="register-card">

<div class="left-panel">

<div class="logo-icon">
📝
</div>

<h1>
Bergabung dengan
MPP Digital
</h1>

<p>

Daftarkan akun Anda untuk menikmati seluruh layanan Mall Pelayanan Publik secara online.

Ajukan dokumen, pantau proses, dan unduh hasil layanan kapan saja.

</p>

<div class="badge">
🟢 Pendaftaran Gratis
</div>

</div>

<div class="right-panel">

<div class="form-wrapper">

<div class="icon">
🏛️
</div>

<h2>Register</h2>

<div class="subtitle">

Sudah punya akun?

<a href="/login?redirect=<?= urlencode($redirect) ?>" style="color:#0891b2;font-weight:700;">
Masuk Sekarang
</a>

</div>

<?php if($error): ?>

<div class="error-box">
<?= htmlspecialchars($error) ?>
</div>

<?php endif; ?>

<form action="/auth/register" method="POST">

<input
type="hidden"
name="redirect"
value="<?= htmlspecialchars($redirect) ?>">

<div class="input-group">

<label>NIK</label>

<input
type="text"
name="nik"
maxlength="16"
minlength="16"
required
placeholder="16 Digit NIK">

</div>

<div class="input-group">

<label>Nama Lengkap</label>

<input
type="text"
name="name"
required
placeholder="Nama Lengkap">

</div>

<div class="input-group">

<label>Email</label>

<input
type="email"
name="email"
required
placeholder="nama@email.com">

</div>

<div class="input-group">

<label>Password</label>

<input
type="password"
name="password"
required
placeholder="Minimal 6 karakter">

</div>

<button type="submit">

DAFTAR SEKARANG

</button>

</form>

<div class="back">

<a href="/">
← Kembali ke Portal
</a>

</div>

</div>

</div>

</div>

</div>

<?php
$content = ob_get_clean();

/*
Supaya navbar dan footer tidak tampil.
*/
$hideNavbar = true;
$hideFooter = true;

include __DIR__.'/layout.blade.php';
?>