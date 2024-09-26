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
  const deleteBtn = document.getElementById('delete-btn');
  const userRows = document.querySelectorAll('.user-row'); 
  const userCheckboxes = document.querySelectorAll('.user-checkbox');
  const searchBar = document.getElementById('search-bar');

  function sortTable() {
    const users = Array.from(userRows).map(row => ({
      username: row.querySelector('td:nth-child(1)').textContent,
      row 
    }));

    users.sort((a, b) => a.username.localeCompare(b.username)); 

    userRows.forEach((row, index) => {
      row.parentNode.appendChild(users[index].row);
    });
  }

  sortBtn.addEventListener('click', sortTable);

  selectAllCheckbox.addEventListener('change', (event) => {
    userCheckboxes.forEach(checkbox => checkbox.checked = event.target.checked);
  });

  deleteBtn.addEventListener('click', function() {
    const selectedUsernames = [];
    userCheckboxes.forEach(checkbox => {
      if (checkbox.checked) {
        const username = checkbox.parentNode.parentNode.querySelector('td:nth-child(1)').textContent;
        selectedUsernames.push(username);
      }
    });

    if (selectedUsernames.length === 0) {
      alert('Please select users to delete');
      return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_users.php", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        if (response.success) {
          alert('Users deleted successfully');
          location.reload();
        } else {
          alert('Failed to delete users');
        }
      }
    };
    xhr.send(JSON.stringify({ usernames: selectedUsernames }));
  });

  searchBar.addEventListener('input', function() {
    const filter = searchBar.value.toLowerCase();
    userRows.forEach(row => {
      const username = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
      if (username.includes(filter)) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
  });