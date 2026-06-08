<?php
/* ============================================
   includes/header.php — Le Noir
   Navbar compartida. Incluir en todas las páginas:
   <?php require_once 'includes/header.php'; ?>
   ============================================ */

// Detectar qué página está activa para resaltar el link
$pagina_actual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($titulo) ? htmlspecialchars($titulo) . ' — Le Noir' : 'Le Noir — Model Agency' ?></title>

  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="/Le-Noir/css/variables.css">
  <link rel="stylesheet" href="/Le-Noir/css/header.css">
  <link rel="stylesheet" href="/Le-Noir/css/footer.css">
  <?php if (isset($css_extra)): ?>
    <link rel="stylesheet" href="/Le-Noir/css/<?= htmlspecialchars($css_extra) ?>">
  <?php endif; ?>

  <script src="/Le-Noir/js/main.js" defer></script>
  <?php if (isset($js_extra)): ?>
    <script src="/Le-Noir/js/<?= htmlspecialchars($js_extra) ?>" defer></script>
  <?php endif; ?>
</head>
<body>

<nav class="navbar" id="navbar">
  <a href="/Le-Noir/index.php" class="navbar-logo">Le Noir</a>

  <ul class="navbar-links">
    <li class="dropdown">
      <a href="#">Opciones</a>
      <ul class="dropdown-menu">
        <?php if (isset($_SESSION['usuario_id'])): ?>
          <li><a href="/Le-Noir/index.php">Cerrar sesión</a></li>
        <?php else: ?>
          <li><a href="/Le-Noir/login.php">Iniciar sesión</a></li>
          <li><a href="/Le-Noir/registro.php">Registrarse</a></li>
        <?php endif; ?>
      </ul>
    </li>
    <li><a href="/Le-Noir/sesiones.php" class="<?= $pagina_actual === 'sesiones.php' ? 'active' : '' ?>">Sesiones</a></li>
    <li><a href="/Le-Noir/novedades.php" class="<?= $pagina_actual === 'novedades.php' ? 'active' : '' ?>">Novedades</a></li>
  </ul>

  <a href="/Le-Noir/perfil.php"><button class="navbar-btn">Perfil</button></a>
  <button class="hamburger" id="hamburger" aria-label="Abrir menú">
    <span></span><span></span><span></span>
  </button>
</nav>

<div class="mobile-nav" id="mobileNav">
  <?php if (isset($_SESSION['usuario_id'])): ?>
    <a href="/Le-Noir/index.php">Cerrar sesión</a>
  <?php else: ?>
    <a href="/Le-Noir/login.php">Iniciar sesión</a>
    <a href="/Le-Noir/registro.php">Registrarse</a>
  <?php endif; ?>
  <a href="/Le-Noir/sesiones.php">Sesiones</a>
  <a href="/Le-Noir/novedades.php">Novedades</a>
  <a href="/Le-Noir/perfil.php">Perfil</a>
</div>
