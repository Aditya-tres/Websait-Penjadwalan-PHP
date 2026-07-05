<?php require_once __DIR__ . '/includes/auth_check.php'; ?>
﻿<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StudySched â€“ Tugas</title>
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
          <span class="active">Tugas</span>
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
          <h1 class="page-title"><i class="fas fa-clipboard-list"></i> Manajemen Tugas</h1>
          <p class="page-subtitle">Pantau dan kelola semua tugas kuliah Anda</p>
        </div>
        <button class="btn-primary" onclick="openAddTask()">
          <i class="fas fa-plus"></i> Tambah Tugas
        </button>
      </div>

      <div class="task-summary-grid">
        <div class="task-summary-card red"><i class="fas fa-fire"></i><div><h3>1</h3><p>Mendesak</p></div></div>
        <div class="task-summary-card orange"><i class="fas fa-spinner"></i><div><h3>2</h3><p>Dalam Proses</p></div></div>
        <div class="task-summary-card blue"><i class="fas fa-inbox"></i><div><h3>1</h3><p>Baru</p></div></div>
        <div class="task-summary-card green"><i class="fas fa-check-double"></i><div><h3>5</h3><p>Selesai</p></div></div>
      </div>

      <div class="task-filters">
        <button class="filter-tab active" onclick="filterTasks('all', this)">Semua</button>
        <button class="filter-tab" onclick="filterTasks('mendesak', this)">Mendesak</button>
        <button class="filter-tab" onclick="filterTasks('proses', this)">Dalam Proses</button>
        <button class="filter-tab" onclick="filterTasks('baru', this)">Baru</button>
        <button class="filter-tab" onclick="filterTasks('selesai', this)">Selesai</button>
      </div>

      <div class="task-cards" id="taskContainer">

        <div class="task-card" data-status="mendesak">
          <div class="task-card-header">
            <div class="task-card-left">
              <input type="checkbox" class="task-check" />
              <div>
                <h3 class="task-card-title">Laporan Praktikum Basis Data</h3>
                <p class="task-card-meta">
                  <span class="meta-tag"><i class="fas fa-book"></i> Basis Data</span>
                  <span class="meta-tag"><i class="fas fa-user-tie"></i> Prof. Sari Dewi</span>
                </p>
              </div>
            </div>
            <span class="task-status-badge mendesak"><i class="fas fa-fire"></i> Mendesak</span>
          </div>
          <p class="task-card-desc">Membuat laporan hasil praktikum normalisasi database dan implementasi SQL query kompleks.</p>
          <div class="task-card-progress">
            <div class="progress-label"><span>Progress</span><span>70%</span></div>
            <div class="progress-bar large"><div class="progress-fill animated" style="width: 70%; background: linear-gradient(90deg, #ef4444, #f97316);"></div></div>
          </div>
          <div class="task-card-footer">
            <div class="task-deadline"><i class="fas fa-calendar-times"></i><span class="deadline-text danger">Besok, 16 Juni 2026 â€“ 23:59</span></div>
            <div class="task-actions">
              <button class="task-action-btn edit" title="Edit"><i class="fas fa-edit"></i></button>
              <button class="task-action-btn delete" title="Hapus"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>

        <div class="task-card" data-status="proses">
          <div class="task-card-header">
            <div class="task-card-left">
              <input type="checkbox" class="task-check" />
              <div>
                <h3 class="task-card-title">Tugas Rekayasa Perangkat Lunak</h3>
                <p class="task-card-meta">
                  <span class="meta-tag"><i class="fas fa-book"></i> RPL</span>
                  <span class="meta-tag"><i class="fas fa-user-tie"></i> Ir. Ahmad Rahman</span>
                </p>
              </div>
            </div>
            <span class="task-status-badge proses"><i class="fas fa-spinner fa-spin"></i> Dalam Proses</span>
          </div>
          <p class="task-card-desc">Membuat diagram UML (Use Case, Class, Sequence) untuk proyek aplikasi perpustakaan digital.</p>
          <div class="task-card-progress">
            <div class="progress-label"><span>Progress</span><span>40%</span></div>
            <div class="progress-bar large"><div class="progress-fill animated" style="width: 40%; background: linear-gradient(90deg, #f97316, #facc15);"></div></div>
          </div>
          <div class="task-card-footer">
            <div class="task-deadline"><i class="fas fa-calendar-alt"></i><span class="deadline-text warning">15 Juni 2026 â€“ 23:59</span></div>
            <div class="task-actions">
              <button class="task-action-btn edit" title="Edit"><i class="fas fa-edit"></i></button>
              <button class="task-action-btn delete" title="Hapus"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>

        <div class="task-card" data-status="proses">
          <div class="task-card-header">
            <div class="task-card-left">
              <input type="checkbox" class="task-check" />
              <div>
                <h3 class="task-card-title">Tugas Kalkulus â€“ Integrasi Numerik</h3>
                <p class="task-card-meta">
                  <span class="meta-tag"><i class="fas fa-book"></i> Kalkulus</span>
                  <span class="meta-tag"><i class="fas fa-user-tie"></i> Dr. Hendra Wijaya</span>
                </p>
              </div>
            </div>
            <span class="task-status-badge proses"><i class="fas fa-spinner fa-spin"></i> Dalam Proses</span>
          </div>
          <p class="task-card-desc">Mengerjakan soal-soal integrasi numerik menggunakan metode Simpson dan Trapezoid.</p>
          <div class="task-card-progress">
            <div class="progress-label"><span>Progress</span><span>55%</span></div>
            <div class="progress-bar large"><div class="progress-fill animated" style="width: 55%; background: linear-gradient(90deg, #f97316, #facc15);"></div></div>
          </div>
          <div class="task-card-footer">
            <div class="task-deadline"><i class="fas fa-calendar-alt"></i><span class="deadline-text warning">18 Juni 2026 â€“ 23:59</span></div>
            <div class="task-actions">
              <button class="task-action-btn edit" title="Edit"><i class="fas fa-edit"></i></button>
              <button class="task-action-btn delete" title="Hapus"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>

        <div class="task-card" data-status="baru">
          <div class="task-card-header">
            <div class="task-card-left">
              <input type="checkbox" class="task-check" />
              <div>
                <h3 class="task-card-title">Makalah Jaringan Komputer</h3>
                <p class="task-card-meta">
                  <span class="meta-tag"><i class="fas fa-book"></i> Jaringan Komputer</span>
                  <span class="meta-tag"><i class="fas fa-user-tie"></i> Dr. Rina Kusuma</span>
                </p>
              </div>
            </div>
            <span class="task-status-badge baru"><i class="fas fa-star"></i> Baru</span>
          </div>
          <p class="task-card-desc">Menulis makalah tentang protokol TCP/IP dan implementasinya dalam jaringan modern (min. 15 halaman).</p>
          <div class="task-card-progress">
            <div class="progress-label"><span>Progress</span><span>15%</span></div>
            <div class="progress-bar large"><div class="progress-fill animated" style="width: 15%; background: linear-gradient(90deg, #38bdf8, #2563eb);"></div></div>
          </div>
          <div class="task-card-footer">
            <div class="task-deadline"><i class="fas fa-calendar-alt"></i><span class="deadline-text normal">20 Juni 2026 â€“ 23:59</span></div>
            <div class="task-actions">
              <button class="task-action-btn edit" title="Edit"><i class="fas fa-edit"></i></button>
              <button class="task-action-btn delete" title="Hapus"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>

        <div class="task-card done" data-status="selesai">
          <div class="task-card-header">
            <div class="task-card-left">
              <input type="checkbox" class="task-check" checked />
              <div>
                <h3 class="task-card-title" style="text-decoration: line-through; opacity: 0.6;">Quiz Algoritma &amp; Pemrograman</h3>
                <p class="task-card-meta">
                  <span class="meta-tag"><i class="fas fa-book"></i> Algoritma</span>
                  <span class="meta-tag"><i class="fas fa-user-tie"></i> Dr. Budi Santoso</span>
                </p>
              </div>
            </div>
            <span class="task-status-badge selesai"><i class="fas fa-check-circle"></i> Selesai</span>
          </div>
          <p class="task-card-desc" style="opacity:0.6;">Mengerjakan quiz online tentang sorting algorithm dan kompleksitas waktu.</p>
          <div class="task-card-progress">
            <div class="progress-label"><span>Progress</span><span>100%</span></div>
            <div class="progress-bar large"><div class="progress-fill animated" style="width: 100%; background: linear-gradient(90deg, #22c55e, #16a34a);"></div></div>
          </div>
          <div class="task-card-footer">
            <div class="task-deadline"><i class="fas fa-check"></i><span class="deadline-text success">Selesai: 05 Juni 2026</span></div>
            <div class="task-actions">
              <button class="task-action-btn edit" title="Edit"><i class="fas fa-edit"></i></button>
              <button class="task-action-btn delete" title="Hapus"><i class="fas fa-trash"></i></button>
            </div>
          </div>
        </div>

        <div class="task-card done" data-status="selesai">
          <div class="task-card-header">
            <div class="task-card-left">
              <input type="checkbox" class="task-check" checked />
              <div>
                <h3 class="task-card-title" style="text-decoration: line-through; opacity: 0.6;">Laporan Statistika Deskriptif</h3>
                <p class="task-card-meta">
                  <span class="meta-tag"><i class="fas fa-book"></i> Statistika</span>
                  <span class="meta-tag"><i class="fas fa-user-tie"></i> Dr. Maya Sari</span>
                </p>
              </div>
            </div>
            <span class="task-status-badge selesai"><i class="fas fa-check-circle"></i> Selesai</span>
          </div>
          <p class="task-card-desc" style="opacity:0.6;">Membuat laporan analisis data menggunakan metode statistika deskriptif.</p>
          <div class="task-card-progress">
            <div class="progress-label"><span>Progress</span><span>100%</span></div>
            <div class="progress-bar large"><div class="progress-fill animated" style="width: 100%; background: linear-gradient(90deg, #22c55e, #16a34a);"></div></div>
          </div>
          <div class="task-card-footer">
            <div class="task-deadline"><i class="fas fa-check"></i><span class="deadline-text success">Selesai: 01 Juni 2026</span></div>
            <div class="task-actions">
              <button class="task-action-btn edit" title="Edit"><i class="fas fa-edit"></i></button>
              <button class="task-action-btn delete" title="Hapus"><i class="fas fa-trash"></i></button>
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

  <div class="modal-overlay" id="addTaskModal">
    <div class="modal">
      <div class="modal-header">
        <h3><i class="fas fa-plus-circle"></i> Tambah Tugas Baru</h3>
        <button class="modal-close" onclick="closeAddTask()"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body">
        <div class="form-group"><label>Nama Tugas</label><input type="text" placeholder="Masukkan nama tugas" /></div>
        <div class="form-group">
          <label>Mata Kuliah</label>
          <select>
            <option>Algoritma &amp; Pemrograman</option>
            <option>Basis Data</option>
            <option>Rekayasa Perangkat Lunak</option>
            <option>Jaringan Komputer</option>
            <option>Kalkulus</option>
            <option>Statistika</option>
          </select>
        </div>
        <div class="form-group"><label>Deskripsi</label><textarea rows="3" placeholder="Deskripsi tugas..."></textarea></div>
        <div class="form-row">
          <div class="form-group"><label>Deadline</label><input type="date" /></div>
          <div class="form-group">
            <label>Status</label>
            <select><option>Baru</option><option>Dalam Proses</option><option>Mendesak</option></select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn-secondary" onclick="closeAddTask()">Batal</button>
        <button class="btn-primary" onclick="closeAddTask(); showToast('Tugas berhasil ditambahkan!', 'success')"><i class="fas fa-check"></i> Simpan</button>
      </div>
    </div>
  </div>

  <script src="js/app.js"></script>
  <script src="js/tugas.js"></script>
</body>
</html>


