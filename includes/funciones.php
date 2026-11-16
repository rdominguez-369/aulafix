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
