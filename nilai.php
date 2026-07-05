<?php require_once __DIR__ . '/includes/auth_check.php'; ?>
﻿<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>StudySched â€“ Nilai</title>
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
          <span class="active">Nilai</span>
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
          <h1 class="page-title"><i class="fas fa-chart-bar"></i> Nilai Akademik</h1>
          <p class="page-subtitle">Riwayat nilai dan perkembangan IPK Anda per semester</p>
        </div>
        <a href="transkrip.php" class="btn-primary">
          <i class="fas fa-file-alt"></i> Lihat Transkrip
        </a>
      </div>

      <!-- Summary -->
      <div class="nilai-summary">
        <div class="nilai-sum-card blue">
          <div class="ns-icon"><i class="fas fa-star"></i></div>
          <div class="ns-value">3.75</div>
          <div class="ns-label">IPK Kumulatif</div>
        </div>
        <div class="nilai-sum-card green">
          <div class="ns-icon"><i class="fas fa-trophy"></i></div>
          <div class="ns-value">3.82</div>
          <div class="ns-label">IPS Semester Ini</div>
        </div>
        <div class="nilai-sum-card orange">
          <div class="ns-icon"><i class="fas fa-layer-group"></i></div>
          <div class="ns-value">60</div>
          <div class="ns-label">SKS Ditempuh</div>
        </div>
        <div class="nilai-sum-card purple">
          <div class="ns-icon"><i class="fas fa-graduation-cap"></i></div>
          <div class="ns-value">4</div>
          <div class="ns-label">Semester Aktif</div>
        </div>
      </div>

      <!-- Semester 4 (Current) -->
      <div class="nilai-table-wrap">
        <div class="section-header" style="margin-bottom:16px;">
          <h2 style="font-size:15px; font-weight:700; color:#0F172A; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-calendar-alt" style="color:#2563EB;"></i> Semester 4 â€“ Genap 2025/2026
          </h2>
          <span style="font-size:12px; font-weight:700; background:#DCFCE7; color:#15803D; padding:4px 12px; border-radius:20px;">IPS: 3.82</span>
        </div>
        <table class="nilai-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Mata Kuliah</th>
              <th>SKS</th>
              <th>Nilai Huruf</th>
              <th>Nilai Mutu</th>
              <th>Bobot</th>
              <th>Progress</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td><strong>Algoritma &amp; Pemrograman</strong><br/><small style="color:#64748b;">Dr. Budi Santoso</small></td>
              <td>3</td>
              <td><span class="grade-badge a">A</span></td>
              <td>4.0</td>
              <td>12.0</td>
              <td><div class="nilai-mutu-bar"><div class="nilai-mutu-fill" style="width:100px; height:6px; border-radius:4px;"></div><span style="font-size:11px; color:#2563EB; font-weight:700;">100%</span></div></td>
            </tr>
            <tr>
              <td>2</td>
              <td><strong>Basis Data</strong><br/><small style="color:#64748b;">Prof. Sari Dewi</small></td>
              <td>3</td>
              <td><span class="grade-badge a">A</span></td>
              <td>4.0</td>
              <td>12.0</td>
              <td><div class="nilai-mutu-bar"><div class="nilai-mutu-fill" style="width:100px; height:6px; border-radius:4px;"></div><span style="font-size:11px; color:#2563EB; font-weight:700;">100%</span></div></td>
            </tr>
            <tr>
              <td>3</td>
              <td><strong>Rekayasa Perangkat Lunak</strong><br/><small style="color:#64748b;">Ir. Ahmad Rahman</small></td>
              <td>3</td>
              <td><span class="grade-badge b">B+</span></td>
              <td>3.5</td>
              <td>10.5</td>
              <td><div class="nilai-mutu-bar"><div class="nilai-mutu-fill" style="width:87.5px; height:6px; border-radius:4px;"></div><span style="font-size:11px; color:#2563EB; font-weight:700;">87%</span></div></td>
            </tr>
            <tr>
              <td>4</td>
              <td><strong>Jaringan Komputer</strong><br/><small style="color:#64748b;">Dr. Rina Kusuma</small></td>
              <td>3</td>
              <td><span class="grade-badge b">B+</span></td>
              <td>3.5</td>
              <td>10.5</td>
              <td><div class="nilai-mutu-bar"><div class="nilai-mutu-fill" style="width:87.5px; height:6px; border-radius:4px;"></div><span style="font-size:11px; color:#2563EB; font-weight:700;">87%</span></div></td>
            </tr>
            <tr>
              <td>5</td>
              <td><strong>Kalkulus</strong><br/><small style="color:#64748b;">Dr. Hendra Wijaya</small></td>
              <td>4</td>
              <td><span class="grade-badge a">A</span></td>
              <td>4.0</td>
              <td>16.0</td>
              <td><div class="nilai-mutu-bar"><div class="nilai-mutu-fill" style="width:100px; height:6px; border-radius:4px;"></div><span style="font-size:11px; color:#2563EB; font-weight:700;">100%</span></div></td>
            </tr>
            <tr>
              <td>6</td>
              <td><strong>Statistika</strong><br/><small style="color:#64748b;">Dr. Maya Sari</small></td>
              <td>4</td>
              <td><span class="grade-badge b">B</span></td>
              <td>3.0</td>
              <td>12.0</td>
              <td><div class="nilai-mutu-bar"><div class="nilai-mutu-fill" style="width:75px; height:6px; border-radius:4px;"></div><span style="font-size:11px; color:#2563EB; font-weight:700;">75%</span></div></td>
            </tr>
          </tbody>
          <tfoot>
            <tr style="background:#F8FAFC;">
              <td colspan="2"><strong>Total Semester 4</strong></td>
              <td><strong>20</strong></td>
              <td>â€“</td>
              <td>â€“</td>
              <td><strong>73.0</strong></td>
              <td><strong style="color:#2563EB;">IPS: 3.82</strong></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Semester 3 -->
      <div class="nilai-table-wrap">
        <div class="section-header" style="margin-bottom:16px;">
          <h2 style="font-size:15px; font-weight:700; color:#0F172A; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-calendar-alt" style="color:#2563EB;"></i> Semester 3 â€“ Ganjil 2024/2025
          </h2>
          <span style="font-size:12px; font-weight:700; background:#DBEAFE; color:#2563EB; padding:4px 12px; border-radius:20px;">IPS: 3.70</span>
        </div>
        <table class="nilai-table">
          <thead>
            <tr>
              <th>#</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai Huruf</th><th>Nilai Mutu</th><th>Bobot</th>
            </tr>
          </thead>
          <tbody>
            <tr><td>1</td><td><strong>Pemrograman Berorientasi Objek</strong></td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>12.0</td></tr>
            <tr><td>2</td><td><strong>Struktur Data</strong></td><td>3</td><td><span class="grade-badge a">A</span></td><td>4.0</td><td>12.0</td></tr>
            <tr><td>3</td><td><strong>Matematika Diskrit</strong></td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>10.5</td></tr>
            <tr><td>4</td><td><strong>Logika dan Penalaran</strong></td><td>2</td><td><span class="grade-badge b">B</span></td><td>3.0</td><td>6.0</td></tr>
            <tr><td>5</td><td><strong>Sistem Operasi</strong></td><td>3</td><td><span class="grade-badge b">B+</span></td><td>3.5</td><td>10.5</td></tr>
            <tr><td>6</td><td><strong>Fisika Dasar</strong></td><td>3</td><td><span class="grade-badge b">B</span></td><td>3.0</td><td>9.0</td></tr>
          </tbody>
          <tfoot>
            <tr style="background:#F8FAFC;">
              <td colspan="2"><strong>Total Semester 3</strong></td><td><strong>17</strong></td><td>â€“</td><td>â€“</td><td><strong>60.0</strong></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- Rekap IPK -->
      <div class="card-section">
        <div class="section-header">
          <h2><i class="fas fa-chart-line"></i> Rekap IPK Per Semester</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-top: 8px;">
          <div style="text-align:center; padding: 16px; background: #F8FAFC; border-radius: 10px; border: 1px solid #E2E8F0;">
            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">Semester 1</div>
            <div style="font-size: 28px; font-weight: 800; color: #0F172A;">3.60</div>
            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">IPS 3.60 &bull; 18 SKS</div>
          </div>
          <div style="text-align:center; padding: 16px; background: #F8FAFC; border-radius: 10px; border: 1px solid #E2E8F0;">
            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">Semester 2</div>
            <div style="font-size: 28px; font-weight: 800; color: #0F172A;">3.72</div>
            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">IPS 3.72 &bull; 18 SKS</div>
          </div>
          <div style="text-align:center; padding: 16px; background: #F8FAFC; border-radius: 10px; border: 1px solid #E2E8F0;">
            <div style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 6px;">Semester 3</div>
            <div style="font-size: 28px; font-weight: 800; color: #0F172A;">3.70</div>
            <div style="font-size: 11px; color: #64748b; margin-top: 4px;">IPS 3.70 &bull; 17 SKS</div>
          </div>
          <div style="text-align:center; padding: 16px; background: #EFF6FF; border-radius: 10px; border: 1px solid #BFDBFE;">
            <div style="font-size: 11px; font-weight: 700; color: #2563EB; text-transform: uppercase; margin-bottom: 6px;">Semester 4 âœ“</div>
            <div style="font-size: 28px; font-weight: 800; color: #2563EB;">3.82</div>
            <div style="font-size: 11px; color: #2563EB; margin-top: 4px;">IPS 3.82 &bull; 20 SKS</div>
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


