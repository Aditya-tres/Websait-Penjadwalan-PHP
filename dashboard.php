<?php require_once __DIR__ . '/includes/auth_check.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StudySched – Beranda</title>
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
          <span class="active">Beranda</span>
        </div>
      </div>
      <div class="topbar-right">
        <button class="topbar-btn" title="Cari"><i class="fas fa-search"></i></button>
        <div class="notification-btn">
          <button class="topbar-btn" title="Notifikasi"><i class="fas fa-bell"></i></button>
          <span class="notif-dot"></span>
        </div>
        <div class="topbar-profile">
          <img src="https://ui-avatars.com/api/?name=User&background=2563EB&color=fff&size=40" alt="Avatar" id="topbarAvatar" />
          <span id="topbarNama">User</span>
        </div>
      </div>
    </header>

    <main class="page-content">

      <!-- Hero Section -->
      <section class="hero-section">
        <div class="hero-bg">
          <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=1600&auto=format&fit=crop&q=80" alt="Kampus" class="hero-bg-img" />
          <div class="hero-overlay"></div>
        </div>
        <div class="hero-content">
          <div class="hero-text">
            <div class="hero-badge"><i class="fas fa-star"></i> Semester Genap 2025/2026</div>
            <h1 class="hero-title">Selamat Datang di <br /><span class="hero-brand">StudySched</span></h1>
            <p class="hero-desc">Kelola jadwal kuliah, tugas, dan aktivitas akademik Anda dengan lebih mudah dan terorganisir.</p>
            <div class="hero-actions">
              <a href="kalender.php" class="btn-primary-hero"><i class="fas fa-calendar-alt"></i> Lihat Jadwal</a>
              <a href="tugas.php" class="btn-outline-hero"><i class="fas fa-tasks"></i> Cek Tugas</a>
            </div>
          </div>
          <div class="hero-stats">
            <div class="hero-stat-card">
              <i class="fas fa-book"></i>
              <div><h3>6</h3><p>Mata Kuliah</p></div>
            </div>
            <div class="hero-stat-card">
              <i class="fas fa-calendar-day"></i>
              <div><h3>4</h3><p>Jadwal Hari Ini</p></div>
            </div>
          </div>
        </div>
      </section>

      <!-- Stats Cards -->
      <section class="stats-section">
        <div class="stats-grid">
          <div class="stat-card">
            <div class="stat-icon stat-blue"><i class="fas fa-book-open"></i></div>
            <div class="stat-body">
              <h3 class="stat-value">6</h3>
              <p class="stat-label">Mata Kuliah Aktif</p>
              <span class="stat-change positive"><i class="fas fa-arrow-up"></i> Semester ini</span>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon stat-sky"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-body">
              <h3 class="stat-value">4</h3>
              <p class="stat-label">Jadwal Hari Ini</p>
              <span class="stat-change neutral"><i class="fas fa-clock"></i> Senin, 15 Jun</span>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon stat-orange"><i class="fas fa-clipboard-list"></i></div>
            <div class="stat-body">
              <h3 class="stat-value">3</h3>
              <p class="stat-label">Tugas Belum Selesai</p>
              <span class="stat-change negative"><i class="fas fa-exclamation-circle"></i> 1 mendekati deadline</span>
            </div>
          </div>
          <div class="stat-card">
            <div class="stat-icon stat-green"><i class="fas fa-graduation-cap"></i></div>
            <div class="stat-body">
              <h3 class="stat-value">20</h3>
              <p class="stat-label">Total SKS</p>
              <span class="stat-change positive"><i class="fas fa-check-circle"></i> Sesuai kurikulum</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Two Column Layout -->
      <div class="two-col-layout">
        <section class="card-section">
          <div class="section-header">
            <h2><i class="fas fa-calendar-day"></i> Jadwal Hari Ini</h2>
            <a href="kalender.php" class="see-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="schedule-list">
            <div class="schedule-item">
              <div class="schedule-time"><span class="time-start">07:30</span><span class="time-end">09:10</span></div>
              <div class="schedule-dot blue"></div>
              <div class="schedule-info">
                <h4>Algoritma &amp; Pemrograman</h4>
                <p><i class="fas fa-map-marker-alt"></i> Gedung A – Ruang 301</p>
                <p><i class="fas fa-user-tie"></i> Dr. Budi Santoso, M.Kom</p>
              </div>
              <span class="schedule-badge active">Berlangsung</span>
            </div>
            <div class="schedule-item">
              <div class="schedule-time"><span class="time-start">09:30</span><span class="time-end">11:10</span></div>
              <div class="schedule-dot sky"></div>
              <div class="schedule-info">
                <h4>Basis Data</h4>
                <p><i class="fas fa-map-marker-alt"></i> Gedung B – Ruang 201</p>
                <p><i class="fas fa-user-tie"></i> Prof. Sari Dewi, Ph.D</p>
              </div>
              <span class="schedule-badge upcoming">Segera</span>
            </div>
            <div class="schedule-item">
              <div class="schedule-time"><span class="time-start">13:00</span><span class="time-end">14:40</span></div>
              <div class="schedule-dot green"></div>
              <div class="schedule-info">
                <h4>Rekayasa Perangkat Lunak</h4>
                <p><i class="fas fa-map-marker-alt"></i> Lab Komputer – Lantai 2</p>
                <p><i class="fas fa-user-tie"></i> Ir. Ahmad Rahman, M.T</p>
              </div>
              <span class="schedule-badge later">Sore Ini</span>
            </div>
            <div class="schedule-item">
              <div class="schedule-time"><span class="time-start">15:00</span><span class="time-end">16:40</span></div>
              <div class="schedule-dot orange"></div>
              <div class="schedule-info">
                <h4>Jaringan Komputer</h4>
                <p><i class="fas fa-map-marker-alt"></i> Gedung C – Ruang 105</p>
                <p><i class="fas fa-user-tie"></i> Dr. Rina Kusuma, M.T</p>
              </div>
              <span class="schedule-badge later">Sore Ini</span>
            </div>
          </div>
        </section>

        <section class="card-section">
          <div class="section-header">
            <h2><i class="fas fa-tasks"></i> Tugas Mendatang</h2>
            <a href="tugas.php" class="see-all">Lihat Semua <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="task-list">
            <div class="task-item">
              <div class="task-status-dot red"></div>
              <div class="task-body">
                <h4>Laporan Praktikum Basis Data</h4>
                <p class="task-meta"><i class="fas fa-clock"></i> Deadline: Besok, 23:59</p>
                <div class="task-progress">
                  <div class="progress-bar"><div class="progress-fill" style="width: 70%; background: #ef4444;"></div></div>
                  <span>70%</span>
                </div>
              </div>
              <span class="task-badge red">Mendesak</span>
            </div>
            <div class="task-item">
              <div class="task-status-dot orange"></div>
              <div class="task-body">
                <h4>Tugas Rekayasa Perangkat Lunak</h4>
                <p class="task-meta"><i class="fas fa-clock"></i> Deadline: 15 Jun 2026</p>
                <div class="task-progress">
                  <div class="progress-bar"><div class="progress-fill" style="width: 40%; background: #f97316;"></div></div>
                  <span>40%</span>
                </div>
              </div>
              <span class="task-badge orange">Proses</span>
            </div>
            <div class="task-item">
              <div class="task-status-dot sky"></div>
              <div class="task-body">
                <h4>Makalah Jaringan Komputer</h4>
                <p class="task-meta"><i class="fas fa-clock"></i> Deadline: 20 Jun 2026</p>
                <div class="task-progress">
                  <div class="progress-bar"><div class="progress-fill" style="width: 15%; background: #38bdf8;"></div></div>
                  <span>15%</span>
                </div>
              </div>
              <span class="task-badge blue">Baru</span>
            </div>
            <div class="task-item done">
              <div class="task-status-dot green"></div>
              <div class="task-body">
                <h4>Quiz Algoritma &amp; Pemrograman</h4>
                <p class="task-meta"><i class="fas fa-check-circle"></i> Selesai: 05 Jun 2026</p>
                <div class="task-progress">
                  <div class="progress-bar"><div class="progress-fill" style="width: 100%; background: #22c55e;"></div></div>
                  <span>100%</span>
                </div>
              </div>
              <span class="task-badge green">Selesai</span>
            </div>
          </div>
        </section>
      </div>

      <!-- Campus Info -->
      <section class="campus-info-section">
        <div class="section-header">
          <h2><i class="fas fa-university"></i> Informasi Akademik</h2>
          <span class="section-subtitle">Informasi terkini dari kampus</span>
        </div>
        <div class="campus-grid">
          <div class="campus-card">
            <div class="campus-card-icon blue-gradient"><i class="fas fa-bullhorn"></i></div>
            <h3>Pengumuman</h3>
            <p>Pengisian KRS Semester Ganjil 2026/2027 dibuka mulai 20 Juni 2026</p>
            <a href="matakuliah.php" class="campus-card-link">Lihat Mata Kuliah <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="campus-card">
            <div class="campus-card-icon sky-gradient"><i class="fas fa-calendar-week"></i></div>
            <h3>Kalender Akademik</h3>
            <p>UAS Semester Genap akan dilaksanakan pada 15–30 Juli 2026</p>
            <a href="kalender.php" class="campus-card-link">Lihat Kalender <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="campus-card">
            <div class="campus-card-icon gold-gradient"><i class="fas fa-trophy"></i></div>
            <h3>Nilai &amp; IPK</h3>
            <p>Pantau perkembangan nilai dan IPK Anda setiap semester</p>
            <a href="nilai.php" class="campus-card-link">Lihat Nilai <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="campus-card">
            <div class="campus-card-icon green-gradient"><i class="fas fa-file-alt"></i></div>
            <h3>Transkrip</h3>
            <p>Unduh transkrip akademik resmi untuk keperluan administrasi</p>
            <a href="transkrip.php" class="campus-card-link">Lihat Transkrip <i class="fas fa-arrow-right"></i></a>
          </div>
        </div>
      </section>

      <!-- Slider -->
      <section class="slider-section">
        <div class="section-header">
          <h2><i class="fas fa-images"></i> Galeri Kampus</h2>
        </div>
        <div class="slider-container" id="sliderContainer">
          <div class="slider-track" id="sliderTrack">
            <div class="slider-slide">
              <img src="https://images.unsplash.com/photo-1562774053-701939374585?w=1200&auto=format&fit=crop&q=80" alt="Gedung Kampus" />
              <div class="slide-caption">Gedung Utama Kampus</div>
            </div>
            <div class="slider-slide">
              <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1200&auto=format&fit=crop&q=80" alt="Mahasiswa Belajar" />
              <div class="slide-caption">Mahasiswa Belajar</div>
            </div>
            <div class="slider-slide">
              <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1200&auto=format&fit=crop&q=80" alt="Perpustakaan" />
              <div class="slide-caption">Perpustakaan Modern</div>
            </div>
            <div class="slider-slide">
              <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=1200&auto=format&fit=crop&q=80" alt="Lab Komputer" />
              <div class="slide-caption">Laboratorium Komputer</div>
            </div>
          </div>
          <button class="slider-btn prev" id="sliderPrev"><i class="fas fa-chevron-left"></i></button>
          <button class="slider-btn next" id="sliderNext"><i class="fas fa-chevron-right"></i></button>
          <div class="slider-dots" id="sliderDots"></div>
        </div>
      </section>

    </main>

    <footer class="app-footer">
      <div class="footer-content">
        <div class="footer-brand"><i class="fas fa-graduation-cap"></i><span>StudySched</span></div>
        <p>&copy; 2026 StudySched – Student Schedule Management System</p>
        <p class="footer-dev">Developed by Aditya Putra Pratama</p>
      </div>
    </footer>
  </div>

  <script src="js/app.js"></script>
  <script src="js/dashboard.js"></script>
</body>
</html>
