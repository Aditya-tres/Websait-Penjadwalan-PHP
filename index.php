<?php
/**
 * index.php — Halaman Login StudySched
 * Diproses dengan PHP + MySQL (menggantikan simulasi localStorage).
 */
require_once __DIR__ . '/config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kalau sudah login, langsung ke dashboard
if (!empty($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$errorMsg   = '';
$successMsg = '';
$oldEmail   = '';

// Pesan sukses kiriman dari register.php / reset_password.php
if (!empty($_GET['registered'])) {
    $successMsg = 'Akun berhasil dibuat! Silakan masuk menggunakan email dan password Anda.';
}
if (!empty($_GET['reset'])) {
    $successMsg = 'Password berhasil diubah! Silakan masuk dengan password baru Anda.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember_me']);
    $oldEmail = htmlspecialchars($email, ENT_QUOTES);

    if ($email === '' || $password === '') {
        $errorMsg = 'Lengkapi semua field!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg = 'Format email tidak valid!';
    } else {
        $stmt = $koneksi->prepare("SELECT id, nama_lengkap, email, password, prodi, nim FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_nama']  = $user['nama_lengkap'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_prodi'] = $user['prodi'];
            $_SESSION['user_nim']   = $user['nim'];

            if ($remember) {
                // Cookie sederhana untuk mengingat email (bukan menyimpan password)
                setcookie('studysched_remember_email', $email, time() + (30 * 24 * 60 * 60), "/");
            } else {
                setcookie('studysched_remember_email', '', time() - 3600, "/");
            }

            header("Location: dashboard.php");
            exit;
        } else {
            $errorMsg = 'Email atau password salah!';
        }
    }
}

if ($oldEmail === '' && isset($_COOKIE['studysched_remember_email'])) {
    $oldEmail = htmlspecialchars($_COOKIE['studysched_remember_email'], ENT_QUOTES);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk – StudySched | Student Schedule Management System</title>
    <meta name="description" content="Masuk ke akun StudySched Anda untuk mengelola jadwal kuliah dan tugas akademik." />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
        :root {
            --navy:       #0F172A;
            --navy-l:     #1E293B;
            --royal:      #2563EB;
            --royal-d:    #1D4ED8;
            --sky:        #38BDF8;
            --white:      #FFFFFF;
            --slate:      #64748B;
            --border:     #E2E8F0;
            --red:        #EF4444;
            --green:      #22C55E;
            --ease:       all .3s cubic-bezier(.4,0,.2,1);
        }
        body {
            font-family:'Inter',sans-serif;
            min-height:100vh;
            background:var(--navy);
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
        }

        .bg-wrap {
            position:fixed; inset:0; z-index:0;
            background:linear-gradient(135deg,#0F172A 0%,#1E293B 50%,#0F2240 100%);
            overflow:hidden;
        }
        .bg-wrap .shape {
            position:absolute; border-radius:50%;
            background:linear-gradient(135deg,rgba(37,99,235,.12),rgba(56,189,248,.08));
            animation:floatUp 8s ease-in-out infinite;
        }
        .s1{width:500px;height:500px;top:-150px;right:-150px;animation-delay:0s}
        .s2{width:350px;height:350px;bottom:-100px;left:-100px;animation-delay:2s}
        .s3{width:250px;height:250px;top:45%;left:10%;animation-delay:4s}
        .s4{width:180px;height:180px;bottom:25%;right:12%;animation-delay:6s}
        @keyframes floatUp {
            0%,100%{transform:translateY(0) rotate(0deg);opacity:.6}
            50%    {transform:translateY(-25px) rotate(6deg);opacity:1}
        }

        .wrapper {
            position:relative; z-index:1;
            display:flex;
            width:100%; max-width:980px;
            min-height:580px;
            margin:20px;
            border-radius:24px;
            overflow:hidden;
            box-shadow:0 30px 90px rgba(0,0,0,.45),0 0 0 1px rgba(255,255,255,.05);
            animation:slideUp .6s cubic-bezier(.4,0,.2,1) both;
        }
        @keyframes slideUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}

        .left {
            flex:1;
            background:linear-gradient(160deg,#1a3a6b 0%,#0F172A 100%);
            padding:52px 44px;
            display:flex; flex-direction:column; justify-content:center;
            position:relative;
            border-right:1px solid rgba(255,255,255,.07);
            overflow:hidden;
        }
        .left::before {
            content:'';position:absolute;inset:0;
            background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
        }
        .brand-logo {
            width:64px;height:64px;
            background:linear-gradient(135deg,var(--royal),var(--sky));
            border-radius:18px;
            display:flex;align-items:center;justify-content:center;
            font-size:30px;color:#fff;
            margin-bottom:20px;
            box-shadow:0 10px 30px rgba(37,99,235,.45);
        }
        .brand-name  {font-size:34px;font-weight:800;color:#fff;letter-spacing:-.5px;}
        .brand-tag   {color:rgba(255,255,255,.45);font-size:14px;margin-top:8px;margin-bottom:48px;}
        .feats       {display:flex;flex-direction:column;gap:26px;}
        .feat        {display:flex;align-items:flex-start;gap:16px;}
        .feat-icon {
            width:46px;height:46px;min-width:46px;
            background:rgba(37,99,235,.15);
            border-radius:12px;border:1px solid rgba(37,99,235,.3);
            display:flex;align-items:center;justify-content:center;
            font-size:18px;color:var(--sky);transition:var(--ease);
        }
        .feat:hover .feat-icon{background:rgba(37,99,235,.28);transform:scale(1.05);}
        .feat-text h4{color:#fff;font-size:15px;font-weight:600;margin-bottom:4px;}
        .feat-text p {color:rgba(255,255,255,.45);font-size:13px;line-height:1.5;}

        .right {
            flex:1;
            background:#fff;
            padding:50px 48px;
            display:flex;flex-direction:column;justify-content:center;
        }
        .card {width:100%;max-width:400px;margin:0 auto;}

        .card-logo {
            width:50px;height:50px;
            background:linear-gradient(135deg,var(--royal),var(--sky));
            border-radius:14px;
            display:flex;align-items:center;justify-content:center;
            font-size:22px;color:#fff;
            margin-bottom:22px;
            box-shadow:0 6px 20px rgba(37,99,235,.38);
        }
        .card h1{font-size:28px;font-weight:800;color:var(--navy);letter-spacing:-.3px;}
        .card .sub{color:var(--slate);margin-top:7px;font-size:14px;margin-bottom:30px;}

        .alert {
            display:flex;align-items:flex-start;gap:10px;
            padding:12px 16px;border-radius:10px;
            font-size:13.5px;font-weight:500;
            margin-bottom:18px;
            animation:fadeIn .3s ease;
        }
        @keyframes fadeIn{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
        .alert-error  {background:#FEF2F2;border:1px solid #FECACA;color:#B91C1C;}
        .alert-success{background:#F0FDF4;border:1px solid #BBF7D0;color:#15803D;}
        .alert-info   {background:#EFF6FF;border:1px solid #BFDBFE;color:#1D4ED8;}
        .alert i{margin-top:2px;flex-shrink:0;}

        .form{display:flex;flex-direction:column;gap:16px;}
        .fg{display:flex;flex-direction:column;gap:6px;}
        .fg label{font-size:13px;font-weight:600;color:#334155;display:flex;align-items:center;gap:6px;}
        .fg label i{color:var(--royal);font-size:12px;}
        .fg input{
            padding:11px 14px;
            border:1.5px solid var(--border);border-radius:9px;
            font-size:14px;font-family:'Inter',sans-serif;
            color:var(--navy);background:#F8FAFC;
            transition:var(--ease);outline:none;
        }
        .fg input:focus{border-color:var(--royal);background:#fff;box-shadow:0 0 0 3.5px rgba(37,99,235,.1);}
        .fg input::placeholder{color:#94A3B8;font-size:13.5px;}

        .pw-wrap{position:relative;}
        .pw-wrap input{width:100%;padding-right:46px;}
        .pw-toggle{
            position:absolute;right:13px;top:50%;transform:translateY(-50%);
            background:none;border:none;color:var(--slate);
            cursor:pointer;font-size:15px;transition:var(--ease);
        }
        .pw-toggle:hover{color:var(--royal);}

        .options{display:flex;align-items:center;justify-content:space-between;}
        .chk-label{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:var(--slate);font-weight:500;user-select:none;}
        .chk-label input[type=checkbox]{width:16px;height:16px;accent-color:var(--royal);cursor:pointer;}
        .link-sm{font-size:13px;color:var(--royal);text-decoration:none;font-weight:600;transition:var(--ease);}
        .link-sm:hover{color:var(--royal-d);text-decoration:underline;}

        .btn-submit {
            display:flex;align-items:center;justify-content:center;gap:10px;
            background:linear-gradient(135deg,var(--royal),var(--royal-d));
            color:#fff;border:none;padding:13px;border-radius:10px;
            font-size:15px;font-weight:700;cursor:pointer;
            transition:var(--ease);
            box-shadow:0 5px 22px rgba(37,99,235,.42);
            width:100%;font-family:'Inter',sans-serif;
        }
        .btn-submit:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(37,99,235,.55);}
        .btn-submit:active{transform:translateY(0);}
        .btn-submit:disabled{opacity:.7;cursor:not-allowed;transform:none;}
        .spinner{display:none;width:16px;height:16px;border:2.5px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;}
        @keyframes spin{to{transform:rotate(360deg)}}

        .divider{display:flex;align-items:center;gap:12px;margin:6px 0;}
        .divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border);}
        .divider span{font-size:12px;color:var(--slate);white-space:nowrap;}

        .reg-row{text-align:center;font-size:13.5px;color:var(--slate);}
        .reg-row a{color:var(--royal);font-weight:700;text-decoration:none;}
        .reg-row a:hover{text-decoration:underline;}

        .card-footer{margin-top:28px;text-align:center;color:var(--slate);font-size:12px;padding-top:20px;border-top:1px solid var(--border);}
        .card-footer .dev{margin-top:4px;color:#94A3B8;font-size:11.5px;}

        @media(max-width:768px){
            .wrapper{flex-direction:column;margin:12px;border-radius:20px;min-height:auto;}
            .left{display:none;}
            .right{padding:38px 28px;}
        }
    </style>
</head>
<body>
    <div class="bg-wrap" aria-hidden="true">
        <div class="shape s1"></div>
        <div class="shape s2"></div>
        <div class="shape s3"></div>
        <div class="shape s4"></div>
    </div>

    <main class="wrapper" role="main">

        <div class="left" aria-hidden="true">
            <div class="brand-logo"><i class="fas fa-graduation-cap"></i></div>
            <h2 class="brand-name">StudySched</h2>
            <p class="brand-tag">Student Schedule Management System</p>

            <div class="feats">
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="feat-text">
                        <h4>Jadwal Terorganisir</h4>
                        <p>Kelola semua jadwal kuliah dalam satu tempat yang mudah diakses</p>
                    </div>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-tasks"></i></div>
                    <div class="feat-text">
                        <h4>Manajemen Tugas</h4>
                        <p>Pantau progress tugas dan deadline dengan visualisasi yang jelas</p>
                    </div>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-chart-bar"></i></div>
                    <div class="feat-text">
                        <h4>Nilai &amp; Akademik</h4>
                        <p>Pantau nilai dan transkrip akademik secara real-time</p>
                    </div>
                </div>
                <div class="feat">
                    <div class="feat-icon"><i class="fas fa-bell"></i></div>
                    <div class="feat-text">
                        <h4>Pengingat Pintar</h4>
                        <p>Notifikasi otomatis untuk ujian dan tugas mendekati deadline</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="right">
            <div class="card">

                <div class="card-logo"><i class="fas fa-graduation-cap"></i></div>
                <h1>Selamat Datang</h1>
                <p class="sub">Masuk ke akun StudySched Anda</p>

                <?php if ($successMsg): ?>
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <span><?= htmlspecialchars($successMsg, ENT_QUOTES) ?></span>
                </div>
                <?php endif; ?>

                <?php if ($errorMsg): ?>
                <div class="alert alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= htmlspecialchars($errorMsg, ENT_QUOTES) ?></span>
                </div>
                <?php endif; ?>

                <form class="form" id="loginForm" method="POST" action="index.php" novalidate>

                    <div class="fg">
                        <label for="email"><i class="fas fa-envelope"></i> Alamat Email</label>
                        <input
                            type="email" id="email" name="email"
                            placeholder="nama@kampus.ac.id"
                            value="<?= $oldEmail ?>"
                            required autocomplete="email"
                        />
                    </div>

                    <div class="fg">
                        <label for="password"><i class="fas fa-lock"></i> Password</label>
                        <div class="pw-wrap">
                            <input type="password" id="password" name="password"
                                placeholder="Masukkan password Anda"
                                required autocomplete="current-password" />
                            <button type="button" class="pw-toggle" id="togglePw" aria-label="Tampilkan/sembunyikan password">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="options">
                        <label class="chk-label" for="remember_me">
                            <input type="checkbox" id="remember_me" name="remember_me" value="1" <?= $oldEmail ? 'checked' : '' ?> />
                            Ingat saya
                        </label>
                        <a href="forgot_password.php" class="link-sm">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <span class="spinner" id="spinner"></span>
                        <span id="btnText"><i class="fas fa-sign-in-alt"></i> Masuk ke Sistem</span>
                    </button>
                </form>

                <div class="divider"><span>atau</span></div>
                <div class="reg-row">
                    Belum punya akun?
                    <a href="register.php">Daftar di sini</a>
                </div>

                <div class="card-footer">
                    <p>StudySched &copy; 2026 &ndash; Student Schedule Management System</p>
                    <p class="dev">Developed by Aditya Putra Pratama</p>
                </div>

            </div>
        </div>
    </main>

    <script>
        document.getElementById('togglePw').addEventListener('click', function () {
            const inp = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            const isHidden = inp.type === 'password';
            inp.type  = isHidden ? 'text' : 'password';
            icon.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
        });

        document.getElementById('loginForm').addEventListener('submit', function () {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            document.getElementById('spinner').style.display = 'block';
            document.getElementById('btnText').innerHTML = 'Memproses...';
        });

        document.querySelectorAll('.alert').forEach(function (el) {
            setTimeout(function () {
                el.style.transition = 'opacity .4s';
                el.style.opacity = '0';
                setTimeout(function () { el.remove(); }, 400);
            }, 6000);
        });
    </script>
</body>
</html>
