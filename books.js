document.getElementById('show-users-btn').addEventListener('click', function() {
  const userSection = document.getElementById('registered-users-section');
  const addBookSection = document.getElementById('add-book-section');
  if (userSection.style.display === 'none') {
    userSection.style.display = 'block';
    addBookSection.style.display = 'none';
  } else {
    userSection.style.display = 'none';
  }
});

document.getElementById('add-books-btn').addEventListener('click', function() {
  const addBookSection = document.getElementById('add-book-section');
  const userSection = document.getElementById('registered-users-section');
  if (addBookSection.style.display === 'none') {
    addBookSection.style.display = 'block';
    userSection.style.display = 'none';
  } else {
    addBookSection.style.display = 'none';
  }
});

const deleteBtn = document.getElementById('delete-btn');
deleteBtn.addEventListener('click', function() {
  const deleteForm = document.getElementById('delete-form');
  if (confirm("Are you sure you want to delete the selected books?")) {
    deleteForm.submit();
  }
});

document.getElementById('back-btn').addEventListener('click', function() {
  const addBookSection = document.getElementById('add-book-section');
  addBookSection.style.display = 'none';
});

document.querySelector("#add-book-form").addEventListener("submit", function (event) {
  event.preventDefault();

  const formResponse = document.querySelector("#response");
  console.log(formResponse);
  let formData = new FormData(this);

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "add_book.php", true);

  xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              let response = JSON.parse(xhr.responseText);

              if (response.status === "error") {
                  alert(response.message);
                  displayResponse("error", formResponse, response.message);
              } else if (response.status === "success") {
                  displayResponse("success", formResponse, response.message);
                  document.querySelector("#add-book-form").reset();
              }
          } else {
              console.error("Error:", xhr.status);
          }
      }
  };

  xhr.send(formData);
});

function displayResponse(responseType, element, message) {
 
  element.style.display = "block";
  element.classList.remove(responseType);
  element.classList.add(responseType);
  element.innerHTML = "<p>" + message + "</p>";

  setTimeout(() => {
      element.style.display = "none";
  }, 4500);
}
