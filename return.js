document.getElementById('show-users-btn').addEventListener('click', function() {
    const userSection = document.getElementById('registered-users-section');
    if (userSection.style.display === 'none') {
      userSection.style.display = 'block';
    } else {
      userSection.style.display = 'none';
    }
    });
    const selectAllCheckbox = document.getElementById('select-all');
    const userCheckboxes = document.querySelectorAll('.category-checkbox');

selectAllCheckbox.addEventListener('change', (event) => {
    userCheckboxes.forEach(checkbox => checkbox.checked = event.target.checked);
});

document.getElementById('search-bar').addEventListener('input', (event) => {
    const query = event.target.value.toLowerCase();
    const rows = document.querySelectorAll('#request-table tr:not(:first-child)');
    rows.forEach(row => {
        const studentName = row.cells[0].innerText.toLowerCase();
        row.style.display = studentName.includes(query) ? '' : 'none';
    });
});
document.getElementById('sort-btn').addEventListener('click', function() {
  const tableBody = document.querySelector('#request-table tbody');
  const rows = Array.from(tableBody.querySelectorAll('tr:not(:first-child)'));

  rows.sort((a, b) => {
      const nameA = a.cells[0].textContent.trim().toLowerCase();
      const nameB = b.cells[0].textContent.trim().toLowerCase();
      if (nameA < nameB) return -1;
      if (nameA > nameB) return 1;
      return 0;
  });
  
  tableBody.innerHTML = '';
  
  rows.forEach(row => {
      tableBody.appendChild(row);
  });
});
