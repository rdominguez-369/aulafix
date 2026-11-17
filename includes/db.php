<?php

/**
 * =====================================================
 * AULAFIX - CONEXIÓN A MYSQL MEDIANTE PDO
 * =====================================================
 *
 * Este archivo proporciona una función reutilizable
 * para establecer la conexión con MySQL 8.
 *
 * @return PDO Objeto de conexión a la base de datos.
 */

// PASO 1: Cargar las constantes de configuración.
require_once __DIR__ . '/../config.php';

/**
 * Obtiene una conexión PDO con MySQL.
 *
 * @return PDO
 * @throws PDOException Si falla la conexión.
 */
function conectarBD(): PDO
{
    // PASO 2: Construir el DSN.
    // DSN significa Data Source Name.
    // Identifica el servidor, la base de datos
    // y el conjunto de caracteres.

    $dsn = 'mysql:host=' . DB_HOST
         . ';dbname=' . DB_NAME
         . ';charset=utf8mb4';

    // PASO 3: Configurar PDO.
    $opciones = [
        // Lanzar excepciones cuando ocurra un error.
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

        // Devolver resultados como arrays asociativos.
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

        // Utilizar consultas preparadas reales.
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    // PASO 4: Crear y devolver la conexión.
    return new PDO(
        $dsn,
        DB_USER,
        DB_PASSWORD,
        $opciones
    );
}
