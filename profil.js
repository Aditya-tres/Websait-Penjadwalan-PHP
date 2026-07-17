// ===== PROFIL JS =====

let editMode = false;

document.addEventListener('DOMContentLoaded', function() {
  loadProfileFromStorage();
});

function loadProfileFromStorage() {
  const user = JSON.parse(localStorage.getItem('studysched_user') || '{}');
  if (!user.email) return;

  const nama = user.nama || user.email.split('@')[0];
  const email = user.email;

  const setEl = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
  const setInp = (id, val) => { const el = document.getElementById(id); if (el) el.value = val; };
  const setImg = (id, src) => { const el = document.getElementById(id); if (el) el.src = src; };

  const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=2563EB&color=fff&size=120`;
  setImg('profileAvatar', avatarUrl);
  setEl('profileName', nama);
  setEl('profileNIM', email);
  setEl('profileProdi', user.prodi || 'Teknik Informatika');
  setEl('fieldNama', nama);
  setEl('fieldEmail', email);
  setEl('fieldProdi', user.prodi || 'Teknik Informatika');
  setInp('inputNama', nama);
  setInp('inputEmail', email);
  setInp('inputProdi', user.prodi || 'Teknik Informatika');
}

function toggleEditMode() {
  editMode = !editMode;
  const fieldValues = document.querySelectorAll('.field-value');
  const fieldInputs = document.querySelectorAll('.field-input');
  const saveBtnArea = document.getElementById('saveBtnArea');
  const editBtnText = document.getElementById('editBtnText');

  fieldValues.forEach(el => el.style.display = editMode ? 'none' : 'block');
  fieldInputs.forEach(el => el.classList.toggle('hidden', !editMode));
  if (saveBtnArea) saveBtnArea.classList.toggle('hidden', !editMode);
  if (editBtnText) editBtnText.textContent = editMode ? 'Batalkan' : 'Edit Profil';
}

function cancelEdit() {
  editMode = false;
  const fieldValues = document.querySelectorAll('.field-value');
  const fieldInputs = document.querySelectorAll('.field-input');
  const saveBtnArea = document.getElementById('saveBtnArea');
  const editBtnText = document.getElementById('editBtnText');
  fieldValues.forEach(el => el.style.display = 'block');
  fieldInputs.forEach(el => el.classList.add('hidden'));
  if (saveBtnArea) saveBtnArea.classList.add('hidden');
  if (editBtnText) editBtnText.textContent = 'Edit Profil';
}

function saveProfile() {
  const nama = document.getElementById('inputNama').value.trim();
  const email = document.getElementById('inputEmail').value.trim();
  const prodi = document.getElementById('inputProdi').value.trim();

  if (!nama || !email) {
    if (typeof showToast !== 'undefined') showToast('Lengkapi nama dan email!', 'warning');
    return;
  }

  // Simpan ke database MySQL lewat PHP (email tidak diubah lewat endpoint ini
  // karena dipakai sebagai kredensial login)
  fetch('api/update_profile.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ nama, prodi })
  })
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        if (typeof showToast !== 'undefined') showToast(data.message || 'Gagal menyimpan profil.', 'warning');
        return;
      }

      const userData = JSON.parse(localStorage.getItem('studysched_user') || '{}');
      userData.nama = nama; userData.prodi = prodi;
      localStorage.setItem('studysched_user', JSON.stringify(userData));

      const setEl = (id, val) => { const el = document.getElementById(id); if (el) el.textContent = val; };
      const setImg = (id, src) => { const el = document.getElementById(id); if (el) el.src = src; };

      setEl('profileName', nama);
      setEl('profileProdi', prodi || 'Teknik Informatika');
      setEl('fieldNama', nama);
      setEl('fieldProdi', prodi);
      setEl('sidebarNama', nama);
      setEl('topbarNama', nama);

      const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=2563EB&color=fff&size=120`;
      setImg('profileAvatar', avatarUrl);

      cancelEdit();
      if (typeof showToast !== 'undefined') showToast('Profil berhasil disimpan!', 'success');
    })
    .catch(() => {
      if (typeof showToast !== 'undefined') showToast('Gagal terhubung ke server.', 'warning');
    });
}

function changeAvatar(event) {
  const file = event.target.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function(e) {
    const img = document.getElementById('profileAvatar');
    if (img) img.src = e.target.result;
    const sidebarAvatar = document.getElementById('sidebarAvatar');
    if (sidebarAvatar) sidebarAvatar.src = e.target.result;
    if (typeof showToast !== 'undefined') showToast('Foto profil berhasil diubah!', 'success');
  };
  reader.readAsDataURL(file);
}

