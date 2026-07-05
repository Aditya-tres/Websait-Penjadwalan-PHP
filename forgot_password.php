<?php
/**
 * forgot_password.php — Lupa Password StudySched
 * Karena di localhost tidak ada SMTP, link reset ditampilkan langsung di halaman
 * (simulasi). Di server production, link ini sebaiknya dikirim lewat email.
 */
require_once __DIR__ . '/config/db.php';

$errorMsg   = '';
$resetLink  = '';
$resetToken = '';
$oldEmail   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $oldEmail = htmlspecialchars($email, ENT_QUOTES);

    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = 'Masukkan alamat email yang valid!';
    } else {
        $stmt = $koneksi->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $errorMsg = 'Email tidak terdaftar di sistem kami.';
            $stmt->close();
        } else {
            $stmt->close();
            $token     = bin2hex(random_bytes(32));
            $expiresAt = date('Y-m-d H:i:s', time() + 3600); // berlaku 1 jam

            $insert = $koneksi->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $email, $token, $expiresAt);
            $insert->execute();
            $insert->close();

            $resetToken = $token;
            $resetLink  = "reset_password.php?token=" . urlencode($token);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lupa Password – StudySched | Student Schedule Management System</title>
    <meta name="description" content="Reset password akun StudySched Anda." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        :root {
            --navy:   #0F172A;
            --royal:  #2563EB;
            --sky:    #38BDF8;
            --slate:  #64748B;
            --border: #E2E8F0;
            --ease:   all .3s cubic-bezier(.4,0,.2,1);
        }
        body{font-family:'Inter',sans-serif;min-height:100vh;background:var(--navy);display:flex;align-items:center;justify-content:center;overflow:hidden;}
        .bg-wrap{position:fixed;inset:0;z-index:0;background:linear-gradient(135deg,#0F172A 0%,#1E293B 50%,#0F2240 100%);overflow:hidden;}
        .bg-wrap .shape{position:absolute;border-radius:50%;background:linear-gradient(135deg,rgba(37,99,235,.12),rgba(56,189,248,.08));animation:floatUp 8s ease-in-out infinite;}
        .s1{width:500px;height:500px;top:-150px;right:-150px;animation-delay:0s}
        .s2{width:350px;height:350px;bottom:-100px;left:-100px;animation-delay:2s}
        .s3{width:250px;height:250px;top:45%;left:10%;animation-delay:4s}
        .s4{width:180px;height:180px;bottom:25%;right:12%;animation-delay:6s}
        @keyframes floatUp{0%,100%{transform:translateY(0) rotate(0deg);opacity:.6}50%{transform:translateY(-25px) rotate(6deg);opacity:1}}
        .wrapper{position:relative;z-index:1;display:flex;width:100%;max-width:980px;min-height:560px;margin:20px;border-radius:24px;overflow:hidden;box-shadow:0 30px 90px rgba(0,0,0,.45),0 0 0 1px rgba(255,255,255,.05);animation:slideUp .6s cubic-bezier(.4,0,.2,1) both;}
        @keyframes slideUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
        .left{flex:1;background:linear-gradient(160deg,#1a3a6b 0%,#0F172A 100%);padding:52px 44px;display:flex;flex-direction:column;justify-content:center;position:relative;border-right:1px solid rgba(255,255,255,.07);overflow:hidden;}
        .left::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");}
        .brand-logo{width:64px;height:64px;background:linear-gradient(135deg,var(--royal),var(--sky));border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:30px;color:#fff;margin-bottom:20px;box-shadow:0 10px 30px rgba(37,99,235,.45);}
        .brand-name{font-size:34px;font-weight:800;color:#fff;letter-spacing:-.5px;}
        .brand-tag{color:rgba(255,255,255,.45);font-size:14px;margin-top:8px;margin-bottom:44px;}
        .feats{display:flex;flex-direction:column;gap:26px;}
        .feat{display:flex;align-items:flex-start;gap:16px;}
        .feat-icon{width:46px;height:46px;min-width:46px;background:rgba(37,99,235,.15);border-radius:12px;border:1px solid rgba(37,99,235,.3);display:flex;align-items:center;justify-content:center;font-size:18px;color:var(--sky);}
        .feat-text h4{color:#fff;font-size:15px;font-weight:600;margin-bottom:4px;}
        .feat-text p{color:rgba(255,255,255,.45);font-size:13px;line-height:1.5;}
        .right{flex:1;background:#fff;padding:50px 48px;display:flex;flex-direction:column;justify-content:center;}
        .card{width:100%;max-width:400px;margin:0 auto;}
        .card-logo{width:50px;height:50px;background:linear-gradient(135deg,var(--royal),var(--sky));border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;color:#fff;margin-bottom:18px;box-shadow:0 6px 20px rgba(37,99,235,.38);}
        .card h1{font-size:26px;font-weight:800;color:var(--navy);}
        .card .sub{color:var(--slate);margin-top:6px;font-size:14px;margin-bottom:24px;line-height:1.6;}
        .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:10px;font-size:13.5px;font-weight:500;margin-bottom:18px;animation:fadeIn .3s ease;}
        @keyframes fadeIn{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
        .alert-error{background:#FEF2F2;border:1px solid #FECACA;color:#B91C1C;}
        .alert-info {background:#EFF6FF;border:1px solid #BFDBFE;color:#1E40AF;}
        .alert i{margin-top:2px;flex-shrink:0;}
        .reset-box{background:linear-gradient(135deg,#EFF6FF,#DBEAFE);border:1.5px solid #93C5FD;border-radius:14px;padding:20px 22px;margin-bottom:20px;animation:fadeIn .4s ease;}
        .reset-box .rb-title{font-size:13px;font-weight:700;color:#1E40AF;display:flex;align-items:center;gap:8px;margin-bottom:10px;}
        .reset-box .rb-title i{font-size:15px;}
        .reset-box .rb-note{font-size:12px;color:#3B82F6;margin-bottom:14px;line-height:1.6;}
        .reset-box .rb-token{background:#fff;border:1px solid #BFDBFE;border-radius:8px;padding:10px 14px;font-size:11px;color:#1D4ED8;word-break:break-all;font-family:monospace;margin-bottom:14px;letter-spacing:.5px;}
        .reset-link-btn{display:inline-flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--royal),#1D4ED8);color:#fff;text-decoration:none;padding:11px 20px;border-radius:9px;font-size:14px;font-weight:700;box-shadow:0 4px 16px rgba(37,99,235,.45);transition:var(--ease);}
        .reset-link-btn:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(37,99,235,.55);}
        .form{display:flex;flex-direction:column;gap:16px;}
        .fg{display:flex;flex-direction:column;gap:6px;}
        .fg label{font-size:13px;font-weight:600;color:#334155;display:flex;align-items:center;gap:6px;}
        .fg label i{color:var(--royal);font-size:12px;}
        .fg input{padding:11px 14px;border:1.5px solid var(--border);border-radius:9px;font-size:14px;font-family:'Inter',sans-serif;color:var(--navy);background:#F8FAFC;transition:var(--ease);outline:none;}
        .fg input:focus{border-color:var(--royal);background:#fff;box-shadow:0 0 0 3.5px rgba(37,99,235,.1);}
        .fg input::placeholder{color:#94A3B8;}
        .btn-submit{display:flex;align-items:center;justify-content:center;gap:10px;background:linear-gradient(135deg,var(--royal),#1D4ED8);color:#fff;border:none;padding:13px;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;transition:var(--ease);box-shadow:0 5px 22px rgba(37,99,235,.42);width:100%;font-family:'Inter',sans-serif;}
        .btn-submit:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(37,99,235,.55);}
        .btn-submit:active{transform:translateY(0);}
        .btn-submit:disabled{opacity:.7;cursor:not-allowed;transform:none;}
        .spinner{display:none;width:16px;height:16px;border:2.5px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;}
        @keyframes spin{to{transform:rotate(360deg)}}
        .back-row{display:flex;align-items:center;justify-content:center;gap:6px;margin-top:18px;font-size:13.5px;color:var(--slate);}
        .back-row a{color:var(--royal);font-weight:700;text-decoration:none;}
        .back-row a:hover{text-decoration:underline;}
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
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-key"></i></div>
                    <div class="feat-text"><h4>Reset Password Aman</h4><p>Token reset bersifat unik dan hanya berlaku 1 jam</p></div>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-shield-alt"></i></div>
                    <div class="feat-text"><h4>Keamanan Data</h4><p>Password baru Anda disimpan dengan enkripsi bcrypt</p></div>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-clock"></i></div>
                    <div class="feat-text"><h4>Token Berkadaluarsa</h4><p>Link reset otomatis tidak valid setelah 1 jam demi keamanan</p></div>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="card">
                <div class="card-logo"><i class="fas fa-key"></i></div>
                <h1>Lupa Password?</h1>
                <p class="sub">
                    Masukkan email yang terdaftar. Kami akan menyiapkan link untuk mereset password Anda.
                </p>

                <?php if ($errorMsg): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($errorMsg, ENT_QUOTES) ?></span>
                </div>
                <?php endif; ?>

                <?php if ($resetLink): ?>
                <div class="reset-box" role="region" aria-label="Link Reset Password">
                    <div class="rb-title">
                        <i class="fas fa-check-circle" style="color:#22C55E;"></i>
                        Token Reset Berhasil Dibuat!
                    </div>
                    <p class="rb-note">
                        <strong>Mode Localhost (Simulasi):</strong><br/>
                        Di environment production, link ini dikirim via email.
                        Karena ini localhost, klik tombol di bawah untuk mereset password Anda.
                        Token berlaku selama <strong>1 jam</strong>.
                    </p>
                    <div class="rb-token"><?= htmlspecialchars($resetToken, ENT_QUOTES) ?></div>
                    <a href="<?= htmlspecialchars($resetLink, ENT_QUOTES) ?>" class="reset-link-btn">
                        <i class="fas fa-unlock-alt"></i> Reset Password Sekarang
                    </a>
                </div>
                <?php endif; ?>

                <form class="form" id="forgotForm" method="POST" action="forgot_password.php" novalidate>
                    <div class="fg">
                        <label for="email"><i class="fas fa-envelope"></i> Alamat Email</label>
                        <input
                            type="email" id="email" name="email"
                            placeholder="nama@kampus.ac.id"
                            value="<?= $oldEmail ?>"
                            required autocomplete="email"
                        />
                    </div>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="spinner" id="spinner"></span>
                        <span id="btnText"><i class="fas fa-paper-plane"></i> Kirim Link Reset</span>
                    </button>
                </form>
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
        const form = document.getElementById('forgotForm');
        if (form) {
            form.addEventListener('submit', function () {
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                document.getElementById('spinner').style.display = 'block';
                document.getElementById('btnText').textContent = 'Memproses...';
            });
        }
    </script>
</body>
</html>
