<?php require_once __DIR__ . '/includes/auth_check.php'; ?>
﻿<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StudySched â€“ Transkrip</title>
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
          <span class="active">Transkrip</span>
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
          <h1 class="page-title"><i class="fas fa-file-alt"></i> Transkrip Akademik</h1>
          <p class="page-subtitle">Rekap seluruh nilai mata kuliah yang telah ditempuh</p>
        </div>
      </div>

      <!-- Header Card -->
      <div class="transkrip-header-card">
        <div class="transkrip-univ">
          <div class="transkrip-univ-logo"><i class="fas fa-university"></i></div>
          <div class="transkrip-univ-info">
            <h2>Universitas Teknologi Nusantara</h2>
            <p>Fakultas Ilmu Komputer &bull; Program Studi Teknik Informatika</p>
            <p style="margin-top:6px; color:rgba(255,255,255,0.4); font-size:12px;">Transkrip ini digenerate otomatis oleh sistem StudySched</p>
          </div>
        </div>
        <button class="transkrip-download-btn" onclick="window.print()">
          <i class="fas fa-print"></i> Cetak Transkrip
        </button>
      </div>

      <!-- Student Info -->
      <div class="transkrip-student-info">
        <div class="transkrip-info-card">
          <label>Nama Mahasiswa</label>
          <span id="trNama">User</span>
        </div>
        <div class="transkrip-info-card">
          <label>NIM</label>
          <span>23051301</span>
        </div>
        <div class="transkrip-info-card">
          <label>Program Studi</label>
          <span>Teknik Informatika</span>
        </div>
        <div class="transkrip-info-card">
          <label>Angkatan</label>
          <span>2023</span>
        </div>
        <div class="transkrip-info-card">
          <label>IPK Kumulatif</label>
          <span style="font-size:18px; font-weight:800; color:#2563EB;">3.75</span>
        </div>
        <div class="transkrip-info-card">
          <label>Total SKS Ditempuh</label>
          <span style="font-size:18px; font-weight:800; color:#2563EB;">73 SKS</span>
        </div>
      </div>

      <!-- Semester 1 -->
      <div class="nilai-table-wrap">
        <div class="section-header" style="margin-bottom:14px;">
          <h2 style="font-size:14px; font-weight:700; color:#0F172A; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-calendar-alt" style="color:#2563EB;"></i> Semester 1 â€“ Ganjil 2023/2024
          </h2>
          <span style="font-size:12px; font-weight:700; background:#F8FAFC; color:#64748b; padding:4px 12px; border-radius:20px; border:1px solid #E2E8F0;">IPS: 3.60 &bull; 18 SKS</span>
        </div>
        <table class="nilai-table">
          <thead>
            <tr><th>#</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai</th><th>Mutu</th><th>Bobot</th></tr>
          </thead>
          <tbody>
            <tr><td>1</td><td>Pengantar Teknologi Informasi</td><td>2</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>8.0</td></tr>
            <tr><td>2</td><td>Pemrograman Dasar</td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>12.0</td></tr>
            <tr><td>3</td><td>Matematika 1</td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>10.5</td></tr>
            <tr><td>4</td><td>Bahasa Indonesia</td><td>2</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>8.0</td></tr>
            <tr><td>5</td><td>Pendidikan Agama</td><td>2</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>8.0</td></tr>
            <tr><td>6</td><td>Pendidikan Pancasila</td><td>2</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>7.0</td></tr>
            <tr><td>7</td><td>Bahasa Inggris Teknik</td><td>2</td><td><span class="grade-badge b">B</span></td><td>3.0</td><td>6.0</td></tr>
            <tr><td>8</td><td>Pengantar Logika</td><td>2</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>7.0</td></tr>
          </tbody>
          <tfoot>
            <tr style="background:#F8FAFC;"><td colspan="2"><strong>Jumlah</strong></td><td><strong>18</strong></td><td colspan="2">â€“</td><td><strong>66.5</strong></td></tr>
          </tfoot>
        </table>
      </div>

      <!-- Semester 2 -->
      <div class="nilai-table-wrap">
        <div class="section-header" style="margin-bottom:14px;">
          <h2 style="font-size:14px; font-weight:700; color:#0F172A; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-calendar-alt" style="color:#2563EB;"></i> Semester 2 â€“ Genap 2023/2024
          </h2>
          <span style="font-size:12px; font-weight:700; background:#F8FAFC; color:#64748b; padding:4px 12px; border-radius:20px; border:1px solid #E2E8F0;">IPS: 3.72 &bull; 18 SKS</span>
        </div>
        <table class="nilai-table">
          <thead>
            <tr><th>#</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai</th><th>Mutu</th><th>Bobot</th></tr>
          </thead>
          <tbody>
            <tr><td>1</td><td>Pemrograman Lanjutan</td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>12.0</td></tr>
            <tr><td>2</td><td>Matematika 2</td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>10.5</td></tr>
            <tr><td>3</td><td>Rekayasa Perangkat Keras</td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>10.5</td></tr>
            <tr><td>4</td><td>Teori Bahasa Formal</td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>12.0</td></tr>
            <tr><td>5</td><td>Etika Profesi</td><td>2</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>8.0</td></tr>
            <tr><td>6</td><td>Kewarganegaraan</td><td>2</td><td><span class="grade-badge b">B</span></td><td>3.0</td><td>6.0</td></tr>
            <tr><td>7</td><td>Fisika Komputasi</td><td>2</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>7.0</td></tr>
          </tbody>
          <tfoot>
            <tr style="background:#F8FAFC;"><td colspan="2"><strong>Jumlah</strong></td><td><strong>18</strong></td><td colspan="2">â€“</td><td><strong>66.0</strong></td></tr>
          </tfoot>
        </table>
      </div>

      <!-- Semester 3 -->
      <div class="nilai-table-wrap">
        <div class="section-header" style="margin-bottom:14px;">
          <h2 style="font-size:14px; font-weight:700; color:#0F172A; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-calendar-alt" style="color:#2563EB;"></i> Semester 3 â€“ Ganjil 2024/2025
          </h2>
          <span style="font-size:12px; font-weight:700; background:#F8FAFC; color:#64748b; padding:4px 12px; border-radius:20px; border:1px solid #E2E8F0;">IPS: 3.70 &bull; 17 SKS</span>
        </div>
        <table class="nilai-table">
          <thead>
            <tr><th>#</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai</th><th>Mutu</th><th>Bobot</th></tr>
          </thead>
          <tbody>
            <tr><td>1</td><td>Pemrograman Berorientasi Objek</td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>12.0</td></tr>
            <tr><td>2</td><td>Struktur Data</td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>12.0</td></tr>
            <tr><td>3</td><td>Matematika Diskrit</td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>10.5</td></tr>
            <tr><td>4</td><td>Logika dan Penalaran</td><td>2</td><td><span class="grade-badge b">B</span></td><td>3.0</td><td>6.0</td></tr>
            <tr><td>5</td><td>Sistem Operasi</td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>10.5</td></tr>
            <tr><td>6</td><td>Fisika Dasar</td><td>3</td><td><span class="grade-badge b">B</span></td><td>3.0</td><td>9.0</td></tr>
          </tbody>
          <tfoot>
            <tr style="background:#F8FAFC;"><td colspan="2"><strong>Jumlah</strong></td><td><strong>17</strong></td><td colspan="2">â€“</td><td><strong>60.0</strong></td></tr>
          </tfoot>
        </table>
      </div>

      <!-- Semester 4 (Current) -->
      <div class="nilai-table-wrap">
        <div class="section-header" style="margin-bottom:14px;">
          <h2 style="font-size:14px; font-weight:700; color:#0F172A; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-calendar-alt" style="color:#2563EB;"></i> Semester 4 â€“ Genap 2025/2026
            <span style="font-size:10px; background:#DCFCE7; color:#15803D; padding:2px 8px; border-radius:12px;">Semester Berjalan</span>
          </h2>
          <span style="font-size:12px; font-weight:700; background:#DBEAFE; color:#2563EB; padding:4px 12px; border-radius:20px; border:1px solid #BFDBFE;">IPS: 3.82 &bull; 20 SKS</span>
        </div>
        <table class="nilai-table">
          <thead>
            <tr><th>#</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai</th><th>Mutu</th><th>Bobot</th></tr>
          </thead>
          <tbody>
            <tr><td>1</td><td>Algoritma &amp; Pemrograman</td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>12.0</td></tr>
            <tr><td>2</td><td>Basis Data</td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>12.0</td></tr>
            <tr><td>3</td><td>Rekayasa Perangkat Lunak</td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>10.5</td></tr>
            <tr><td>4</td><td>Jaringan Komputer</td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>10.5</td></tr>
            <tr><td>5</td><td>Kalkulus</td><td>4</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>16.0</td></tr>
            <tr><td>6</td><td>Statistika</td><td>4</td><td><span class="grade-badge b">B</span></td><td>3.0</td><td>12.0</td></tr>
          </tbody>
          <tfoot>
            <tr style="background:#EFF6FF;"><td colspan="2"><strong>Jumlah</strong></td><td><strong>20</strong></td><td colspan="2">â€“</td><td><strong>73.0</strong></td></tr>
          </tfoot>
        </table>
      </div>

      <!-- Rekap Total -->
      <div class="card-section">
        <div class="section-header">
          <h2><i class="fas fa-calculator"></i> Rekap Kumulatif</h2>
        </div>
        <div class="academic-info-grid" style="margin-top:8px;">
          <div class="academic-info-item">
            <div class="ai-icon blue"><i class="fas fa-layer-group"></i></div>
            <div><h4>Total SKS Ditempuh</h4><div class="ai-value" style="font-size:18px;">73 SKS</div></div>
          </div>
          <div class="academic-info-item">
            <div class="ai-icon green"><i class="fas fa-star"></i></div>
            <div><h4>IPK Kumulatif</h4><div class="ai-value" style="font-size:18px; color:#2563EB;">3.75</div></div>
          </div>
          <div class="academic-info-item">
            <div class="ai-icon orange"><i class="fas fa-book"></i></div>
            <div><h4>Total Mata Kuliah</h4><div class="ai-value" style="font-size:18px;">29 MK</div></div>
          </div>
          <div class="academic-info-item">
            <div class="ai-icon purple"><i class="fas fa-award"></i></div>
            <div><h4>Predikat</h4><div class="ai-value" style="font-size:14px; color:#7C3AED;">Sangat Memuaskan</div></div>
          </div>
          <div class="academic-info-item">
            <div class="ai-icon sky"><i class="fas fa-graduation-cap"></i></div>
            <div><h4>Semester Aktif</h4><div class="ai-value" style="font-size:18px;">4 Semester</div></div>
          </div>
          <div class="academic-info-item">
            <div class="ai-icon pink"><i class="fas fa-flag-checkered"></i></div>
            <div><h4>Target Lulus</h4><div class="ai-value" style="font-size:14px;">2027 (8 Semester)</div></div>
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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const user = JSON.parse(localStorage.getItem('studysched_user') || '{}');
      const nama = user.nama || (user.email ? user.email.split('@')[0] : 'User');
      const el = document.getElementById('trNama');
      if (el) el.textContent = nama;
    });
  </script>
</body>
</html>


