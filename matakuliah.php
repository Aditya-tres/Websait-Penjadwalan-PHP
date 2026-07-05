<?php require_once __DIR__ . '/includes/auth_check.php'; ?>
﻿<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StudySched â€“ Mata Kuliah</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body class="app-body">
<?php include __DIR__ . '/includes/session_bridge.php'; ?>

  <aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <a href="dashboard.php" class="sidebar-logo">
        <i class="fas fa-graduation-cap"></i>
        <span class="logo-text">StudySched</span>
      </a>
      <button class="sidebar-toggle-btn" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    </div>
    <div class="sidebar-profile">
      <div class="profile-avatar">
        <img src="https://ui-avatars.com/api/?name=User&background=2563EB&color=fff&size=80" alt="Avatar" id="sidebarAvatar" />
        <div class="avatar-online"></div>
      </div>
      <div class="profile-info">
        <h4 id="sidebarNama">User</h4>
        <p id="sidebarNim">email@kampus.ac.id</p>
      </div>
    </div>
    <nav class="sidebar-nav">
      <div class="nav-group">
        <span class="nav-group-label">Menu Utama</span>
        <a href="dashboard.php" class="nav-item" data-page="dashboard.php"><i class="fas fa-home"></i><span>Beranda</span></a>
        <a href="kalender.php" class="nav-item" data-page="kalender.php"><i class="fas fa-calendar-alt"></i><span>Kalender</span></a>
        <a href="tugas.php" class="nav-item" data-page="tugas.php"><i class="fas fa-clipboard-list"></i><span>Tugas</span><span class="nav-badge">3</span></a>
        <a href="profil.php" class="nav-item" data-page="profil.php"><i class="fas fa-user-circle"></i><span>Profil</span></a>
      </div>
      <div class="nav-group">
        <span class="nav-group-label">Akademik</span>
        <a href="matakuliah.php" class="nav-item" data-page="matakuliah.php"><i class="fas fa-book"></i><span>Mata Kuliah</span></a>
        <a href="nilai.php" class="nav-item" data-page="nilai.php"><i class="fas fa-chart-bar"></i><span>Nilai</span></a>
        <a href="transkrip.php" class="nav-item" data-page="transkrip.php"><i class="fas fa-file-alt"></i><span>Transkrip</span></a>
      </div>
    </nav>
    <div class="sidebar-footer">
      <a href="logout.php" class="nav-item logout-btn">
        <i class="fas fa-sign-out-alt"></i><span>Keluar</span>
      </a>
    </div>
  </aside>

  <div class="main-wrapper" id="mainWrapper">
    <header class="topbar">
      <div class="topbar-left">
        <button class="mobile-toggle" id="mobileToggle"><i class="fas fa-bars"></i></button>
        <div class="breadcrumb">
          <span>StudySched</span><i class="fas fa-chevron-right"></i>
          <span>Akademik</span><i class="fas fa-chevron-right"></i>
          <span class="active">Mata Kuliah</span>
        </div>
      </div>
      <div class="topbar-right">
        <button class="topbar-btn"><i class="fas fa-search"></i></button>
        <div class="notification-btn">
          <button class="topbar-btn"><i class="fas fa-bell"></i></button>
          <span class="notif-dot"></span>
        </div>
        <div class="topbar-profile">
          <img src="https://ui-avatars.com/api/?name=User&background=2563EB&color=fff&size=40" alt="Avatar" id="topbarAvatar" />
          <span id="topbarNama">User</span>
        </div>
      </div>
    </header>

    <main class="page-content">
      <div class="page-title-bar">
        <div>
          <h1 class="page-title"><i class="fas fa-book"></i> Mata Kuliah</h1>
          <p class="page-subtitle">Daftar mata kuliah semester ini beserta informasi lengkapnya</p>
        </div>
        <div style="display:flex; gap:10px; align-items:center;">
          <span style="font-size: 13px; font-weight: 600; background: #EFF6FF; color: #2563EB; padding: 8px 16px; border-radius: 8px; border: 1px solid #BFDBFE;">
            <i class="fas fa-calendar-alt"></i> Semester Genap 2025/2026
          </span>
        </div>
      </div>

      <!-- Stats row -->
      <div class="stats-grid" style="margin-bottom: 24px;">
        <div class="stat-card">
          <div class="stat-icon stat-blue"><i class="fas fa-book-open"></i></div>
          <div><h3 class="stat-value">6</h3><p class="stat-label">Mata Kuliah</p></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon stat-sky"><i class="fas fa-layer-group"></i></div>
          <div><h3 class="stat-value">20</h3><p class="stat-label">Total SKS</p></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon stat-green"><i class="fas fa-chalkboard-teacher"></i></div>
          <div><h3 class="stat-value">6</h3><p class="stat-label">Dosen Pengajar</p></div>
        </div>
        <div class="stat-card">
          <div class="stat-icon stat-orange"><i class="fas fa-percentage"></i></div>
          <div><h3 class="stat-value">92</h3><p class="stat-label">Rata-rata Kehadiran (%)</p></div>
        </div>
      </div>

      <!-- Mata Kuliah Cards -->
      <div class="mk-page-grid">

        <div class="mk-page-card">
          <div class="mk-page-card-top">
            <span class="mk-color-dot" style="background:#2563EB;"></span>
            <span class="mk-sks-badge">3 SKS</span>
          </div>
          <h3>Algoritma &amp; Pemrograman</h3>
          <p class="mk-lecturer"><i class="fas fa-user-tie"></i> Dr. Budi Santoso, M.Kom</p>
          <p class="mk-schedule"><i class="fas fa-clock"></i> Senin 07:30 â€“ 09:10</p>
          <p class="mk-room"><i class="fas fa-map-marker-alt"></i> Gedung A â€“ Ruang 301</p>
          <div class="mk-grade-row">
            <span>Nilai Saat Ini</span>
            <span class="mk-grade-val">A</span>
          </div>
          <div class="mk-att-row">
            <span style="font-size:11px; color:#64748b; min-width:70px;">Kehadiran</span>
            <div class="mk-att-bar"><div class="mk-att-fill" style="width:95%;"></div></div>
            <span class="mk-att-pct">95%</span>
          </div>
        </div>

        <div class="mk-page-card">
          <div class="mk-page-card-top">
            <span class="mk-color-dot" style="background:#38BDF8;"></span>
            <span class="mk-sks-badge">3 SKS</span>
          </div>
          <h3>Basis Data</h3>
          <p class="mk-lecturer"><i class="fas fa-user-tie"></i> Prof. Sari Dewi, Ph.D</p>
          <p class="mk-schedule"><i class="fas fa-clock"></i> Senin 09:30 â€“ 11:10</p>
          <p class="mk-room"><i class="fas fa-map-marker-alt"></i> Gedung B â€“ Ruang 201</p>
          <div class="mk-grade-row">
            <span>Nilai Saat Ini</span>
            <span class="mk-grade-val">A</span>
          </div>
          <div class="mk-att-row">
            <span style="font-size:11px; color:#64748b; min-width:70px;">Kehadiran</span>
            <div class="mk-att-bar"><div class="mk-att-fill" style="width:90%;"></div></div>
            <span class="mk-att-pct">90%</span>
          </div>
        </div>

        <div class="mk-page-card">
          <div class="mk-page-card-top">
            <span class="mk-color-dot" style="background:#22C55E;"></span>
            <span class="mk-sks-badge">3 SKS</span>
          </div>
          <h3>Rekayasa Perangkat Lunak</h3>
          <p class="mk-lecturer"><i class="fas fa-user-tie"></i> Ir. Ahmad Rahman, M.T</p>
          <p class="mk-schedule"><i class="fas fa-clock"></i> Senin 13:00 â€“ 14:40</p>
          <p class="mk-room"><i class="fas fa-map-marker-alt"></i> Lab Komputer â€“ Lantai 2</p>
          <div class="mk-grade-row">
            <span>Nilai Saat Ini</span>
            <span class="mk-grade-val">B+</span>
          </div>
          <div class="mk-att-row">
            <span style="font-size:11px; color:#64748b; min-width:70px;">Kehadiran</span>
            <div class="mk-att-bar"><div class="mk-att-fill" style="width:88%;"></div></div>
            <span class="mk-att-pct">88%</span>
          </div>
        </div>

        <div class="mk-page-card">
          <div class="mk-page-card-top">
            <span class="mk-color-dot" style="background:#F97316;"></span>
            <span class="mk-sks-badge">3 SKS</span>
          </div>
          <h3>Jaringan Komputer</h3>
          <p class="mk-lecturer"><i class="fas fa-user-tie"></i> Dr. Rina Kusuma, M.T</p>
          <p class="mk-schedule"><i class="fas fa-clock"></i> Senin 15:00 â€“ 16:40</p>
          <p class="mk-room"><i class="fas fa-map-marker-alt"></i> Gedung C â€“ Ruang 105</p>
          <div class="mk-grade-row">
            <span>Nilai Saat Ini</span>
            <span class="mk-grade-val">B+</span>
          </div>
          <div class="mk-att-row">
            <span style="font-size:11px; color:#64748b; min-width:70px;">Kehadiran</span>
            <div class="mk-att-bar"><div class="mk-att-fill" style="width:93%;"></div></div>
            <span class="mk-att-pct">93%</span>
          </div>
        </div>

        <div class="mk-page-card">
          <div class="mk-page-card-top">
            <span class="mk-color-dot" style="background:#8B5CF6;"></span>
            <span class="mk-sks-badge">4 SKS</span>
          </div>
          <h3>Kalkulus</h3>
          <p class="mk-lecturer"><i class="fas fa-user-tie"></i> Dr. Hendra Wijaya, M.Si</p>
          <p class="mk-schedule"><i class="fas fa-clock"></i> Selasa 08:00 â€“ 09:40</p>
          <p class="mk-room"><i class="fas fa-map-marker-alt"></i> Gedung D â€“ Ruang 401</p>
          <div class="mk-grade-row">
            <span>Nilai Saat Ini</span>
            <span class="mk-grade-val">A</span>
          </div>
          <div class="mk-att-row">
            <span style="font-size:11px; color:#64748b; min-width:70px;">Kehadiran</span>
            <div class="mk-att-bar"><div class="mk-att-fill" style="width:96%;"></div></div>
            <span class="mk-att-pct">96%</span>
          </div>
        </div>

        <div class="mk-page-card">
          <div class="mk-page-card-top">
            <span class="mk-color-dot" style="background:#EC4899;"></span>
            <span class="mk-sks-badge">4 SKS</span>
          </div>
          <h3>Statistika</h3>
          <p class="mk-lecturer"><i class="fas fa-user-tie"></i> Dr. Maya Sari, M.Stat</p>
          <p class="mk-schedule"><i class="fas fa-clock"></i> Rabu 13:00 â€“ 14:40</p>
          <p class="mk-room"><i class="fas fa-map-marker-alt"></i> Gedung A â€“ Ruang 201</p>
          <div class="mk-grade-row">
            <span>Nilai Saat Ini</span>
            <span class="mk-grade-val">B</span>
          </div>
          <div class="mk-att-row">
            <span style="font-size:11px; color:#64748b; min-width:70px;">Kehadiran</span>
            <div class="mk-att-bar"><div class="mk-att-fill" style="width:85%;"></div></div>
            <span class="mk-att-pct">85%</span>
          </div>
        </div>

      </div>

      <!-- Info Card -->
      <div class="card-section">
        <div class="section-header">
          <h2><i class="fas fa-info-circle"></i> Informasi Pengisian KRS</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;">
          <div class="academic-info-item">
            <div class="ai-icon blue"><i class="fas fa-calendar-check"></i></div>
            <div><h4>Periode KRS</h4><div class="ai-value">20 Jun â€“ 5 Jul 2026</div></div>
          </div>
          <div class="academic-info-item">
            <div class="ai-icon green"><i class="fas fa-check-circle"></i></div>
            <div><h4>Status KRS</h4><div class="ai-value">Belum Diisi</div></div>
          </div>
          <div class="academic-info-item">
            <div class="ai-icon orange"><i class="fas fa-book"></i></div>
            <div><h4>Maks SKS</h4><div class="ai-value">24 SKS</div></div>
          </div>
        </div>
      </div>
    </main>

    <footer class="app-footer">
      <div class="footer-content">
        <div class="footer-brand"><i class="fas fa-graduation-cap"></i><span>StudySched</span></div>
        <p>&copy; 2026 StudySched â€“ Student Schedule Management System</p>
        <p class="footer-dev">Developed by Aditya Putra Pratama</p>
      </div>
    </footer>
  </div>

  <script src="js/app.js"></script>
</body>
</html>


