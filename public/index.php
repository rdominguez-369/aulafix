<?php

/**
 * =====================================================
 * AULAFIX - PÁGINA DE INICIO
 * =====================================================
 *
 * Esta página utiliza los archivos reutilizables
 * cabecera.php y pie.php.
 */

// PASO 1: Definir el título de la página.
$tituloPagina = 'Inicio';

// PASO 2: Cargar la cabecera común.
require_once __DIR__ . '/../includes/cabecera.php';

?>

<!-- PASO 3: Contenido principal de AulaFix -->
<section>
    <h2>Bienvenido a AulaFix</h2>

    <p>
        Sistema de gestión de incidencias del aula.
    </p>

    <p>
        Desde esta aplicación podrás consultar,
        registrar y gestionar incidencias
        relacionadas con los equipos del aula.
    </p>
</section>

<?php

// PASO 4: Cargar el pie de página común.
require_once __DIR__ . '/../includes/pie.php';

?>
