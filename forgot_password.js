document.getElementById("emailForm").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData(this);
    var xhr = new XMLHttpRequest();

    xhr.open("POST", this.action, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);

            if (xhr.responseText.trim() === "found") {
                document.getElementById("emailForm").style.display = "none";
                document.getElementById("newPasswordForm").style.display = "block";
                document.getElementById("email").value = formData.get("email");
            } else {
                alert("Email not found in our records.");
            }
        } else {
            console.error("Error:", xhr.status);
        }
    };

    xhr.onerror = function () {
        console.error("Request failed");
    };

    xhr.send(formData);
});

document.getElementById("confirmPassword").addEventListener("click", function() {
    var email = document.getElementById("email").value;
    var newPassword = document.querySelector('input[name="new_password"]').value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "update_password.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
            alert("Password change successfully!");

            document.getElementById("newPasswordForm").style.display = "none";
            document.getElementById("backForm").style.display = "block";
        } else {
            console.error("Error:", xhr.status);
        }
    };
    xhr.onerror = function () {
        console.error("Request failed");
    };
    xhr.send("email=" + encodeURIComponent(email) + "&new_password=" + encodeURIComponent(newPassword));
});

document.getElementById("backButton").addEventListener("click", function() {

    window.location.href = "register_interface.html";
});
