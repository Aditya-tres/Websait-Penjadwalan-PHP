// ===== CALENDAR JS =====

document.addEventListener('DOMContentLoaded', function() {
  initCalendar();
});

let calYear = 2026;
let calMonth = 5; // 0-indexed: June=5

const MONTHS = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

const EVENTS = {
  '2026-06-10': ['Quiz Basis Data'],
  '2026-06-11': ['Deadline Laporan'],
  '2026-06-15': ['UTS'],
  '2026-06-20': ['Pengisian KRS'],
  '2026-06-25': ['Seminar AI'],
};

function initCalendar() {
  renderCalendar();
  const prevBtn = document.getElementById('prevMonth');
  const nextBtn = document.getElementById('nextMonth');
  if (prevBtn) prevBtn.addEventListener('click', () => {
    calMonth--;
    if (calMonth < 0) { calMonth = 11; calYear--; }
    renderCalendar();
  });
  if (nextBtn) nextBtn.addEventListener('click', () => {
    calMonth++;
    if (calMonth > 11) { calMonth = 0; calYear++; }
    renderCalendar();
  });
}

function renderCalendar() {
  const grid = document.getElementById('calendarGrid');
  const monthYearEl = document.getElementById('calMonthYear');
  if (!grid) return;

  monthYearEl.textContent = `${MONTHS[calMonth]} ${calYear}`;
  grid.innerHTML = '';

  const today = new Date();
  const firstDay = new Date(calYear, calMonth, 1).getDay();
  const daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();
  const daysInPrev = new Date(calYear, calMonth, 0).getDate();

  for (let i = firstDay - 1; i >= 0; i--) {
    const day = document.createElement('div');
    day.className = 'cal-day other-month';
    day.textContent = daysInPrev - i;
    grid.appendChild(day);
  }

  for (let d = 1; d <= daysInMonth; d++) {
    const day = document.createElement('div');
    day.className = 'cal-day';
    day.textContent = d;

    const dateStr = `${calYear}-${String(calMonth + 1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
    const isToday = today.getFullYear() === calYear && today.getMonth() === calMonth && today.getDate() === d;

    if (isToday) day.classList.add('today');
    if (EVENTS[dateStr]) day.classList.add('has-event');

    day.addEventListener('click', () => {
      grid.querySelectorAll('.cal-day.selected').forEach(el => el.classList.remove('selected'));
      if (!isToday) day.classList.add('selected');
      if (EVENTS[dateStr]) {
        showToast && showToast(EVENTS[dateStr].join(', '), 'info');
      }
    });

    grid.appendChild(day);
  }

  const totalCells = Math.ceil((firstDay + daysInMonth) / 7) * 7;
  const remaining = totalCells - firstDay - daysInMonth;
  for (let i = 1; i <= remaining; i++) {
    const day = document.createElement('div');
    day.className = 'cal-day other-month';
    day.textContent = i;
    grid.appendChild(day);
  }
}

function openAddEvent() {
  const modal = document.getElementById('addEventModal');
  if (modal) modal.classList.add('open');
}
function closeAddEvent() {
  const modal = document.getElementById('addEventModal');
  if (modal) modal.classList.remove('open');
}
document.addEventListener('click', function(e) {
  const modal = document.getElementById('addEventModal');
  if (modal && e.target === modal) closeAddEvent();
});

