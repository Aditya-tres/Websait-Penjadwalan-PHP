<?php require_once __DIR__ . '/includes/auth_check.php'; ?>
﻿<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StudySched â€“ Profil</title>
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
          <span class="active">Profil</span>
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
          <h1 class="page-title"><i class="fas fa-user-circle"></i> Profil Mahasiswa</h1>
          <p class="page-subtitle">Kelola informasi dan data diri Anda</p>
        </div>
        <button class="btn-primary" onclick="toggleEditMode()">
          <i class="fas fa-edit"></i> <span id="editBtnText">Edit Profil</span>
        </button>
      </div>

      <div class="profile-layout">
        <!-- Left Card -->
        <div>
          <div class="profile-card-main">
            <div class="profile-cover"><div class="profile-cover-bg"></div></div>
            <div class="profile-card-body">
              <div class="profile-avatar-lg">
                <img src="https://ui-avatars.com/api/?name=User&background=2563EB&color=fff&size=120" alt="Avatar" id="profileAvatar" />
                <label class="avatar-edit-btn" for="avatarInput" title="Ganti Foto">
                  <i class="fas fa-camera"></i>
                </label>
                <input type="file" id="avatarInput" accept="image/*" style="display:none" onchange="changeAvatar(event)" />
              </div>
              <div class="profile-card-info">
                <h2 id="profileName">User</h2>
                <p class="profile-nim" id="profileNIM">email@kampus.ac.id</p>
                <span class="prodi-badge-lg" id="profileProdi">Teknik Informatika</span>
              </div>
              <div class="profile-quick-stats">
                <div class="quick-stat"><h3>6</h3><p>Mata Kuliah</p></div>
                <div class="quick-stat"><h3>20</h3><p>SKS</p></div>
                <div class="quick-stat"><h3>3.75</h3><p>IPK</p></div>
                <div class="quick-stat"><h3>4</h3><p>Semester</p></div>
              </div>
            </div>
          </div>

        </div>

        <!-- Right Details -->
        <div class="profile-details">
          <div class="profile-section-card">
            <h3 class="profile-section-title"><i class="fas fa-user"></i> Informasi Pribadi</h3>
            <div class="profile-form">
              <div class="profile-field">
                <label>Nama Lengkap</label>
                <div class="field-value" id="fieldNama">User</div>
                <input type="text" class="field-input hidden" id="inputNama" placeholder="Nama lengkap" />
              </div>
              <div class="profile-field">
                <label>Email</label>
                <div class="field-value" id="fieldEmail">email@kampus.ac.id</div>
                <input type="email" class="field-input hidden" id="inputEmail" placeholder="email@kampus.ac.id" readonly title="Email tidak dapat diubah karena digunakan sebagai login" />
              </div>
              <div class="profile-field">
                <label>Program Studi</label>
                <div class="field-value" id="fieldProdi">Teknik Informatika</div>
                <input type="text" class="field-input hidden" id="inputProdi" placeholder="Program Studi" />
              </div>
              <div class="profile-field">
                <label>Fakultas</label>
                <div class="field-value">Fakultas Ilmu Komputer</div>
              </div>
              <div class="profile-field">
                <label>Angkatan</label>
                <div class="field-value">2023</div>
              </div>
              <div class="save-btn-area hidden" id="saveBtnArea">
                <button class="btn-secondary" onclick="cancelEdit()">Batal</button>
                <button class="btn-primary" onclick="saveProfile()"><i class="fas fa-save"></i> Simpan</button>
              </div>
            </div>
          </div>

          <div class="profile-section-card">
            <h3 class="profile-section-title"><i class="fas fa-graduation-cap"></i> Informasi Akademik</h3>
            <div class="academic-info-grid">
              <div class="academic-info-item">
                <div class="ai-icon blue"><i class="fas fa-id-card"></i></div>
                <div><h4>NIM</h4><div class="ai-value">23051301</div></div>
              </div>
              <div class="academic-info-item">
                <div class="ai-icon sky"><i class="fas fa-layer-group"></i></div>
                <div><h4>Semester</h4><div class="ai-value">4 (Genap)</div></div>
              </div>
              <div class="academic-info-item">
                <div class="ai-icon green"><i class="fas fa-star"></i></div>
                <div><h4>IPK</h4><div class="ai-value">3.75</div></div>
              </div>
              <div class="academic-info-item">
                <div class="ai-icon orange"><i class="fas fa-book"></i></div>
                <div><h4>SKS Ditempuh</h4><div class="ai-value">60 SKS</div></div>
              </div>
              <div class="academic-info-item">
                <div class="ai-icon purple"><i class="fas fa-clock"></i></div>
                <div><h4>SKS Semester Ini</h4><div class="ai-value">20 SKS</div></div>
              </div>
              <div class="academic-info-item">
                <div class="ai-icon pink"><i class="fas fa-chart-bar"></i></div>
                <div><h4>Status</h4><div class="ai-value">Aktif</div></div>
              </div>
            </div>
          </div>

          <div class="profile-section-card">
            <h3 class="profile-section-title"><i class="fas fa-table"></i> Nilai Semester Terakhir</h3>
            <div class="grades-table-wrap">
              <table class="grades-table">
                <thead>
                  <tr>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Nilai</th>
                    <th>Mutu</th>
                  </tr>
                </thead>
                <tbody>
                  <tr><td>Algoritma &amp; Pemrograman</td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td></tr>
                  <tr><td>Basis Data</td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td></tr>
                  <tr><td>Rekayasa Perangkat Lunak</td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td></tr>
                  <tr><td>Jaringan Komputer</td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td></tr>
                  <tr><td>Kalkulus</td><td>4</td><td><span class="grade-badge a">A</span></td><td>4.0</td></tr>
                  <tr><td>Statistika</td><td>4</td><td><span class="grade-badge b">B</span></td><td>3.0</td></tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="profile-section-card">
            <h3 class="profile-section-title"><i class="fas fa-shield-alt"></i> Keamanan Akun</h3>
            <div class="security-section">
              <div class="security-item">
                <div class="security-icon"><i class="fas fa-envelope"></i></div>
                <div class="security-info">
                  <h4>Email</h4>
                  <p>Digunakan sebagai identitas login</p>
                </div>
                <span class="verified-badge"><i class="fas fa-check"></i> Aktif</span>
              </div>
              <div class="security-item">
                <div class="security-icon"><i class="fas fa-lock"></i></div>
                <div class="security-info">
                  <h4>Password</h4>
                  <p>Terakhir diubah 30 hari yang lalu</p>
                </div>
                <button class="btn-outline-sm">Ubah</button>
              </div>
              <div class="security-item">
                <div class="security-icon"><i class="fas fa-sign-out-alt"></i></div>
                <div class="security-info">
                  <h4>Keluar dari Akun</h4>
                  <p>Akhiri sesi sekarang dan kembali ke halaman login</p>
                </div>
                <button class="btn-outline-sm" onclick="handleLogout()">Keluar</button>
              </div>
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

  <script src="js/app.js"></script>
  <script src="js/profil.js"></script>
</body>
</html>


