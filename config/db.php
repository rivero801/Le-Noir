<?php
/* ============================================
   config/db.php — Le Noir
   Conexión a la base de datos MySQL con PDO.
   Incluir al principio de cualquier página
   que necesite la base de datos:
   require_once __DIR__ . '/../config/db.php';
   ============================================ */

// ── Datos de conexión ──
// Estos valores son los que trae XAMPP por defecto.
// Cuando subas a producción, cambialos por los del hosting.
define('DB_HOST',    'localhost');
define('DB_NAME',    'lenoir');       // nombre de la base de datos
define('DB_USER',    'root');         // usuario por defecto en XAMPP
define('DB_PASS',    '');             // contraseña vacía por defecto en XAMPP
define('DB_CHARSET', 'utf8mb4');

// ── Conexión PDO ──
// PDO es la forma moderna y segura de conectarse en PHP.
// Protege automáticamente contra inyección SQL si usás
// "prepared statements" (lo hacemos en registro y login).

try {
    $dsn = "mysql:host=" . DB_HOST
         . ";dbname=" . DB_NAME
         . ";charset=" . DB_CHARSET;

    $opciones = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // lanza errores
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // devuelve arrays asociativos
        PDO::ATTR_EMULATE_PREPARES   => false,                   // prepared statements reales
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $opciones);

} catch (PDOException $e) {
    // En producción nunca mostrar el error real, solo loguearlo
    error_log("Error de conexión: " . $e->getMessage());
    die("Error al conectar con la base de datos. Intentá más tarde.");
}
