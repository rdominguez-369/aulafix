<?php

/**
 * =====================================================
 * AULAFIX - CONFIGURACIÓN DE LA BASE DE DATOS
 * =====================================================
 *
 * Este archivo obtiene los parámetros de conexión
 * desde las variables de entorno de Docker.
 *
 * No contiene contraseñas escritas directamente.
 */

// PASO 1: Obtener el servidor de base de datos.
define('DB_HOST', getenv('DB_HOST'));

// PASO 2: Obtener el nombre de la base de datos.
define('DB_NAME', getenv('DB_NAME'));

// PASO 3: Obtener el usuario de MySQL.
define('DB_USER', getenv('DB_USER'));

// PASO 4: Obtener la contraseña del usuario.
define('DB_PASSWORD', getenv('DB_PASSWORD'));
