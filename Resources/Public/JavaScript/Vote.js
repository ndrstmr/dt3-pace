document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.vote').forEach(btn => {
    btn.addEventListener('click', () => {
      btn.disabled = true;
      fetch(TYPO3.settings.ajaxUrls['dt3pace_session_vote'], {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-TYPO3-RequestToken': TYPO3.settings.security.csrfToken
        },
        body: JSON.stringify({ session: btn.dataset.session })
      }).then(r => r.json()).then(data => {
        if (data.success) {
          const li = btn.closest('li');
          li.querySelector('.votes').textContent = data.votes;
          li.querySelector('.vote-message').textContent = 'Thanks for voting!';
          li.querySelector('.vote-message').hidden = false;
        } else {
          btn.disabled = false;
        }
      }).catch(() => {
        btn.disabled = false;
      });
    });
  });
});
