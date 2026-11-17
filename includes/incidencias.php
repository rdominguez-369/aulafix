<?php

declare(strict_types=1);

/**
 * =====================================================
 * AULAFIX - FUNCIONES DE INCIDENCIAS
 * =====================================================
 *
 * Este archivo contiene las funciones relacionadas
 * con la gestión de incidencias del aula.
 *
 * En esta versión obtenemos las incidencias reales
 * almacenadas en MySQL mediante PDO.
 */

// =====================================================
// PASO 1: Cargar la conexión a la base de datos.
// =====================================================

require_once __DIR__ . '/db.php';


// =====================================================
// PASO 2: Definir la función obtenerIncidencias().
// =====================================================

/**
 * Obtiene todas las incidencias almacenadas en MySQL.
 *
 * @return array Lista de incidencias.
 * @throws PDOException Si ocurre un error en la consulta.
 */
function obtenerIncidencias(): array
{
    // PASO 3: Establecer la conexión con MySQL.
    $pdo = conectarBD();

    // PASO 4: Preparar la consulta SQL.
    // Ordenamos las incidencias desde la más reciente.
    $sql = '
        SELECT
            id,
            titulo,
            descripcion,
            categoria,
            prioridad,
            estado,
            fecha_creacion
        FROM incidencias
        ORDER BY fecha_creacion DESC, id DESC
    ';

    // PASO 5: Ejecutar la consulta SQL.
    $sentencia = $pdo->query($sql);

    // PASO 6: Recuperar los resultados.
    $incidencias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    // PASO 7: Devolver las incidencias.
    return $incidencias;
}
