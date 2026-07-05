<?php
/**
 * register.php — Halaman Registrasi StudySched
 */
require_once __DIR__ . '/config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!empty($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$errorMsg    = '';
$successMsg  = '';
$old = ['nama_lengkap' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama_lengkap'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $pass   = $_POST['password'] ?? '';
    $pass2  = $_POST['password2'] ?? '';
    $old    = ['nama_lengkap' => htmlspecialchars($nama, ENT_QUOTES), 'email' => htmlspecialchars($email, ENT_QUOTES)];

    if ($nama === '' || $email === '' || $pass === '' || $pass2 === '') {
        $errorMsg = 'Lengkapi semua field!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = 'Format email tidak valid!';
    } elseif (strlen($pass) < 8) {
        $errorMsg = 'Password minimal 8 karakter!';
    } elseif ($pass !== $pass2) {
        $errorMsg = 'Konfirmasi password tidak cocok!';
    } else {
        $stmt = $koneksi->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errorMsg = 'Email sudah terdaftar. Silakan masuk atau gunakan email lain.';
            $stmt->close();
        } else {
            $stmt->close();
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            $insert = $koneksi->prepare("INSERT INTO users (nama_lengkap, email, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $nama, $email, $hash);

            if ($insert->execute()) {
                $insert->close();
                header("Location: index.php?registered=1");
                exit;
            } else {
                $errorMsg = 'Gagal membuat akun. Silakan coba lagi.';
                $insert->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar – StudySched | Student Schedule Management System</title>
    <meta name="description" content="Buat akun StudySched baru untuk mengelola jadwal kuliah dan tugas akademik Anda." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        :root {
            --navy:#0F172A; --navy-l:#1E293B; --royal:#2563EB; --royal-d:#1D4ED8;
            --sky:#38BDF8; --slate:#64748B; --border:#E2E8F0; --red:#EF4444; --green:#22C55E;
            --ease:all .3s cubic-bezier(.4,0,.2,1);
        }
        body{font-family:'Inter',sans-serif;min-height:100vh;background:var(--navy);display:flex;align-items:center;justify-content:center;overflow:hidden;padding:20px 0;}
        .bg-wrap{position:fixed;inset:0;z-index:0;background:linear-gradient(135deg,#0F172A 0%,#1E293B 50%,#0F2240 100%);overflow:hidden;}
        .bg-wrap .shape{position:absolute;border-radius:50%;background:linear-gradient(135deg,rgba(37,99,235,.12),rgba(56,189,248,.08));animation:floatUp 8s ease-in-out infinite;}
        .s1{width:500px;height:500px;top:-150px;right:-150px;animation-delay:0s}
        .s2{width:350px;height:350px;bottom:-100px;left:-100px;animation-delay:2s}
        .s3{width:250px;height:250px;top:45%;left:10%;animation-delay:4s}
        .s4{width:180px;height:180px;bottom:25%;right:12%;animation-delay:6s}
        @keyframes floatUp{0%,100%{transform:translateY(0) rotate(0deg);opacity:.6}50%{transform:translateY(-25px) rotate(6deg);opacity:1}}
        .wrapper{position:relative;z-index:1;display:flex;width:100%;max-width:980px;min-height:640px;margin:20px;border-radius:24px;overflow:hidden;box-shadow:0 30px 90px rgba(0,0,0,.45),0 0 0 1px rgba(255,255,255,.05);animation:slideUp .6s cubic-bezier(.4,0,.2,1) both;}
        @keyframes slideUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
        .left{flex:1;background:linear-gradient(160deg,#1a3a6b 0%,#0F172A 100%);padding:52px 44px;display:flex;flex-direction:column;justify-content:center;position:relative;border-right:1px solid rgba(255,255,255,.07);overflow:hidden;}
        .left::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");}
        .brand-logo{width:64px;height:64px;background:linear-gradient(135deg,var(--royal),var(--sky));border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:30px;color:#fff;margin-bottom:20px;box-shadow:0 10px 30px rgba(37,99,235,.45);}
        .brand-name{font-size:34px;font-weight:800;color:#fff;letter-spacing:-.5px;}
        .brand-tag{color:rgba(255,255,255,.45);font-size:14px;margin-top:8px;margin-bottom:44px;}
        .feats{display:flex;flex-direction:column;gap:24px;}
        .feat{display:flex;align-items:flex-start;gap:16px;}
        .feat-icon{width:46px;height:46px;min-width:46px;background:rgba(37,99,235,.15);border-radius:12px;border:1px solid rgba(37,99,235,.3);display:flex;align-items:center;justify-content:center;font-size:18px;color:var(--sky);}
        .feat-text h4{color:#fff;font-size:15px;font-weight:600;margin-bottom:4px;}
        .feat-text p{color:rgba(255,255,255,.45);font-size:13px;line-height:1.5;}
        .right{flex:1;background:#fff;padding:44px 48px;display:flex;flex-direction:column;justify-content:center;overflow-y:auto;}
        .card{width:100%;max-width:400px;margin:0 auto;}
        .card-logo{width:50px;height:50px;background:linear-gradient(135deg,var(--royal),var(--sky));border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;margin-bottom:18px;box-shadow:0 6px 20px rgba(37,99,235,.38);}
        .card h1{font-size:26px;font-weight:800;color:var(--navy);}
        .card .sub{color:var(--slate);margin-top:6px;font-size:14px;margin-bottom:22px;}
        .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:10px;font-size:13.5px;font-weight:500;margin-bottom:18px;animation:fadeIn .3s ease;}
        @keyframes fadeIn{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
        .alert-error{background:#FEF2F2;border:1px solid #FECACA;color:#B91C1C;}
        .alert-success{background:#F0FDF4;border:1px solid #BBF7D0;color:#15803D;}
        .alert i{margin-top:2px;flex-shrink:0;}
        .form{display:flex;flex-direction:column;gap:14px;}
        .fg{display:flex;flex-direction:column;gap:6px;}
        .fg label{font-size:13px;font-weight:600;color:#334155;display:flex;align-items:center;gap:6px;}
        .fg label i{color:var(--royal);font-size:12px;}
        .fg input{padding:11px 14px;border:1.5px solid var(--border);border-radius:9px;font-size:14px;font-family:'Inter',sans-serif;color:var(--navy);background:#F8FAFC;transition:var(--ease);outline:none;}
        .fg input:focus{border-color:var(--royal);background:#fff;box-shadow:0 0 0 3.5px rgba(37,99,235,.1);}
        .fg input::placeholder{color:#94A3B8;font-size:13.5px;}
        .pw-wrap{position:relative;}
        .pw-wrap input{width:100%;padding-right:46px;}
        .pw-toggle{position:absolute;right:13px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--slate);cursor:pointer;font-size:15px;}
        .pw-toggle:hover{color:var(--royal);}
        .strength-bar{height:5px;background:#E2E8F0;border-radius:3px;margin-top:6px;overflow:hidden;}
        .strength-fill{height:100%;width:0;border-radius:3px;transition:var(--ease);background:#94A3B8;}
        .strength-fill.str-weak{width:25%;background:#EF4444;}
        .strength-fill.str-fair{width:50%;background:#F97316;}
        .strength-fill.str-good{width:75%;background:#EAB308;}
        .strength-fill.str-strong{width:100%;background:#22C55E;}
        .strength-text{font-size:11px;margin-top:4px;font-weight:600;}
        .btn-submit{display:flex;align-items:center;justify-content:center;gap:10px;background:linear-gradient(135deg,var(--royal),var(--royal-d));color:#fff;border:none;padding:13px;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;transition:var(--ease);box-shadow:0 5px 22px rgba(37,99,235,.42);width:100%;font-family:'Inter',sans-serif;}
        .btn-submit:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(37,99,235,.55);}
        .btn-submit:disabled{opacity:.7;cursor:not-allowed;transform:none;}
        .spinner{display:none;width:16px;height:16px;border:2.5px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;}
        @keyframes spin{to{transform:rotate(360deg)}}
        .divider{display:flex;align-items:center;gap:12px;margin:6px 0;}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border);}
        .divider span{font-size:12px;color:var(--slate);white-space:nowrap;}
        .login-row{text-align:center;font-size:13.5px;color:var(--slate);}
        .login-row a{color:var(--royal);font-weight:700;text-decoration:none;}
        .login-row a:hover{text-decoration:underline;}
        .card-footer{margin-top:22px;text-align:center;color:var(--slate);font-size:12px;padding-top:18px;border-top:1px solid var(--border);}
        .card-footer .dev{margin-top:4px;color:#94A3B8;font-size:11.5px;}
        @media(max-width:768px){.wrapper{flex-direction:column;margin:12px;border-radius:20px;min-height:auto;}.left{display:none;}.right{padding:36px 24px;}}
    </style>
</head>
<body>
    <div class="bg-wrap" aria-hidden="true">
        <div class="shape s1"></div><div class="shape s2"></div>
        <div class="shape s3"></div><div class="shape s4"></div>
    </div>

    <main class="wrapper" role="main">
        <div class="left" aria-hidden="true">
            <div class="brand-logo"><i class="fas fa-graduation-cap"></i></div>
            <h2 class="brand-name">StudySched</h2>
            <p class="brand-tag">Student Schedule Management System</p>
            <div class="feats">
                <div class="feat"><div class="feat-icon"><i class="fas fa-user-plus"></i></div><div class="feat-text"><h4>Daftar Gratis</h4><p>Buat akun dalam hitungan detik, tanpa biaya apapun</p></div></div>
                <div class="feat"><div class="feat-icon"><i class="fas fa-calendar-check"></i></div><div class="feat-text"><h4>Jadwal Terorganisir</h4><p>Kelola semua jadwal kuliah dalam satu tempat</p></div></div>
                <div class="feat"><div class="feat-icon"><i class="fas fa-shield-alt"></i></div><div class="feat-text"><h4>Data Aman</h4><p>Password dienkripsi dengan algoritma bcrypt</p></div></div>
            </div>
        </div>

        <div class="right">
            <div class="card">
                <div class="card-logo"><i class="fas fa-user-plus"></i></div>
                <h1>Buat Akun Baru</h1>
                <p class="sub">Daftarkan diri Anda ke sistem StudySched</p>

                <?php if ($errorMsg): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($errorMsg, ENT_QUOTES) ?></span>
                </div>
                <?php endif; ?>

                <form class="form" id="regForm" method="POST" action="register.php" novalidate>

                    <div class="fg">
                        <label for="nama_lengkap"><i class="fas fa-user"></i> Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                            placeholder="Contoh: Budi Santoso"
                            value="<?= htmlspecialchars($old['nama_lengkap'], ENT_QUOTES) ?>"
                            required autocomplete="name" />
                    </div>

                    <div class="fg">
                        <label for="email"><i class="fas fa-envelope"></i> Alamat Email</label>
                        <input type="email" id="email" name="email"
                            placeholder="nama@kampus.ac.id"
                            value="<?= htmlspecialchars($old['email'], ENT_QUOTES) ?>"
                            required autocomplete="email" />
                    </div>

                    <div class="fg">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <div class="pw-wrap">
                            <input type="password" id="password" name="password"
                                placeholder="Minimal 8 karakter"
                                required autocomplete="new-password" />
                            <button type="button" class="pw-toggle" id="togglePw1" aria-label="Tampilkan password">
                                <i class="fas fa-eye" id="eye1"></i>
                            </button>
                        </div>
                        <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                        <div class="strength-text" id="strengthText" style="color:#94A3B8;"></div>
                    </div>

                    <div class="fg">
                        <label for="password2"><i class="fas fa-lock"></i> Konfirmasi Password</label>
                        <div class="pw-wrap">
                            <input type="password" id="password2" name="password2"
                                placeholder="Ulangi password"
                                required autocomplete="new-password" />
                            <button type="button" class="pw-toggle" id="togglePw2" aria-label="Tampilkan konfirmasi">
                                <i class="fas fa-eye" id="eye2"></i>
                            </button>
                        </div>
                        <div id="matchMsg" style="font-size:11px;font-weight:600;margin-top:3px;"></div>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="spinner" id="spinner"></span>
                        <span id="btnText"><i class="fas fa-user-plus"></i> Buat Akun Sekarang</span>
                    </button>
                </form>

                <div class="divider"><span>sudah punya akun?</span></div>
                <div class="login-row">
                    <a href="index.php">Masuk di sini</a>
                </div>

                <div class="card-footer">
                    <p>StudySched &copy; 2026 &ndash; Student Schedule Management System</p>
                    <p class="dev">Developed by Aditya Putra Pratama</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('togglePw1').addEventListener('click', function () {
            const inp = document.getElementById('password');
            const icon = document.getElementById('eye1');
            const h = inp.type === 'password';
            inp.type = h ? 'text' : 'password';
            icon.className = h ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
        document.getElementById('togglePw2').addEventListener('click', function () {
            const inp = document.getElementById('password2');
            const icon = document.getElementById('eye2');
            const h = inp.type === 'password';
            inp.type = h ? 'text' : 'password';
            icon.className = h ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
        document.getElementById('password').addEventListener('input', function () {
            const val = this.value;
            const fill = document.getElementById('strengthFill');
            const txt  = document.getElementById('strengthText');
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^a-zA-Z0-9]/.test(val)) score++;
            const map = [
                { cls: '', label: '', color: '#94A3B8' },
                { cls: 'str-weak', label: 'Lemah', color: '#EF4444' },
                { cls: 'str-fair', label: 'Sedang', color: '#F97316' },
                { cls: 'str-good', label: 'Bagus', color: '#EAB308' },
                { cls: 'str-strong', label: 'Sangat Kuat', color: '#22C55E' },
            ];
            const s = val.length === 0 ? 0 : Math.max(1, score);
            fill.className = 'strength-fill ' + map[s].cls;
            txt.textContent = map[s].label;
            txt.style.color = map[s].color;
        });
        function checkMatch() {
            const p1 = document.getElementById('password').value;
            const p2 = document.getElementById('password2').value;
            const el = document.getElementById('matchMsg');
            if (!p2) { el.textContent = ''; return; }
            if (p1 === p2) { el.textContent = 'Password cocok'; el.style.color = '#22C55E'; }
            else { el.textContent = 'Password tidak cocok'; el.style.color = '#EF4444'; }
        }
        document.getElementById('password').addEventListener('input', checkMatch);
        document.getElementById('password2').addEventListener('input', checkMatch);
        document.getElementById('regForm').addEventListener('submit', function (e) {
            const p1 = document.getElementById('password').value;
            const p2 = document.getElementById('password2').value;
            if (p1 !== p2) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
                return;
            }
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            document.getElementById('spinner').style.display = 'block';
            document.getElementById('btnText').textContent = 'Memproses...';
        });
        document.querySelectorAll('.alert').forEach(function (el) {
            setTimeout(function () {
                el.style.transition = 'opacity .4s';
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 400);
            }, 8000);
        });
    </script>
</body>
</html>
