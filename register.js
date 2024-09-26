var x = document.getElementById("loginform");
var y = document.getElementById("registerform");
var z = document.getElementById("btn");

function registerform() {
  x.style.left = "-400px";
  y.style.left = "100px";
  z.style.left = "110px";
}

function loginform() {
  x.style.left = "100px";
  y.style.left = "650px";
  z.style.left = "0";
}

const loginButton = document.getElementById("homepage");
loginButton.addEventListener("click", function () {
  window.location.href = "admin_user.html";
});

document
  .querySelector("#registerform")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const formResponse = document.querySelector("#register_error");
    let formData = new FormData(this);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "register.php", true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let response = JSON.parse(xhr.responseText);

          if (response.status === "error") {
            displayResponse("error", formResponse, response.message);
          } else if (response.status === "success") {
            displayResponse("success", formResponse, response.message);
            document.querySelector("#registerform").reset();
          }
        } else {
          console.error("Error:", xhr.status);
        }
      }
    };

    xhr.send(formData);
  });

document
  .querySelector("#loginform")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const formResponse = document.querySelector("#error_msg");
    let formData = new FormData(this);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "login.php", true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let response = JSON.parse(xhr.responseText);

          if (response.status === "error") {
            displayResponse("error", formResponse, response.message);
          } else if (response.status === "success") {
            displayResponse("success", formResponse, response.message);
            document.querySelector("#loginform").reset();

            // Store username and email in localStorage
            localStorage.setItem('username', response.username);
            localStorage.setItem('email', response.email);

            redirectTo("bookshelf.php", 1800);
          }
        } else {
          console.error("Error:", xhr.status);
        }
      }
    };

    xhr.send(formData);
  });

function forgotPassword() {
  window.location.href = "forgot_password.html";
}

function displayResponse(responseType, element, message) {
  element.style.display = "block";
  element.classList.remove(responseType);
  element.classList.add(responseType);
  element.innerHTML = "<p>" + message + "</p>";

  setTimeout(() => {
    element.style.display = "none";
  }, 4500);
}

function redirectTo(path, time) {
  setTimeout(() => {
    window.location.href = path;
  }, time);
}

// Function to show the modal with book details
function showModal(imgElement) {
  const modal = document.getElementById('myModal');
  const modalImg = document.getElementById('modal-img');
  const modalDetails = document.getElementById('modal-details');
  const bookDetails = imgElement.nextElementSibling;

  modal.style.display = "block";
  modalImg.src = imgElement.src;
  modalDetails.innerHTML = bookDetails.innerHTML;
}

// Function to show the borrow form with book details
function showBorrowForm(bookId, bookName) {
  const borrowModal = document.getElementById('borrowModal');
  document.getElementById('book-id').value = bookId;
  document.getElementById('book-name').value = bookName;

  // Auto-fill the student name and email from localStorage
  document.getElementById('student-name').value = localStorage.getItem('username');
  document.getElementById('email').value = localStorage.getItem('email');

  // Make the student name and email read-only
  document.getElementById('student-name').readOnly = true;
  document.getElementById('email').readOnly = true;

  borrowModal.style.display = "block";
}

// Function to close the borrow modal
function closeBorrowModal() {
  document.getElementById('borrowModal').style.display = "none";
}

// Function to search for books
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

// Event listener for document ready
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
