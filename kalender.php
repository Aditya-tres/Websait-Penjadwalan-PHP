<?php require_once __DIR__ . '/includes/auth_check.php'; ?>
﻿<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StudySched â€“ Kalender</title>
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
          <span class="active">Kalender</span>
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
          <h1 class="page-title"><i class="fas fa-calendar-alt"></i> Kalender Akademik</h1>
          <p class="page-subtitle">Jadwal kuliah dan kegiatan akademik Anda</p>
        </div>
        <button class="btn-primary" onclick="openAddEvent()">
          <i class="fas fa-plus"></i> Tambah Event
        </button>
      </div>

      <div class="calendar-layout">
        <div class="calendar-main">
          <div class="calendar-card">
            <div class="calendar-nav">
              <button class="cal-nav-btn" id="prevMonth"><i class="fas fa-chevron-left"></i></button>
              <h2 id="calMonthYear">Juni 2026</h2>
              <button class="cal-nav-btn" id="nextMonth"><i class="fas fa-chevron-right"></i></button>
            </div>
            <div class="calendar-grid-header">
              <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div>
              <div>Kam</div><div>Jum</div><div>Sab</div>
            </div>
            <div class="calendar-grid" id="calendarGrid"></div>
          </div>

          <div class="week-schedule-card">
            <div class="section-header">
              <h2><i class="fas fa-list-ul"></i> Jadwal Minggu Ini</h2>
            </div>
            <div class="week-schedule">
              <div class="week-day-col">
                <div class="week-day-label">Senin</div>
                <div class="week-event blue">07:30 â€“ Algoritma &amp; Pemrograman<br/><small>Gd. A R.301</small></div>
                <div class="week-event sky">09:30 â€“ Basis Data<br/><small>Gd. B R.201</small></div>
                <div class="week-event green">13:00 â€“ RPL<br/><small>Lab Komputer</small></div>
                <div class="week-event orange">15:00 â€“ Jaringan Komputer<br/><small>Gd. C R.105</small></div>
              </div>
              <div class="week-day-col">
                <div class="week-day-label">Selasa</div>
                <div class="week-event purple">08:00 â€“ Kalkulus<br/><small>Gd. D R.401</small></div>
                <div class="week-event blue">14:00 â€“ Algoritma (Prak)<br/><small>Lab 1</small></div>
              </div>
              <div class="week-day-col">
                <div class="week-day-label">Rabu</div>
                <div class="week-event sky">10:00 â€“ Basis Data (Prak)<br/><small>Lab 2</small></div>
                <div class="week-event pink">13:00 â€“ Statistika<br/><small>Gd. A R.201</small></div>
              </div>
              <div class="week-day-col">
                <div class="week-day-label">Kamis</div>
                <div class="week-event green">07:30 â€“ RPL<br/><small>Gd. B R.301</small></div>
                <div class="week-event orange">15:00 â€“ Jarkom (Prak)<br/><small>Lab 3</small></div>
              </div>
              <div class="week-day-col">
                <div class="week-day-label">Jumat</div>
                <div class="week-event purple">09:00 â€“ Kalkulus<br/><small>Gd. D R.402</small></div>
                <div class="week-event pink">11:00 â€“ Statistika<br/><small>Gd. A R.203</small></div>
              </div>
            </div>
          </div>
        </div>

        <div class="calendar-sidebar">
          <div class="upcoming-card">
            <h3><i class="fas fa-bell"></i> Event Mendatang</h3>
            <div class="event-list">
              <div class="event-item">
                <div class="event-date-badge blue"><span class="event-day">10</span><span class="event-month">Jun</span></div>
                <div class="event-info"><h4>Quiz Basis Data</h4><p><i class="fas fa-clock"></i> 09:30 â€“ 11:10</p></div>
              </div>
              <div class="event-item">
                <div class="event-date-badge red"><span class="event-day">11</span><span class="event-month">Jun</span></div>
                <div class="event-info"><h4>Deadline Laporan Praktikum</h4><p><i class="fas fa-clock"></i> 23:59</p></div>
              </div>
              <div class="event-item">
                <div class="event-date-badge orange"><span class="event-day">15</span><span class="event-month">Jun</span></div>
                <div class="event-info"><h4>Ujian Tengah Semester</h4><p><i class="fas fa-clock"></i> 08:00 â€“ 10:00</p></div>
              </div>
              <div class="event-item">
                <div class="event-date-badge green"><span class="event-day">20</span><span class="event-month">Jun</span></div>
                <div class="event-info"><h4>Pengisian KRS</h4><p><i class="fas fa-clock"></i> Mulai 08:00</p></div>
              </div>
              <div class="event-item">
                <div class="event-date-badge purple"><span class="event-day">25</span><span class="event-month">Jun</span></div>
                <div class="event-info"><h4>Seminar Nasional AI</h4><p><i class="fas fa-clock"></i> 09:00 â€“ 17:00</p></div>
              </div>
            </div>
          </div>

          <div class="mata-kuliah-card">
            <h3><i class="fas fa-book"></i> Mata Kuliah</h3>
            <div class="mk-list">
              <div class="mk-item"><span class="mk-dot blue"></span><div><p>Algoritma &amp; Pemrograman</p><small>3 SKS</small></div></div>
              <div class="mk-item"><span class="mk-dot sky"></span><div><p>Basis Data</p><small>3 SKS</small></div></div>
              <div class="mk-item"><span class="mk-dot green"></span><div><p>Rekayasa Perangkat Lunak</p><small>3 SKS</small></div></div>
              <div class="mk-item"><span class="mk-dot orange"></span><div><p>Jaringan Komputer</p><small>3 SKS</small></div></div>
              <div class="mk-item"><span class="mk-dot purple"></span><div><p>Kalkulus</p><small>4 SKS</small></div></div>
              <div class="mk-item"><span class="mk-dot pink"></span><div><p>Statistika</p><small>4 SKS</small></div></div>
            </div>
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

  <div class="modal-overlay" id="addEventModal">
    <div class="modal">
      <div class="modal-header">
        <h3><i class="fas fa-calendar-plus"></i> Tambah Event</h3>
        <button class="modal-close" onclick="closeAddEvent()"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body">
        <div class="form-group"><label>Nama Event</label><input type="text" placeholder="Contoh: Quiz Algoritma" /></div>
        <div class="form-group"><label>Tanggal</label><input type="date" /></div>
        <div class="form-row">
          <div class="form-group"><label>Mulai</label><input type="time" value="08:00" /></div>
          <div class="form-group"><label>Selesai</label><input type="time" value="10:00" /></div>
        </div>
        <div class="form-group">
          <label>Kategori</label>
          <select><option>Kuliah</option><option>Ujian</option><option>Tugas</option><option>Event</option></select>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn-secondary" onclick="closeAddEvent()">Batal</button>
        <button class="btn-primary" onclick="closeAddEvent(); showToast('Event berhasil ditambahkan!', 'success')"><i class="fas fa-check"></i> Simpan</button>
      </div>
    </div>
  </div>

  <script src="js/app.js"></script>
  <script src="js/kalender.js"></script>
</body>
</html>


