<?php
/* ============================================
   registro.php — Le Noir
   Muestra el formulario Y procesa el envío.
   ============================================ */

session_start();

// Si ya está logueado, redirigir al perfil
if (isset($_SESSION['usuario_id'])) {
    header('Location: perfil.php');
    exit;
}

require_once 'config/db.php';

// ── Variables para el header ──
$titulo    = 'home';
$css_extra = 'home.css';
$js_extra  = 'main.js';

require_once 'includes/header.php';
?>


  <!-- CUERPO — exclusivo de index.html -->
  <main>

    <section class="hero">
      <div class="hero-featured">
        <img src="img/img1.jpg" alt="Modelo destacado">
        <div class="hero-featured-overlay">
          <p class="hero-featured-tag">★ Modelo Destacado</p>
          <h2 class="hero-featured-name">Nombre<br>Perfil</h2>
          <p class="hero-featured-desc">Modelo profesional, egresado de Kremlin Agency. Disponible para pasarela y fotografía editorial.</p>
        </div>
      </div>

      <div class="hero-right">
        <div class="hero-title-block">
          <p class="hero-eyebrow">Model Agency — Est. 2022</p>
          <h1 class="hero-title">Le<br><em>Noir</em></h1>
          <p class="hero-subtitle">Conectamos talento con oportunidad. Más de 10.000 empresas confían en nuestra selección.</p>
        </div>
        <div class="hero-search">
          <input type="text" placeholder="Buscar perfiles..." name="search">
          <button aria-label="Buscar"><img src="img/busqueda.svg" alt=""></button>
        </div>
        <div class="hero-grid">
          <a href="perfil.html" class="hero-card">
            <img src="img/imgP.jpg" alt="Modelo">
            <div class="hero-card-info">
              <p class="hero-card-name">Nombre Perfil</p>
              <p class="hero-card-tag">Pasarela · Buenos Aires</p>
            </div>
          </a>
          <a href="perfil.html" class="hero-card">
            <img src="img/imgP.jpg" alt="Modelo">
            <div class="hero-card-info">
              <p class="hero-card-name">Nombre Perfil</p>
              <p class="hero-card-tag">Editorial · París</p>
            </div>
          </a>
        </div>
      </div>
    </section>


    <section class="stats-section">
      <div class="stats-header">
        <p class="eyebrow">Por qué elegirnos</p>
        <h2>La agencia que<br><em>mueve el mundo</em></h2>
      </div>
      <div class="stats-grid">
        <div class="stat-item">
          <p class="stat-number"><span class="stat-plus">+</span>27.000</p>
          <p class="stat-label">Colegas dedicados</p>
        </div>
        <div class="stat-item">
          <p class="stat-number"><span class="stat-plus">+</span>10.000</p>
          <p class="stat-label">Empresas socias</p>
        </div>
        <div class="stat-item">
          <p class="stat-number">48</p>
          <p class="stat-label">Países presentes</p>
        </div>
      </div>
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">✦</div>
          <h3>Trabajá con nosotros</h3>
          <p>Con más de 27.000 colegas trabajando en pasarela y fotografía, sé la portada que está buscando la empresa de tus sueños.</p>
          <a href="detalles.html" class="feature-link">Conocé más</a>
        </div>
        <div class="feature-card">
          <div class="feature-icon">✈</div>
          <h3>Viajá por el mundo</h3>
          <p>Más de 10.000 empresas extranjeras nos contactan diariamente buscando nuevos talentos. El mundo te está esperando.</p>
          <a href="detalles.html" class="feature-link">Ver destinos</a>
        </div>
        <div class="feature-card">
          <div class="feature-icon">◈</div>
          <h3>Consultá sin cargo</h3>
          <p>No te quedés con las ganas. Nuestro equipo está disponible para resolver cualquier inquietud que se te presente.</p>
          <a href="contacto.html" class="feature-link">Escribinos</a>
        </div>
      </div>
    </section>


    <section class="comentarios-section">
      <div class="comentarios-header">
        <h2>Testimonios</h2>
        <span>Lo que dicen nuestros modelos</span>
      </div>
      <div class="comentarios-grid">
        <div class="comentario-card">
          <img src="img/placeholder-aside.png" alt="Perfil" class="comentario-avatar">
          <p class="comentario-text">"Le Noir cambió mi carrera por completo. En tres meses viajé a Europa y trabajé con marcas que nunca imaginé."</p>
        </div>
        <div class="comentario-card">
          <img src="img/placeholder-aside.png" alt="Perfil" class="comentario-avatar">
          <p class="comentario-text">"El equipo es increíble, siempre están disponibles. Te hacen sentir parte de algo más grande que vos mismo."</p>
        </div>
        <div class="comentario-card">
          <img src="img/placeholder-aside.png" alt="Perfil" class="comentario-avatar">
          <p class="comentario-text">"Nunca pensé que a los 19 años podría estar en una agencia así. Le Noir abrió puertas que parecían imposibles."</p>
        </div>
      </div>
    </section>

  </main>


  <!-- FOOTER — igual en todas las páginas -->
  <footer>
    <div class="footer-grid">
      <div>
        <div class="footer-logo">Le Noir</div>
        <p class="footer-desc">Agencia de modelos profesional con presencia en 48 países. Conectamos talento con las mejores marcas del mundo desde 2022.</p>
      </div>
      <div class="footer-col">
        <h4>Soluciones</h4>
        <a href="recuperar-contraseña.html">Recuperar Contraseña</a>
        <a href="contacto.html">Resolución de Problemas</a>
        <a href="#">Términos y Condiciones</a>
      </div>
      <div class="footer-col">
        <h4>Compañía</h4>
        <a href="contacto.html">Contactanos</a>
        <a href="#">Dónde nos encontramos</a>
        <a href="#">¿Cómo surgió?</a>
        <a href="#">Donar</a>
      </div>
      <div class="footer-col">
        <h4>Redes Sociales</h4>
        <a href="https://www.facebook.com/" target="_blank" class="footer-social">
          <img src="img/facebook.svg" alt=""> Facebook
        </a>
        <a href="https://www.twitter.com/" target="_blank" class="footer-social">
          <img src="img/twitter.svg" alt=""> Twitter
        </a>
        <a href="https://web.whatsapp.com/" target="_blank" class="footer-social">
          <img src="img/whatsapp.svg" alt=""> Whatsapp
        </a>
        <a href="https://www.instagram.com/" target="_blank" class="footer-social">
          <img src="img/Instagram.svg" alt=""> Instagram
        </a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>Todos los derechos reservados © 2025 <strong>Le Noir</strong></p>
      <p>Diseño: Tomás Rivero</p>
    </div>
  </footer>

</body>
</html>
