document.getElementById('show-users-btn').addEventListener('click', function() {
    const userSection = document.getElementById('registered-users-section');
    if (userSection.style.display === 'none') {
      userSection.style.display = 'block';
    } else {
      userSection.style.display = 'none';
    }
  });

  const sortBtn = document.getElementById('sort-btn');
  const selectAllCheckbox = document.getElementById('select-all');
  const userCheckboxes = document.querySelectorAll('.category-checkbox');
  const searchBar = document.getElementById('search-bar');
  const userRows = document.querySelectorAll('.user-row');

  selectAllCheckbox.addEventListener('change', (event) => {
    userCheckboxes.forEach(checkbox => checkbox.checked = event.target.checked);
  });

  searchBar.addEventListener('input', function() {
    const filter = searchBar.value.toLowerCase();
    userRows.forEach(row => {
      const username = row.querySelector('.username-cell').textContent.toLowerCase();
      if (username.includes(filter)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });
  document.getElementById('return').addEventListener('click', () => {
  const selected = document.querySelectorAll('.category-checkbox:checked');
  const ids = Array.from(selected).map(checkbox => checkbox.dataset.id);
    if (ids.length > 0) {
      fetch('returned_books_record.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ ids })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          selected.forEach(checkbox => checkbox.closest('tr').remove());
        } else {
          alert('Error confirming requests.');
        }
      });
    }
  });