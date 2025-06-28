document.addEventListener('DOMContentLoaded', () => {
  const update = () => {
    fetch(TYPO3.settings.ajaxUrls['dt3pace_sessions_json'])
      .then(r => r.json())
      .then(data => {
        document.querySelectorAll('#session-grid td').forEach(c => c.textContent = '');
        data.forEach(item => {
          const cell = document.querySelector(`#session-grid [data-slot="${item.timeslot}"] [data-room="${item.room}"]`);
          if (cell) {
            cell.textContent = item.title;
          }
        });
      });
  };
  update();
  setInterval(update, 30000);
});
