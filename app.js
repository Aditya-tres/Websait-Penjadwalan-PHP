// ===== STUDYSCHED – MAIN JS (Email + Password Auth) =====

// ---- Auth / User Data ----
function getUser() {
  try { return JSON.parse(localStorage.getItem('studysched_user')); } catch { return null; }
}

function saveUser(data) {
  localStorage.setItem('studysched_user', JSON.stringify(data));
}

function loadUserData() {
  const user = getUser();
  if (!user) return;

  const email = user.email || 'mahasiswa@kampus.ac.id';
  const nama = user.nama || email.split('@')[0];
  const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=2563EB&color=fff&size=80`;

  const setEl = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
  const setImg = (id, src) => { const el = document.getElementById(id); if (el) el.src = src; };

  setEl('sidebarNama', nama);
  setEl('sidebarEmail', email);
  setEl('sidebarNim', email);
  setImg('sidebarAvatar', avatarUrl);
  setImg('topbarAvatar', `https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=2563EB&color=fff&size=40`);
  setEl('topbarNama', nama);

  // Profile page
  setEl('profileName', nama);
  setEl('profileNIM', email);
  setEl('profileProdi', user.prodi || 'Teknik Informatika');
  setImg('profileAvatar', `https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=2563EB&color=fff&size=120`);
  setEl('fieldNama', nama);
  setEl('fieldEmail', email);
  setEl('fieldProdi', user.prodi || 'Teknik Informatika');

  const inp = (id, val) => { const el = document.getElementById(id); if (el) el.value = val; };
  inp('inputNama', nama);
  inp('inputEmail', email);
  inp('inputProdi', user.prodi || 'Teknik Informatika');
}

// ---- Active Nav Item ----
function setActiveNav() {
  const page = window.location.pathname.split('/').pop() || 'dashboard.php';
  document.querySelectorAll('.nav-item[data-page]').forEach(item => {
    if (item.dataset.page === page) {
      item.classList.add('active');
    }
  });
}

// ---- Auth Guard ----
// Catatan: proteksi login yang SESUNGGUHNYA sekarang ditangani di server
// oleh includes/auth_check.php (PHP session + MySQL). Blok di bawah ini
// hanya menjaga agar localStorage tetap konsisten dengan session PHP;
// index.php/register.php sendiri sudah memproses login lewat POST ke server.

// ---- Password Toggle ----
const toggleBtn = document.getElementById('toggleBtn');
if (toggleBtn) {
  toggleBtn.addEventListener('click', function() {
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (input.type === 'password') {
      input.type = 'text';
      if (icon) icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
      input.type = 'password';
      if (icon) icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
  });
}

// ---- Sidebar Toggle ----
const sidebar = document.getElementById('sidebar');
const mainWrapper = document.getElementById('mainWrapper');
const sidebarToggle = document.getElementById('sidebarToggle');
const mobileToggle = document.getElementById('mobileToggle');

if (sidebarToggle) {
  sidebarToggle.addEventListener('click', () => {
    if (sidebar) sidebar.classList.toggle('collapsed');
    if (mainWrapper) mainWrapper.classList.toggle('sidebar-collapsed');
  });
}
if (mobileToggle) {
  mobileToggle.addEventListener('click', () => {
    if (sidebar) sidebar.classList.toggle('open');
  });
}
document.addEventListener('click', (e) => {
  if (sidebar && window.innerWidth <= 768 && sidebar.classList.contains('open')) {
    if (!sidebar.contains(e.target) && e.target !== mobileToggle) {
      sidebar.classList.remove('open');
    }
  }
});

// ---- Logout ----
function handleLogout() {
  localStorage.removeItem('studysched_user');
  window.location.href = 'logout.php';
}

// ---- Toast ----
function showToast(message, type = 'info') {
  let toast = document.getElementById('globalToast');
  if (!toast) {
    toast = document.createElement('div');
    toast.id = 'globalToast';
    toast.className = 'toast';
    document.body.appendChild(toast);
  }
  const icons = { success: 'fa-check-circle', warning: 'fa-exclamation-circle', info: 'fa-info-circle', error: 'fa-times-circle' };
  const icon = icons[type] || icons.info;
  toast.innerHTML = `<i class="fas ${icon}"></i> ${message}`;
  toast.className = 'toast show';
  setTimeout(() => { toast.className = 'toast'; }, 3000);
}

// ---- Download Website as ZIP ----
async function downloadWebsite() {
  const btn = document.getElementById('downloadBtn');
  if (btn) {
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mempersiapkan ZIP...';
  }

  try {
    if (typeof JSZip === 'undefined') {
      showToast('Memuat JSZip...', 'info');
      await new Promise((resolve, reject) => {
        const s = document.createElement('script');
        s.src = 'https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js';
        s.onload = resolve; s.onerror = reject;
        document.head.appendChild(s);
      });
    }

    const zip = new JSZip();
    const cssFolder = zip.folder('css');
    const jsFolder = zip.folder('js');

    const files = [
      { url: 'css/style.css', folder: cssFolder, name: 'style.css' },
      { url: 'js/app.js', folder: jsFolder, name: 'app.js' },
      { url: 'js/dashboard.js', folder: jsFolder, name: 'dashboard.js' },
      { url: 'js/kalender.js', folder: jsFolder, name: 'kalender.js' },
      { url: 'js/tugas.js', folder: jsFolder, name: 'tugas.js' },
      { url: 'js/profil.js', folder: jsFolder, name: 'profil.js' },
      { url: 'index.php', folder: zip, name: 'index.php' },
      { url: 'dashboard.php', folder: zip, name: 'dashboard.php' },
      { url: 'kalender.php', folder: zip, name: 'kalender.php' },
      { url: 'tugas.php', folder: zip, name: 'tugas.php' },
      { url: 'profil.php', folder: zip, name: 'profil.php' },
      { url: 'matakuliah.php', folder: zip, name: 'matakuliah.php' },
      { url: 'nilai.php', folder: zip, name: 'nilai.php' },
      { url: 'transkrip.php', folder: zip, name: 'transkrip.php' },
    ];

    await Promise.all(files.map(async ({ url, folder, name }) => {
      try {
        const resp = await fetch(url);
        const text = await resp.text();
        folder.file(name, text);
      } catch (err) {
        console.warn('Could not fetch', url, err);
      }
    }));

    const blob = await zip.generateAsync({ type: 'blob' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'StudySched-Website.zip';
    link.click();
    URL.revokeObjectURL(link.href);
    showToast('ZIP berhasil diunduh!', 'success');
  } catch (err) {
    showToast('Gagal membuat ZIP: ' + err.message, 'error');
    console.error(err);
  } finally {
    if (btn) {
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-download"></i> Unduh Website (ZIP)';
    }
  }
}

// ---- Init ----
document.addEventListener('DOMContentLoaded', () => {
  loadUserData();
  setActiveNav();
});

