const adminButton = document.getElementById('admin');
adminButton.addEventListener('click', function() {
    window.location.href = "admin.php";
});
const userButton = document.getElementById('user');
userButton.addEventListener('click', function() {
    window.location.href = "register_interface.html";
});
const backButton = document.getElementById('back');
backButton.addEventListener('click', function() {
    window.location.href = "index.html";
});
