# StudySched — Panduan Menjalankan di XAMPP (PHP + MySQL)

Paket ini berisi backend PHP + MySQL untuk website StudySched kamu.
Sistem login, daftar akun, lupa password, dan reset password sekarang
diproses **sungguhan** lewat database MySQL (sebelumnya cuma simulasi
`localStorage` di browser).

## 1. Struktur Folder

```
studysched/
├── config/
│   └── db.php                 <- koneksi database
├── includes/
│   ├── auth_check.php         <- penjaga halaman (redirect kalau belum login)
│   └── session_bridge.php     <- menyalurkan data session ke localStorage
├── api/
│   └── update_profile.php     <- endpoint AJAX simpan perubahan profil
├── sql/
│   └── studysched.sql         <- struktur database (import ini duluan!)
├── css/style.css
├── js/ (app.js, dashboard.js, kalender.js, profil.js, tugas.js)
├── index.php                  <- halaman Login (dulu login.html)
├── register.php                <- halaman Daftar
├── forgot_password.php
├── reset_password.php
├── logout.php
├── dashboard.php, kalender.php, tugas.php, profil.php,
│   matakuliah.php, nilai.php, transkrip.php   <- halaman setelah login
```

## 2. Instalasi di XAMPP

1. **Copy folder** `studysched` ke dalam folder `htdocs` XAMPP.
   - Windows: `C:\xampp\htdocs\studysched`
   - macOS: `/Applications/XAMPP/htdocs/studysched`
2. **Jalankan Apache & MySQL** lewat XAMPP Control Panel.
3. Buka **phpMyAdmin** → `http://localhost/phpmyadmin`
4. Buat database baru bernama `studysched_db` (atau import langsung, database-nya akan otomatis dibuat oleh file SQL).
5. Klik tab **Import**, pilih file `sql/studysched.sql`, lalu klik **Go**.
   Ini akan membuat tabel `users` dan `password_resets`.
6. Buka browser ke: `http://localhost/studysched/index.php`

Selesai! Sekarang kamu bisa:
- **Daftar akun baru** lewat halaman Register (data tersimpan di tabel `users`, password di-hash dengan bcrypt).
- **Login** menggunakan email & password yang baru didaftarkan.
- **Lupa password** → sistem membuat token di tabel `password_resets` (berlaku 1 jam) dan menampilkan link reset langsung di halaman (karena localhost tidak punya server email/SMTP). Di production sungguhan, link ini seharusnya dikirim lewat email.
- **Edit profil** (nama & program studi) di halaman Profil akan tersimpan ke database lewat `api/update_profile.php`.

## 3. Kalau nama database/kredensial MySQL kamu beda

Edit file `config/db.php`:

```php
$host    = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "studysched_db";
```

Sesuaikan `$db_user`, `$db_pass`, dan `$db_name` sesuai setup MySQL kamu.

## 4. Catatan Penting

- Semua halaman aplikasi (`dashboard.php`, `kalender.php`, dll) sekarang
  dilindungi oleh `includes/auth_check.php` — kalau belum login, otomatis
  diarahkan ke `index.php`.
- Password disimpan dengan `password_hash()` (bcrypt), **bukan** teks polos.
- Token reset password otomatis kedaluwarsa setelah **1 jam** dan hanya bisa
  dipakai **1 kali**.
- Halaman-halaman lain (Kalender, Tugas, Mata Kuliah, Nilai, Transkrip) masih
  memakai data contoh statis di HTML — hanya sistem **login/registrasi/profil**
  yang sudah terhubung ke MySQL. Kalau kamu mau tabel jadwal/tugas/nilai juga
  disimpan ke database, kabari saja, nanti dibuatkan tabel & endpoint PHP-nya juga.
- Untuk mengecek error PHP saat development, kamu bisa aktifkan
  `display_errors` di `php.ini` XAMPP kalau perlu.

---
StudySched © 2026 — Student Schedule Management System
