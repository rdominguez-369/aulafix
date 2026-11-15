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
