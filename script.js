function pesan(){
alert("Selamat datang di website kuliner lokal Indonesia!");
}
function openLogin() {
    document.getElementById("loginModal").style.display = "block";
}

function openRegister() {
    document.getElementById("registerModal").style.display = "block";
}

function closeModal() {
    document.getElementById("loginModal").style.display = "none";
    document.getElementById("registerModal").style.display = "none";
}

// klik luar modal = close
window.onclick = function(event) {
    let login = document.getElementById("loginModal");
    let register = document.getElementById("registerModal");

    if (event.target == login) login.style.display = "none";
    if (event.target == register) register.style.display = "none";
}