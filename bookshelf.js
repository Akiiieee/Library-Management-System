function showModal(imgElement) {
  const modal = document.getElementById('myModal');
  const modalImg = document.getElementById('modal-img');
  const modalDetails = document.getElementById('modal-details');
  const bookDetails = imgElement.nextElementSibling;

  modal.style.display = "block";
  modalImg.src = imgElement.src;
  modalDetails.innerHTML = bookDetails.innerHTML;
}

function showBorrowForm(bookId, bookName) {
  const borrowModal = document.getElementById('borrowModal');
  document.getElementById('book-id').value = bookId;
  document.getElementById('book-name').value = bookName;

  // Retrieve user data from localStorage and auto-fill the form
  const username = localStorage.getItem('username');
  const email = localStorage.getItem('email');

  if (username) {
    document.getElementById('student-name').value = username;
  }

  if (email) {
    document.getElementById('email').value = email;
  }

  borrowModal.style.display = "block";
}

function closeBorrowModal() {
  document.getElementById('borrowModal').style.display = "none";
}

function searchBooks() {
  const input = document.getElementById('search-input').value.toLowerCase();
  const books = document.getElementsByClassName('book');

  for (let i = 0; i < books.length; i++) {
    const bookName = books[i].getElementsByTagName('h2')[0].innerText.toLowerCase();
    if (bookName.includes(input)) {
      books[i].style.display = "";
    } else {
      books[i].style.display = "none";
    }
  }
}

document.addEventListener('DOMContentLoaded', function() {
  const borrowButtons = document.querySelectorAll('.borrow-button');

  borrowButtons.forEach(button => {
    button.addEventListener('click', function(event) {
      if (button.disabled) {
        alert('This book is out of stock');
      }
    });
  });

  const modal = document.getElementById('myModal');
  const span = document.getElementsByClassName("close")[0];

  span.onclick = function() {
    modal.style.display = "none";
  }

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    } else if (event.target == document.getElementById('borrowModal')) {
      closeBorrowModal();
    }
  };

  document.getElementById('borrowForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('send_request.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        alert(data.message);
        closeBorrowModal();
        document.getElementById('borrowForm').reset();
      } else {
        alert(data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  });
});
