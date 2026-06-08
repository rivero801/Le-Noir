/* ============================================
   registro.js — Le Noir
   - Preview de foto de perfil
   - Mostrar / ocultar contraseña
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* ── Preview foto de perfil ── */
  const inputFoto     = document.getElementById('fotoPerfil');
  const preview       = document.getElementById('previewFoto');
  const placeholder   = document.getElementById('fotoPlaceholder');

  if (inputFoto && preview && placeholder) {
    inputFoto.addEventListener('change', () => {
      const file = inputFoto.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = (e) => {
        preview.src = e.target.result;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
      };
      reader.readAsDataURL(file);
    });
  }

  /* ── Mostrar / ocultar contraseña ── */
  document.querySelectorAll('.toggle-password').forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.dataset.target;
      const input    = document.getElementById(targetId);
      if (!input) return;

      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';

      // Cambiar el ícono
      const icon = btn.querySelector('.eye-icon');
      if (icon) icon.textContent = isPassword ? '🙈' : '👁';
    });
  });

  /* ── Validación básica antes de enviar ── */
  const form = document.getElementById('formR');
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const nombre    = form.querySelector('#nombre')?.value.trim();
      const apellido  = form.querySelector('#apellido')?.value.trim();
      const email     = form.querySelector('#email')?.value.trim();
      const usuario   = form.querySelector('#usuario')?.value.trim();
      const password  = form.querySelector('#contrasena')?.value;

      if (!nombre || !apellido || !email || !usuario || !password) {
        mostrarMensaje('Por favor completá todos los campos obligatorios.', 'error');
        return;
      }

      if (password.length < 8) {
        mostrarMensaje('La contraseña debe tener al menos 8 caracteres.', 'error');
        return;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        mostrarMensaje('El email ingresado no es válido.', 'error');
        return;
      }

      // Todo OK — redirigir (cuando tengamos PHP, acá va el fetch al backend)
      mostrarMensaje('¡Cuenta creada con éxito! Redirigiendo...', 'ok');
      //setTimeout(() => { window.location.href = 'login.html'; }, 1800);
    });
  }

  /* ── Helper: mostrar mensaje de feedback ── */
  function mostrarMensaje(texto, tipo) {
    // Remover mensaje anterior si existe
    const anterior = document.querySelector('.form-mensaje');
    if (anterior) anterior.remove();

    const msg = document.createElement('p');
    msg.className = 'form-mensaje';
    msg.textContent = texto;
    msg.style.cssText = `
      font-size: 0.78rem;
      letter-spacing: 0.05em;
      margin-top: 1rem;
      padding: 0.8rem 1rem;
      border-left: 2px solid ${tipo === 'ok' ? '#c9a84c' : '#c0392b'};
      color: ${tipo === 'ok' ? '#c9a84c' : '#e74c3c'};
      background: ${tipo === 'ok' ? 'rgba(201,168,76,0.06)' : 'rgba(192,57,43,0.08)'};
    `;

    const submitDiv = document.querySelector('.form-submit');
    if (submitDiv) submitDiv.appendChild(msg);
  }

});
