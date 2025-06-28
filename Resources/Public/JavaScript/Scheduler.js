document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('#session-pool li').forEach(el => {
    el.draggable = true;
    el.addEventListener('dragstart', e => {
      e.dataTransfer.setData('text/plain', el.dataset.sessionId);
    });
  });
  document.querySelectorAll('#schedule-grid td').forEach(cell => {
    cell.addEventListener('dragover', e => {
      e.preventDefault();
    });
    cell.addEventListener('drop', e => {
      e.preventDefault();
      const sessionId = e.dataTransfer.getData('text/plain');
      const roomId = cell.dataset.roomId;
      const timeSlotId = cell.dataset.timeslotId;
      fetch(TYPO3.settings.ajaxUrls['dt3pace_scheduler_update'], {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ session: sessionId, room: roomId, timeSlot: timeSlotId })
      }).then(r => r.json()).then(data => {
        if (data.success) {
          const el = document.querySelector('[data-session-id="' + sessionId + '"]');
          cell.appendChild(el);
        }
      });
    });
  });
});
