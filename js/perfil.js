document.addEventListener("DOMContentLoaded", () => {
    iniciarApp();

    const correoActivo = localStorage.getItem("usuarioActivo");
    const usuarios = JSON.parse(localStorage.getItem("usuarios"));

    if (!correoActivo) {
        window.location.href = "login.html";
        return;
    }

    const usuario = usuarios.find(u => u.correo === correoActivo);

    if (!usuario) {
        window.location.href = "login.html"
        return;
    }

    cargarPerfil();
});


function cargarPerfil() {
    
};