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

// ── Variables para el formulario ──
$errores  = [];
$exito    = false;
$valores  = []; // para repoblar el form si hay error

// ── Procesar cuando se envía el formulario ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Recoger y sanear los datos
    $valores['nombre']    = trim($_POST['Nombre']    ?? '');
    $valores['apellido']  = trim($_POST['Apellido']  ?? '');
    $valores['correo']    = trim($_POST['correo']    ?? '');
    $valores['usuario']   = trim($_POST['usuario']   ?? '');
    $valores['contrasena']= $_POST['contrasena']     ?? '';
    $valores['fecha_nac'] = $_POST['fechaNac']       ?? '';
    $valores['altura']    = intval($_POST['altura']  ?? 0);
    $valores['categoria'] = $_POST['categoria']      ?? '';
    $valores['pais']      = $_POST['Pais']           ?? '';
    $valores['bio']       = trim($_POST['bio']       ?? '');

    // Idiomas vienen como array de checkboxes
    $idiomas_arr          = $_POST['idiomas']        ?? [];
    $valores['idiomas']   = implode(',', $idiomas_arr);

    // 2. Validaciones
    if (empty($valores['nombre']))
        $errores[] = 'El nombre es obligatorio.';

    if (empty($valores['apellido']))
        $errores[] = 'El apellido es obligatorio.';

    if (empty($valores['correo']) || !filter_var($valores['correo'], FILTER_VALIDATE_EMAIL))
        $errores[] = 'El email no es válido.';

    if (empty($valores['usuario']) || strlen($valores['usuario']) < 3)
        $errores[] = 'El usuario debe tener al menos 3 caracteres.';

    if (strlen($valores['contrasena']) < 8)
        $errores[] = 'La contraseña debe tener al menos 8 caracteres.';

    // 3. Verificar que el usuario y correo no existan ya
    if (empty($errores)) {
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE usuario = ? OR correo = ? LIMIT 1');
        $stmt->execute([$valores['usuario'], $valores['correo']]);
        if ($stmt->fetch()) {
            $errores[] = 'El usuario o el email ya están registrados.';
        }
    }

    // 4. Manejo de la foto de perfil
    $foto_ruta = null;

    if (!empty($_FILES['fotoPerfil']['name'])) {
        $foto        = $_FILES['fotoPerfil'];
        $ext_validas = ['jpg', 'jpeg', 'png', 'webp'];
        $ext         = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $tam_max     = 3 * 1024 * 1024; // 3 MB

        if (!in_array($ext, $ext_validas))
            $errores[] = 'La foto debe ser JPG, PNG o WEBP.';

        if ($foto['size'] > $tam_max)
            $errores[] = 'La foto no puede superar los 3 MB.';

        if (empty($errores)) {
            // Crear carpeta si no existe
            $carpeta = 'img/perfiles/';
            if (!is_dir($carpeta)) mkdir($carpeta, 0755, true);

            // Nombre único para evitar colisiones
            $nombre_archivo = uniqid('perfil_', true) . '.' . $ext;
            $destino        = $carpeta . $nombre_archivo;

            if (move_uploaded_file($foto['tmp_name'], $destino)) {
                $foto_ruta = $destino;
            } else {
                $errores[] = 'No se pudo subir la foto. Intentá de nuevo.';
            }
        }
    }

    // 5. Si no hay errores, insertar en la BD
    if (empty($errores)) {
        // Hashear la contraseña — NUNCA guardar en texto plano
        $hash = password_hash($valores['contrasena'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios
                    (usuario, correo, contrasena, nombre, apellido,
                     fecha_nac, altura, categoria, pais, idiomas, bio, foto_perfil)
                VALUES
                    (:usuario, :correo, :contrasena, :nombre, :apellido,
                     :fecha_nac, :altura, :categoria, :pais, :idiomas, :bio, :foto_perfil)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':usuario'     => $valores['usuario'],
            ':correo'      => $valores['correo'],
            ':contrasena'  => $hash,
            ':nombre'      => $valores['nombre'],
            ':apellido'    => $valores['apellido'],
            ':fecha_nac'   => $valores['fecha_nac'] ?: null,
            ':altura'      => $valores['altura']    ?: null,
            ':categoria'   => $valores['categoria'] ?: null,
            ':pais'        => $valores['pais']      ?: null,
            ':idiomas'     => $valores['idiomas']   ?: null,
            ':bio'         => $valores['bio']       ?: null,
            ':foto_perfil' => $foto_ruta,
        ]);

        // Guardar la sesión y redirigir al perfil
        $_SESSION['usuario_id'] = $pdo->lastInsertId();
        $_SESSION['usuario']    = $valores['usuario'];
        $_SESSION['nombre']     = $valores['nombre'];

        header('Location: perfil.php?nuevo=1');
        exit;
    }
}

// ── Variables para el header ──
$titulo    = 'Registro';
$css_extra = 'registro.css';
$js_extra  = 'registro.js';

require_once 'includes/header.php';
?>

  <!-- CUERPO -->
  <main class="registro-main">

    <!-- Panel izquierdo -->
    <aside class="registro-panel">
      <div class="panel-content">
        <a href="index.php" class="panel-logo">Le Noir</a>
        <div class="panel-texto">
          <p class="panel-eyebrow">Bienvenido</p>
          <h2 class="panel-titulo">Creá tu<br><em>perfil</em></h2>
          <p class="panel-desc">Formá parte de la agencia de modelos más exclusiva. Completá tu perfil y conectate con las mejores marcas del mundo.</p>
        </div>
        <div class="panel-stats">
          <div class="panel-stat">
            <span class="panel-stat-num">+27K</span>
            <span class="panel-stat-label">Modelos</span>
          </div>
          <div class="panel-stat">
            <span class="panel-stat-num">48</span>
            <span class="panel-stat-label">Países</span>
          </div>
          <div class="panel-stat">
            <span class="panel-stat-num">+10K</span>
            <span class="panel-stat-label">Empresas</span>
          </div>
        </div>
      </div>
      <img src="img/img-registro.jpg" alt="Le Noir Registro" class="panel-img">
    </aside>

    <!-- Panel derecho: formulario -->
    <div class="registro-form-wrapper">

      <div class="registro-header">
        <p class="eyebrow">Paso 1 de 1</p>
        <h1 class="registro-titulo">Crear cuenta</h1>
        <p class="registro-sub">¿Ya tenés cuenta? <a href="login.php" class="link-dorado">Iniciá sesión</a></p>
      </div>

      <?php if (!empty($errores)): ?>
        <div class="form-errores">
          <?php foreach ($errores as $e): ?>
            <p class="form-error-item">✕ <?= htmlspecialchars($e) ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form id="formR" class="registro-form"
            method="POST" action="registro.php"
            enctype="multipart/form-data">

        <!-- Foto de perfil -->
        <div class="form-group foto-group">
          <label class="foto-label" for="fotoPerfil" id="fotoLabel">
            <div class="foto-placeholder" id="fotoPlaceholder">
              <span class="foto-icono">+</span>
              <span class="foto-texto">Foto de perfil</span>
            </div>
            <img id="previewFoto" class="foto-preview" alt="Preview" style="display:none;">
          </label>
          <input type="file" id="fotoPerfil" name="fotoPerfil" accept="image/*" style="display:none;">
        </div>

        <!-- Datos personales -->
        <div class="form-section">
          <p class="section-title">Datos personales</p>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="nombre">Nombre</label>
              <input type="text" id="nombre" name="Nombre" class="form-input"
                     placeholder="ej. Tomás"
                     value="<?= htmlspecialchars($valores['nombre'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="apellido">Apellido</label>
              <input type="text" id="apellido" name="Apellido" class="form-input"
                     placeholder="ej. Rivero"
                     value="<?= htmlspecialchars($valores['apellido'] ?? '') ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="email">Email</label>
              <input type="email" id="email" name="correo" class="form-input"
                     placeholder="ej. tomas@email.com"
                     value="<?= htmlspecialchars($valores['correo'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="fechaNac">Fecha de nacimiento</label>
              <input type="date" id="fechaNac" name="fechaNac" class="form-input"
                     value="<?= htmlspecialchars($valores['fecha_nac'] ?? '') ?>">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="altura">Altura (cm)</label>
              <input type="number" id="altura" name="altura" class="form-input"
                     placeholder="ej. 175"
                     value="<?= htmlspecialchars($valores['altura'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="categoria">Categoría</label>
              <select id="categoria" name="categoria" class="form-select">
                <option value="" disabled <?= empty($valores['categoria']) ? 'selected' : '' ?>>Seleccioná una</option>
                <option value="fashion"    <?= ($valores['categoria'] ?? '') === 'fashion'    ? 'selected' : '' ?>>Fashion</option>
                <option value="comercial"  <?= ($valores['categoria'] ?? '') === 'comercial'  ? 'selected' : '' ?>>Comercial</option>
                <option value="fitness"    <?= ($valores['categoria'] ?? '') === 'fitness'    ? 'selected' : '' ?>>Fitness</option>
              </select>
            </div>
          </div>
        </div>

        <!-- País -->
        <div class="form-section">
          <p class="section-title">País de origen</p>
          <div class="radio-group radio-inline">
            <?php
            $paises = ['argentina' => 'Argentina', 'estados unidos' => 'Estados Unidos', 'alemania' => 'Alemania', 'brasil' => 'Brasil'];
            foreach ($paises as $val => $label):
              $checked = ($valores['pais'] ?? '') === $val ? 'checked' : '';
            ?>
            <label class="radio-option">
              <input type="radio" name="Pais" value="<?= $val ?>" <?= $checked ?>>
              <span class="radio-custom"></span>
              <span class="radio-text"><?= $label ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Idiomas -->
        <div class="form-section">
          <p class="section-title">Idiomas que hablás</p>
          <div class="check-group">
            <?php
            $idiomas_sel = explode(',', $valores['idiomas'] ?? '');
            $idiomas_ops = ['ingles' => 'Inglés', 'español' => 'Español', 'aleman' => 'Alemán', 'portugues' => 'Portugués'];
            foreach ($idiomas_ops as $val => $label):
              $checked = in_array($val, $idiomas_sel) ? 'checked' : '';
            ?>
            <label class="check-option">
              <input type="checkbox" name="idiomas[]" value="<?= $val ?>" <?= $checked ?>>
              <span class="check-custom"></span>
              <span class="check-text"><?= $label ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Cuenta -->
        <div class="form-section">
          <p class="section-title">Datos de cuenta</p>
          <div class="form-row">
            <div class="form-group">
              <label class="form-label" for="usuario">Usuario</label>
              <input type="text" id="usuario" name="usuario" class="form-input"
                     placeholder="ej. tomas.rivero"
                     value="<?= htmlspecialchars($valores['usuario'] ?? '') ?>">
            </div>
            <div class="form-group">
              <label class="form-label" for="contrasena">Contraseña</label>
              <div class="input-password-wrapper">
                <input type="password" id="contrasena" name="contrasena" class="form-input"
                       placeholder="Mínimo 8 caracteres">
                <button type="button" class="toggle-password" data-target="contrasena">
                  <span class="eye-icon">👁</span>
                </button>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="form-label" for="bio">Sobre vos</label>
            <textarea id="bio" name="bio" class="form-textarea"
                      placeholder="Contanos sobre tu experiencia, objetivos y estilo..."><?= htmlspecialchars($valores['bio'] ?? '') ?></textarea>
          </div>
        </div>

        <!-- Submit -->
        <div class="form-submit">
          <button type="submit" class="form-btn">
            <span>Crear mi perfil</span>
            <span class="btn-arrow">→</span>
          </button>
          <p class="form-terms">Al registrarte aceptás los <a href="#" class="link-dorado">Términos y Condiciones</a></p>
        </div>

      </form>
    </div>

  </main>

<?php require_once 'includes/footer.php'; ?>
