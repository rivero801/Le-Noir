/* ============================================
   registro.js — Le Noir
   - Preview de foto de perfil
   - Mostrar / ocultar contraseña
   - Validación básica antes de enviar
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* ── Preview foto de perfil ── */
  const inputFoto   = document.getElementById('fotoPerfil');
  const preview     = document.getElementById('previewFoto');
  const placeholder = document.getElementById('fotoPlaceholder');

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
      const input = document.getElementById(btn.dataset.target);
      if (!input) return;
      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';
      const icon = btn.querySelector('.eye-icon');
      if (icon) icon.textContent = isPassword ? '🙈' : '👁';
    });
  });

  /* ── Validación antes de enviar ── */
  const form = document.getElementById('formR');

  if (form) {
    form.addEventListener('submit', (e) => {

      // Limpiar mensaje anterior
      document.querySelector('.form-mensaje')?.remove();

      const nombre   = document.getElementById('nombre')?.value.trim();
      const apellido = document.getElementById('apellido')?.value.trim();
      const email    = document.getElementById('email')?.value.trim();
      const usuario  = document.getElementById('usuario')?.value.trim();
      const password = document.getElementById('contrasena')?.value;

      // ── Campos obligatorios ──
      if (!nombre || !apellido || !email || !usuario || !password) {
        e.preventDefault(); // ← frena el envío
        mostrarMensaje('Por favor completá todos los campos obligatorios.', 'error');
        return;
      }

      // ── Longitud contraseña ──
      if (password.length < 8) {
        e.preventDefault();
        mostrarMensaje('La contraseña debe tener al menos 8 caracteres.', 'error');
        return;
      }

      // ── Formato email ──
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        e.preventDefault();
        mostrarMensaje('El email ingresado no es válido.', 'error');
        return;
      }

      // Si llegó hasta acá, todo OK → el form se envía solo a registro.php
    });
  }

  /* ── Helper: mostrar mensaje ── */
  function mostrarMensaje(texto, tipo) {
    document.querySelector('.form-mensaje')?.remove();

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

    document.querySelector('.form-submit')?.appendChild(msg);
  }

});