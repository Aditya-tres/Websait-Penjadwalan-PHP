<?php
/**
 * reset_password.php — Reset Password StudySched
 * Validasi token dari tabel password_resets, lalu update password user.
 */
require_once __DIR__ . '/config/db.php';

$token       = trim($_GET['token'] ?? $_POST['token'] ?? '');
$state       = 'invalid'; // invalid | valid | success
$errorMsg    = '';
$invalidMsg  = 'Link reset password tidak valid, sudah digunakan, atau sudah kedaluwarsa. Silakan minta link baru.';
$successMsg  = '';
$resetEmail  = '';

function getValidReset($koneksi, $token) {
    $stmt = $koneksi->prepare("SELECT email, expires_at, used FROM password_resets WHERE token = ? LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$row) return null;
    if ((int)$row['used'] === 1) return null;
    if (strtotime($row['expires_at']) < time()) return null;

    return $row['email'];
}

if ($token !== '') {
    $resetEmail = getValidReset($koneksi, $token);
    if ($resetEmail) {
        $state = 'valid';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $state === 'valid') {
    $pass  = $_POST['password'] ?? '';
    $pass2 = $_POST['password2'] ?? '';

    if (strlen($pass) < 8 || !preg_match('/[A-Z]/', $pass) || !preg_match('/[0-9]/', $pass) || !preg_match('/[^a-zA-Z0-9]/', $pass)) {
        $errorMsg = 'Password harus minimal 8 karakter dan mengandung huruf kapital, angka, serta simbol.';
    } elseif ($pass !== $pass2) {
        $errorMsg = 'Konfirmasi password tidak cocok!';
    } else {
        $hash = password_hash($pass, PASSWORD_BCRYPT);

        $update = $koneksi->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update->bind_param("ss", $hash, $resetEmail);
        $update->execute();
        $update->close();

        $markUsed = $koneksi->prepare("UPDATE password_resets SET used = 1 WHERE token = ?");
        $markUsed->bind_param("s", $token);
        $markUsed->execute();
        $markUsed->close();

        $state = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password – StudySched | Student Schedule Management System</title>
    <meta name="description" content="Atur password baru untuk akun StudySched Anda." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        :root { --navy:#0F172A; --royal:#2563EB; --sky:#38BDF8; --slate:#64748B; --border:#E2E8F0; --ease:all .3s cubic-bezier(.4,0,.2,1); }
        body{font-family:'Inter',sans-serif;min-height:100vh;background:var(--navy);display:flex;align-items:center;justify-content:center;overflow:hidden;}
        .bg-wrap{position:fixed;inset:0;z-index:0;background:linear-gradient(135deg,#0F172A 0%,#1E293B 50%,#0F2240 100%);overflow:hidden;}
        .bg-wrap .shape{position:absolute;border-radius:50%;background:linear-gradient(135deg,rgba(37,99,235,.12),rgba(56,189,248,.08));animation:floatUp 8s ease-in-out infinite;}
        .s1{width:500px;height:500px;top:-150px;right:-150px;animation-delay:0s}
        .s2{width:350px;height:350px;bottom:-100px;left:-100px;animation-delay:2s}
        .s3{width:250px;height:250px;top:45%;left:10%;animation-delay:4s}
        .s4{width:180px;height:180px;bottom:25%;right:12%;animation-delay:6s}
        @keyframes floatUp{0%,100%{transform:translateY(0) rotate(0deg);opacity:.6}50%{transform:translateY(-25px) rotate(6deg);opacity:1}}
        .wrapper{position:relative;z-index:1;display:flex;width:100%;max-width:980px;min-height:600px;margin:20px;border-radius:24px;overflow:hidden;box-shadow:0 30px 90px rgba(0,0,0,.45),0 0 0 1px rgba(255,255,255,.05);animation:slideUp .6s cubic-bezier(.4,0,.2,1) both;}
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
        .right{flex:1;background:#fff;padding:50px 48px;display:flex;flex-direction:column;justify-content:center;overflow-y:auto;}
        .card{width:100%;max-width:400px;margin:0 auto;}
        .card-logo{width:50px;height:50px;background:linear-gradient(135deg,var(--royal),var(--sky));border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;margin-bottom:18px;box-shadow:0 6px 20px rgba(37,99,235,.38);}
        .card h1{font-size:26px;font-weight:800;color:var(--navy);}
        .card .sub{color:var(--slate);margin-top:6px;font-size:14px;margin-bottom:24px;}
        .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:10px;font-size:13.5px;font-weight:500;margin-bottom:18px;animation:fadeIn .3s ease;}
        @keyframes fadeIn{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
        .alert-error{background:#FEF2F2;border:1px solid #FECACA;color:#B91C1C;}
        .alert i{margin-top:2px;flex-shrink:0;}
        .expired-box{text-align:center;padding:24px;background:#FEF2F2;border:1.5px solid #FECACA;border-radius:14px;}
        .expired-box i{font-size:40px;color:#EF4444;margin-bottom:14px;display:block;}
        .expired-box h3{color:#B91C1C;font-size:18px;font-weight:700;margin-bottom:8px;}
        .expired-box p{color:#DC2626;font-size:13.5px;line-height:1.6;margin-bottom:16px;}
        .success-box{text-align:center;padding:24px;background:#F0FDF4;border:1.5px solid #BBF7D0;border-radius:14px;}
        .success-box i{font-size:44px;color:#22C55E;margin-bottom:14px;display:block;}
        .success-box h3{color:#15803D;font-size:20px;font-weight:800;margin-bottom:8px;}
        .success-box p{color:#166534;font-size:13.5px;line-height:1.6;margin-bottom:18px;}
        .btn-login{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#22C55E,#16A34A);color:#fff;text-decoration:none;padding:11px 22px;border-radius:9px;font-size:14px;font-weight:700;box-shadow:0 4px 16px rgba(34,197,94,.4);}
        .form{display:flex;flex-direction:column;gap:16px;}
        .fg{display:flex;flex-direction:column;gap:6px;}
        .fg label{font-size:13px;font-weight:600;color:#334155;display:flex;align-items:center;gap:6px;}
        .fg label i{color:var(--royal);font-size:12px;}
        .fg input{padding:11px 14px;border:1.5px solid var(--border);border-radius:9px;font-size:14px;font-family:'Inter',sans-serif;color:var(--navy);background:#F8FAFC;transition:var(--ease);outline:none;}
        .fg input:focus{border-color:var(--royal);background:#fff;box-shadow:0 0 0 3.5px rgba(37,99,235,.1);}
        .pw-wrap{position:relative;}
        .pw-wrap input{width:100%;padding-right:46px;}
        .pw-toggle{position:absolute;right:13px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--slate);cursor:pointer;font-size:15px;}
        .strength-bar{height:5px;background:#E2E8F0;border-radius:3px;margin-top:6px;overflow:hidden;}
        .strength-fill{height:100%;width:0;border-radius:3px;transition:var(--ease);background:#94A3B8;}
        .strength-fill.str-weak{width:25%;background:#EF4444;}
        .strength-fill.str-fair{width:50%;background:#F97316;}
        .strength-fill.str-good{width:75%;background:#EAB308;}
        .strength-fill.str-strong{width:100%;background:#22C55E;}
        .req-list{list-style:none;margin-top:8px;display:flex;flex-direction:column;gap:4px;}
        .req-list li{font-size:11.5px;color:#94A3B8;display:flex;align-items:center;gap:6px;}
        .req-list li i{font-size:6px;}
        .req-list li.ok{color:#22C55E;}
        .req-list li.fail{color:#EF4444;}
        .match-msg{font-size:11px;font-weight:600;margin-top:3px;}
        .btn-submit{display:flex;align-items:center;justify-content:center;gap:10px;background:linear-gradient(135deg,var(--royal),#1D4ED8);color:#fff;border:none;padding:13px;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;transition:var(--ease);box-shadow:0 5px 22px rgba(37,99,235,.42);width:100%;font-family:'Inter',sans-serif;}
        .btn-submit:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(37,99,235,.55);}
        .btn-submit:disabled{opacity:.7;cursor:not-allowed;transform:none;}
        .spinner{display:none;width:16px;height:16px;border:2.5px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;}
        @keyframes spin{to{transform:rotate(360deg)}}
        .back-row{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:18px;font-size:13.5px;color:var(--slate);}
        .back-row a{color:var(--royal);font-weight:700;text-decoration:none;}
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
                <div class="feat"><div class="feat-icon"><i class="fas fa-lock"></i></div><div class="feat-text"><h4>Password Aman</h4><p>Password baru dienkripsi dengan algoritma bcrypt yang kuat</p></div></div>
                <div class="feat"><div class="feat-icon"><i class="fas fa-shield-check"></i></div><div class="feat-text"><h4>Token Sekali Pakai</h4><p>Token reset hanya bisa digunakan sekali dan hangus setelah dipakai</p></div></div>
                <div class="feat"><div class="feat-icon"><i class="fas fa-clock"></i></div><div class="feat-text"><h4>Masa Berlaku 1 Jam</h4><p>Link reset kadaluarsa otomatis dalam 60 menit demi keamanan akun</p></div></div>
            </div>
        </div>

        <div class="right">
            <div class="card">
                <div class="card-logo"><i class="fas fa-unlock-alt"></i></div>
                <h1>Buat Password Baru</h1>
                <p class="sub">Masukkan password baru Anda di bawah ini.</p>

                <?php if ($state === 'invalid'): ?>
                    <div class="expired-box" role="alert">
                        <i class="fas fa-times-circle"></i>
                        <h3>Link Tidak Valid</h3>
                        <p><?= htmlspecialchars($invalidMsg, ENT_QUOTES) ?></p>
                        <a href="forgot_password.php" style="display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,#EF4444,#DC2626);color:#fff;text-decoration:none;padding:11px 22px;border-radius:9px;font-size:14px;font-weight:700;box-shadow:0 4px 16px rgba(239,68,68,.45);">
                            <i class="fas fa-redo"></i> Minta Link Baru
                        </a>
                    </div>

                <?php elseif ($state === 'success'): ?>
                    <div class="success-box" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <h3>Password Berhasil Diubah!</h3>
                        <p>Password akun Anda sudah diperbarui. Silakan masuk menggunakan password baru.</p>
                        <a href="index.php?reset=1" class="btn-login">
                            <i class="fas fa-sign-in-alt"></i> Masuk ke Akun
                        </a>
                    </div>

                <?php else: /* valid */ ?>
                    <?php if ($errorMsg): ?>
                    <div class="alert alert-error" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?= htmlspecialchars($errorMsg, ENT_QUOTES) ?></span>
                    </div>
                    <?php endif; ?>

                    <form class="form" id="resetForm" method="POST" action="reset_password.php?token=<?= urlencode($token) ?>" novalidate>
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token, ENT_QUOTES) ?>" />

                        <div class="fg">
                            <label for="password"><i class="fas fa-lock"></i> Password Baru</label>
                            <div class="pw-wrap">
                                <input type="password" id="password" name="password"
                                    placeholder="Minimal 8 karakter" required autocomplete="new-password" />
                                <button type="button" class="pw-toggle" id="togglePw1" aria-label="Tampilkan password">
                                    <i class="fas fa-eye" id="eye1"></i>
                                </button>
                            </div>
                            <div class="strength-bar"><div class="strength-fill" id="strengthFill"></div></div>
                            <ul class="req-list" id="reqList">
                                <li id="req-len"><i class="fas fa-circle"></i> Minimal 8 karakter</li>
                                <li id="req-upper"><i class="fas fa-circle"></i> Mengandung huruf kapital (A-Z)</li>
                                <li id="req-num"><i class="fas fa-circle"></i> Mengandung angka (0-9)</li>
                                <li id="req-sym"><i class="fas fa-circle"></i> Mengandung simbol (!@#...)</li>
                            </ul>
                        </div>

                        <div class="fg">
                            <label for="password2"><i class="fas fa-lock"></i> Konfirmasi Password Baru</label>
                            <div class="pw-wrap">
                                <input type="password" id="password2" name="password2"
                                    placeholder="Ulangi password baru" required autocomplete="new-password" />
                                <button type="button" class="pw-toggle" id="togglePw2" aria-label="Tampilkan konfirmasi">
                                    <i class="fas fa-eye" id="eye2"></i>
                                </button>
                            </div>
                            <div class="match-msg" id="matchMsg"></div>
                        </div>

                        <button type="submit" class="btn-submit" id="submitBtn">
                            <span class="spinner" id="spinner"></span>
                            <span id="btnText"><i class="fas fa-save"></i> Simpan Password Baru</span>
                        </button>
                    </form>
                <?php endif; ?>

                <div class="back-row">
                    <i class="fas fa-arrow-left" style="font-size:12px;"></i>
                    <a href="index.php">Kembali ke halaman Masuk</a>
                </div>

                <div class="card-footer">
                    <p>StudySched &copy; 2026 &ndash; Student Schedule Management System</p>
                    <p class="dev">Developed by Aditya Putra Pratama</p>
                </div>
            </div>
        </div>
    </main>

    <script>
        const togglePw1 = document.getElementById('togglePw1');
        if (togglePw1) {
            togglePw1.addEventListener('click', function () {
                const inp = document.getElementById('password');
                const icon = document.getElementById('eye1');
                const h = inp.type === 'password';
                inp.type = h ? 'text' : 'password';
                icon.className = h ? 'fas fa-eye-slash' : 'fas fa-eye';
            });
        }
        const togglePw2 = document.getElementById('togglePw2');
        if (togglePw2) {
            togglePw2.addEventListener('click', function () {
                const inp = document.getElementById('password2');
                const icon = document.getElementById('eye2');
                const h = inp.type === 'password';
                inp.type = h ? 'text' : 'password';
                icon.className = h ? 'fas fa-eye-slash' : 'fas fa-eye';
            });
        }
        const pwInput = document.getElementById('password');
        if (pwInput) {
            pwInput.addEventListener('input', function () {
                const v = this.value;
                const checks = {
                    'req-len':   v.length >= 8,
                    'req-upper': /[A-Z]/.test(v),
                    'req-num':   /[0-9]/.test(v),
                    'req-sym':   /[^a-zA-Z0-9]/.test(v),
                };
                let score = 0;
                for (const [id, pass] of Object.entries(checks)) {
                    const el = document.getElementById(id);
                    if (el) {
                        el.classList.toggle('ok', pass);
                        el.classList.toggle('fail', !pass && v.length > 0);
                        el.querySelector('i').className = pass ? 'fas fa-check-circle' : 'fas fa-circle';
                    }
                    if (pass) score++;
                }
                const fill = document.getElementById('strengthFill');
                if (fill) {
                    fill.className = 'strength-fill';
                    if (v.length === 0) { fill.style.width = '0'; return; }
                    const map = ['', 'str-weak', 'str-fair', 'str-good', 'str-strong'];
                    fill.classList.add(map[Math.max(1, score)]);
                }
            });
        }
        function checkMatch() {
            const p1 = document.getElementById('password');
            const p2 = document.getElementById('password2');
            const el = document.getElementById('matchMsg');
            if (!p1 || !p2 || !el) return;
            if (!p2.value) { el.textContent = ''; return; }
            if (p1.value === p2.value) { el.textContent = 'Password cocok'; el.style.color = '#22C55E'; }
            else { el.textContent = 'Password tidak cocok'; el.style.color = '#EF4444'; }
        }
        const pw2 = document.getElementById('password2');
        if (pw2) pw2.addEventListener('input', checkMatch);
        if (pwInput) pwInput.addEventListener('input', checkMatch);
        const resetForm = document.getElementById('resetForm');
        if (resetForm) {
            resetForm.addEventListener('submit', function (e) {
                const p1 = document.getElementById('password').value;
                const p2 = document.getElementById('password2').value;
                if (p1 !== p2) {
                    e.preventDefault();
                    alert('Password dan konfirmasi tidak cocok!');
                    return;
                }
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                document.getElementById('spinner').style.display = 'block';
                document.getElementById('btnText').textContent = 'Menyimpan...';
            });
        }
    </script>
</body>
</html>
