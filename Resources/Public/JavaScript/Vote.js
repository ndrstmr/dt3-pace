document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.vote').forEach(btn => {
    btn.addEventListener('click', () => {
      fetch(TYPO3.settings.ajaxUrls['dt3pace_session_vote'], {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ session: btn.dataset.session })
      }).then(r => r.json()).then(data => {
        if (data.success) {
          btn.parentElement.innerHTML = `${btn.parentElement.textContent.split(' ')[0]} - ${data.votes} votes`;
        }
      });
    });
  });
});
