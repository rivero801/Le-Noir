document.addEventListener("DOMContentLoaded", () => {
    iniciarApp();
    const correoActivo = localStorage.getItem("usuarioActivo");

    if (correoActivo) {
        window.location.href = "perfil.html";
    }
});

function iniciarApp() {
    console.log("App iniciada");
    cargarPerfil();
    eventos();
}

function eventos() {
    const botonGuardar = document.querySelector("#guardarPerfil");
    
    if (botonGuardar) {
        botonGuardar.addEventListener("click", guardarPerfil);
    }
}

function guardarPerfil() {
    console.log("Guardando perfil...");
}

function cargarPerfil() {
    console.log("Cargando perfil...");
}

// Recibimos información del formulario para guardarlo en el localstorage
const form = document.querySelector("#formR");

form.addEventListener("submit", function(e){
    e.preventDefault();
    crearUsuario();
});

function crearUsuario() {
    const nuevoUsuario = {
        nombre: document.querySelector("[name='Nombre']").value,
        apellido: document.querySelector("[name='Apellido']").value,
        correo: document.querySelector("[name='correo']").value.trim().toLowerCase(),
        fechaNacimiento: document.querySelector("[name='fechaNac']").value,
        pais: document.querySelector("[name='Pais']:checked")?.value || "",
        usuario: document.querySelector("[name='usuario']").value.trim().toLowerCase(),
        password: document.querySelector("[name='contraseña']").value,
        altura: document.querySelector("[name='altura']")?.value || "",
        categoria: document.querySelector("[name='categoria']")?.value || "",
        bio: document.querySelector("[name='bio']")?.value || "",
        idiomas: obtenerIdiomas()
    };

    let usuarios = JSON.parse(localStorage.getItem("usuarios")) || [];

    // VALIDAR EMAIL ÚNICO
    const emailExiste = usuarios.some(u => u.correo === nuevoUsuario.correo);

    // VALIDAR USUARIO ÚNICO
    const usernameExiste = usuarios.some(u => u.usuario === nuevoUsuario.usuario);

    if (emailExiste) {
        alert("Ese correo ya está registrado.");
        return;
    }

    if (usernameExiste) {
        alert("Ese nombre de usuario ya existe.");
        return;
    }

    console.log(nuevoUsuario); //MOSTRAMOS AL USUARIO QUE SE VAYA CARGANDO POR PANTALLA

    usuarios.push(nuevoUsuario);
    localStorage.setItem("usuarios", JSON.stringify(usuarios));

    localStorage.setItem("usuarioActivo", JSON.stringify(nuevoUsuario.correo)); //INICIA SESIÓN EL MODELO, QUEDA LOGUEADO.

    const mensaje = document.createElement("p");
    mensaje.textContent = "Registro exitoso 🎉 Redirigiendo...";
    mensaje.style.color = "green";

    form.appendChild(mensaje);

    setTimeout(() => {
        window.location.href = "perfil.html";
    }, 2000);
};

//Es para que el usuario pueda recorrer los items delchecklist, no se puede obtener de forma directa como el radioButton.
function obtenerIdiomas() {
    const checkboxes = document.querySelectorAll("[name='idiomas']:checked");
    const idiomas = [];

    checkboxes.forEach(check => {
        idiomas.push(check.value); //funciona como un append
    });

    return idiomas;
}