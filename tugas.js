// ===== TUGAS JS =====

document.addEventListener('DOMContentLoaded', function() {
  initTaskFilters();
  animateProgressBars();
});

function initTaskFilters() {
  filterTasks('all', null);
}

function filterTasks(status, btn) {
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  if (btn) btn.classList.add('active');

  const cards = document.querySelectorAll('.task-card');
  cards.forEach(card => {
    if (status === 'all' || card.dataset.status === status) {
      card.style.display = 'block';
      card.style.animation = 'none';
      setTimeout(() => { card.style.animation = ''; }, 10);
    } else {
      card.style.display = 'none';
    }
  });
}

function animateProgressBars() {
  document.querySelectorAll('.progress-fill.animated').forEach(bar => {
    const target = bar.style.width;
    bar.style.width = '0';
    setTimeout(() => { bar.style.width = target; }, 300);
  });
}

function openAddTask() {
  const modal = document.getElementById('addTaskModal');
  if (modal) modal.classList.add('open');
}
function closeAddTask() {
  const modal = document.getElementById('addTaskModal');
  if (modal) modal.classList.remove('open');
}
document.addEventListener('click', function(e) {
  const modal = document.getElementById('addTaskModal');
  if (modal && e.target === modal) closeAddTask();
});

document.addEventListener('change', function(e) {
  if (e.target.classList.contains('task-check')) {
    const card = e.target.closest('.task-card');
    if (card) {
      card.classList.toggle('done', e.target.checked);
      const title = card.querySelector('.task-card-title');
      if (title) title.style.textDecoration = e.target.checked ? 'line-through' : 'none';
    }
  }
});

document.addEventListener('click', function(e) {
  if (e.target.closest('.task-action-btn.delete')) {
    const card = e.target.closest('.task-card');
    if (card && confirm('Hapus tugas ini?')) {
      card.style.animation = 'slideUp 0.3s ease reverse';
      setTimeout(() => card.remove(), 280);
      if (typeof showToast !== 'undefined') showToast('Tugas dihapus!', 'info');
    }
  }
});

