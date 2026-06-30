# MPP Digital Kota Tangerang Selatan Prototype

Prototype portal layanan publik digital berbasis Laravel-style structure dengan fokus pada SIP Dokter sebagai use case utama.

## Struktur utama
- public/index.html : landing page demo
- public/services.html : katalog layanan
- public/service-detail.html : halaman detail layanan
- public/sip-form.html : form pendaftaran SIP Dokter
- public/assets/app.js : interaktivitas login, autofill, telemetry
- app/Http/Controllers : controller Laravel-style untuk home, auth, service, interoperability
- resources/views : Blade-style view skeleton

## Cara melihat prototype
Buka salah satu file HTML langsung di browser, misalnya:
- public/index.html
- public/services.html
- public/sip-form.html

## Fitur yang tersedia
- Landing page modern
- Katalog multi-layanan
- Detail layanan
- Modal login/register simulasi
- Autofill data Dukcapil berdasarkan NIK
- Autofill data Kemenkes berdasarkan STR
- Preview dokumen digital otomatis
- Dashboard telemetry traffic light
