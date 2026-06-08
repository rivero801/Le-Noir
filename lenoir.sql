-- ============================================
-- lenoir.sql — Le Noir
-- Script para crear la base de datos y tablas.
-- Cómo usarlo:
-- 1. Abrí phpMyAdmin (http://localhost/phpmyadmin)
-- 2. Click en "Importar"
-- 3. Seleccioná este archivo y ejecutá
-- ============================================

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS `lenoir`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `lenoir`;

-- ── Tabla: usuarios ──
-- Guarda los datos de registro de cada modelo
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id`            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `usuario`       VARCHAR(60)     NOT NULL UNIQUE,
    `correo`        VARCHAR(150)    NOT NULL UNIQUE,
    `contrasena`    VARCHAR(255)    NOT NULL,           -- contraseña hasheada con password_hash()
    `nombre`        VARCHAR(80)     NOT NULL,
    `apellido`      VARCHAR(80)     NOT NULL,
    `fecha_nac`     DATE            DEFAULT NULL,
    `altura`        SMALLINT        DEFAULT NULL,       -- en cm
    `categoria`     ENUM('fashion','comercial','fitness') DEFAULT NULL,
    `pais`          VARCHAR(60)     DEFAULT NULL,
    `idiomas`       VARCHAR(150)    DEFAULT NULL,       -- ej: "ingles,español"
    `bio`           TEXT            DEFAULT NULL,
    `foto_perfil`   VARCHAR(255)    DEFAULT NULL,       -- ruta relativa a la imagen
    `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ── Tabla: sesiones_foto ──
-- Guarda las sesiones fotográficas del portfolio
CREATE TABLE IF NOT EXISTS `sesiones_foto` (
    `id`            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `usuario_id`    INT UNSIGNED    NOT NULL,
    `titulo`        VARCHAR(120)    NOT NULL,
    `descripcion`   TEXT            DEFAULT NULL,
    `imagen`        VARCHAR(255)    NOT NULL,
    `categoria`     ENUM('fashion','editorial','fitness') DEFAULT 'fashion',
    `ciudad`        VARCHAR(80)     DEFAULT NULL,
    `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ── Tabla: novedades ──
-- Noticias y novedades de la agencia
CREATE TABLE IF NOT EXISTS `novedades` (
    `id`            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `titulo`        VARCHAR(150)    NOT NULL,
    `descripcion`   TEXT            NOT NULL,
    `imagen`        VARCHAR(255)    DEFAULT NULL,
    `categoria`     VARCHAR(60)     DEFAULT NULL,
    `destacada`     TINYINT(1)      NOT NULL DEFAULT 0,  -- 1 = aparece primero
    `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ── Tabla: contacto ──
-- Mensajes enviados desde el formulario de contacto
CREATE TABLE IF NOT EXISTS `contacto` (
    `id`            INT UNSIGNED    NOT NULL AUTO_INCREMENT,
    `nombre`        VARCHAR(120)    NOT NULL,
    `correo`        VARCHAR(150)    NOT NULL,
    `motivo`        TINYINT         NOT NULL DEFAULT 0,  -- corresponde al valor del radio
    `mensaje`       TEXT            NOT NULL,
    `leido`         TINYINT(1)      NOT NULL DEFAULT 0,  -- 0 = no leído
    `created_at`    TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ── Datos de prueba ──
-- Un usuario de ejemplo para testear el login
INSERT INTO `usuarios`
    (`usuario`, `correo`, `contrasena`, `nombre`, `apellido`, `altura`, `categoria`, `pais`, `bio`)
VALUES (
    'tomas.rivero',
    'tomas@lenoir.com',
    '$2y$10$exampleHashedPassword123456789abcdefg',  -- reemplazar con password_hash() real
    'Tomás',
    'Rivero',
    178,
    'fashion',
    'argentina',
    'Modelo profesional, Le Noir Agency.'
);
