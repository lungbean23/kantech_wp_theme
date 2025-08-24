(function() {
  document.addEventListener('DOMContentLoaded', function() {
    // Tab navigation: show only selected category section
    const navList = document.querySelector('.top-nav ul');
    if (navList) {
      navList.addEventListener('click', function(e) {
        const target = e.target;
        if (target && target.tagName === 'LI') {
          const targetId = target.getAttribute('data-target');
          // Update active class on nav items
          navList.querySelectorAll('li').forEach(function(li) {
            li.classList.remove('active');
          });
          target.classList.add('active');
          // Hide all category sections
          document.querySelectorAll('.content section').forEach(function(sec) {
            sec.style.display = 'none';
          });
          // Show selected section
          const section = document.getElementById(targetId);
          if (section) {
            section.style.display = 'grid';
          }
        }
      });
    }
    // Search filter across product cards
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
      searchInput.addEventListener('input', function(e) {
        const query = e.target.value.trim().toLowerCase();
        const cards = document.querySelectorAll('.product-card');
        cards.forEach(function(card) {
          const name = card.querySelector('h3').textContent.toLowerCase();
          const desc = card.querySelector('p').textContent.toLowerCase();
          const match = name.includes(query) || desc.includes(query);
          card.style.display = match ? '' : 'none';
        });
        if (query) {
          // Show all sections when searching
          document.querySelectorAll('.content section').forEach(function(sec) {
            sec.style.display = 'grid';
          });
        } else {
          // When search cleared, show only active category
          const active = document.querySelector('.top-nav li.active');
          const activeId = active ? active.getAttribute('data-target') : null;
          document.querySelectorAll('.content section').forEach(function(sec) {
            sec.style.display = 'none';
          });
          if (activeId) {
            const activeSec = document.getElementById(activeId);
            if (activeSec) activeSec.style.display = 'grid';
          }
        }
      });
    }
  });
})();