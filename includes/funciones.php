<?php

declare(strict_types=1);

/**
 * =====================================================
 * AULAFIX - FUNCIONES GENERALES
 * =====================================================
 *
 * Funciones reutilizables para las páginas PHP.
 */

/**
 * Escapa un valor antes de mostrarlo en HTML.
 *
 * Evita que las etiquetas o scripts introducidos
 * por usuarios se interpreten como código HTML.
 *
 * @param mixed $valor Valor que queremos mostrar.
 * @return string Texto seguro para HTML.
 */
function e(mixed $valor): string
{
    return htmlspecialchars(
        (string) $valor,
        ENT_QUOTES,
        'UTF-8'
    );
}


/**
 * =====================================================
 * FUNCIÓN: OBTENER CATEGORÍAS
 * =====================================================
 *
 * Devuelve las categorías permitidas para
 * clasificar las incidencias.
 *
 * @return array Lista de categorías.
 */
function obtenerCategorias(): array
{
    // PASO 1: Devolver las categorías disponibles.
    return [
        'Hardware',
        'Software',
        'Redes',
        'Otros'
    ];
}

/**
 * =====================================================
 * FUNCIÓN: OBTENER PRIORIDADES
 * =====================================================
 *
 * Devuelve los niveles de prioridad permitidos.
 *
 * @return array Lista de prioridades.
 */
function obtenerPrioridades(): array
{
    // PASO 2: Devolver las prioridades disponibles.
    return [
        'Baja',
        'Media',
        'Alta'
    ];
}

/**
 * =====================================================
 * FUNCIÓN: LIMPIAR CAMPO DE FORMULARIO
 * =====================================================
 *
 * Comprueba que el valor recibido sea una cadena.
 * Si lo es, elimina los espacios de sus extremos.
 * Si no lo es, devuelve una cadena vacía.
 *
 * @param mixed $valor Valor recibido del formulario.
 * @return string Valor preparado para su validación.
 */
function limpiarCampo(mixed $valor): string
{
    // PASO 1: Comprobar si el valor es una cadena.
    if (!is_string($valor)) {
        return '';
    }

    // PASO 2: Eliminar espacios al inicio y al final.
    return trim($valor);
}


/**
 * =====================================================
 * AULAFIX - PROTECCIÓN CSRF
 * =====================================================
 *
 * Estas funciones permiten generar y verificar
 * un token de seguridad para los formularios POST.
 */


/**
 * Genera o recupera el token CSRF de la sesión.
 *
 * @return string Token de seguridad.
 */
function obtenerTokenCSRF(): string
{
    // PASO 1: Comprobar si existe una sesión activa.
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // PASO 2: Generar el token si todavía no existe.
    if (!isset($_SESSION['csrf_token'])) {

        // Generamos 32 bytes aleatorios y los
        // convertimos a una cadena hexadecimal.
        $_SESSION['csrf_token'] = bin2hex(
            random_bytes(32)
        );
    }

    // PASO 3: Devolver el token de la sesión.
    return $_SESSION['csrf_token'];
}


/**
 * Comprueba si el token recibido es válido.
 *
 * @param string $token Token enviado por el formulario.
 * @return bool True si coincide con el de la sesión.
 */
function validarTokenCSRF(string $token): bool
{
    // PASO 1: Comprobar si existe una sesión activa.
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // PASO 2: Recuperar el token almacenado.
    $tokenGuardado = $_SESSION['csrf_token'] ?? '';

    // PASO 3: Comparar ambos tokens de forma segura.
    return $tokenGuardado !== ''
        && hash_equals($tokenGuardado, $token);
}
