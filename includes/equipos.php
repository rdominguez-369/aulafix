<?php

declare(strict_types=1);

/**
 * =====================================================
 * AULAFIX - FUNCIONES DE EQUIPOS
 * =====================================================
 *
 * Contiene las funciones relacionadas con los
 * equipos informáticos registrados en AulaFix.
 */

// =====================================================
// PASO 1: Cargar la conexión a la base de datos.
// =====================================================

require_once __DIR__ . '/db.php';


// =====================================================
// PASO 2: Obtener los equipos registrados.
// =====================================================

/**
 * Recupera los equipos disponibles desde MySQL.
 *
 * @return array Lista de equipos.
 * @throws PDOException Si falla la consulta.
 */
function obtenerEquipos(): array
{
    // PASO 3: Establecer la conexión.
    $pdo = conectarBD();

    // PASO 4: Preparar la consulta SQL.
    $sql = '
        SELECT
            id,
            nombre,
            tipo,
            ubicacion
        FROM equipos
        ORDER BY ubicacion ASC, nombre ASC
    ';

    // PASO 5: Ejecutar la consulta.
    $sentencia = $pdo->query($sql);

    // PASO 6: Recuperar los resultados.
    $equipos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    // PASO 7: Devolver la lista de equipos.
    return $equipos;
}

/**
 * =====================================================
 * AULAFIX - VALIDAR EQUIPO
 * =====================================================
 *
 * Comprueba si existe un equipo con el identificador
 * proporcionado.
 *
 * @param int $equipoId Identificador del equipo.
 * @return bool True si existe; false en caso contrario.
 */
function existeEquipo(int $equipoId): bool
{
    // PASO 1: Rechazar identificadores no válidos.
    if ($equipoId <= 0) {
        return false;
    }

    // PASO 2: Conectar con MySQL.
    $pdo = conectarBD();

    // PASO 3: Preparar una consulta segura.
    $sql = '
        SELECT COUNT(*)
        FROM equipos
        WHERE id = :equipo_id
    ';

    $sentencia = $pdo->prepare($sql);

    // PASO 4: Ejecutar la consulta.
    $sentencia->execute([
        'equipo_id' => $equipoId
    ]);

    // PASO 5: Comprobar si existe el equipo.
    return (int) $sentencia->fetchColumn() > 0;
}
