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


/**
 * =====================================================
 * AULAFIX - GUARDAR UNA INCIDENCIA
 * =====================================================
 *
 * Inserta una nueva incidencia en MySQL mediante
 * una consulta preparada con PDO.
 *
 * @param string $titulo Título de la incidencia.
 * @param string $descripcion Descripción del problema.
 * @param string $categoria Categoría seleccionada.
 * @param string $prioridad Prioridad seleccionada.
 *
 * @return int Identificador de la incidencia creada.
 * @throws PDOException Si falla la operación SQL.
 */
function guardarIncidencia(
    string $titulo,
    string $descripcion,
    string $categoria,
    string $prioridad
): int {

    // PASO 1: Conectar con MySQL.
    $pdo = conectarBD();

    // PASO 2: Definir la consulta SQL.
    // Los marcadores :titulo, :descripcion, etc.
    // serán sustituidos por valores de forma segura.
    $sql = '
        INSERT INTO incidencias (
            titulo,
            descripcion,
            categoria,
            prioridad
        )
        VALUES (
            :titulo,
            :descripcion,
            :categoria,
            :prioridad
        )
    ';

    // PASO 3: Preparar la consulta.
    $sentencia = $pdo->prepare($sql);

    // PASO 4: Ejecutar la consulta con los datos.
    $sentencia->execute([
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'categoria' => $categoria,
        'prioridad' => $prioridad
    ]);

    // PASO 5: Obtener el identificador generado.
    return (int) $pdo->lastInsertId();
}
