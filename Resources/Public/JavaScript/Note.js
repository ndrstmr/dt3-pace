document.addEventListener('DOMContentLoaded', () => {
  const textarea = document.getElementById('session-note');
  if (!textarea) {
    return;
  }
  const indicator = document.getElementById('note-saved');
  let timer;
  textarea.addEventListener('input', () => {
    clearTimeout(timer);
    timer = setTimeout(() => {
      fetch(TYPO3.settings.ajaxUrls['dt3pace_note_update'], {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-TYPO3-RequestToken': TYPO3.settings.security.csrfToken
        },
        body: JSON.stringify({
          session: textarea.dataset.session,
          note: textarea.value
        })
      }).then(() => {
        if (indicator) {
          indicator.hidden = false;
          setTimeout(() => {
            indicator.hidden = true;
          }, 2000);
        }
      });
    }, 1500);
  });
});
