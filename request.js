document.getElementById('show-users-btn').addEventListener('click', () => {
  const section = document.getElementById('registered-users-section');
  section.style.display = section.style.display === 'none' ? 'block' : 'none';
});

document.getElementById('sort-btn').addEventListener('click', () => {
  const table = document.getElementById('request-table');
  const rows = Array.from(table.rows).slice(1);
  rows.sort((a, b) => a.cells[0].innerText.localeCompare(b.cells[0].innerText));
  rows.forEach(row => table.appendChild(row));
});

document.getElementById('decline-btn').addEventListener('click', () => {
  const selected = document.querySelectorAll('.category-checkbox:checked');
  const ids = Array.from(selected).map(checkbox => checkbox.dataset.id);
  if (ids.length > 0) {
    fetch('decline_request.php', {
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
        alert('Error declining requests.');
      }
    });
  }
});

document.getElementById('confirm-btn').addEventListener('click', () => {
  const selected = document.querySelectorAll('.category-checkbox:checked');
  const ids = Array.from(selected).map(checkbox => checkbox.dataset.id);
  if (ids.length > 0) {
    fetch('confirm_request.php', {
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

document.getElementById('select-all').addEventListener('change', (event) => {
  const checkboxes = document.querySelectorAll('.category-checkbox');
  checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
});

document.getElementById('search-bar').addEventListener('input', (event) => {
  const query = event.target.value.toLowerCase();
  const rows = document.querySelectorAll('#request-table tr:not(:first-child)');
  rows.forEach(row => {
    const studentName = row.cells[0].innerText.toLowerCase();
    row.style.display = studentName.includes(query) ? '' : 'none';
  });
});
